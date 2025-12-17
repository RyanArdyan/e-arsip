{{-- @memperluas parent nya yaitu views/layouts/app --}}
@extends('layouts.app')

{{-- mengirimkan value 'Edit Profile' ke @yield milik parent --}}
@section('title', 'Edit Profile')

{{-- mengirimkan value main ke @yield milik parent --}}
@section('main')
    <main class="app-main">
        <!--begin::App Content Header-->
        <div class="app-content-header">
            <!--begin::Container-->
            <div class="container-fluid">
                <!--begin::Row-->
                <div class="row">
                    <div class="col-sm-12">
                        {{-- jika ada sesi sukses yang dikimkan controller maka --}}
                        @if (@session('success'))
                            <div class="alert alert-primary" role="alert">
                                {{ session('success') }}
                            </div>
                            @endsession
                    </div>
                    <div class="col-sm-6">
                        <h3 class="mb-0">Edit Profile</h3>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item active" aria-current="page">Edit Profile</li>
                        </ol>
                    </div>
                </div>
                <!--end::Row-->
            </div>
            <!--end::Container-->
        </div>
        <!--end::App Content Header-->
        <!--begin::App Content-->
        <div class="app-content">
            <!--begin::Container-->
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <!--begin::Quick Example-->
                        <div class="card card-primary card-outline mb-4">
                            <!--begin::Header-->
                            <div class="card-header">
                                <div class="card-title">Silahkan edit</div>
                            </div>
                            <!--end::Header-->

                            <!--begin::Form-->
                            {{-- enctype="multipart/form-data" agar bisa mengupload file --}}
                            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                                {{-- agar aman dari serangan --}}
                                @csrf
                                {{-- agar method PUT bekerja --}}
                                @method('PUT')
                                <!--begin::Body-->
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Nama</label>
                                        {{--  value="{{ $name }}" berarti cetak value name --}}
                                        {{--  @error('name') is-invalid @enderror" berarti tambahkan class is-invalid jika ketemu error pada name --}}
                                        {{--  value="{{ old('name', $name) }}" , old('name') berarti cetak value lama pada input name jika input name salah --}}
                                        {{-- value="{{ old('name', $name) }}", $name berarti cetak value detail user yg login, column name --}}
                                        <input name="name" type="text"
                                            class="form-control @error('name') is-invalid @enderror"
                                            value="{{ old('name', $name) }}" id="name" />
                                        {{-- jika ada error pada name maka --}}
                                        @error('name')
                                            {{-- cetak pesan error nya --}}
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror

                                    </div>
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input name="email" type="email"
                                            class="form-control @error('email') is-invalid @enderror"
                                            value="{{ old('email', $email) }}" id="email" />
                                        @error('email')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="password_lama" class="form-label">Password Lama</label>
                                        <div class="input-group">
                                            <input name="password_lama" type="password"
                                                class="form-control  @error('password_lama') is-invalid @enderror"
                                                id="password_lama" />
                                            <button class="btn btn-outline-primary" type="button" id="togglePasswordLama">
                                                <i class="bi bi-eye-fill" id="eyeIconLama"></i>
                                            </button>
                                        </div>
                                        @error('password_lama')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="password_baru" class="form-label">Password Baru</label>
                                        <div class="input-group">
                                            <input name="password_baru" type="password"
                                                class="form-control @error('password_baru') is-invalid @enderror"
                                                id="password_baru" />
                                            <button class="btn btn-outline-primary" type="button" id="togglePasswordBaru">
                                                <i class="bi bi-eye-fill" id="eyeIconBaru"></i>
                                            </button>
                                        </div>
                                        @error('password_baru')
                                            <span class="invalid-feedback d-block">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="tanda_tangan" class="form-label">Upload Tanda Tangan</label>
                                        {{-- Tampilkan Tanda Tangan Saat Ini (Jika Ada) --}}
                                        {{-- jika value column tanda tangan tidak kosong di table users maka --}}
                                        @if (!empty($tanda_tangan))
                                            <div class="mb-2">
                                                <p>Tanda Tangan Saat Ini:</p>
                                                {{-- Sesuaikan $ttd_path dengan path yang benar --}}
                                                {{-- asset('') akan memanggil folder public --}}
                                                <img src="{{ asset('storage/tanda_tangan/' . $tanda_tangan) }}"
                                                    alt="Tanda Tangan" style="max-width: 200px; border: 1px solid #ccc;">
                                                <br>
                                                <small class="text-muted">Upload file baru untuk mengganti.</small>
                                            </div>
                                        @endif

                                        <div class="input-group">
                                            <input type="file" name="tanda_tangan"
                                                class="form-control @error('tanda_tangan') is-invalid @enderror"
                                                id="inputGroupFile02" />
                                            <label class="input-group-text" for="inputGroupFile02">Pilih File TTD</label>
                                        </div>
                                        @error('tanda_tangan')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <!--end::Body-->
                                <!--begin::Footer-->
                                <div class="card-footer mb-3">
                                    <button type="submit" class="btn btn-primary">Kirim</button>
                                </div>
                                <!--end::Footer-->
                            </form>
                            <!--end::Form-->
                        </div>
                        <!--end::Quick Example-->
                    </div>
                </div>
            </div>
            <!--end::Container-->
        </div>
        <!--end::App Content-->
    </main>
@endsection

{{-- START: Tambahkan Script JavaScript untuk Toggle Password --}}
@push('scripts')
    <script>
        // Fungsi generik untuk menangani toggle
        // fungsi pengaturan tombol sandi
        function setupPasswordToggle(toggleId, inputId, iconId) {
            // berisi dokumen dapatkan element dengan id berikut
            const toggleButton = document.getElementById(toggleId);
            const passwordField = document.getElementById(inputId);
            const eyeIcon = document.getElementById(iconId);

            // untuk memastikan bahwa elemen-elemen HTML yang dicari oleh JavaScript benar-benar ada di halaman (DOM) sebelum kode mencoba memanipulasinya.
            if (toggleButton && passwordField && eyeIcon) {
                // jika tombol toggle di click maka jalankan fungsi berikut
                toggleButton.addEventListener('click', function() {
                    // Toggle tipe input: password <-> text
                    // berisi panggil input passwordField, dapatkan atribut type, jika tipe password maka ganti menjadi text, jika text maka ganti menjadi password, disimpan di const type
                    const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
                    // input password lakukan setel attribute untuk mengatur atribut type menjadi nilai pada variable type
                    passwordField.setAttribute('type', type);

                    // Toggle ikon (bi-eye-fill untuk terlihat, bi-eye-slash-fill untuk tersembunyi)
                    // Jika elemen saat ini memiliki class 'bi-eye-fill' (ikon mata terbuka/terlihat), metode ini akan menghapus class tersebut.
                    // Jika elemen saat ini tidak memiliki class 'bi-eye-fill', metode ini akan menambahkan class tersebut.
                    eyeIcon.classList.toggle('bi-eye-fill');
                    eyeIcon.classList.toggle('bi-eye-slash-fill');
                });
            }
        }

        // Setup untuk Password Lama
        // panggil fungsi setupPasswordToggle lalu kirimkan button#togglePasswordLama #input#password_lama i##eyeIconLama
        setupPasswordToggle('togglePasswordLama', 'password_lama', 'eyeIconLama');

        // Setup untuk Password Baru
        setupPasswordToggle('togglePasswordBaru', 'password_baru', 'eyeIconBaru');
    </script>
@endpush
{{-- END: Tambahkan Script JavaScript untuk Toggle Password --}}
