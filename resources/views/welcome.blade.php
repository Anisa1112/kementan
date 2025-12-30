@extends('layouts.app')
@section('title', 'Dashboard Portal Master Data')
@section('content')

    <!-- Content wrapper -->
    <div class="content-wrapper">
        <!-- Content -->
        <div class="container-xxl flex-grow-1 container-p-y">

            <!-- Header -->
            <div class="row mb-4">
                <div class="col-12">
                    <h2 class="fw-bold mb-0">Dashboard Portal Master Data Komoditas</h2>
                    <p class="text-muted mb-0">Sistem Informasi Komoditas Kementerian Pertanian</p>
                </div>
            </div>

            <!-- Statistics Cards -->
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-xl-6 g-4 mb-4">
                <!-- Total Komoditas -->
                <div class="col">
                    <div class="card h-100">
                        <div class="card-body d-flex align-items-start justify-content-between">
                            <div class="content-left">
                                <span class="text-muted d-block mb-1 small">Total Komoditas</span>
                                <h3 class="mb-2 text-primary fw-bold">{{ $totalKomoditas ?? 0 }}</h3>
                                <small class="text-muted">
                                    <i class="ti ti-check-circle text-success"></i> Total data
                                </small>
                            </div>
                            <div class="avatar">
                                <span class="avatar-initial rounded bg-label-primary">
                                    <i class="ti ti-database ti-sm"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tanaman Pangan -->
                <div class="col">
                    <div class="card h-100">
                        <div class="card-body d-flex align-items-start justify-content-between">
                            <div class="content-left">
                                <span class="text-muted d-block mb-1 small">Tanaman Pangan</span>
                                <h3 class="mb-2 text-success fw-bold">{{ $tanamanPangan ?? 0 }}</h3>
                                <small class="text-muted">Total data</small>
                            </div>
                            <div class="avatar">
                                <span class="avatar-initial rounded bg-label-success">
                                    <i class="ti ti-plant ti-sm"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Hortikultura -->
                <div class="col">
                    <div class="card h-100">
                        <div class="card-body d-flex align-items-start justify-content-between">
                            <div class="content-left">
                                <span class="text-muted d-block mb-1 small">Hortikultura</span>
                                <h3 class="mb-2 text-warning fw-bold">{{ $hortikultura ?? 0 }}</h3>
                                <small class="text-muted">Total data</small>
                            </div>
                            <div class="avatar">
                                <span class="avatar-initial rounded bg-label-warning">
                                    <i class="ti ti-flower ti-sm"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Perkebunan -->
                <div class="col">
                    <div class="card h-100">
                        <div class="card-body d-flex align-items-start justify-content-between">
                            <div class="content-left">
                                <span class="text-muted d-block mb-1 small">Perkebunan</span>
                                <h3 class="mb-2 text-danger fw-bold">{{ $perkebunan ?? 0 }}</h3>
                                <small class="text-muted">Total data</small>
                            </div>
                            <div class="avatar">
                                <span class="avatar-initial rounded bg-label-danger">
                                    <i class="ti ti-tree ti-sm"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Peternakan -->
                <div class="col">
                    <div class="card h-100">
                        <div class="card-body d-flex align-items-start justify-content-between">
                            <div class="content-left">
                                <span class="text-muted d-block mb-1 small">Peternakan</span>
                                <h3 class="mb-2 text-info fw-bold">{{ $peternakan ?? 0 }}</h3>
                                <small class="text-muted">Total data</small>
                            </div>
                            <div class="avatar">
                                <span class="avatar-initial rounded bg-label-info">
                                    <i class="ti ti-paw ti-sm"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total PSP -->
                <div class="col">
                    <div class="card h-100">
                        <div class="card-body d-flex align-items-start justify-content-between">
                            <div class="content-left">
                                <span class="text-muted d-block mb-1 small">Total PSP</span>
                                <h3 class="mb-2 text-dark fw-bold">{{ $totalPsp ?? 0 }}</h3>
                                <small class="text-muted">Total data</small>
                            </div>
                            <div class="avatar">
                                <span class="avatar-initial rounded bg-label-dark">
                                    <i class="ti ti-file-text ti-sm"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Data Table Komoditas -->
            <div class="card mb-4">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="mb-0">Data Komoditas Terbaru</h5>
                            <small class="text-muted">Preview 10 data terbaru</small>
                        </div>
                        <a href="{{ route('komoditas') }}" class="btn btn-primary btn-sm">
                            <i class="ti ti-eye me-1"></i>Lihat Semua Data
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <!-- Table -->
                    <div class="table-responsive">
                        @if ($komoditas->count() > 0)
                            <table class="table table-hover table-sm">
                                <thead class="table-light small">
                                    <tr>
                                        <th style="width: 5%">No</th>
                                        <th style="width: 10%">Kode</th>
                                        <th style="width: 11%">Sektor</th>
                                        <th style="width: 11%">Subsektor</th>
                                        <th style="width: 11%">Kategori</th>
                                        <th style="width: 11%">Item</th>
                                        <th style="width: 11%">Jenis</th>
                                        <th style="width: 13%">Nama Latin</th>
                                        <th style="width: 9%" class="text-center">Status</th>
                                        <th style="width: 8%" class="text-center">Aksi</th>
                                    </tr>
                                </thead>

                                <tbody class="small">
                                    @foreach ($komoditas->take(10) as $index => $item)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>
                                                <span class="badge bg-primary text-truncate" style="max-width: 100px;">
                                                    {{ $item->kode }}
                                                </span>
                                            </td>
                                            <td><small>{{ $item->sektor ?? '-' }}</small></td>
                                            <td><small>{{ $item->subsektor ?? '-' }}</small></td>
                                            <td><small>{{ $item->kategori ?? '-' }}</small></td>
                                            <td class="fw-semibold"><small>{{ $item->item ?? '-' }}</small></td>
                                            <td><small>{{ $item->jenis ?? '-' }}</small></td>
                                            <td>
                                                <small>
                                                    <em class="text-muted">{{ $item->nama_latin ?? '-' }}</em>
                                                </small>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge bg-{{ $item->status == 'Aktif' ? 'success' : 'secondary' }}">
                                                    {{ $item->status }}
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <button type="button"
                                                        class="btn btn-sm btn-icon btn-outline-info"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#detailModal{{ $item->id }}"
                                                        title="Lihat Detail">
                                                    <i class="ti ti-eye"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <div class="text-center py-5">
                                <div class="mb-3">
                                    <i class="ti ti-database-off" style="font-size: 64px; opacity: 0.3;"></i>
                                </div>
                                <h5 class="text-muted mb-2">Tidak Ada Data</h5>
                                <p class="text-muted mb-3">Belum ada data komoditas yang terdaftar.</p>
                                @auth
                                    @if(auth()->user()->canCRUD())
                                        <a href="{{ route('komoditas') }}" class="btn btn-primary">
                                            <i class="ti ti-plus me-1"></i>Tambah Komoditas
                                        </a>
                                    @endif
                                @endauth
                            </div>
                        @endif
                    </div>

                    @if ($komoditas->count() > 10)
                        <div class="mt-3 text-center">
                            <p class="text-muted mb-2">Menampilkan 10 dari {{ $komoditas->count() }} data</p>
                            <a href="{{ route('komoditas') }}" class="btn btn-sm btn-primary">
                                <i class="ti ti-arrow-right me-1"></i>Lihat Semua Data
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Data Table PSP -->
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="mb-0">Data PSP Terbaru</h5>
                            <small class="text-muted">Preview 10 data terbaru</small>
                        </div>
                        <a href="{{ route('komoditas', ['tab' => 'psp']) }}" class="btn btn-dark btn-sm">
                            <i class="ti ti-eye me-1"></i>Lihat Semua Data
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <!-- Table -->
                    <div class="table-responsive">
                        @if (isset($psp) && $psp->count() > 0)
                            <table class="table table-hover table-sm">
                                <thead class="table-light small">
                                    <tr>
                                        <th style="width: 5%">No</th>
                                        <th style="width: 12%">Kode</th>
                                        <th style="width: 20%">Sektor</th>
                                        <th style="width: 15%">Jenis</th>
                                        <th style="width: 15%">Kategori</th>
                                        <th style="width: 18%">Item</th>
                                        <th style="width: 10%" class="text-center">Status</th>
                                        <th style="width: 8%" class="text-center">Aksi</th>
                                    </tr>
                                </thead>

                                <tbody class="small">
                                    @foreach ($psp->take(10) as $index => $item)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>
                                                <span class="badge bg-dark text-truncate" style="max-width: 120px;">
                                                    {{ $item->kode ?? '-' }}
                                                </span>
                                            </td>
                                            <td><small>{{ $item->sektor ?? '-' }}</small></td>
                                            <td><small>{{ $item->jenis ?? '-' }}</small></td>
                                            <td><small>{{ $item->kategori ?? '-' }}</small></td>
                                            <td class="fw-semibold">
                                                <small class="text-truncate d-block" style="max-width: 200px;">
                                                    {{ $item->item ?? '-' }}
                                                </small>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge bg-{{ $item->status == 'Aktif' ? 'success' : 'secondary' }}">
                                                    {{ $item->status ?? 'Aktif' }}
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <button type="button"
                                                        class="btn btn-sm btn-icon btn-outline-info"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#detailPspModal{{ $item->id }}"
                                                        title="Lihat Detail">
                                                    <i class="ti ti-eye"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <div class="text-center py-5">
                                <div class="mb-3">
                                    <i class="ti ti-file-off" style="font-size: 64px; opacity: 0.3;"></i>
                                </div>
                                <h5 class="text-muted mb-2">Tidak Ada Data</h5>
                                <p class="text-muted mb-3">Belum ada data PSP yang terdaftar.</p>
                                @auth
                                    @if(auth()->user()->canCRUD())
                                        <a href="{{ route('komoditas', ['tab' => 'psp']) }}" class="btn btn-dark">
                                            <i class="ti ti-plus me-1"></i>Tambah PSP
                                        </a>
                                    @endif
                                @endauth
                            </div>
                        @endif
                    </div>

                    @if (isset($psp) && $psp->count() > 10)
                        <div class="mt-3 text-center">
                            <p class="text-muted mb-2">Menampilkan 10 dari {{ $psp->count() }} data</p>
                            <a href="{{ route('komoditas', ['tab' => 'psp']) }}" class="btn btn-sm btn-dark">
                                <i class="ti ti-arrow-right me-1"></i>Lihat Semua Data
                            </a>
                        </div>
                    @endif
                </div>
            </div>

        </div>
        <!-- / Content -->
    </div>
    <!-- / Content wrapper -->

    <!-- Detail Modals Komoditas -->
    @foreach ($komoditas->take(10) as $item)
        <div class="modal fade" id="detailModal{{ $item->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <h5 class="modal-title text-white">
                            <i class="ti ti-info-circle me-2"></i>Detail Komoditas
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-3">
                            <!-- Kode -->
                            <div class="col-md-6">
                                <label class="form-label text-muted small mb-1">Kode Komoditas</label>
                                <div class="fw-semibold">
                                    <span class="badge bg-primary">{{ $item->kode }}</span>
                                </div>
                            </div>

                            <!-- Status -->
                            <div class="col-md-6">
                                <label class="form-label text-muted small mb-1">Status</label>
                                <div class="fw-semibold">
                                    <span class="badge bg-{{ $item->status == 'Aktif' ? 'success' : 'secondary' }}">
                                        {{ $item->status }}
                                    </span>
                                </div>
                            </div>

                            <!-- Sektor -->
                            <div class="col-md-6">
                                <label class="form-label text-muted small mb-1">Sektor</label>
                                <div class="fw-semibold">{{ $item->sektor ?? '-' }}</div>
                            </div>

                            <!-- Subsektor -->
                            <div class="col-md-6">
                                <label class="form-label text-muted small mb-1">Subsektor</label>
                                <div class="fw-semibold">{{ $item->subsektor ?? '-' }}</div>
                            </div>

                            <!-- Kategori -->
                            <div class="col-md-6">
                                <label class="form-label text-muted small mb-1">Kategori</label>
                                <div class="fw-semibold">{{ $item->kategori ?? '-' }}</div>
                            </div>

                            <!-- Item -->
                            <div class="col-md-6">
                                <label class="form-label text-muted small mb-1">Item</label>
                                <div class="fw-semibold">{{ $item->item ?? '-' }}</div>
                            </div>

                            <!-- Jenis -->
                            <div class="col-md-6">
                                <label class="form-label text-muted small mb-1">Jenis</label>
                                <div class="fw-semibold">{{ $item->jenis ?? '-' }}</div>
                            </div>

                            <!-- Nama Latin -->
                            <div class="col-md-6">
                                <label class="form-label text-muted small mb-1">Nama Latin</label>
                                <div class="fw-semibold">
                                    <em class="text-muted">{{ $item->nama_latin ?? '-' }}</em>
                                </div>
                            </div>

                            <!-- Deskripsi (jika ada) -->
                            @if(isset($item->deskripsi) && $item->deskripsi)
                            <div class="col-12">
                                <label class="form-label text-muted small mb-1">Deskripsi</label>
                                <div class="fw-normal">{{ $item->deskripsi }}</div>
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="ti ti-x me-1"></i>Tutup
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    <!-- Detail Modals PSP -->
    @if(isset($psp))
        @foreach ($psp->take(10) as $item)
            <div class="modal fade" id="detailPspModal{{ $item->id }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header bg-dark">
                            <h5 class="modal-title text-white">
                                <i class="ti ti-info-circle me-2"></i>Detail PSP
                            </h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row g-3">
                                <!-- Kode PSP -->
                                <div class="col-md-6">
                                    <label class="form-label text-muted small mb-1">Kode</label>
                                    <div class="fw-semibold">
                                        <span class="badge bg-dark">{{ $item->kode ?? '-' }}</span>
                                    </div>
                                </div>

                                <!-- Status -->
                                <div class="col-md-6">
                                    <label class="form-label text-muted small mb-1">Status</label>
                                    <div class="fw-semibold">
                                        <span class="badge bg-{{ $item->status == 'Aktif' ? 'success' : 'secondary' }}">
                                            {{ $item->status ?? 'Aktif' }}
                                        </span>
                                    </div>
                                </div>

                                <!-- Sektor -->
                                <div class="col-md-6">
                                    <label class="form-label text-muted small mb-1">Sektor</label>
                                    <div class="fw-semibold">{{ $item->sektor ?? '-' }}</div>
                                </div>

                                <!-- Jenis -->
                                <div class="col-md-6">
                                    <label class="form-label text-muted small mb-1">Jenis</label>
                                    <div class="fw-semibold">{{ $item->jenis ?? '-' }}</div>
                                </div>

                                <!-- Kategori -->
                                <div class="col-12">
                                    <label class="form-label text-muted small mb-1">Kategori</label>
                                    <div class="fw-semibold">{{ $item->kategori ?? '-' }}</div>
                                </div>

                                <!-- Item -->
                                <div class="col-12">
                                    <label class="form-label text-muted small mb-1">Item</label>
                                    <div class="fw-semibold">{{ $item->item ?? '-' }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                <i class="ti ti-x me-1"></i>Tutup
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endif

@endsection
