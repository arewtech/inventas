@extends('layouts.app', ['title' => 'Pemeliharaan Aset'])
@section('content')
    <div class="container-fluid">
        <div class="d-sm-flex d-block align-items-center justify-content-between mb-7">
            <div class="mb-3 mb-sm-0">
                <h5 class="card-title fw-semibold">Pemeliharaan Aset</h5>
                <p class="card-subtitle mb-0">Daftar detail individual aset untuk pemeliharaan</p>
            </div>
            <div class="d-flex align-items-center gap-2">
                <div>
                    <form action="{{ route('asset-maintenances.index') }}" method="get">
                        @if (request('name'))
                            <input type="hidden" name="name" value="{{ request('name') }}">
                        @endif
                        <div class="input-group">
                            <select name="category" class="form-select" style="max-width: 170px;">
                                <option value="">Semua Kategori</option>
                                @foreach (\App\Models\Category::all() as $category)
                                    <option value="{{ $category->id }}"
                                        {{ request()->category == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            <select name="location" class="form-select" style="max-width: 170px;">
                                <option value="">Semua Lokasi</option>
                                @foreach (\App\Models\Location::all() as $location)
                                    <option value="{{ $location->id }}"
                                        {{ request()->location == $location->id ? 'selected' : '' }}>
                                        {{ $location->name }}
                                    </option>
                                @endforeach
                            </select>
                            <input type="text" name="q" value="{{ request()->q }}" autofocus class="form-control"
                                placeholder="Cari nama/nomor aset" aria-label="Cari" aria-describedby="button-addon2">
                            <button class="btn btn-outline-primary" type="submit" id="button-addon2">
                                <i class="ti ti-search"></i>
                            </button>
                        </div>
                    </form>
                </div>
                <a href="{{ route('assets.index') }}" class="btn btn-secondary">
                    <i class="ti ti-arrow-left"></i> Kembali
                </a>
            </div>
        </div>

        @if (request('name'))
            <div class="alert alert-info">
                <i class="ti ti-info-circle me-2"></i>
                Menampilkan detail aset: <strong>{{ request('name') }}</strong>
            </div>
        @endif

        <div class="card w-100">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead>
                            <tr class="text-muted fw-semibold">
                                <th scope="col">No</th>
                                <th scope="col">Gambar</th>
                                <th scope="col">Nomor Aset</th>
                                <th scope="col">Nama</th>
                                <th scope="col">Kategori</th>
                                <th scope="col">Lokasi</th>
                                <th scope="col">Kondisi</th>
                                <th scope="col">Dibuat</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody class="border-top">
                            @forelse ($assets as $asset)
                                <tr>
                                    <td>
                                        <p class="mb-0">
                                            {{ $loop->iteration + ($assets->currentPage() - 1) * $assets->perPage() }}
                                        </p>
                                    </td>
                                    <td>
                                        @if ($asset->image)
                                            <img src="{{ asset('storage/' . $asset->image) }}" alt="{{ $asset->name }}"
                                                class="rounded" style="width: 50px; height: 50px; object-fit: cover;">
                                        @else
                                            <div class="rounded bg-light d-flex align-items-center justify-content-center"
                                                style="width: 50px; height: 50px;">
                                                <i class="ti ti-photo-off text-muted"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        <span
                                            class="text-uppercase fw-semibold text-primary">{{ $asset->asset_number }}</span>
                                    </td>
                                    <td>
                                        <span class="text-capitalize">{{ $asset->name }}</span>
                                    </td>
                                    <td>
                                        <span class="badge bg-primary-subtle text-primary rounded-3 fw-semibold fs-2">
                                            {{ $asset->category->name }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="text-capitalize">{{ $asset->location->name }}</span>
                                    </td>
                                    <td>
                                        <span class="badge {{ $asset->status_color }} rounded-3 fw-semibold fs-2">
                                            {{ ucfirst($asset->condition) }}
                                        </span>
                                    </td>
                                    <td>
                                        <p class="fs-3 text-dark mb-0">
                                            {{ $asset->created_at->format('d/m/Y') }}
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
                                                    <a href="{{ route('asset-maintenances.show', $asset) }}"
                                                        class="dropdown-item d-flex align-items-center gap-3">
                                                        <i class="fs-4 ti ti-eye"></i>Detail
                                                    </a>
                                                </li>
                                                @if (auth()->user()->isNotPrincipal())
                                                    <li>
                                                        <a href="{{ route('asset-maintenances.edit', $asset) }}"
                                                            class="dropdown-item d-flex align-items-center gap-3">
                                                            <i class="fs-4 ti ti-pencil"></i>Edit
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <form
                                                            onsubmit="return confirm('Apakah anda yakin ingin menghapus aset ini?')"
                                                            action="{{ route('asset-maintenances.destroy', $asset) }}"
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
                                    <td colspan="9" class="text-center">
                                        <p class="fs-3 text-muted mb-0">Tidak ada aset ditemukan</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class='px-4 mt-3'>{{ $assets->appends(request()->query())->links() }}</div>
            </div>
        </div>
    </div>
@endsection
