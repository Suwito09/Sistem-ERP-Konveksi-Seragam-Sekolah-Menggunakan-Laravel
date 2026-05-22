<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Pengaturan Perusahaan
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <x-partials.card>
                <x-slot name="title">
                    <i class="mr-1 icon ion-md-settings"></i>
                    Pengaturan Informasi Perusahaan
                </x-slot>

                <form method="POST" action="{{ route('company-settings.update') }}" enctype="multipart/form-data" class="mt-4">
                    @csrf

                    {{-- Informasi Perusahaan --}}
                    <div class="border-b border-gray-200 pb-4 mb-6">
                            <h3 class="text-lg font-semibold text-gray-700 mb-4">Informasi Perusahaan</h3>
                            
                            <div class="mb-4">
                                <x-inputs.group class="w-full" for="company_name" label="Nama Perusahaan">
                                    <x-inputs.text 
                                        name="company_name" 
                                        id="company_name" 
                                        value="{{ old('company_name', $setting->company_name) }}" 
                                        placeholder="Nama Perusahaan"
                                        required
                                    />
                                </x-inputs.group>
                            </div>

                            <div class="mb-4">
                                <x-inputs.group class="w-full" for="company_address" label="Alamat Perusahaan">
                                    <x-inputs.textarea 
                                        name="company_address" 
                                        id="company_address" 
                                        rows="3"
                                        placeholder="Alamat lengkap perusahaan"
                                    >{{ old('company_address', $setting->company_address) }}</x-inputs.textarea>
                                </x-inputs.group>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <x-inputs.group for="company_phone" label="Nomor Telepon">
                                        <x-inputs.text 
                                            name="company_phone" 
                                            id="company_phone" 
                                            value="{{ old('company_phone', $setting->company_phone) }}" 
                                            placeholder="Nomor telepon perusahaan"
                                        />
                                    </x-inputs.group>
                                </div>

                                <div>
                                    <x-inputs.group for="company_email" label="Email">
                                        <x-inputs.text 
                                            name="company_email" 
                                            id="company_email" 
                                            type="email"
                                            value="{{ old('company_email', $setting->company_email) }}" 
                                            placeholder="Email perusahaan"
                                        />
                                    </x-inputs.group>
                                </div>
                            </div>
                        </div>

                        {{-- Informasi Owner/Pimpinan --}}
                        <div class="border-b border-gray-200 pb-4 mb-6">
                            <h3 class="text-lg font-semibold text-gray-700 mb-4">Informasi Pimpinan</h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <x-inputs.group for="owner_name" label="Nama Pimpinan/Owner">
                                        <x-inputs.text 
                                            name="owner_name" 
                                            id="owner_name" 
                                            value="{{ old('owner_name', $setting->owner_name) }}" 
                                            placeholder="Nama pimpinan"
                                            required
                                        />
                                    </x-inputs.group>
                                </div>

                                <div>
                                    <x-inputs.group for="owner_position" label="Jabatan">
                                        <x-inputs.text 
                                            name="owner_position" 
                                            id="owner_position" 
                                            value="{{ old('owner_position', $setting->owner_position) }}" 
                                            placeholder="Jabatan pimpinan"
                                            required
                                        />
                                    </x-inputs.group>
                                </div>
                            </div>
                        </div>

                        {{-- Upload File --}}
                        <div class="mb-6">
                            <h3 class="text-lg font-semibold text-gray-700 mb-4">Upload File</h3>
                            
                            {{-- Logo --}}
                            <div class="mb-6">
                                <x-inputs.group for="logo" label="Logo Perusahaan">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        File saat ini:
                                    </label>
                                    @if($setting->logo_url)
                                        <div class="flex items-center gap-4 mb-3">
                                            <img src="{{ $setting->logo_url }}" alt="Logo" class="h-20 border rounded">
                                            <form method="POST" action="{{ route('company-settings.delete-logo') }}" onsubmit="return confirm('Yakin ingin menghapus logo?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-800 text-sm">
                                                    <i class="icon ion-md-trash"></i> Hapus Logo
                                                </button>
                                            </form>
                                        </div>
                                    @else
                                        <p class="text-gray-500 text-sm mb-2">Belum ada logo</p>
                                    @endif
                                    <input 
                                        type="file" 
                                        name="logo" 
                                        id="logo" 
                                        accept="image/png,image/jpg,image/jpeg"
                                        class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-maroon-50 file:text-maroon-700 hover:file:bg-maroon-100"
                                    />
                                    <p class="text-xs text-gray-500 mt-1">Format: PNG, JPG, JPEG. Maksimal 2MB</p>
                                </x-inputs.group>
                            </div>

                            {{-- Tanda Tangan --}}
                            <div class="mb-6">
                                <x-inputs.group for="signature" label="Tanda Tangan Digital">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        File saat ini:
                                    </label>
                                    @if($setting->signature_url)
                                        <div class="flex items-center gap-4 mb-3">
                                            <img src="{{ $setting->signature_url }}" alt="Tanda Tangan" class="h-20 border rounded bg-white">
                                            <form method="POST" action="{{ route('company-settings.delete-signature') }}" onsubmit="return confirm('Yakin ingin menghapus tanda tangan?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-800 text-sm">
                                                    <i class="icon ion-md-trash"></i> Hapus Tanda Tangan
                                                </button>
                                            </form>
                                        </div>
                                    @else
                                        <p class="text-gray-500 text-sm mb-2">Belum ada tanda tangan</p>
                                    @endif
                                    <input 
                                        type="file" 
                                        name="signature" 
                                        id="signature" 
                                        accept="image/png,image/jpg,image/jpeg"
                                        class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-maroon-50 file:text-maroon-700 hover:file:bg-maroon-100"
                                    />
                                    <p class="text-xs text-gray-500 mt-1">Format: PNG, JPG, JPEG. Maksimal 2MB. Background transparan direkomendasikan.</p>
                                </x-inputs.group>
                            </div>

                            {{-- Stempel --}}
                            <div class="mb-6">
                                <x-inputs.group for="stamp" label="Stempel Perusahaan">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        File saat ini:
                                    </label>
                                    @if($setting->stamp_url)
                                        <div class="flex items-center gap-4 mb-3">
                                            <img src="{{ $setting->stamp_url }}" alt="Stempel" class="h-20 border rounded bg-white">
                                            <form method="POST" action="{{ route('company-settings.delete-stamp') }}" onsubmit="return confirm('Yakin ingin menghapus stempel?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-800 text-sm">
                                                    <i class="icon ion-md-trash"></i> Hapus Stempel
                                                </button>
                                            </form>
                                        </div>
                                    @else
                                        <p class="text-gray-500 text-sm mb-2">Belum ada stempel</p>
                                    @endif
                                    <input 
                                        type="file" 
                                        name="stamp" 
                                        id="stamp" 
                                        accept="image/png,image/jpg,image/jpeg"
                                        class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-maroon-50 file:text-maroon-700 hover:file:bg-maroon-100"
                                    />
                                    <p class="text-xs text-gray-500 mt-1">Format: PNG, JPG, JPEG. Maksimal 2MB. Background transparan direkomendasikan.</p>
                                </x-inputs.group>
                            </div>
                        </div>

                        {{-- Pengaturan Pesanan --}}
                        <div class="border-b border-gray-200 pb-4 mb-6">
                            <h3 class="text-lg font-semibold text-gray-700 mb-4">Pengaturan Pesanan</h3>
                            
                            <div class="mb-4">
                                <x-inputs.group for="unpaid_order_auto_delete_days" label="Batas Waktu Pembayaran Pesanan (Hari)">
                                    <x-inputs.number 
                                        name="unpaid_order_auto_delete_days" 
                                        id="unpaid_order_auto_delete_days" 
                                        value="{{ old('unpaid_order_auto_delete_days', $setting->unpaid_order_auto_delete_days ?? 30) }}" 
                                        placeholder="30"
                                        min="1"
                                        max="365"
                                        required
                                    />
                                    <p class="text-xs text-gray-500 mt-1">
                                        Pesanan yang belum lunas akan otomatis dihapus setelah melewati batas waktu ini (dalam hari). Stok akan dikembalikan ke sistem.
                                    </p>
                                </x-inputs.group>
                            </div>
                        </div>

                        {{-- Submit Button --}}
                        <div class="mt-6 flex justify-end">
                            <button 
                                type="submit" 
                                class="button button-primary"
                                style="background-color: #800000; color: white; padding: 10px 20px; border-radius: 5px; transition: background-color 0.3s;"
                                onmouseover="this.style.backgroundColor='#600000'"
                                onmouseout="this.style.backgroundColor='#800000'"
                            >
                                <i class="icon ion-md-save mr-1"></i>
                                Simpan Pengaturan
                            </button>
                        </div>
                    </form>
            </x-partials.card>

            {{-- Preview Section --}}
            @if($setting->signature_url || $setting->stamp_url)
            <x-partials.card class="mt-6">
                <x-slot name="title">
                    <i class="mr-1 icon ion-md-eye"></i>
                    Preview Tanda Tangan & Stempel di Slip Gaji
                </x-slot>

                <div class="bg-gray-50 p-6 rounded-lg">
                    <div class="text-center">
                        <p class="text-sm text-gray-600 mb-4">Mengetahui,</p>
                        
                        @if($setting->signature_url)
                            <div class="mb-2">
                                <img src="{{ $setting->signature_url }}" alt="TTD" class="mx-auto" style="max-width: 150px; height: auto;">
                            </div>
                        @endif
                        
                        @if($setting->stamp_url)
                            <div class="mb-2">
                                <img src="{{ $setting->stamp_url }}" alt="Stempel" class="mx-auto" style="max-width: 100px; height: auto;">
                            </div>
                        @endif
                        
                        <div class="border-t border-gray-400 pt-2 inline-block min-w-[200px]">
                            <p class="font-semibold">{{ $setting->owner_name }}</p>
                            <p class="text-sm text-gray-600">{{ $setting->owner_position }}</p>
                        </div>
                    </div>
                </div>
            </x-partials.card>
            @endif
        </div>
    </div>
</x-app-layout>
