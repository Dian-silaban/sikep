@extends('layouts.app')

@section('title', 'Edit Pegawai')

@section('content')

<div class="min-h-screen bg-gray-100 flex items-center justify-center p-4 sm:p-6 lg:p-8 font-inter">
    <div class="bg-white rounded-xl shadow-lg p-6 sm:p-8 lg:p-10 w-full max-w-4xl">
        <h2 class="text-2xl sm:text-3xl font-bold text-gray-800 mb-6 text-center">{{ $pegawai->nama_lengkap }}</h2>

        <form method="POST" action="{{ route('pegawai.update', $pegawai->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- Input tersembunyi untuk menyimpan URL pengalihan --}}
            @if(request()->has('_redirect_to'))
                <input type="hidden" name="_redirect_to" value="{{ request('_redirect_to') }}">
            @endif

            {{-- Bagian Foto Profil --}}
            <div class="flex flex-col items-center mb-8">
                <div class="relative w-32 h-32 overflow-hidden border-1 border-white-600 shadow-md">
    {{-- Image element for profile picture preview --}}
    <img id="profile-preview-image"
        src="{{ $pegawai->foto_profil_path ? asset($pegawai->foto_profil_path) : 'https://placehold.co/128x128/e0e0e0/ffffff?text=No+Photo' }}"
        alt="Foto Profil Saat Ini"
        class="w-full h-full object-cover">
    <input type="file" name="foto_profil" id="foto_profil" class="hidden" accept="image/*">
