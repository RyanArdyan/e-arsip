{{-- @memperluas parent nya yaitu views/layouts/app --}}
@extends('layouts.app')

{{-- mengirimkan value 'Edit Profile' ke @yield milik parent --}}
@section('title', 'Kantor')

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
                        @if (@session('success'))
                            <div class="alert alert-primary" role="alert">
                                {{-- cetak sesi sukses --}}
                                {{ session('success') }}
                            </div>
                            @endsession
                    </div>
                    <div class="col-sm-6">
                        <h3 class="mb-0">Daftar Kantor</h3>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item active" aria-current="page">Daftar Kantor</li>
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
                                <h3 class="card-title">Berikut Daftar Kantor Yang Tersedia</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th style="width: 10px">#</th>
                                            <th>Nama</th>
                                            <th style="width: 25%">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {{-- lakukan pengulangan kepada semua kantor --}}
                                        @foreach ($semua_kantor as $kantor)
                                            <tr class="align-middle">
                                                <td>{{ $loop->iteration + ($semua_kantor->perPage() * ($semua_kantor->currentPage() - 1)) }}</td>
                                                {{-- cetak value detail kantor, column nama --}}
                                                <td>{{ $kantor->nama }}</td>
                                                <td>
                                                    <a href="/manajemen/kantor/detail/{{ $kantor->kantor_id }}" class="badge text-bg-primary">Detail</a>
                                                    <a href="" class="badge text-bg-warning">Edit</a>
                                                    <a href="" class="badge text-bg-danger">Hapus</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                                <div class="d-flex justify-content-center mt-3">
                                    {{ $semua_kantor->links() }}
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
