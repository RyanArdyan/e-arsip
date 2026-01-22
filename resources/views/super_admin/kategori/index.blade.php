{{-- @memperluas parent nya yaitu views/layouts/app --}}
@extends('layouts.app')

{{-- mengirimkan value 'kategori' ke @yield milik parent --}}
@section('title', 'Kategori')

{{-- mengirimkan value main ke @yield('main') milik parent --}}
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
                        @if (session('success'))
                            <div class="alert alert-primary" role="alert">
                                {{-- cetak sesi sukses --}}
                                {{ session('success') }}
                            </div>
                        @endif

                        {{-- jika ada sesi error yang dikimkan controller maka --}}
                        @if (session('error'))
                            <div class="alert alert-danger" role="alert">
                                {{-- cetak sesi sukses --}}
                                {{ session('error') }}
                            </div>
                        @endif
                    </div>
                    <div class="col-sm-6">
                        <h3 class="mb-0">Daftar kategori</h3>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item active" aria-current="page">Daftar kategori</li>
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
                        <div class="card mb-4">
                            <div class="card-header">
                                <h3 class="card-title">Berikut Daftar kategori Yang Tersedia</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <a href="/manajemen/kategori/create" class="btn btn-sm btn-success mb-2">Tambah kategori</a>

                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th style="width: 10px">#</th>
                                            <th>Nama</th>
                                            <th style="width: 25%">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {{-- lakukan pengulangan kepada semua kategori --}}
                                        @foreach ($semua_kategori as $kategori)
                                            <tr class="align-middle">
                                                <td>{{ $loop->iteration + ($semua_kategori->perPage() * ($semua_kategori->currentPage() - 1)) }}</td>
                                                {{-- cetak value detail kategori, column nama --}}
                                                <td>{{ $kategori->nama }}</td>
                                                <td>
                                                    <a href="/manajemen/kategori/detail/{{ $kategori->kategori_dokumen_id }}" class="badge text-bg-primary">Detail</a>
                                                    <a href="/manajemen/kategori/edit/{{ $kategori->kategori_dokumen_id }}" class="badge text-bg-warning">Edit</a>

                                                    {{-- ketika dikirim maka panggil konfirmasi penghapusan menggunakan javascript --}}
                                                    {{-- panggil rute berikut, lalu kirimkan kategori_id --}}
                                                    <form onsubmit="return confirm('Apakah anda yakin ingin menghapus kategori ini?')" action="{{ route('manajemen.kategori.destroy', $kategori->kategori_dokumen_id) }}" method="POST" class="d-inline">
                                                        {{-- agar aman dari serangan csrf --}}
                                                        @csrf
                                                        {{-- pake rute dengan method DELETE --}}
                                                        @method('DELETE')
                                                        <button type="submit" class="badge text-bg-danger border-0">Hapus</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                                <div class="d-flex justify-content-center mt-3">
                                    {{-- cetak paginasi --}}
                                    {{ $semua_kategori->links() }}
                                </div>
                            </div>
                        </div>
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
