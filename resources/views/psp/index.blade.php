@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Daftar Prasarana & Sarana</h2>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode</th>
                    <th>Nama</th>
                    <th>Jenis</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($psp as $index => $item)
                    <tr>
                        <td>{{ $psp->firstItem() + $index }}</td>
                        <td class="fw-semibold">{{ $item->kode }}</td>
                        <td class="fw-semibold">{{ $item->nama }}</td>
                        <td>{{ $item->jenis }}</td>
                        <td>
                            <span class="badge bg-{{ $item->status == 'Aktif' ? 'success' : 'secondary' }}">
                                {{ $item->status }}
                            </span>
                        </td>
                        <td class="text-center">
                            <!-- Tombol Detail -->
                            <button type="button" class="btn btn-sm btn-icon btn-outline-primary" data-bs-toggle="modal"
                                data-bs-target="#detailModal{{ $item->id }}" title="Detail">
                                <i class="ti ti-eye"></i>
                            </button>

                            {{-- Tombol Edit/Hapus hanya untuk admin --}}
                            @auth
                                @if (auth()->user()->canCRUD())
                                    <button type="button" class="btn btn-sm btn-icon btn-outline-warning"
                                        data-bs-toggle="modal" data-bs-target="#editModal{{ $item->id }}" title="Edit">
                                        <i class="ti ti-edit"></i>
                                    </button>

                                    <button type="button" class="btn btn-sm btn-icon btn-outline-danger"
                                        onclick="confirmDelete({{ $item->id }})" title="Hapus">
                                        <i class="ti ti-trash"></i>
                                    </button>

                                    <!-- Form Delete -->
                                    <form id="delete-form-{{ $item->id }}" action="{{ route('psp.destroy', $item->id) }}"
                                        method="POST" style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                @endif
                            @endauth
                        </td>
                    </tr>

                    <!-- Modal Detail -->
                    <div class="modal fade" id="detailModal{{ $item->id }}" tabindex="-1"
                        aria-labelledby="detailModalLabel{{ $item->id }}" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content border border-primary">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="detailModalLabel{{ $item->id }}">Detail PSP</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Tutup"></button>
                                </div>
                                <div class="modal-body">
                                    <p class="border-bottom pb-2"><strong>Kode:</strong> {{ $item->kode }}</p>
                                    <p class="border-bottom pb-2"><strong>Nama:</strong> {{ $item->nama }}</p>
                                    <p class="border-bottom pb-2"><strong>Jenis:</strong> {{ $item->jenis }}</p>
                                    <p><strong>Status:</strong> {{ $item->status }}</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </tbody>
        </table>

        <!-- Pagination -->
        {{ $psp->links() }}
    </div>
@endsection
