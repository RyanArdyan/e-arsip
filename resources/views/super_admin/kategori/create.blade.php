{{-- @memperluas parent nya yaitu views/layouts/app --}}
@extends('layouts.app')

{{-- mengirimkan value 'Tambah kategori' ke @yield milik parent --}}
@section('title', 'Tambah Kategori')

{{-- mengirimkan value main ke @yield milik parent --}}
@section('main')
    <main class="app-main">
        <!--begin::App Content Header-->
        <div class="app-content-header">
            <!--begin::Container-->
            <div class="container-fluid">
                <!--begin::Row-->
                <div class="row">
                    <div class="col-sm-6">
                        <h3 class="mb-0">Tambah Kategori</h3>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item active" aria-current="page">Tambah Kategori</li>
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
                                <div class="card-title">Silahkan Tambah Kategori</div>
                            </div>
                            <!--end::Header-->

                            {{-- jika ada error apa pun itu --}}
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        {{-- lakukan pengulangan terhadap semua error lalu setiap error akan jadi $error --}}
                                        @foreach ($errors->all() as $error)
                                            {{-- cetak setiap error --}}
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <!--begin::Form-->
                            {{-- enctype="multipart/form-data" agar bisa mengupload file --}}
                            <form action="/manajemen/kategori/store" method="POST">
                                {{-- agar aman dari serangan --}}
                                @csrf
                                {{-- metode 'POST' --}}
                                @method('POST')
                                <!--begin::Body-->
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label for="nama" class="form-label">Nama</label>
                                        {{--  @error('nama') is-invalid @enderror" berarti tambahkan class is-invalid jika ketemu error pada nama --}}
                                        {{--  value="{{ old('nama') }}" berarti cetak value lama pada input nama jika input nama salah --}}
                                        <input name="nama" type="text" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama') }}" id="nama" />
                                        {{-- jika ada error pada nama maka --}}
                                        @error('nama')
                                            {{-- cetak pesan error nya --}}
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="jenis" class="form-label">Jenis</label>
                                        <select name="jenis" class="form-select" id="jenis" required>
                                            <option selected disabled value="">Silahkan pilih...</option>
                                            <option value="Teknis">Teknis</option>
                                            <option value="Keuangan">Keuangan</option>
                                            <option value="Kepegawaian">Kepegawaian</option>
                                            <option value="Umum">Umum</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="deskripsi" class="form-label">Deskripsi</label>
                                        <textarea name="deskripsi" id="deskripsi" class="form-control" cols="30" rows="5"></textarea>
                                        @error('deskripsi')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <!--end::Body-->
                                <!--begin::Footer-->
                                <div class="card-footer mb-3">
                                    <button type="submit" class="btn btn-primary">Kirim</button>
                                    <a href="/manajemen/kategori" type="submit" class="btn btn-danger">Kembali</a>
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
    <script></script>
@endpush
{{-- END: Tambahkan Script JavaScript untuk Toggle Password --}}
