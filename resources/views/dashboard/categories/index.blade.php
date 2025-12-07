@extends('layouts.app', ['title' => 'Kategori'])
@section('content')
    <div class="container-fluid">
        <div class="d-sm-flex d-block align-items-center justify-content-between mb-7">
            <div class="mb-3 mb-sm-0">
                <h5 class="card-title fw-semibold">Kategori</h5>
                <p class="card-subtitle mb-0">Daftar kategori yang tersedia</p>
            </div>
        </div>

        <div class="row">
            <!-- Kolom kiri - Tabel kategori -->
            <div class="{{ auth()->user()->isNotPrincipal() ? 'col-md-8' : 'col-md-12' }}">
                <div class="card w-100">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table align-middle mb-0">
                                <thead>
                                    <tr class="text-muted fw-semibold">
                                        <th scope="col">ID</th>
                                        <th scope="col">Nama</th>
                                        <th scope="col">Deskripsi</th>
                                        <th scope="col">Dibuat</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody class="border-top">
                                    @forelse ($categories as $category)
                                        <tr>
                                            <td>
                                                <p class="mb-0">{{ $loop->iteration }}</p>
                                            </td>
                                            <td>
                                                <span class="text-capitalize">{{ $category->name }}</span>
                                            </td>
                                            <td>
                                                <span class="line-clamp-2">{{ $category->description ?? '-' }}</span>
                                            </td>
                                            <td>
                                                <p class="fs-3 text-dark mb-0">
                                                    {{ $category->created_at->format('d/m/Y') }}
                                                </p>
                                            </td>
                                            @if (auth()->user()->role !== 'kepala_sekolah')
                                                <td>
                                                    <div class="dropdown dropstart">
                                                        <a href="#" class="text-muted" id="dropdownMenuButton"
                                                            data-bs-toggle="dropdown" aria-expanded="false">
                                                            <i class="ti ti-dots fs-5"></i>
                                                        </a>
                                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                            <li>
                                                                <a href="javascript:void(0)" data-bs-toggle="modal"
                                                                    data-bs-target="#modal-edit{{ $category->id }}"
                                                                    class="dropdown-item d-flex align-items-center gap-3">
                                                                    <i class="fs-4 ti ti-pencil"></i>Edit
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <form
                                                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori ini?')"
                                                                    action="{{ route('categories.destroy', $category->id) }}"
                                                                    method="post">
                                                                    @csrf
                                                                    @method('delete')
                                                                    <button type="submit"
                                                                        class="dropdown-item d-flex align-items-center gap-3">
                                                                        <i class="fs-4 ti ti-trash"></i>Hapus
                                                                    </button>
                                                                </form>
                                                            </li>
                                                        </ul>
                                                    </div>

                                                    <!-- Modal edit kategori -->
                                                    <div class="modal fade" id="modal-edit{{ $category->id }}"
                                                        tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-scrollable">
                                                            <div class="modal-content">
                                                                <div class="modal-header d-flex align-items-center">
                                                                    <h4 class="modal-title" id="editModalLabel">
                                                                        Edit Kategori: {{ $category->name }}
                                                                    </h4>
                                                                    <button type="button" class="btn-close"
                                                                        data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <form
                                                                        action="{{ route('categories.update', $category->id) }}"
                                                                        method="post">
                                                                        @csrf
                                                                        @method('put')
                                                                        <div class="mb-3">
                                                                            <label for="name" class="form-label">Nama
                                                                                Kategori</label>
                                                                            <input type="text" class="form-control"
                                                                                id="name"
                                                                                value="{{ $category->name }}"
                                                                                name="name"
                                                                                placeholder="Contoh: Elektronik" required>
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <label for="description"
                                                                                class="form-label">Deskripsi</label>
                                                                            <textarea class="form-control" id="description" name="description" rows="3" placeholder="Deskripsi kategori">{{ $category->description }}</textarea>
                                                                        </div>
                                                                        <div class="d-flex justify-content-end">
                                                                            <button type="submit"
                                                                                class="btn btn-primary">Perbarui</button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            @endif
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center">
                                                <p class="fs-3 text-muted mb-0">Tidak ada kategori ditemukan</p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            @if (auth()->user()->isNotPrincipal())
                <!-- Kolom kanan - Form tambah -->
                <div class="col-md-4">
                    <div class="card">
                        <div class="px-4 py-3 border-bottom">
                            <h5 class="card-title fw-normal mb-0">
                                Tambah Kategori
                            </h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('categories.store') }}" method="post">
                                @csrf
                                <div class="mb-3">
                                    <label for="create-name" class="form-label">Nama Kategori</label>
                                    <input type="text" class="form-control" id="create-name" name="name"
                                        placeholder="Contoh: Elektronik" required>
                                </div>
                                <div class="mb-3">
                                    <label for="create-description" class="form-label">Deskripsi</label>
                                    <textarea class="form-control" id="create-description" name="description" rows="3"
                                        placeholder="Deskripsi kategori"></textarea>
                                </div>
                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
