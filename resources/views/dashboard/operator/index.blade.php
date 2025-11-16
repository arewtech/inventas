@extends('layouts.app', ['title' => 'Data User'])
@section('content')
    <div class="container-fluid">
        <div class="d-sm-flex d-block align-items-center justify-content-between mb-7">
            <div class="mb-3 mb-sm-0">
                <h5 class="card-title fw-semibold">Data User</h5>
                <p class="card-subtitle mb-0">Data User yang terdaftar.</p>
            </div>
            @if (auth()->user()->role == 'admin')
                <div class="d-flex align-items-center gap-2">
                    <a href="{{ route('operator.create') }}" class="btn btn-primary">Tambah</a>
                </div>
            @endif
        </div>
        <div class="card w-100">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead>
                            <tr class="text-muted fw-semibold">
                                <th scope="col">No</th>
                                <th scope="col">Nama</th>
                                <th scope="col">Email</th>
                                <th scope="col">Phone</th>
                                <th scope="col">Role</th>
                                <th scope="col">Status</th>
                                @if (auth()->user()->role == 'admin')
                                    <th></th>
                                @endif
                            </tr>
                        </thead>
                        <tbody class="border-top">
                            @forelse ($operators as $item)
                                <tr>
                                    <td>
                                        <p class="mb-0">{{ $loop->iteration }}</p>
                                    </td>
                                    <td>
                                        <span class="line-clamp-2 text-capitalize"> {{ $item->name }} </span>
                                    </td>
                                    <td>
                                        <div class="mb-0 fs-3">
                                            {{ $item->email }}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="mb-0 fs-3">
                                            {{ $item->phone == '' ? '-' : $item->phone }}
                                        </div>
                                    </td>
                                    <td>
                                        <span
                                            class="text-capitalize badge {{ $item->role == 'operator' ? 'bg-info-subtle text-info' : 'bg-primary-subtle text-primary' }} rounded-3 fw-semibold fs-2">
                                            {{ $item->role == 'kepala_sekolah' ? 'Kepala Sekolah' : $item->role }}
                                        </span>
                                    </td>
                                    <td>
                                        <span
                                            class="text-capitalize badge {{ $item->status_color }} rounded-3 fw-semibold fs-2">
                                            {{ $item->status }}
                                        </span>
                                    </td>
                                    @if (auth()->user()->role == 'admin')
                                        <td>
                                            <div class="dropdown dropstart">
                                                <a href="#" class="text-muted" id="dropdownMenuButton"
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="ti ti-dots fs-5"></i>
                                                </a>
                                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton"
                                                    style="">
                                                    <li>
                                                        <a class="dropdown-item d-flex align-items-center gap-3"
                                                            href="{{ route('operator.edit', $item) }}">
                                                            <i class="fs-4 ti ti-edit"></i>Edit</a>
                                                    </li>
                                                    @if (auth()->user()->isNotPrincipal())
                                                        <li>
                                                            <form onsubmit="return confirm('Apakah anda yakin?')"
                                                                action="{{ route('operator.destroy', $item) }}"
                                                                method="post">
                                                                @csrf
                                                                @method('delete')
                                                                <button type="submit"
                                                                    class="dropdown-item d-flex align-items-center gap-3">
                                                                    <i class="fs-4 ti ti-trash"></i>
                                                                    Delete</button>
                                                            </form>
                                                        </li>
                                                    @endif
                                                </ul>
                                            </div>
                                        </td>
                                    @endif
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center">
                                        <p class="fs-3 text-dark mb-0">Tidak ada data User yang terdaftar</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
