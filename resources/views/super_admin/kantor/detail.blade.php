{{-- @memperluas parent nya yaitu views/layouts/app --}}
@extends('layouts.app')

{{-- mengirimkan value 'Detail Kantor' ke @yield milik parent --}}
@section('title', 'Detail Kantor')

{{-- mengirimkan value main ke @yield('main') milik parent --}}
@section('main')
    <main class="app-main">
        <!--begin::App Content Header-->
        <div class="app-content-header">
            <!--begin::Container-->
            <div class="container-fluid">
                <!--begin::Row-->
                <div class="row">
                    <div class="col-sm-6">
                        <h3 class="mb-0">Detail Kantor</h3>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item active" aria-current="page">Detail Kantor</li>
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
                                <h3 class="card-title">Nama Kantor: {{ $detail_kantor->nama }}</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <p>Alamat: {{ $detail_kantor->alamat }}</p>
                                <a href="/manajemen/kantor" class="btn btn-sm btn-danger">Kembali</a>
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
