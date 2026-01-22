{{-- @memperluas parent nya yaitu views/layouts/app --}}
@extends('layouts.app')

{{-- mengirimkan value 'Edit Kategori' ke @yield milik parent --}}
@section('title', 'Edit Kategori')

{{-- mengirimkan value main ke @yield milik parent --}}
@section('main')
    <main class="app-main">
        <div class="app-content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h3 class="mb-0">Edit Kategori</h3>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-end">
                            {{-- panggil rute yang bernama berikut --}}
                            <li class="breadcrumb-item"><a href="{{ route('manajemen.kategori.index') }}">Kategori</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Edit Kategori</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="app-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-warning card-outline mb-4">
                            <div class="card-header">
                                {{-- cetak detail_kategori, column nama --}}
                                <div class="card-title">Edit Data Kategori: {{ $detail_kategori->nama }}</div>
                            </div>

                            {{-- jika ada error, apa pun itu --}}
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        {{-- lakukan pengulangan untuk semua error, setiap error akan masuk ke @error --}}
                                        @foreach ($errors->all() as $error)
                                            {{-- cetak setiap errornya --}}
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            {{-- panggil rute berikut lalu kirimkan kategori_dokumen_id berikut --}}
                            <form action="{{ route('manajemen.kategori.update', $detail_kategori->kategori_dokumen_id) }}" method="POST">
                                {{-- untuk mencegah serangan csrf --}}
                                @csrf
                                {{-- WAJIB: Gunakan method PUT untuk proses update --}}
                                @method('PUT')

                                <div class="card-body">
                                    <div class="mb-3">
                                        <label for="nama" class="form-label">Nama</label>
                                        {{-- value mengambil dari old() atau data di database ($detail_kategori->nama) --}}
                                        {{-- Fungsi old('nama') dalam Laravel adalah teknik untuk mempertahankan nilai input agar pengguna tidak perlu mengetik ulang jika terjadi kesalahan validasi --}}
                                        <input name="nama" type="text" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama', $detail_kategori->nama) }}" id="nama" />
                                        {{-- cetak kesalahan jika input name="nama" error --}}
                                        @error('nama')
                                        {{-- cetak {{ $message }} --}}
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="jenis" class="form-label">Jenis</label>
                                        <select name="jenis" class="form-select @error('jenis') is-invalid @enderror" id="jenis" required>
                                            <option disabled value="">Silahkan pilih...</option>
                                            {{-- {{ old('jenis', $detail_kategori->jenis) == 'Teknis' ? 'selected' : '' }} berarti jika value adalah teknis maka tambahkan attribute selected --}}
                                            <option value="Teknis" {{ old('jenis', $detail_kategori->jenis) == 'Teknis' ? 'selected' : '' }}>Teknis</option>
                                            <option value="Keuangan" {{ old('jenis', $detail_kategori->jenis) == 'Keuangan' ? 'selected' : '' }}>Keuangan</option>
                                            <option value="Kepegawaian" {{ old('jenis', $detail_kategori->jenis) == 'Kepegawaian' ? 'selected' : '' }}>Kepegawaian</option>
                                            <option value="Umum" {{ old('jenis', $detail_kategori->jenis) == 'Umum' ? 'selected' : '' }}>Umum</option>
                                        </select>
                                        @error('jenis')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="deskripsi" class="form-label">Deskripsi</label>
                                        <textarea name="deskripsi" id="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror"
                                                  cols="30" rows="5">{{ old('deskripsi', $detail_kategori->deskripsi) }}</textarea>
                                        @error('deskripsi')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="card-footer mb-3">
                                    <button type="submit" class="btn btn-warning">Perbarui</button>
                                    <a href="{{ route('manajemen.kategori.index') }}" class="btn btn-danger">Kembali</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
