<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Invoice;
use App\Models\Pesanan;
use App\Models\UkuranProduk;
use App\Models\StokProduk;
use App\Models\StokKeluar;
use App\Models\RiwayatStokProduk;
use App\Models\CompanySetting;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DeleteExpiredUnpaidOrders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'orders:delete-expired';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Hapus pesanan belum lunas yang sudah lewat batas waktu pembayaran dan kembalikan stok';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $companySetting = CompanySetting::getInstance();
        $autoDeleteDays = $companySetting->unpaid_order_auto_delete_days ?? 30;

        // Ambil pesanan yang sudah lewat deadline dan belum lunas
        $expiredInvoices = Invoice::where('tagihan_sisa', '>', 0)
            ->whereNotNull('payment_deadline')
            ->where('payment_deadline', '<', Carbon::now())
            ->get();

        if ($expiredInvoices->isEmpty()) {
            $this->info('Tidak ada pesanan yang expired.');
            return 0;
        }

        $deletedCount = 0;
        $stockReturnedCount = 0;

        foreach ($expiredInvoices as $invoice) {
            DB::beginTransaction();
            
            try {
                // Ambil semua pesanan dari invoice ini
                $pesanans = Pesanan::where('invoice_id', $invoice->id)->get();

                // Kembalikan stok untuk setiap pesanan
                foreach ($pesanans as $pesanan) {
                    // Kembalikan stok di ukuran_produk
                    $ukuranProduk = UkuranProduk::where('produk_id', $pesanan->produk_id)
                        ->where('ukuran', $pesanan->ukuran)
                        ->first();

                    if ($ukuranProduk) {
                        $ukuranProduk->stok += $pesanan->jumlah_pesanan;
                        $ukuranProduk->save();
                    }

                    // Kembalikan stok di stok_produk
                    $stokProduk = StokProduk::where('produk_id', $pesanan->produk_id)
                        ->where('ukuran_produk', $pesanan->ukuran)
                        ->first();

                    if ($stokProduk) {
                        $stokProduk->stok_tersedia += $pesanan->jumlah_pesanan;
                        $stokProduk->save();
                    }

                    // Catat pengembalian stok di riwayat
                    RiwayatStokProduk::create([
                        'id_produk' => $pesanan->produk_id,
                        'ukuran_produk' => $pesanan->ukuran,
                        'stok_masuk' => $pesanan->jumlah_pesanan,
                        'stok_keluar' => 0,
                        'tipe_transaksi' => 'masuk',
                        'user_id' => 1, // System user
                        'catatan' => 'Pengembalian stok otomatis dari pesanan expired #' . $invoice->invoice
                    ]);

                    // Catat pengembalian stok di stok_keluar (sebagai entry negatif untuk audit trail)
                    StokKeluar::create([
                        'produk_id' => $pesanan->produk_id,
                        'ukuran_produk' => $pesanan->ukuran,
                        'jumlah_keluar' => -$pesanan->jumlah_pesanan, // negative = pengembalian
                        'user_id' => 1, // System user
                        'catatan' => 'Pengembalian stok otomatis dari pesanan expired #' . $invoice->invoice
                    ]);

                    $stockReturnedCount++;
                }

                // Update customer billing - kurangi tagihan yang belum dibayar
                $customer = $invoice->user;
                if ($customer) {
                    $customer->tagihan -= $invoice->tagihan_sisa;
                    $customer->tagihan = max(0, $customer->tagihan);
                    $customer->save();
                }

                // Hapus pesanan
                Pesanan::where('invoice_id', $invoice->id)->delete();

                // Hapus invoice
                $invoice->delete();

                $deletedCount++;

                DB::commit();

                Log::info("Pesanan expired dihapus: Invoice #{$invoice->invoice}, Stok dikembalikan: {$pesanans->count()} items");

            } catch (\Exception $e) {
                DB::rollBack();
                Log::error("Gagal menghapus pesanan expired #{$invoice->invoice}: " . $e->getMessage());
                $this->error("Gagal memproses invoice #{$invoice->invoice}: " . $e->getMessage());
            }
        }

        $this->info("Berhasil menghapus {$deletedCount} pesanan expired dan mengembalikan {$stockReturnedCount} item stok.");
        Log::info("Auto-delete expired orders: {$deletedCount} invoices deleted, {$stockReturnedCount} stock items returned");

        return 0;
    }
}
