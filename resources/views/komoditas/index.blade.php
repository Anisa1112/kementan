@extends('layouts.app')
@section('title', 'Data Komoditas Lengkap')
@section('content')

    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">

            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h4 class="fw-bold mb-0">Data Master Komoditas</h4>
                    <p class="text-muted mb-0">Kelola data komoditas dan prasarana sarana pertanian</p>
                </div>
            </div>

            <!-- Alert Success -->
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="ti ti-check me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- Nav Tabs -->
            <ul class="nav nav-tabs nav-fill mb-4" id="dashboardTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link {{ request('tab') != 'psp' ? 'active' : '' }}" id="komoditas-tab"
                        data-bs-toggle="tab" data-bs-target="#komoditas" type="button" role="tab">
                        <i class="ti ti-leaf me-2"></i>Komoditas Pertanian
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link {{ request('tab') == 'psp' ? 'active' : '' }}" id="psp-tab"
                        data-bs-toggle="tab" data-bs-target="#psp" type="button" role="tab">
                        <i class="ti ti-tools me-2"></i>Prasarana & Sarana Pertanian
                    </button>
                </li>
            </ul>

            <!-- Tab Content -->
            <div class="tab-content" id="dashboardTabsContent">

                <!-- TAB 1: KOMODITAS -->
                <div class="tab-pane fade {{ request('tab') != 'psp' ? 'show active' : '' }}" id="komoditas"
                    role="tabpanel">

                    <!-- Header dengan Tombol Tambah -->
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="mb-0">Data Komoditas</h5>
                                @if (hasPermission('manage_komoditas'))
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#createModalKomoditas">
                                        <i class="ti ti-plus me-1"></i>Tambah Komoditas
                                    </button>
                                @endif



                    </div>

                    <div class="card">
                        <!-- Filter Komoditas -->
                        <div class="card-header">
                            <h6 class="card-title mb-3">Filter Data Komoditas</h6>
                            <form method="GET" action="{{ route('komoditas') }}" class="row g-3">
                                <div class="col-md-3">
                                    <label class="form-label small">Sektor</label>
                                    <select name="sektor" class="form-select form-select-sm">
                                        <option value="">Semua Sektor</option>
                                        <option value="Tanaman Pangan"
                                            {{ request('sektor') == 'Tanaman Pangan' ? 'selected' : '' }}>
                                            Tanaman Pangan
                                        </option>
                                        <option value="Hortikultura"
                                            {{ request('sektor') == 'Hortikultura' ? 'selected' : '' }}>
                                            Hortikultura
                                        </option>
                                        <option value="Perkebunan"
                                            {{ request('sektor') == 'Perkebunan' ? 'selected' : '' }}>
                                            Perkebunan
                                        </option>
                                        <option value="Peternakan & Kesehatan Hewan"
                                            {{ request('sektor') == 'Peternakan & Kesehatan Hewan' ? 'selected' : '' }}>
                                            Peternakan & Kesehatan Hewan
                                        </option>
                                    </select>
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label small">Status</label>
                                    <select name="status" class="form-select form-select-sm">
                                        <option value="">Semua Status</option>
                                        <option value="Aktif" {{ request('status') == 'Aktif' ? 'selected' : '' }}>Aktif
                                        </option>
                                        <option value="Tidak Aktif"
                                            {{ request('status') == 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label small">Pencarian</label>
                                    <input type="text" name="search" class="form-control form-control-sm"
                                        placeholder="Cari kode, item, atau nama latin..." value="{{ request('search') }}">
                                </div>

                                <div class="col-md-2">
                                    <label class="form-label small d-block">&nbsp;</label>
                                    <button type="submit" class="btn btn-primary btn-sm me-1">
                                        <i class="ti ti-search me-1"></i>Filter
                                    </button>
                                    <a href="{{ route('komoditas') }}" class="btn btn-secondary btn-sm">
                                        <i class="ti ti-refresh"></i>
                                    </a>
                                </div>
                            </form>
                        </div>

                        <div class="card-body">
                            @if ($komoditas->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-hover table-sm">
                                        <thead class="table-light small">
                                            <tr>
                                                <th style="width: 3%">No</th>
                                                <th style="width: 7%">Kode</th>
                                                <th style="width: 11%">Sektor</th>
                                                <th style="width: 10%">Subsektor</th>
                                                <th style="width: 10%">Kategori</th>
                                                <th style="width: 11%">Item</th>
                                                <th style="width: 10%">Jenis</th>
                                                <th style="width: 12%">Nama Latin</th>
                                                <th style="width: 7%" class="text-center">Status</th>
                                                <th style="width: 14%" class="text-center">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody class="small">
                                            @php $no = 1; @endphp
                                            @foreach ($komoditas as $item)
                                                <tr>
                                                    <td>{{ $no++ }}</td>
                                                    <td><span class="badge bg-primary text-truncate"
                                                            style="max-width: 80px;">{{ $item->kode }}</span></td>
                                                    <td><small>{{ $item->sektor ?? '-' }}</small></td>
                                                    <td><small>{{ $item->subsektor ?? '-' }}</small></td>
                                                    <td><small>{{ $item->kategori ?? '-' }}</small></td>
                                                    <td class="fw-semibold"><small>{{ $item->item ?? '-' }}</small></td>
                                                    <td><small>{{ $item->jenis ?? '-' }}</small></td>
                                                    <td><small><em
                                                                class="text-muted">{{ $item->nama_latin ?? '-' }}</em></small>
                                                    </td>
                                                    <td class="text-center">
                                                        <span
                                                            class="badge bg-{{ $item->status == 'Aktif' ? 'success' : 'secondary' }}">
                                                            {{ $item->status }}
                                                        </span>
                                                    </td>
                                                    <td class="text-center text-nowrap">
                                                        <button type="button"
                                                            class="btn btn-sm btn-icon btn-outline-info"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#detailModalKomoditas{{ $item->id }}"
                                                            title="Lihat Detail">
                                                            <i class="ti ti-eye"></i>
                                                        </button>
                                                        @if (hasPermission('manage_komoditas'))
                                                                <button type="button"
                                                                    class="btn btn-sm btn-icon btn-outline-warning"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#editModalKomoditas{{ $item->id }}"
                                                                    title="Edit">
                                                                    <i class="ti ti-edit"></i>
                                                                </button>
                                                                <button type="button"
                                                                    class="btn btn-sm btn-icon btn-outline-danger"
                                                                    onclick="confirmDelete('komoditas', {{ $item->id }})"
                                                                    title="Hapus">
                                                                    <i class="ti ti-trash"></i>
                                                                </button>
                                                                <form id="delete-form-komoditas-{{ $item->id }}"
                                                                    action="{{ route('komoditas.destroy', $item->id) }}"
                                                                    method="POST" style="display: none;">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                </form>
                                                            @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="mt-3">
                                    {{ $komoditas->appends(['tab' => 'komoditas'])->links('pagination::bootstrap-5') }}
                                </div>
                            @else
                                <div class="text-center py-5">
                                    <i class="ti ti-database-off" style="font-size: 64px; opacity: 0.3;"></i>
                                    <h5 class="text-muted mt-3">Tidak Ada Data</h5>
                                    <p class="text-muted">Belum ada data komoditas yang sesuai dengan filter.</p>
                                </div>
                            @endif
                        </div>

                    </div>
                </div>
                <!-- END TAB KOMODITAS -->

                <!-- TAB 2: PRASARANA & SARANA -->
                <div class="tab-pane fade {{ request('tab') == 'psp' ? 'show active' : '' }}" id="psp"
                    role="tabpanel">

                    <!-- Header dengan Tombol Tambah -->
                    <div class="d-flex justify-content-between align-items-center mb-3">

                        <h5 class="mb-0">Data Prasarana & Sarana Pertanian</h5>
                            @if (hasPermission('manage_komoditas'))
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#createModalPSP">
                                    <i class="ti ti-plus me-1"></i>Tambah PSP
                                </button>
                            @endif
                    </div>

                    <!-- Tabel PSP -->
                    <div class="card">
                        <div class="card-body">
                            @if ($psp->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-hover table-sm">
                                        <thead class="table-light">
                                            <tr>
                                                <th style="width: 5%">No</th>
                                                <th style="width: 12%">Kode</th>
                                                <th style="width: 30%">Nama</th>
                                                <th style="width: 18%">Jenis</th>
                                                <th style="width: 10%" class="text-center">Status</th>
                                                <th style="width: 15%" class="text-center">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($psp as $index => $item)
                                                <tr>
                                                    <td>{{ $psp->firstItem() + $index }}</td>
                                                    <td><span class="badge bg-dark">{{ $item->kode }}</span></td>
                                                    <td class="fw-semibold text-truncate" style="max-width: 250px;">
                                                        {{ $item->nama }}</td>
                                                    <td><small>{{ $item->jenis }}</small></td>
                                                    <td class="text-center">
                                                        <span
                                                            class="badge bg-{{ $item->status == 'Aktif' ? 'success' : 'secondary' }}">
                                                            {{ $item->status }}
                                                        </span>
                                                    </td>
                                                    <td class="text-center text-nowrap">
                                                        <button type="button"
                                                            class="btn btn-sm btn-icon btn-outline-info"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#detailModalPSP{{ $item->id }}"
                                                            title="Lihat Detail">
                                                            <i class="ti ti-eye"></i>
                                                        </button>
                                                        @if (hasPermission('manage_komoditas'))
                                                                <button type="button"
                                                                    class="btn btn-sm btn-icon btn-outline-warning"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#editModalPSP{{ $item->id }}"
                                                                    title="Edit">
                                                                    <i class="ti ti-edit"></i>
                                                                </button>
                                                                <button type="button"
                                                                    class="btn btn-sm btn-icon btn-outline-danger"
                                                                    onclick="confirmDelete('psp', {{ $item->id }})"
                                                                    title="Hapus">
                                                                    <i class="ti ti-trash"></i>
                                                                </button>
                                                                <form id="delete-form-psp-{{ $item->id }}"
                                                                    action="{{ route('psp.destroy', $item->id) }}"
                                                                    method="POST" style="display: none;">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                </form>

                                                            @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="mt-3">
                                    {{ $psp->appends(['tab' => 'psp'])->links('pagination::bootstrap-5') }}
                                </div>
                            @else
                                <div class="text-center py-5">
                                    <i class="ti ti-tools" style="font-size: 64px; opacity: 0.3;"></i>
                                    <h5 class="text-muted mt-3">Tidak Ada Data PSP</h5>
                                    <p class="text-muted">Silakan tambahkan data Prasarana & Sarana Pertanian</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <!-- END TAB PSP -->

            </div>
            <!-- END TAB CONTENT -->

            {{-- MODALS KOMODITAS --}}
            @foreach ($komoditas as $item)
                {{-- Modal Detail Komoditas --}}
                <div class="modal fade" id="detailModalKomoditas{{ $item->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header bg-primary">
                                <h5 class="modal-title text-white">
                                    <i class="ti ti-info-circle me-2"></i>Detail Komoditas
                                </h5>
                                <button type="button" class="btn-close btn-close-white"
                                    data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row g-3">
                                    <!-- Kode -->
                                    <div class="col-md-6">
                                        <label class="form-label text-muted small mb-1">Kode Komoditas</label>
                                        <div class="fw-semibold">
                                            <span class="badge bg-primary fs-6">{{ $item->kode }}</span>
                                        </div>
                                    </div>

                                    <!-- Status -->
                                    <div class="col-md-6">
                                        <label class="form-label text-muted small mb-1">Status</label>
                                        <div class="fw-semibold">
                                            <span
                                                class="badge bg-{{ $item->status == 'Aktif' ? 'success' : 'secondary' }} fs-6">
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

                {{-- Modal Edit Komoditas --}}
                @auth
                    @if (auth()->user()->canCRUD())
                        <div class="modal fade" id="editModalKomoditas{{ $item->id }}" tabindex="-1"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="{{ route('komoditas.update', $item->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-header">
                                            <h5 class="modal-title">Edit Komoditas</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body small">
                                            <div class="mb-3">
                                                <label class="form-label">Kode <span class="text-danger">*</span></label>
                                                <input type="text" name="kode" class="form-control form-control-sm"
                                                    value="{{ $item->kode }}" readonly>
                                                <small class="text-muted">Kode otomatis, tidak bisa diubah.</small>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Sektor <span class="text-danger">*</span></label>
                                                <input type="text" name="sektor" class="form-control form-control-sm"
                                                    value="{{ $item->sektor }}" required>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Subsektor</label>
                                                <input type="text" name="subsektor" class="form-control form-control-sm"
                                                    value="{{ $item->subsektor }}">
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Kategori</label>
                                                <input type="text" name="kategori" class="form-control form-control-sm"
                                                    value="{{ $item->kategori }}">
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Item</label>
                                                <input type="text" name="item" class="form-control form-control-sm"
                                                    value="{{ $item->item }}">
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Jenis <span class="text-danger">*</span></label>
                                                <input type="text" name="jenis" class="form-control form-control-sm"
                                                    value="{{ $item->jenis }}" required>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Nama Latin</label>
                                                <input type="text" name="nama_latin" class="form-control form-control-sm"
                                                    value="{{ $item->nama_latin }}">
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Status <span class="text-danger">*</span></label>
                                                <select name="status" class="form-select form-select-sm" required>
                                                    <option value="Aktif" {{ $item->status == 'Aktif' ? 'selected' : '' }}>
                                                        Aktif</option>
                                                    <option value="Tidak Aktif"
                                                        {{ $item->status == 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary btn-sm"
                                                data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-primary btn-sm">
                                                <i class="ti ti-device-floppy me-1"></i>Simpan
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endif
                @endauth
            @endforeach

            {{-- Modal Tambah Komoditas --}}
            @auth
                @if (auth()->user()->canCRUD())
                    <div class="modal fade" id="createModalKomoditas" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <form action="{{ route('komoditas.store') }}" method="POST">
                                    @csrf
                                    <!-- Hidden input untuk arah redirect -->
                                    <input type="hidden" name="redirect_to" value="master">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Tambah Komoditas Baru</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>

                                    <div class="modal-body small">
                                        <!-- Kode otomatis -->
                                        <div class="mb-3">
                                            <label class="form-label">Kode</label>
                                            <input type="text" class="form-control form-control-sm" value="(otomatis)"
                                                disabled>
                                            <small class="text-muted">Kode akan dibuat otomatis berdasarkan sektor, subsektor,
                                                dan kategori.</small>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-4 mb-3">
                                                <label class="form-label">Sektor <span class="text-danger">*</span></label>
                                                <select id="sektor" name="sektor" class="form-select form-select-sm"
                                                    required>
                                                    <option value="">-- Pilih Sektor --</option>
                                                    <option value="Tanaman Pangan">Tanaman Pangan</option>
                                                    <option value="Hortikultura">Hortikultura</option>
                                                    <option value="Perkebunan">Perkebunan</option>
                                                    <option value="Peternakan & Kesehatan Hewan">Peternakan & Kesehatan Hewan
                                                    </option>
                                                </select>
                                            </div>

                                            <div class="col-md-4 mb-3">
                                                <label class="form-label">Subsektor</label>
                                                <select id="subsektor" name="subsektor" class="form-select form-select-sm">
                                                    <option value="">-- Pilih Subsektor --</option>
                                                    <option data-sektor="Tanaman Pangan" value="Padi">Padi</option>
                                                    <option data-sektor="Tanaman Pangan" value="Palawija">Palawija</option>
                                                    <option data-sektor="Tanaman Pangan"
                                                        value="Kacang-kacangan dan Umbi-umbian">Kacang-kacangan dan Umbi-umbian
                                                    </option>
                                                    <option data-sektor="Hortikultura" value="Buah-buahan">Buah-buahan
                                                    </option>
                                                    <option data-sektor="Hortikultura" value="Sayuran">Sayuran</option>
                                                    <option data-sektor="Hortikultura" value="Tanaman Obat">Tanaman Obat
                                                    </option>
                                                    <option data-sektor="Hortikultura" value="Tanaman Hias">Tanaman Hias
                                                    </option>
                                                    <option data-sektor="Perkebunan" value="Perkebunan">Perkebunan</option>
                                                    <option data-sektor="Peternakan & Kesehatan Hewan" value="Pakan Ternak">
                                                        Pakan Ternak</option>
                                                    <option data-sektor="Peternakan & Kesehatan Hewan" value="Ternak">Ternak
                                                    </option>
                                                    <option data-sektor="Peternakan & Kesehatan Hewan" value="Obat Hewan">Obat
                                                        Hewan</option>
                                                </select>
                                            </div>

                                            <div class="col-md-4 mb-3">
                                                <label class="form-label">Kategori</label>
                                                <select id="kategori" name="kategori" class="form-select form-select-sm">
                                                    <option value="">-- Pilih Kategori --</option>
                                                    <option data-subsektor="Pakan Ternak" value="Rumput Pakan Ternak">Rumput
                                                        Pakan Ternak</option>
                                                    <option data-subsektor="Pakan Ternak"
                                                        value="Kacang-kacangan Pakan Ternak">
                                                        Kacang-kacangan Pakan Ternak</option>
                                                    <option data-subsektor="Ternak" value="Unggas">Unggas</option>
                                                    <option data-subsektor="Ternak" value="Ruminasia Besar">Ruminasia Besar
                                                    </option>
                                                    <option data-subsektor="Ternak" value="Ruminasia Kecil">Ruminasia Kecil
                                                    </option>
                                                    <option data-subsektor="Ternak" value="Nonruminansia">Nonruminansia
                                                    </option>
                                                    <option data-subsektor="Ternak" value="Lainnya">Lainnya
                                                    </option>
                                                    <option data-subsektor="Ternak" value="Hewan Kesayangan">Hewan Kesayangan
                                                    </option>
                                                    <option data-subsektor="Ternak" value="Burung Hias">Burung Hias
                                                    </option>
                                                    <option data-subsektor="Obat Hewan" value="Produk Jadi">Produk Jadi
                                                    </option>
                                                    <option data-subsektor="Obat Hewan" value="Bahan Baku">Bahan Baku</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Item</label>
                                            <select id="item" name="item" class="form-select form-select-sm">
                                                <option value="">-- Pilih Item --</option>
                                                <option data-kategori="Unggas" value="Ayam">Ayam</option>
                                                <option data-kategori="Unggas" value="Itik">Itik</option>
                                                <option data-kategori="Ruminasia Besar" value="Sapi">Sapi</option>
                                                <option data-kategori="Ruminasia Besar" value="Kerbau">Kerbau</option>
                                                <option data-kategori="Ruminasia Kecil" value="Kambing">Kambing</option>
                                                <option data-kategori="Ruminasia Kecil" value="Domba">Domba</option>
                                                <option data-kategori="Kacang-kacangan Pakan Ternak" value="Herba">Herba
                                                </option>
                                                <option data-kategori="Kacang-kacangan Pakan Ternak" value="Perdu">Perdu
                                                </option>
                                                <option data-kategori="Nonruminansia" value="Kuda">Kuda</option>
                                                <option data-kategori="Nonruminansia" value="Kelinci">Kelinci</option>
                                                <option data-kategori="Nonruminansia" value="Babi">Babi</option>



                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Jenis <span class="text-danger">*</span></label>
                                            <input type="text" name="jenis" class="form-control form-control-sm"
                                                placeholder="Contoh: Sapi Bali, Sapi Limousin" required>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Nama Latin</label>
                                            <input type="text" name="nama_latin" class="form-control form-control-sm"
                                                placeholder="Contoh: Gallus gallus">
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Status <span class="text-danger">*</span></label>
                                            <select name="status" class="form-select form-select-sm" required>
                                                <option value="Aktif">Aktif</option>
                                                <option value="Tidak Aktif">Tidak Aktif</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary btn-sm"
                                            data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-primary btn-sm">
                                            <i class="ti ti-device-floppy me-1"></i>Simpan
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    {{-- SCRIPT FILTERING --}}
                    <script>
                        document.addEventListener('DOMContentLoaded', () => {
                            const sektor = document.getElementById('sektor');
                            const subsektor = document.getElementById('subsektor');
                            const kategori = document.getElementById('kategori');
                            const item = document.getElementById('item');

                            function filterOptions(selectEl, attr, value) {
                                if (!selectEl) return;
                                Array.from(selectEl.options).forEach(opt => {
                                    if (!opt.value) {
                                        opt.hidden = false;
                                        return;
                                    }
                                    opt.hidden = (opt.getAttribute(attr) !== value);
                                });
                                selectEl.value = '';
                            }

                            if (sektor) {
                                sektor.addEventListener('change', () => {
                                    filterOptions(subsektor, 'data-sektor', sektor.value);
                                    filterOptions(kategori, 'data-subsektor', '');
                                    filterOptions(item, 'data-kategori', '');
                                });
                            }

                            if (subsektor) {
                                subsektor.addEventListener('change', () => {
                                    filterOptions(kategori, 'data-subsektor', subsektor.value);
                                    filterOptions(item, 'data-kategori', '');
                                });
                            }

                            if (kategori && item) {
                                kategori.addEventListener('change', () => {
                                    filterOptions(item, 'data-kategori', kategori.value);
                                });
                            }
                        });
                    </script>
                @endif
            @endauth

            {{-- MODALS PSP --}}
            @foreach ($psp as $item)
                {{-- Modal Detail PSP --}}
                <div class="modal fade" id="detailModalPSP{{ $item->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header bg-primary text-white">
                                <h5 class="modal-title"><i class="ti ti-info-circle me-2"></i>Detail Prasarana & Sarana
                                </h5>
                                <button type="button" class="btn-close btn-close-white"
                                    data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label text-muted small mb-1">Kode</label>
                                        <div class="fw-semibold">
                                            <span class="badge bg-dark fs-6">{{ $item->kode }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label text-muted small mb-1">Status</label>
                                        <div class="fw-semibold">
                                            <span
                                                class="badge bg-{{ $item->status == 'Aktif' ? 'success' : 'secondary' }} fs-6">{{ $item->status }}</span>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label text-muted small mb-1">Nama</label>
                                        <div class="fw-semibold fs-5">{{ $item->nama }}</div>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label text-muted small mb-1">Jenis</label>
                                        <div class="fw-semibold"><i class="ti ti-category me-1"></i>{{ $item->jenis }}
                                        </div>
                                    </div>
                                    @if ($item->deskripsi)
                                        <div class="col-12">
                                            <label class="form-label text-muted small mb-1">Deskripsi</label>
                                            <div class="p-2 bg-light rounded">{{ $item->deskripsi }}</div>
                                        </div>
                                    @endif
                                    <div class="col-12">
                                        <hr class="my-2">
                                        <div class="d-flex justify-content-between text-muted small">
                                            <span>
                                                <i class="ti ti-calendar-plus me-1"></i>
                                                Dibuat: {{ $item->created_at->format('d M Y H:i') }}
                                            </span>
                                            <span>
                                                <i class="ti ti-calendar-edit me-1"></i>
                                                Diubah: {{ $item->updated_at->format('d M Y H:i') }}
                                            </span>
                                        </div>
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

                {{-- Modal Edit PSP --}}
                @auth
                    @if (auth()->user()->canCRUD())
                        <div class="modal fade" id="editModalPSP{{ $item->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title"><i class="ti ti-edit me-2"></i>Edit Prasarana & Sarana</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <form action="{{ route('psp.update', $item->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label class="form-label">Nama PSP <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="nama"
                                                    value="{{ $item->nama }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Jenis <span class="text-danger">*</span></label>
                                                <select class="form-select" name="jenis" required>
                                                    <option value="">-- Pilih Jenis --</option>
                                                    <option value="Alat Mesin Pertanian"
                                                        {{ $item->jenis == 'Alat Mesin Pertanian' ? 'selected' : '' }}>Alat
                                                        Mesin Pertanian</option>
                                                    <option value="Infrastruktur"
                                                        {{ $item->jenis == 'Infrastruktur' ? 'selected' : '' }}>Infrastruktur
                                                    </option>
                                                    <option value="Bangunan"
                                                        {{ $item->jenis == 'Bangunan' ? 'selected' : '' }}>Bangunan</option>
                                                    <option value="Kendaraan"
                                                        {{ $item->jenis == 'Kendaraan' ? 'selected' : '' }}>Kendaraan</option>
                                                    <option value="Peralatan"
                                                        {{ $item->jenis == 'Peralatan' ? 'selected' : '' }}>Peralatan</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Status <span class="text-danger">*</span></label>
                                                <select class="form-select" name="status" required>
                                                    <option value="Aktif" {{ $item->status == 'Aktif' ? 'selected' : '' }}>
                                                        Aktif</option>
                                                    <option value="Tidak Aktif"
                                                        {{ $item->status == 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-warning">
                                                <i class="ti ti-device-floppy me-1"></i>Update
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endif
                @endauth
            @endforeach

            {{-- Modal Create PSP --}}
            @auth
                @if (auth()->user()->canCRUD())
                    <div class="modal fade" id="createModalPSP" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title"><i class="ti ti-plus me-2"></i>Tambah Prasarana & Sarana</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <form action="{{ route('psp.store') }}" method="POST">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label class="form-label">Nama PSP <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="nama" required
                                                placeholder="Contoh: Traktor Roda 4">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Jenis <span class="text-danger">*</span></label>
                                            <select class="form-select" name="jenis" required>
                                                <option value="">-- Pilih Jenis --</option>
                                                <option value="Alat Mesin Pertanian">Alat Mesin Pertanian</option>
                                                <option value="Infrastruktur">Infrastruktur</option>
                                                <option value="Bangunan">Bangunan</option>
                                                <option value="Kendaraan">Kendaraan</option>
                                                <option value="Peralatan">Peralatan</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Status <span class="text-danger">*</span></label>
                                            <select class="form-select" name="status" required>
                                                <option value="Aktif">Aktif</option>
                                                <option value="Tidak Aktif">Tidak Aktif</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="ti ti-device-floppy me-1"></i>Simpan
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @endif
            @endauth

        </div>
    </div>

    <script>
        function confirmDelete(type, id) {
            if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
                document.getElementById('delete-form-' + type + '-' + id).submit();
            }
        }
    </script>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const urlParams = new URLSearchParams(window.location.search);
                const activeTab = urlParams.get('tab');

                if (activeTab === 'psp') {
                    const pspTab = document.getElementById('psp-tab');
                    if (pspTab) {
                        const tab = new bootstrap.Tab(pspTab);
                        tab.show();
                    }
                }
            });
        </script>
    @endpush

@endsection
