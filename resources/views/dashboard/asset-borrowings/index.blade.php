@extends('layouts.app', ['title' => 'Daftar Peminjaman Aset'])
@section('content')
    <div class="container-fluid">
        <div class="d-sm-flex d-block align-items-center justify-content-between mb-7">
            <div class="mb-3 mb-sm-0">
                <h5 class="card-title fw-semibold">Daftar Peminjaman Aset</h5>
                <p class="card-subtitle mb-0">Mengelola data peminjaman aset</p>
            </div>
            <div class="d-flex align-items-center gap-2">
                <div>
                    <form action="{{ route('asset-borrowings.index') }}" method="get">
                        <div class="input-group">
                            <select name="status" class="form-select" style="max-width: 150px;">
                                <option value="">Semua Status</option>
                                <option value="borrowed" {{ request()->status == 'borrowed' ? 'selected' : '' }}>Dipinjam
                                </option>
                                <option value="returned" {{ request()->status == 'returned' ? 'selected' : '' }}>
                                    Dikembalikan</option>
                                <option value="lost" {{ request()->status == 'lost' ? 'selected' : '' }}>Hilang</option>
                            </select>
                            <input type="text" name="q" value="{{ request()->q }}" class="form-control"
                                placeholder="Cari" aria-label="Cari" aria-describedby="button-addon2">
                            <button class="btn btn-outline-primary" type="submit" id="button-addon2">
                                <i class="ti ti-search"></i>
                            </button>
                        </div>
                    </form>
                </div>
                @if (auth()->user()->isNotPrincipal())
                    <a href="{{ route('asset-borrowings.create') }}" class="btn btn-primary">Tambah</a>
                @endif
            </div>
        </div>

        <div class="card w-100">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead>
                            <tr class="text-muted fw-semibold">
                                <th scope="col">No</th>
                                <th scope="col">Aset</th>
                                <th scope="col">Peminjam</th>
                                <th scope="col">Jumlah</th>
                                <th scope="col">Tgl Pinjam</th>
                                <th scope="col">Tgl Kembali</th>
                                <th scope="col">Status</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody class="border-top">
                            @forelse ($borrowings as $borrowing)
                                <tr>
                                    <td>
                                        <p class="mb-0">
                                            {{ $loop->iteration + ($borrowings->currentPage() - 1) * $borrowings->perPage() }}
                                        </p>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if ($borrowing->asset->image)
                                                <img src="{{ asset('storage/' . $borrowing->asset->image) }}"
                                                    alt="{{ $borrowing->asset->name }}" class="rounded me-2"
                                                    style="width: 40px; height: 40px; object-fit: cover;">
                                            @else
                                                <div class="rounded bg-light d-flex align-items-center justify-content-center me-2"
                                                    style="width: 40px; height: 40px;">
                                                    <i class="ti ti-photo-off text-muted"></i>
                                                </div>
                                            @endif
                                            <div>
                                                <h6 class="fw-semibold mb-0">{{ $borrowing->asset->name }}</h6>
                                                <small class="text-muted">{{ $borrowing->asset->category->name }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="mb-0 fw-semibold">{{ $borrowing->borrower_name }}</p>
                                        <span class="fs-3 text-muted">{{ $borrowing->borrower_phone }}</span>
                                    </td>
                                    <td>
                                        <p class="mb-0">{{ $borrowing->quantity }}</p>
                                    </td>
                                    <td>
                                        <p class="fs-3 text-dark mb-0">
                                            {{ $borrowing->borrowed_at->format('d/m/Y') }}
                                        </p>
                                    </td>
                                    <td>
                                        <p class="fs-3 text-dark mb-0">
                                            {{ $borrowing->expected_return_date->format('d/m/Y') }}
                                        </p>
                                    </td>
                                    <td>
                                        <span
                                            class="badge {{ getBorrowingColors($borrowing->status) }} rounded-3 fw-semibold fs-2">
                                            {{ getBorrowingStatuses($borrowing->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="dropdown dropstart">
                                            <a href="#" class="text-muted" id="dropdownMenuButton"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="ti ti-dots fs-5"></i>
                                            </a>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <li>
                                                    <a href="{{ route('asset-borrowings.show', $borrowing->id) }}"
                                                        class="dropdown-item d-flex align-items-center gap-3">
                                                        <i class="fs-4 ti ti-eye"></i>Detail
                                                    </a>
                                                </li>
                                                @if (auth()->user()->isNotPrincipal())
                                                    <li>
                                                        <a href="{{ route('asset-borrowings.edit', $borrowing->id) }}"
                                                            class="dropdown-item d-flex align-items-center gap-3">
                                                            <i class="fs-4 ti ti-pencil"></i>Edit
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <form
                                                            onsubmit="return confirm('Apakah anda yakin ingin menghapus data peminjaman ini?')"
                                                            action="{{ route('asset-borrowings.destroy', $borrowing->id) }}"
                                                            method="post">
                                                            @csrf
                                                            @method('delete')
                                                            <button type="submit"
                                                                class="dropdown-item d-flex align-items-center gap-3">
                                                                <i class="fs-4 ti ti-trash"></i>Hapus
                                                            </button>
                                                        </form>
                                                    </li>
                                                @endif
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center">
                                        <p class="fs-3 text-muted mb-0">Tidak ada data peminjaman ditemukan</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class='px-4 mt-3'>{{ $borrowings->links() }}</div>
            </div>
        </div>
    </div>
@endsection
