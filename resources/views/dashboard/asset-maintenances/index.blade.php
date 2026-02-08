@extends('layouts.app', ['title' => 'Pemeliharaan Aset'])
@section('content')
    <div class="container-fluid">
        <div class="d-sm-flex d-block align-items-center justify-content-between mb-7">
            <div class="mb-3 mb-sm-0">
                <h5 class="card-title fw-semibold">Pemeliharaan Aset</h5>
                <p class="card-subtitle mb-0">Riwayat pemeliharaan aset</p>
            </div>
            <div class="d-flex align-items-center gap-2">
                <div>
                    <form action="{{ route('asset-maintenances.index') }}" method="get">
                        <div class="input-group">
                            <select name="category" class="form-select" style="max-width: 150px;">
                                <option value="">Semua Kategori</option>
                                @foreach (\App\Models\Category::all() as $category)
                                    <option value="{{ $category->id }}"
                                        {{ request('category') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            <select name="location" class="form-select" style="max-width: 150px;">
                                <option value="">Semua Lokasi</option>
                                @foreach (\App\Models\Location::all() as $location)
                                    <option value="{{ $location->id }}"
                                        {{ request('location') == $location->id ? 'selected' : '' }}>
                                        {{ $location->name }}
                                    </option>
                                @endforeach
                            </select>
                            <select name="condition" class="form-select" style="max-width: 150px;">
                                <option value="">Semua Kondisi</option>
                                <option value="baik" {{ request('condition') == 'baik' ? 'selected' : '' }}>Baik</option>
                                <option value="rusak" {{ request('condition') == 'rusak' ? 'selected' : '' }}>Rusak
                                </option>
                                <option value="perbaikan" {{ request('condition') == 'perbaikan' ? 'selected' : '' }}>
                                    Perbaikan</option>
                            </select>
                            <input type="text" name="q" value="{{ request('q') }}" autofocus class="form-control"
                                placeholder="Cari nama/nomor aset" aria-label="Cari">
                            <button class="btn btn-outline-primary" type="submit">
                                <i class="ti ti-search"></i>
                            </button>
                        </div>
                    </form>
                </div>
                @if (auth()->user()->isNotPrincipal())
                    <a href="{{ route('asset-maintenances.create') }}" class="btn btn-primary">
                        <i class="ti ti-plus"></i> Tambah Pemeliharaan
                    </a>
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
                                {{-- <th scope="col">Nomor Aset</th> --}}
                                <th scope="col">Nama Aset</th>
                                <th scope="col">Kategori</th>
                                <th scope="col">Lokasi</th>
                                <th scope="col">Kondisi</th>
                                <th scope="col">Nominal</th>
                                <th scope="col">Tanggal</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody class="border-top">
                            @forelse ($maintenances as $maintenance)
                                <tr>
                                    <td>
                                        <p class="mb-0">
                                            {{ $loop->iteration + ($maintenances->currentPage() - 1) * $maintenances->perPage() }}
                                        </p>
                                    </td>
                                    {{-- <td>
                                        <span
                                            class="text-uppercase fw-semibold text-primary">{{ $maintenance->asset->asset_number }}</span>
                                    </td> --}}
                                    <td>
                                        <span class="text-capitalize">{{ $maintenance->asset->name }}</span>
                                    </td>
                                    <td>
                                        <span class="badge bg-primary-subtle text-primary rounded-3 fw-semibold fs-2">
                                            {{ $maintenance->asset->category->name }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="text-capitalize">{{ $maintenance->asset->location->name }}</span>
                                    </td>
                                    <td>
                                        @if ($maintenance->condition == 'baik')
                                            <span
                                                class="badge bg-success-subtle text-success rounded-3 fw-semibold fs-2">Baik</span>
                                        @elseif($maintenance->condition == 'rusak')
                                            <span
                                                class="badge bg-danger-subtle text-danger rounded-3 fw-semibold fs-2">Rusak</span>
                                        @else
                                            <span
                                                class="badge bg-warning-subtle text-warning rounded-3 fw-semibold fs-2">Perbaikan</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($maintenance->nominal)
                                            <span class="fw-semibold">Rp
                                                {{ number_format($maintenance->nominal, 0, ',', '.') }}</span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        <p class="fs-3 text-dark mb-0">
                                            {{ $maintenance->created_at->format('d/m/Y H:i') }}
                                        </p>
                                    </td>
                                    <td>
                                        <div class="dropdown dropstart">
                                            <a href="#" class="text-muted" id="dropdownMenuButton"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="ti ti-dots fs-5"></i>
                                            </a>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <li>
                                                    <a href="{{ route('asset-maintenances.show', $maintenance) }}"
                                                        class="dropdown-item d-flex align-items-center gap-3">
                                                        <i class="fs-4 ti ti-eye"></i>Detail
                                                    </a>
                                                </li>
                                                @if (auth()->user()->isNotPrincipal())
                                                    <li>
                                                        <a href="{{ route('asset-maintenances.edit', $maintenance) }}"
                                                            class="dropdown-item d-flex align-items-center gap-3">
                                                            <i class="fs-4 ti ti-pencil"></i>Edit
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <form
                                                            action="{{ route('asset-maintenances.destroy', $maintenance) }}"
                                                            method="POST"
                                                            onsubmit="return confirm('Yakin ingin menghapus record pemeliharaan ini?')">
                                                            @csrf
                                                            @method('DELETE')
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
                                    <td colspan="9" class="text-center">
                                        <p class="fs-3 text-muted mb-0">Tidak ada record pemeliharaan ditemukan</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class='px-4 mt-3'>{{ $maintenances->appends(request()->query())->links() }}</div>
            </div>
        </div>
    </div>
@endsection
