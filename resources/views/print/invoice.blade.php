<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice - {{ $invoice->invoice }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        @page {
            size: 80mm auto;
            margin: 0;
        }
        html, body {
            width: 80mm;
            height: auto;
            margin: 0;
            padding: 0;
        }
        body {
            font-family: 'Courier New', Courier, monospace;
            font-size: 10px;
            width: 80mm;
            margin: 0;
            padding: 3mm;
            position: relative;
        }
        @media print {
            html, body {
                width: 80mm;
                height: auto;
            }
            body {
                padding: 2mm;
            }
        }
        .container {
            width: 100%;
            position: relative;
        }
        /* Stempel LUNAS */
        .stamp-lunas {
            position: absolute;
            top: 35mm;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-15deg);
            font-size: 36px;
            font-weight: bold;
            color: #28a745;
            border: 4px solid #28a745;
            padding: 8px 20px;
            opacity: 0.3;
            z-index: 999;
            pointer-events: none;
            letter-spacing: 3px;
        }
        @media print {
            .stamp-lunas {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
                color: #28a745 !important;
                border-color: #28a745 !important;
            }
        }
        .header {
            text-align: center;
            margin-bottom: 6px;
            border-bottom: 2px dashed #000;
            padding-bottom: 4px;
        }
        .header img {
            max-width: 45px;
            height: auto;
        }
        .header .title {
            font-weight: bold;
            font-size: 13px;
            margin-top: 2px;
            letter-spacing: 2px;
        }
        .header .subtitle {
            font-size: 9px;
            margin: 1px 0;
        }
        .info-section {
            border-bottom: 1px dashed #000;
            padding-bottom: 4px;
            margin-bottom: 4px;
        }
        .info-row {
            margin: 2px 0;
            font-size: 9px;
            line-height: 1.3;
        }
        .label {
            font-weight: bold;
            display: inline-block;
            width: 60px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 8px;
            margin: 4px 0;
        }
        th {
            border-top: 1px solid #000;
            border-bottom: 1px solid #000;
            padding: 3px 1px;
            text-align: left;
            font-weight: bold;
            font-size: 8px;
        }
        td {
            padding: 2px 1px;
            font-size: 8px;
        }
        .total-section {
            border-top: 2px solid #000;
            margin-top: 4px;
            padding-top: 4px;
        }
        .total-row {
            font-size: 9px;
            margin: 2px 0;
            display: flex;
            justify-content: space-between;
        }
        .total-row.grand-total {
            font-weight: bold;
            border-top: 1px solid #000;
            padding-top: 3px;
            margin-top: 3px;
            font-size: 10px;
        }
        .total-row.kembalian {
            font-weight: bold;
            color: #28a745;
            border-top: 1px dashed #28a745;
            padding-top: 3px;
            margin-top: 3px;
        }
        .total-row.deadline {
            font-size: 8px;
            color: #dc3545;
            border-top: 1px dashed #dc3545;
            padding-top: 3px;
            margin-top: 3px;
        }
        @media print {
            .total-row.kembalian {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
                color: #28a745 !important;
            }
            .total-row.deadline {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
                color: #dc3545 !important;
            }
        }
        .footer {
            text-align: center;
            margin-top: 6px;
            font-size: 8px;
            border-top: 2px dashed #000;
            padding-top: 4px;
        }
    </style>
</head>
<body>
    <div class="container">
    @if($invoice->tagihan_sisa == 0)
        <div class="stamp-lunas">LUNAS</div>
    @endif
    
    <div class="header">
        @if(file_exists(public_path('favicon.png')))
        <img src="{{ asset('favicon.png') }}" alt="Logo">
        @endif
        <div class="title">INVOICE</div>
        <div class="subtitle">{{ $invoice->invoice }}</div>
        <div class="subtitle">{{ \Carbon\Carbon::parse($invoice->created_at)->format('d/m/Y H:i') }}</div>
    </div>

    <div class="info-section">
        <div class="info-row">
            <span class="label">Customer:</span> {{ $invoice->user->nama ?? 'N/A' }}
        </div>
        <div class="info-row">
            <span class="label">Telepon:</span> {{ $invoice->user->telepon ?? '-' }}
        </div>
        <div class="info-row">
            <span class="label">Alamat:</span> {{ $invoice->user->alamat ?? '-' }}
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width:40%;">Produk</th>
                <th style="width:10%; text-align:center;">Size</th>
                <th style="width:8%; text-align:center;">Qty</th>
                <th style="width:20%; text-align:right;">Harga</th>
                <th style="width:22%; text-align:right;">Total</th>
            </tr>
        </thead>
        <tbody>
            @php
                $total_subtotal = 0;
            @endphp
            @foreach($pesanans as $pesanan)
                @if (isset($pesanan->jumlah_pesanan) && isset($pesanan->harga))
                    @php
                        $subtotal = $pesanan->jumlah_pesanan * $pesanan->harga;
                        $total_subtotal += $subtotal;
                    @endphp
                    <tr>
                        <td>{{ $pesanan->produk->nama_produk ?? 'N/A' }}</td>
                        <td style="text-align:center;">{{ $pesanan->ukuran ?? '-' }}</td>
                        <td style="text-align:center;">{{ $pesanan->jumlah_pesanan }}</td>
                        <td style="text-align:right;">{{ number_format($pesanan->harga, 0, ',', '.') }}</td>
                        <td style="text-align:right;">{{ number_format($subtotal, 0, ',', '.') }}</td>
                    </tr>
                @endif
            @endforeach
        </tbody>
    </table>

    <div class="total-section">
        <div class="total-row">
            <span>Total:</span>
            <span>Rp {{ number_format($total_subtotal, 0, ',', '.') }}</span>
        </div>
        <div class="total-row">
            <span>Tagihan Sebelumnya:</span>
            <span>Rp {{ number_format($invoice->tagihan_sebelumnya ?? 0, 0, ',', '.') }}</span>
        </div>
        <div class="total-row grand-total">
            <span>SUB TOTAL:</span>
            <span>Rp {{ number_format($invoice->tagihan_total ?? 0, 0, ',', '.') }}</span>
        </div>
        <div class="total-row">
            <span>Jumlah Bayar:</span>
            <span>Rp {{ number_format($invoice->jumlah_bayar ?? 0, 0, ',', '.') }}</span>
        </div>
        <div class="total-row" style="font-weight:bold;">
            <span>Sisa Tagihan:</span>
            <span>Rp {{ number_format($invoice->tagihan_sisa ?? 0, 0, ',', '.') }}</span>
        </div>
        
        @php
            $kembalian = ($invoice->jumlah_bayar ?? 0) - ($invoice->tagihan_total ?? 0);
        @endphp
        @if($kembalian > 0)
        <div class="total-row kembalian">
            <span>KEMBALIAN:</span>
            <span>Rp {{ number_format($kembalian, 0, ',', '.') }}</span>
        </div>
        @endif

        @if($invoice->tagihan_sisa > 0 && $invoice->payment_deadline)
        <div class="total-row deadline">
            <span>Batas Bayar:</span>
            <span>{{ \Carbon\Carbon::parse($invoice->payment_deadline)->format('d/m/Y H:i') }}</span>
        </div>
        @endif
    </div>

    <div class="footer">
        Terima Kasih
    </div>
    </div>

    <script>
        // Auto-trigger print dialog when page loads
        window.addEventListener('load', function() {
            // Small delay to ensure content is fully rendered
            setTimeout(function() {
                window.print();
            }, 250);
        });
    </script>
</body>
</html>
