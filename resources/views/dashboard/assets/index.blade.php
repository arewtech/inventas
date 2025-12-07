@extends('layouts.app', ['title' => 'Daftar Aset'])
@section('content')
    <div class="container-fluid">
        <div class="d-sm-flex d-block align-items-center justify-content-between mb-7">
            <div class="mb-3 mb-sm-0">
                <h5 class="card-title fw-semibold">Daftar Aset</h5>
                <p class="card-subtitle mb-0">List semua aset yang tersedia</p>
            </div>
            <div class="d-flex align-items-center gap-2">
                <div>
                    <form action="{{ route('assets.index') }}" method="get">
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
                                placeholder="Cari" aria-label="Cari" aria-describedby="button-addon2">
                            <button class="btn btn-outline-primary" type="submit" id="button-addon2">
                                <i class="ti ti-search"></i>
                            </button>
                        </div>
                    </form>
                </div>
                @if (auth()->user()->isNotPrincipal())
                    <a href="{{ route('assets.create') }}" class="btn btn-primary">Tambah</a>
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
                                <th scope="col">Gambar</th>
                                <th scope="col">Nama</th>
                                <th scope="col">Kategori</th>
                                <th scope="col">Lokasi</th>
                                <th scope="col">Jumlah</th>
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
                                        <span class="text-capitalize">{{ $asset->name }}</span>
                                    </td>
                                    <td>
                                        <span class="badge bg-primary-subtle text-primary rounded-3 fw-semibold fs-2">
                                            {{ $asset->category->name }}
                                        </span>
                                    </td>
                                    <td>
                                        <span
                                            class="text-capitalize">{{ $asset->location ? $asset->location->name : $asset->location }}</span>
                                    </td>
                                    <td>
                                        <p class="mb-0">{{ $asset->quantity }}</p>
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
                                                    <a href="{{ route('assets.show', $asset) }}"
                                                        class="dropdown-item d-flex align-items-center gap-3">
                                                        <i class="fs-4 ti ti-eye"></i>Detail
                                                    </a>
                                                </li>
                                                @if (auth()->user()->isNotPrincipal())
                                                    <li>
                                                        <a href="{{ route('assets.edit', $asset) }}"
                                                            class="dropdown-item d-flex align-items-center gap-3">
                                                            <i class="fs-4 ti ti-pencil"></i>Edit
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <form
                                                            onsubmit="return confirm('Apakah anda yakin ingin menghapus aset ini?')"
                                                            action="{{ route('assets.destroy', $asset) }}" method="post">
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
                                        <p class="fs-3 text-muted mb-0">Tidak ada aset ditemukan</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class='px-4 mt-3'>{{ $assets->links() }}</div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        // Menangani peringatan sukses
        var successAlert = document.getElementById('success-alert');
        if (successAlert) {
            setTimeout(function() {
                successAlert.classList.add('animate__fadeOut');
                successAlert.addEventListener('animationend', function() {
                    successAlert.remove();
                });
            }, 3000);
        }
    </script>
@endsection
