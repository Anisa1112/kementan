@extends('layouts.app')

@section('title', 'Komoditas - ' . $sektorName)

@section('content')
<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">

        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold mb-0">Daftar Komoditas Sektor: {{ $sektorName }}</h4>
                <p class="text-muted mb-0">Data komoditas pada sektor {{ $sektorName }}</p>
            </div>
            <div>
                    @if (hasPermission('manage_komoditas'))
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModalKomoditas">
                            <i class="ti ti-plus me-1"></i>Tambah Komoditas
                        </button>
                    @endif

            </div>
        </div>

        <!-- Alert Success -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="ti ti-check me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Card Tabel -->
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Data Komoditas</h5>
                <small class="text-muted">Total: {{ $komoditas->total() }} data</small>
            </div>

            <div class="card-body">
                @if($komoditas->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover table-sm">
                            <thead class="table-light small">
                                <tr>
                                    <th style="width: 5%">No</th>
                                    <th style="width: 10%">Kode</th>
                                    <th style="width: 12%">Sektor</th>
                                    @php
                                        $hasSubsektor = $komoditas->contains(fn($item) => !empty($item->subsektor));
                                        $hasKategori = $komoditas->contains(fn($item) => !empty($item->kategori));
                                        $hasItem = $komoditas->contains(fn($item) => !empty($item->item));
                                        $hasNamaLatin = $komoditas->contains(fn($item) => !empty($item->nama_latin));
                                    @endphp
                                    @if($hasSubsektor)
                                        <th style="width: 12%">Subsektor</th>
                                    @endif
                                    @if($hasKategori)
                                        <th style="width: 12%">Kategori</th>
                                    @endif
                                    @if($hasItem)
                                        <th style="width: 12%">Item</th>
                                    @endif
                                    <th style="width: 12%">Jenis</th>
                                    @if($hasNamaLatin)
                                        <th style="width: 12%">Nama Latin</th>
                                    @endif
                                    <th style="width: 8%" class="text-center">Status</th>
                                    <th style="width: 10%" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="small">
                                @foreach($komoditas as $index => $item)
                                    <tr>
                                        <td>{{ $komoditas->firstItem() + $index }}</td>
                                        <td>
                                            <span class="badge bg-primary text-truncate" style="max-width: 100px;">
                                                {{ $item->kode }}
                                            </span>
                                        </td>
                                        <td><small>{{ $item->sektor }}</small></td>
                                        @if($hasSubsektor)
                                            <td><small>{{ $item->subsektor ?? '-' }}</small></td>
                                        @endif
                                        @if($hasKategori)
                                            <td><small>{{ $item->kategori ?? '-' }}</small></td>
                                        @endif
                                        @if($hasItem)
                                            <td class="fw-semibold"><small>{{ $item->item ?? '-' }}</small></td>
                                        @endif
                                        <td><small>{{ $item->jenis }}</small></td>
                                        @if($hasNamaLatin)
                                            <td>
                                                <small>
                                                    <em class="text-muted">{{ $item->nama_latin ?? '-' }}</em>
                                                </small>
                                            </td>
                                        @endif
                                        <td class="text-center">
                                            <span class="badge bg-{{ $item->status == 'Aktif' ? 'success' : 'secondary' }}">
                                                {{ $item->status }}
                                            </span>
                                        </td>
                                        <td class="text-center text-nowrap">
                                            <button type="button"
                                                class="btn btn-sm btn-icon btn-outline-info"
                                                data-bs-toggle="modal"
                                                data-bs-target="#detailModal{{ $item->id }}"
                                                title="Lihat Detail">
                                                <i class="ti ti-eye"></i>
                                            </button>
                                           @if (hasPermission('manage_komoditas'))
                                                    <button type="button"
                                                        class="btn btn-sm btn-icon btn-outline-warning"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#editModal{{ $item->id }}"
                                                        title="Edit">
                                                        <i class="ti ti-edit"></i>
                                                    </button>
                                                    <button type="button"
                                                        class="btn btn-sm btn-icon btn-outline-danger"
                                                        onclick="confirmDelete({{ $item->id }})"
                                                        title="Hapus">
                                                        <i class="ti ti-trash"></i>
                                                    </button>
                                                    <form id="delete-form-{{ $item->id }}"
                                                        action="{{ route('komoditas.destroy', $item->id) }}"
                                                        method="POST" style="display: none;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <input type="hidden" name="redirect_to" value="sektor">
                                                        <input type="hidden" name="slug" value="{{ $slug }}">
                                                    </form>
                                                @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-3">
                        {{ $komoditas->links('pagination::bootstrap-5') }}
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="ti ti-database-off" style="font-size: 64px; opacity: 0.3;"></i>
                        <h5 class="text-muted mt-3">Tidak Ada Data</h5>
                        <p class="text-muted">Belum ada data komoditas di sektor {{ $sektorName }}.</p>
                    </div>
                @endif
            </div>
        </div>

    </div>
</div>

<!-- MODALS -->
@foreach($komoditas as $item)
    <!-- Modal Detail -->
    <div class="modal fade" id="detailModal{{ $item->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title text-white">
                        <i class="ti ti-info-circle me-2"></i>Detail Komoditas
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label text-muted small mb-1">Kode Komoditas</label>
                            <div class="fw-semibold">
                                <span class="badge bg-primary fs-6">{{ $item->kode }}</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-muted small mb-1">Status</label>
                            <div class="fw-semibold">
                                <span class="badge bg-{{ $item->status == 'Aktif' ? 'success' : 'secondary' }} fs-6">
                                    {{ $item->status }}
                                </span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-muted small mb-1">Sektor</label>
                            <div class="fw-semibold">{{ $item->sektor ?? '-' }}</div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-muted small mb-1">Subsektor</label>
                            <div class="fw-semibold">{{ $item->subsektor ?? '-' }}</div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-muted small mb-1">Kategori</label>
                            <div class="fw-semibold">{{ $item->kategori ?? '-' }}</div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-muted small mb-1">Item</label>
                            <div class="fw-semibold">{{ $item->item ?? '-' }}</div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-muted small mb-1">Jenis</label>
                            <div class="fw-semibold">{{ $item->jenis ?? '-' }}</div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-muted small mb-1">Nama Latin</label>
                            <div class="fw-semibold">
                                <em class="text-muted">{{ $item->nama_latin ?? '-' }}</em>
                            </div>
                        </div>
                        <div class="col-12">
                            <hr class="my-2">
                            <div class="d-flex justify-content-between text-muted small">
                                <span>
                                    <i class="ti ti-calendar-plus me-1"></i>
                                    Dibuat: {{ $item->created_at ? $item->created_at->format('d M Y H:i') : '-' }}
                                </span>
                                <span>
                                    <i class="ti ti-calendar-edit me-1"></i>
                                    Diubah: {{ $item->updated_at ? $item->updated_at->format('d M Y H:i') : '-' }}
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

    <!-- Modal Edit -->
    @auth
        @if(auth()->user()->canCRUD())
            <div class="modal fade" id="editModal{{ $item->id }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form action="{{ route('komoditas.update', $item->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="redirect_to" value="sektor">
                            <input type="hidden" name="slug" value="{{ $slug }}">

                            <div class="modal-header">
                                <h5 class="modal-title">Edit Komoditas</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>

                            <div class="modal-body small">
                                <div class="mb-3">
                                    <label class="form-label">Kode <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control form-control-sm" value="{{ $item->kode }}" readonly>
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
                                        <option value="Aktif" {{ $item->status == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                                        <option value="Tidak Aktif" {{ $item->status == 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                                    </select>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-primary btn-sm">
                                    <i class="ti ti-device-floppy me-1"></i>Simpan Perubahan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endif
    @endauth
@endforeach

<!-- Modal Tambah Komoditas -->
@auth
    @if(auth()->user()->canCRUD())
        <div class="modal fade" id="createModalKomoditas" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form action="{{ route('komoditas.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="redirect_to" value="sektor">
                        <input type="hidden" name="slug" value="{{ $slug }}">

                        <div class="modal-header">
                            <h5 class="modal-title">Tambah Komoditas Baru</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-body small">
                            <!-- Kode otomatis -->
                            <div class="mb-3">
                                <label class="form-label">Kode</label>
                                <input type="text" class="form-control form-control-sm" value="(otomatis)" disabled>
                                <small class="text-muted">Kode akan dibuat otomatis berdasarkan sektor, subsektor, dan kategori.</small>
                            </div>

                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Sektor <span class="text-danger">*</span></label>
                                    <select id="sektorSektor" name="sektor" class="form-select form-select-sm" required>
                                        <option value="">-- Pilih Sektor --</option>
                                        <option value="Tanaman Pangan" {{ $sektorName == 'Tanaman Pangan' ? 'selected' : '' }}>Tanaman Pangan</option>
                                        <option value="Hortikultura" {{ $sektorName == 'Hortikultura' ? 'selected' : '' }}>Hortikultura</option>
                                        <option value="Perkebunan" {{ $sektorName == 'Perkebunan' ? 'selected' : '' }}>Perkebunan</option>
                                        <option value="Peternakan & Kesehatan Hewan" {{ $sektorName == 'Peternakan & Kesehatan Hewan' ? 'selected' : '' }}>Peternakan & Kesehatan Hewan</option>
                                    </select>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Subsektor</label>
                                    <select id="subsektorSektor" name="subsektor" class="form-select form-select-sm">
                                        <option value="">-- Pilih Subsektor --</option>
                                        <option data-sektor="Tanaman Pangan" value="Padi">Padi</option>
                                        <option data-sektor="Tanaman Pangan" value="Palawija">Palawija</option>
                                        <option data-sektor="Tanaman Pangan" value="Kacang-kacangan dan Umbi-umbian">Kacang-kacangan dan Umbi-umbian</option>
                                        <option data-sektor="Hortikultura" value="Buah-buahan">Buah-buahan</option>
                                        <option data-sektor="Hortikultura" value="Sayuran">Sayuran</option>
                                        <option data-sektor="Hortikultura" value="Tanaman Obat">Tanaman Obat</option>
                                        <option data-sektor="Hortikultura" value="Tanaman Hias">Tanaman Hias</option>
                                        <option data-sektor="Perkebunan" value="Perkebunan">Perkebunan</option>
                                        <option data-sektor="Peternakan & Kesehatan Hewan" value="Pakan Ternak">Pakan Ternak</option>
                                        <option data-sektor="Peternakan & Kesehatan Hewan" value="Ternak">Ternak</option>
                                        <option data-sektor="Peternakan & Kesehatan Hewan" value="Obat Hewan">Obat Hewan</option>
                                    </select>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Kategori</label>
                                    <select id="kategoriSektor" name="kategori" class="form-select form-select-sm">
                                        <option value="">-- Pilih Kategori --</option>
                                        <option data-subsektor="Pakan Ternak" value="Rumput Pakan Ternak">Rumput Pakan Ternak</option>
                                        <option data-subsektor="Ternak" value="Unggas">Unggas</option>
                                        <option data-subsektor="Ternak" value="Ruminasia Besar">Ruminasia Besar</option>
                                        <option data-subsektor="Ternak" value="Ruminasia Kecil">Ruminasia Kecil</option>
                                        <option data-subsektor="Ternak" value="Nonruminansia">Nonruminansia</option>
                                        <option data-subsektor="Obat Hewan" value="Produk Jadi">Produk Jadi</option>
                                        <option data-subsektor="Obat Hewan" value="Bahan Baku">Bahan Baku</option>
                                    </select>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Item</label>
                                <select id="itemSektor" name="item" class="form-select form-select-sm">
                                    <option value="">-- Pilih Item --</option>
                                    <option data-kategori="Unggas" value="Ayam">Ayam</option>
                                    <option data-kategori="Unggas" value="Itik">Itik</option>
                                    <option data-kategori="Ruminasia Besar" value="Sapi">Sapi</option>
                                    <option data-kategori="Ruminasia Besar" value="Kerbau">Kerbau</option>
                                    <option data-kategori="Ruminasia Kecil" value="Kambing">Kambing</option>
                                    <option data-kategori="Ruminasia Kecil" value="Domba">Domba</option>
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
                            <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary btn-sm">
                                <i class="ti ti-device-floppy me-1"></i>Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- SCRIPT FILTERING UNTUK MODAL SEKTOR --}}
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const sektorSektor = document.getElementById('sektorSektor');
                const subsektorSektor = document.getElementById('subsektorSektor');
                const kategoriSektor = document.getElementById('kategoriSektor');
                const itemSektor = document.getElementById('itemSektor');

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

                // Auto filter saat halaman dimuat (berdasarkan sektor yang sudah terpilih)
                if (sektorSektor && sektorSektor.value) {
                    filterOptions(subsektorSektor, 'data-sektor', sektorSektor.value);
                }

                if (sektorSektor) {
                    sektorSektor.addEventListener('change', () => {
                        filterOptions(subsektorSektor, 'data-sektor', sektorSektor.value);
                        filterOptions(kategoriSektor, 'data-subsektor', '');
                        filterOptions(itemSektor, 'data-kategori', '');
                    });
                }

                if (subsektorSektor) {
                    subsektorSektor.addEventListener('change', () => {
                        filterOptions(kategoriSektor, 'data-subsektor', subsektorSektor.value);
                        filterOptions(itemSektor, 'data-kategori', '');
                    });
                }

                if (kategoriSektor && itemSektor) {
                    kategoriSektor.addEventListener('change', () => {
                        filterOptions(itemSektor, 'data-kategori', kategoriSektor.value);
                    });
                }
            });
        </script>
    @endif
@endauth

<script>
    function confirmDelete(id) {
        if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
            document.getElementById('delete-form-' + id).submit();
        }
    }
</script>

@endsection
