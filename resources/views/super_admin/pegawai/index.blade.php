{{-- @memperluas parent nya yaitu views/layouts/app --}}
@extends('layouts.app')

{{-- mengirimkan value 'Pegawai' ke @yield milik parent --}}
@section('title', 'Pegawai')

@section('main')
    <main class="app-main">
        <div class="app-content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-12">
                        {{-- jika ada sesi sukses yang dikirimkan oleh controller --}}
                        @if (session('success'))
                            <div class="alert alert-primary" role="alert">
                                {{-- cetak sesi sukses --}}
                                {{ session('success') }}
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger" role="alert">
                                {{ session('error') }}
                            </div>
                        @endif
                    </div>
                    <div class="col-sm-6">
                        <h3 class="mb-0">Daftar Pegawai</h3>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Daftar Pegawai</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="app-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card mb-4 border-top-primary">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="bi bi-people-fill me-2"></i>
                                    {{-- cetak value dari detail_kantor, column nama --}}
                                    Berikut Daftar Pegawai di Kantor <strong>{{ $detail_kantor->nama }}</strong>
                                </h3>
                            </div>

                            <div class="card-body">
                                <div class="bg-light p-3 rounded mb-4 border">
                                    {{-- cetak panggil rute berikut --}}
                                    <form action="{{ route('manajemen.pegawai.index') }}" method="GET">
                                        <div class="row g-3 align-items-end">
                                            <div class="col-md-4">
                                                <label for="filter_kantor" class="form-label fw-bold small text-muted text-uppercase">Filter Wilayah Kantor</label>
                                                <select name="kantor_id" id="filter_kantor" class="form-select border-primary">
                                                    <option value="">-- Tampilkan Seluruh Cabang --</option>
                                                    {{-- lakukan pengulangan pada semua kantor, setiap kantor dijadikan $k --}}
                                                    @foreach ($semua_kantor as $k)
                                                        {{-- value nya akan berisi setiap detail kantor, column kantor_id --}}
                                                        <option value="{{ $k->kantor_id }}"
                                                            {{-- jika permintaan input name="kantor_id" sama dengan detail_kantor, column kantor_id maka tambahkan attribute selected --}}
                                                            {{ request('kantor_id') == $k->kantor_id ? 'selected' : '' }}>
                                                            {{-- ucfirst(): Ini adalah fungsi bawaan PHP (Uppercase First) yang berfungsi mengubah huruf pertama menjadi huruf kapital. --}}
                                                            {{ $k->nama }} ({{ ucfirst($k->tipe) }})
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <button type="submit" class="btn btn-primary shadow-sm">
                                                    <i class="bi bi-search me-1"></i> Cari
                                                </button>
                                                @if(request('kantor_id'))
                                                    {{-- untuk melakukan reset --}}
                                                    <a href="{{ route('manajemen.pegawai.index') }}" class="btn btn-outline-secondary shadow-sm">
                                                        <i class="bi bi-arrow-clockwise me-1"></i> Reset
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <div>
                                        {{-- Logika: Jika filter aktif, arahkan ke kantor tsb dengan cara mengirimkan kantor_id yang terlihat di url. Jika tidak, ke default (ID 1 aslinya pusat) --}}
                                        <a href="{{ route('manajemen.pegawai.create', request('kantor_id') ?? $detail_kantor->kantor_id ?? 1) }}"
                                            class="btn btn-success shadow-sm">
                                            <i class="bi bi-person-plus-fill me-1"></i> Tambah Pegawai Baru
                                        </a>
                                    </div>
                                    <div class="text-muted small">
                                        Menampilkan {{ $daftar_pegawai_yg_terkait_dgn_kantor->firstItem() }} - {{ $daftar_pegawai_yg_terkait_dgn_kantor->lastItem() }} dari {{ $daftar_pegawai_yg_terkait_dgn_kantor->total() }} pegawai
                                    </div>
                                </div>

                                <div class="table-responsive">
                                    <table class="table table-hover table-striped border">
                                        <thead class="table-dark">
                                            <tr>
                                                <th style="width: 50px">#</th>
                                                <th>Nama Pegawai</th>
                                                <th>Email Instansi</th>
                                                <th>Unit Kerja (Kantor)</th>
                                                <th>Peran/Role</th>
                                                <th style="width: 180px" class="text-center">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($daftar_pegawai_yg_terkait_dgn_kantor as $pegawai)
                                                <tr class="align-middle">
                                                    <td>{{ $loop->iteration + $daftar_pegawai_yg_terkait_dgn_kantor->perPage() * ($daftar_pegawai_yg_terkait_dgn_kantor->currentPage() - 1) }}</td>
                                                    <td><strong>{{ $pegawai->name }}</strong></td>
                                                    <td>{{ $pegawai->email }}</td>
                                                    <td>
                                                        <span class="badge border text-dark bg-light">
                                                            {{ $pegawai->kantor->nama ?? 'Tidak Ada Kantor' }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <span class="badge {{ $pegawai->peran == 'admin' ? 'text-bg-info' : 'text-bg-secondary' }}">
                                                            {{ strtoupper($pegawai->peran) }}
                                                        </span>
                                                    </td>
                                                    <td class="text-center">
                                                        <a href="{{ route('manajemen.pegawai.edit', $pegawai->user_id) }}"
                                                            class="btn btn-sm btn-warning shadow-sm" title="Ubah Peran">
                                                            <i class="bi bi-pencil-square"></i> Edit
                                                        </a>

                                                        <form method="POST" action="#" class="d-inline ms-1">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-danger shadow-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus pegawai ini?')">
                                                                <i class="bi bi-trash"></i> Hapus
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="6" class="text-center py-5 text-muted">
                                                        <i class="bi bi-info-circle fs-2 d-block mb-2"></i>
                                                        Tidak ada data pegawai yang ditemukan untuk kantor ini.
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>

                                <div class="d-flex justify-content-center mt-4">
                                    {{ $daftar_pegawai_yg_terkait_dgn_kantor->appends(request()->query())->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