</div>
                <div class="mt-4 flex space-x-4">
                    {{-- "Upload New" button now triggers the hidden file input --}}
                    <button type="button" id="upload-new-button" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors shadow-md">Upload New</button>
                    @if ($pegawai->foto_profil_path)
                        <label for="hapus_foto_profil" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors shadow-md cursor-pointer">
                            <input type="checkbox" name="hapus_foto_profil" value="1" id="hapus_foto_profil" class="hidden">
                            Delete avatar
                        </label>
                    @endif
                </div>
                @error('foto_profil')
                    <div class="text-red-500 text-sm mt-2">{{ $message }}</div>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                {{-- NIP --}}
                <div>
                    <label for="nip" class="block text-gray-700 text-sm font-semibold mb-2">NIP:</label>
                    <input type="text" name="nip" id="nip" value="{{ old('nip', $pegawai->nip) }}" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 bg-gray-50 text-gray-900">
                    @error('nip')
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                {{-- NIK --}}
                <div>
                    <label for="nik" class="block text-gray-700 text-sm font-semibold mb-2">NIK:</label>
                    <input type="text" name="nik" id="nik" value="{{ old('nik', $pegawai->nik) }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 bg-gray-50 text-gray-900">
                    @error('nik')
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Nama Lengkap --}}
                <div>
                    <label for="nama_lengkap" class="block text-gray-700 text-sm font-semibold mb-2">Nama Lengkap:</label>
                    <input type="text" name="nama_lengkap" id="nama_lengkap" value="{{ old('nama_lengkap', $pegawai->nama_lengkap) }}" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 bg-gray-50 text-gray-900">
                    @error('nama_lengkap')
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Tanggal Lahir --}}
                <div>
                    <label for="tanggal_lahir" class="block text-gray-700 text-sm font-semibold mb-2">Tanggal Lahir:</label>
                    <input type="date" name="tanggal_lahir" id="tanggal_lahir" value="{{ old('tanggal_lahir', $pegawai->tanggal_lahir ? \Carbon\Carbon::parse($pegawai->tanggal_lahir)->format('Y-m-d') : '') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 bg-gray-50 text-gray-900">
                    @error('tanggal_lahir')
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Jenis Kelamin --}}
                <div>
                    <label class="block text-gray-700 text-sm font-semibold mb-2">Jenis Kelamin:</label>
                    <div class="flex items-center space-x-4">
                        <label class="inline-flex items-center">
                            <input type="radio" name="jenis_kelamin" value="Laki-laki" {{ old('jenis_kelamin', $pegawai->jenis_kelamin) == 'Laki-laki' ? 'checked' : '' }} class="form-radio h-4 w-4 text-blue-600">
                            <span class="ml-2 text-gray-700">Laki-laki</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="radio" name="jenis_kelamin" value="Perempuan" {{ old('jenis_kelamin', $pegawai->jenis_kelamin) == 'Perempuan' ? 'checked' : '' }} class="form-radio h-4 w-4 text-blue-600">
                            <span class="ml-2 text-gray-700">Perempuan</span>
                        </label>
                    </div>
                    @error('jenis_kelamin')
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Email --}}
                <div>
                    <label for="email" class="block text-gray-700 text-sm font-semibold mb-2">Email:</label>
                    <input type="email" name="email" id="email" value="{{ old('email', $pegawai->email) }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 bg-gray-50 text-gray-900">
                    @error('email')
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Nomor Telepon --}}
                <div>
                    <label for="nomor_telepon" class="block text-gray-700 text-sm font-semibold mb-2">Nomor Telepon:</label>
                    <input type="text" name="nomor_telepon" id="nomor_telepon" value="{{ old('nomor_telepon', $pegawai->nomor_telepon) }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 bg-gray-50 text-gray-900">
                    @error('nomor_telepon')
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Jabatan --}}
                <div>
                    <label for="jabatan" class="block text-gray-700 text-sm font-semibold mb-2">Jabatan:</label>
                    <input type="text" name="jabatan" id="jabatan" value="{{ old('jabatan', $pegawai->jabatan) }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 bg-gray-50 text-gray-900">
                    @error('jabatan')
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Golongan Pangkat --}}
                <div>
                    <label for="golongan_pangkat" class="block text-gray-700 text-sm font-semibold mb-2">Pangkat dan Golongan:</label>
                    <input type="text" name="golongan_pangkat" id="golongan_pangkat" value="{{ old('golongan_pangkat', $pegawai->golongan_pangkat) }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 bg-gray-50 text-gray-900">
                    @error('golongan_pangkat')
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Unit Kerja --}}
                <div>
                    <label for="unit_kerja_id" class="block text-gray-700 text-sm font-semibold mb-2">Unit Kerja:</label>
                    <select name="unit_kerja_id" id="unit_kerja_id"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 bg-gray-50 text-gray-900">
                        <option value="">Pilih Unit Kerja</option>
                        @foreach ($unit_kerja as $unit)
                            <option value="{{ $unit->id }}" {{ old('unit_kerja_id', $pegawai->unit_kerja_id) == $unit->id ? 'selected' : '' }}>
                                {{ $unit->nama_unit }}
                            </option>
                        @endforeach
                    </select>
                    @error('unit_kerja_id')
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Status Pegawai --}}
                <div>
                    <label for="status_pegawai" class="block text-gray-700 text-sm font-semibold mb-2">Status Pegawai:</label>
                    <select name="status_pegawai" id="status_pegawai"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 bg-gray-50 text-gray-900">
                        <option value="">Pilih</option>
                        <option value="Aktif" {{ old('status_pegawai', $pegawai->status_pegawai) == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="Non-aktif" {{ old('status_pegawai', $pegawai->status_pegawai) == 'Non-aktif' ? 'selected' : '' }}>Non-aktif</option>
                        <option value="Pensiun" {{ old('status_pegawai', $pegawai->status_pegawai) == 'Pensiun' ? 'selected' : '' }}>Pensiun</option>
                    </select>
                    @error('status_pegawai')
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            {{-- Alamat (Full Width) --}}
            <div class="mb-8">
                <label for="alamat" class="block text-gray-700 text-sm font-semibold mb-2">Alamat:</label>
                <textarea name="alamat" id="alamat" rows="3"
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 bg-gray-50 text-gray-900">{{ old('alamat', $pegawai->alamat) }}</textarea>
                @error('alamat')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="flex flex-col sm:flex-row justify-center space-y-4 sm:space-y-0 sm:space-x-4">
                <button type="submit" class="w-full sm:w-auto px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg shadow-md hover:bg-blue-700 transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    Perbarui Data Pegawai
                </button>
                @if(request()->has('_redirect_to'))
                    <a href="{{ request('_redirect_to') }}" class="w-full sm:w-auto px-6 py-3 border border-gray-300 text-gray-700 font-semibold rounded-lg shadow-md hover:bg-gray-100 transition-colors text-center focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-offset-2">
                        Batal
                    </a>
                @else
                    <a href="{{ route('pegawai.index') }}" class="w-full sm:w-auto px-6 py-3 border border-gray-300 text-gray-700 font-semibold rounded-lg shadow-md hover:bg-gray-100 transition-colors text-center focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-offset-2">
                        Batal
                    </a>
                @endif
            </div>
        </form>
    </div>
</div>

@endsection

<script src="https://cdn.tailwindcss.com"></script>
<script>
    tailwind.config = {
        theme: {
            extend: {
                fontFamily: {
                    inter: ['Inter', 'sans-serif'],
                },
            },
        },
    };

    document.addEventListener('DOMContentLoaded', function() {
        const fotoProfilInput = document.getElementById('foto_profil');
        const profilePreviewImage = document.getElementById('profile-preview-image');
        const uploadNewButton = document.getElementById('upload-new-button');
        const hapusFotoProfilCheckbox = document.getElementById('hapus_foto_profil');
        const originalProfileSrc = profilePreviewImage.src; // Store the original image source

        // Trigger the hidden file input when "Upload New" button is clicked
        if (uploadNewButton) {
            uploadNewButton.addEventListener('click', function() {
                fotoProfilInput.click();
            });
        }

        // Handle file input change for image preview
        if (fotoProfilInput) {
            fotoProfilInput.addEventListener('change', function(event) {
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        profilePreviewImage.src = e.target.result;
                        // Uncheck "Delete avatar" if a new photo is uploaded
                        if (hapusFotoProfilCheckbox) {
                            hapusFotoProfilCheckbox.checked = false;
                        }
                    };
                    reader.readAsDataURL(file);
                } else {
                    // If no file is selected, revert to original or placeholder
                    profilePreviewImage.src = originalProfileSrc;
                }
            });
        }

        // Handle "Delete avatar" checkbox change
        if (hapusFotoProfilCheckbox) {
            hapusFotoProfilCheckbox.addEventListener('change', function() {
                if (this.checked) {
                    // Set to placeholder if delete is checked
                    profilePreviewImage.src = 'https://placehold.co/128x128/e0e0e0/ffffff?text=No+Photo';
                    // Clear the file input value so it's not sent
                    fotoProfilInput.value = '';
                } else {
                    // Revert to original or current preview if unchecked
                    profilePreviewImage.src = fotoProfilInput.files.length > 0 ? URL.createObjectURL(fotoProfilInput.files[0]) : originalProfileSrc;
                }
            });
        }
    });
</script>
