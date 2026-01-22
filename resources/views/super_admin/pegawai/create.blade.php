{{-- Memperluas layouts.app nya atau parent nya --}}
@extends('layouts.app')

{{-- Mengirimkan value berikut ke yield title milik parent --}}
@section('title', 'Tambah Pegawai Baru')

{{-- Mengisi yield 'main' di file parent dengan konten di bawah ini --}}
@section('main')
    <main class="app-main">
        <div class="app-content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-12">
                        {{-- Memeriksa apakah ada sesi pesan error yang dikirim dari controller menggunakan session --}}
                        @if (session('error'))
                            <div class="alert alert-danger" role="alert">
                                {{-- Mencetak isi pesan error dari session --}}
                                {{ session('error') }}
                            </div>
                        @endif
                    </div>
                    <div class="col-sm-6">
                        <h3 class="mb-0">Manajemen Pegawai</h3>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-end">
                            {{-- Membuat link kembali ke halaman daftar pegawai menggunakan nama route --}}
                            {{-- cetak rute berikut --}}
                            <li class="breadcrumb-item"><a href="{{ route('manajemen.pegawai.index') }}">Daftar Pegawai</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Tambah Pegawai</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="app-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-success card-outline mb-4">
                            <div class="card-header">
                                <div class="card-title">Form Tambah Pegawai Baru</div>
                            </div>

                            {{-- Form dikirim ke route store dengan method POST. enctype digunakan karena ada upload file --}}
                            <form action="{{ route('manajemen.pegawai.store') }}" method="POST"
                                enctype="multipart/form-data">
                                {{-- Token keamanan Laravel untuk mencegah serangan Cross-Site Request Forgery --}}
                                @csrf
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="name" class="form-label">Nama Lengkap</label>
                                            {{-- @error akan menambahkan class is-invalid jika validasi kolom 'name' gagal --}}
                                            {{-- old('name') berfungsi agar teks yang sudah diketik tidak hilang jika form error --}}
                                            <input name="name" type="text"
                                                class="form-control @error('name') is-invalid @enderror"
                                                value="{{ old('name') }}" id="name"
                                                placeholder="Masukkan nama lengkap" />
                                            {{-- Menampilkan pesan error spesifik untuk kolom 'name' --}}
                                            @error('name')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="email" class="form-label">Email Instansi</label>
                                            <input name="email" type="email"
                                                class="form-control @error('email') is-invalid @enderror"
                                                value="{{ old('email') }}" id="email"
                                                placeholder="contoh@kantor.com" />
                                            @error('email')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="kantor_id" class="form-label">Unit Kerja (Kantor)</label>
                                            <select name="kantor_id" id="kantor_id"
                                                class="form-select @error('kantor_id') is-invalid @enderror">
                                                <option value="">-- Pilih Kantor Penempatan --</option>
                                                {{-- Melakukan perulangan data kantor yang dikirim dari controller --}}
                                                @foreach ($semua_kantor as $k)
                                                    {{-- Logika selected: Cek input lama, jika kosong cek data kantor terpilih dari halaman index --}}
                                                    <option value="{{ $k->kantor_id }}"
                                                        {{ (old('kantor_id') ?? ($kantor_terpilih->kantor_id ?? '')) == $k->kantor_id ? 'selected' : '' }}>
                                                        {{-- Mencetak nama kantor dan mengubah huruf pertama tipe menjadi kapital --}}
                                                        {{ $k->nama }} ({{ ucfirst($k->tipe) }})
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('kantor_id')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="peran" class="form-label">Peran / Role</label>
                                            <select name="peran" id="peran"
                                                class="form-select @error('peran') is-invalid @enderror">
                                                {{-- Mengecek jika peran tertentu yang dipilih sebelumnya agar tetap terpilih (selected) --}}
                                                <option value="staff" {{ old('peran') == 'staff' ? 'selected' : '' }}>
                                                    STAFF</option>
                                                <option value="admin" {{ old('peran') == 'admin' ? 'selected' : '' }}>
                                                    ADMIN CABANG</option>
                                                <option value="super_admin"
                                                    {{ old('peran') == 'super_admin' ? 'selected' : '' }}>SUPER ADMIN
                                                </option>
                                            </select>
                                            @error('peran')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="password" class="form-label">Password</label>
                                            <div class="input-group">
                                                <input name="password" type="password"
                                                    class="form-control @error('password') is-invalid @enderror"
                                                    id="password" />
                                                <button class="btn btn-outline-secondary" type="button"
                                                    id="togglePassword">
                                                    <i class="bi bi-eye-fill" id="eyeIcon"></i>
                                                </button>
                                            </div>
                                            <small class="text-muted">Gunakan minimal 8 karakter.</small>
                                            {{-- d-block digunakan agar error muncul meskipun input berada di dalam input-group --}}
                                            @error('password')
                                                <span class="invalid-feedback d-block">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="tanda_tangan" class="form-label">Upload Signature (Optional)</label>
                                            <input type="file" name="tanda_tangan" id="tanda_tangan"
                                                class="form-control @error('tanda_tangan') is-invalid @enderror"
                                                accept="image/*" />
                                            <small class="text-muted">Format: PNG/JPG (Max 2MB).</small>

                                            <div class="mt-2">
                                                <img id="previewContainer" src="#" alt="Signature Preview"
                                                    style="max-width: 200px; display: none; border: 1px solid #ddd; padding: 5px; border-radius: 5px;" />
                                            </div>

                                            @error('tanda_tangan')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="card-footer text-end">
                                    <a href="{{ route('manajemen.pegawai.index') }}"
                                        class="btn btn-secondary me-2">Batal</a>
                                    <button type="submit" class="btn btn-success">Simpan Data Pegawai</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

@push('scripts')
    <script>
        // jika documen siap maka jalankan fungsi berikut
        document.addEventListener('DOMContentLoaded', function() {
            // untuk menangkap #password, #togglePassword, dan #eyeIcon
            const passwordInput = document.getElementById('password');
            const toggleButton = document.getElementById('togglePassword');
            const eyeIcon = document.getElementById('eyeIcon');

            // ketika #togglePassword di klik maka jalankan fungsi berikut
            toggleButton.addEventListener('click', function() {
                // Toggle the type attribute
                // jika type password maka diubah ke text, jika text diubah ke password
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);

                // Toggle the eye icon class (Bootstrap Icons)
                if (type === 'password') {
                    // hapus class berikut
                    eyeIcon.classList.remove('bi-eye-slash-fill');
                    // tambahkan class berikut
                    eyeIcon.classList.add('bi-eye-fill');
                }
                // jika tipe nya text maka
                else {
                    // hapus class berikut
                    eyeIcon.classList.remove('bi-eye-fill');
                    // tambah class berikut
                    eyeIcon.classList.add('bi-eye-slash-fill');
                }
            });
        });
    </script>
@endpush
