{{-- memperluas parent  --}}
@extends('layouts.app')

{{-- kirimkan value @title ke @yield title --}}
@section('title', 'Edit Kantor')

{{-- kirimkan value @main ke @yield main --}}
@section('main')
    <main class="app-main">
        <div class="app-content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h3 class="mb-0">Edit Kantor</h3>
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
                                {{-- cetak detail_kantor, column nama --}}
                                <div class="card-title">Ubah data kantor: {{ $detail_kantor->nama }}</div>
                            </div>

                            {{-- panggil url berikut lalu kirimkan kantor_id --}}
                            <form action="/manajemen/kantor/update/{{ $detail_kantor->kantor_id }}" method="POST">
                                {{-- agar aman dari serangan csrf --}}
                                @csrf
                                {{-- untuk memanggil rute method put --}}
                                @method('PUT') {{-- PENTING: Untuk Update gunakan PUT --}}

                                <div class="card-body">
                                    <div class="mb-3">
                                        <label for="nama" class="form-label">Nama</label>
                                        {{-- @error('nama') is-invalid @enderror agar jika ada error maka class is-invalid akan dibuat --}}
                                        {{-- old('nama') akan mencetak data nama input lama ketika misalnya alamat belum diisi --}}
                                        {{-- $detail_kantor->nama akan mencetak value detail_kantor, column nama --}}
                                        <input name="nama" type="text"
                                            class="form-control @error('nama') is-invalid @enderror"
                                            value="{{ old('nama', $detail_kantor->nama) }}" id="nama" />
                                        {{-- jika ada error nama maka --}}
                                        @error('nama')
                                        {{-- {{ $message }} akan mencetak pesan error --}}
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="alamat" class="form-label">Alamat</label>
                                        <input name="alamat" type="text"
                                            class="form-control @error('alamat') is-invalid @enderror"
                                            value="{{ old('alamat', $detail_kantor->alamat) }}" id="alamat" />
                                        @error('alamat')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="tipe" class="form-label">Tipe</label>
                                        <select name="tipe" class="form-select" id="tipe" required>
                                            {{--  $detail_kantor->tipe) == 'pusat' ? 'selected' : '' berarti jika value detail kantor, column tipe sama dengan 'pusat' maka tambahkan attributee selected--}}
                                            <option value="pusat" {{ old('tipe', $detail_kantor->tipe) == 'pusat' ? 'selected' : '' }}>Pusat</option>
                                            <option value="cabang" {{ old('tipe', $detail_kantor->tipe) == 'cabang' ? 'selected' : '' }}>Cabang</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="card-footer mb-3">
                                    <button type="submit" class="btn btn-warning">Perbarui</button>
                                    <a href="/manajemen/kantor" class="btn btn-danger">Kembali</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
