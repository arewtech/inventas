@extends('layouts.app', ['title' => 'List Surat Keterangan Mutasi Keluar'])
@section('content')
    <div class="container-fluid">
        <div class="d-sm-flex d-block align-items-center justify-content-between mb-7">
            <div class="mb-3 mb-sm-0">
                <h5 class="card-title fw-semibold">Data Surat Keterangan Mutasi Keluar</h5>
                <p class="card-subtitle mb-0">List Surat Keterangan Mutasi Keluar yang telah dibuat</p>
            </div>
            <div class="d-flex align-items-center gap-2">
                <div>
                    <form action="" method="get">
                        <select class="form-select" name="status">
                            <option value="" selected> Pilih Status </option>
                            <option value="pending" @if (request('status') == 'pending') selected @endif>Pending</option>
                            <option value="approved" @if (request('status') == 'approved') selected @endif>Approved</option>
                        </select>
                </div>
                <div>
                    <div class="input-group">
                        <input type="text" name="q" value="{{ request()->q }}" autofocus class="form-control"
                            placeholder="Search" aria-label="Search" aria-describedby="button-addon2">
                        <button class="btn btn-outline-primary" type="submit" id="button-addon2">
                            <i class="ti ti-search"></i>
                        </button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="card w-100">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead>
                            <tr class="text-muted fw-semibold">
                                <th scope="col">No</th>
                                <th scope="col">Nama Siswa</th>
                                <th scope="col">Kelas</th>
                                <th scope="col">Sekolah Tujuan</th>
                                <th scope="col">Pengaju</th>
                                <th scope="col">Tanggal</th>
                                <th scope="col">Status</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody class="border-top">
                            @forelse ($transfer_outs as $item)
                                <tr>
                                    <td>
                                        <p class="mb-0">
                                            {{ $loop->iteration + ($transfer_outs->currentPage() - 1) * $transfer_outs->perPage() }}
                                        </p>
                                    </td>
                                    <td>
                                        <span class="line-clamp-2 text-capitalize">
                                            {{ $item->student_name }}
                                        </span>
                                    </td>
                                    <td>
                                        {{ $item->class }} SMP
                                    </td>
                                    <td>
                                        <p class="fs-3 text-dark mb-0">
                                            {{ $item->destination_school }}
                                        </p>
                                    </td>
                                    <td>
                                        <span class="line-clamp-2 text-capitalize">
                                            {{ $item->user->name }}
                                        </span>
                                    </td>
                                    <td>
                                        <p class="fs-3 text-dark mb-0">
                                            {{ formatDate($item->created_at) }}
                                        </p>
                                    </td>
                                    <td>
                                        <form action="{{ route('transfer-outs.update', $item->id) }}" method="post">
                                            @csrf
                                            @method('put')
                                            <a onclick="this.closest('form').submit()" href="javascript:void(0)"
                                                class="mb-0 text-capitalize">
                                                <span class="badge {{ $item->status_color }} rounded-3 fw-semibold fs-2">
                                                    {{ $item->status }}
                                            </a>
                                        </form>
                                    </td>
                                    <td>
                                        <div class="dropdown dropstart">
                                            <a href="javascript:void(0)" class="text-muted" id="dropdownMenuButton"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="ti ti-dots fs-5"></i>
                                            </a>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="">
                                                <li>
                                                    <a href="javascript:void(0)" data-bs-toggle="modal"
                                                        data-bs-target="#modal-detail-{{ $item->id }}"
                                                        class="dropdown-item d-flex align-items-center gap-3">
                                                        <i class="fs-4 ti ti-eye"></i>Detail</a>
                                                </li>
                                                <li>
                                                    <a href="javascript:void(0)" data-bs-toggle="modal"
                                                        data-bs-target="#modal-update-{{ $item->id }}"
                                                        class="dropdown-item d-flex align-items-center gap-3">
                                                        <i class="fs-4 ti ti-pencil"></i>Edit</a>
                                                </li>
                                                <li>
                                                    <form onsubmit="return confirm('Apakah anda yakin?')"
                                                        action="{{ route('transfer-outs.destroy', $item->id) }}"
                                                        method="post">
                                                        @csrf
                                                        @method('delete')
                                                        <button type="submit"
                                                            class="dropdown-item d-flex align-items-center gap-3">
                                                            <i class="fs-4 ti ti-trash"></i>
                                                            Delete</button>
                                                    </form>
                                                </li>
                                            </ul>
                                        </div>

                                        <!-- Modal detail letter -->
                                        <div class="modal fade" id="modal-detail-{{ $item->id }}" tabindex="-1"
                                            aria-labelledby="mySmallModalLabel" aria-hidden="true" style="display: none;">
                                            <div class="modal-dialog modal-dialog-scrollable modal-xl">
                                                <div class="modal-content">
                                                    <div class="modal-header d-flex align-items-center">
                                                        <h4 class="modal-title" id="myModalLabel">
                                                            Detail Surat Keterangan Mutasi Keluar
                                                        </h4>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <h6> Title : <span
                                                                class="fw-normal text-capitalize">{{ $item->letter ?? '-' }}</span>
                                                        </h6>
                                                        <h6> Di setujui oleh :
                                                            {{ $item->responseBy->name ?? '-' }}
                                                        </h6>
                                                        @if ($item->number !== null)
                                                            <div class="d-flex align-items-center gap-1">
                                                                <h6 class="m-0">
                                                                    Print :
                                                                </h6>
                                                                <a href="{{ route('transfer-outs.print', $item->id) }}"
                                                                    class="d-flex align-items-center gap-3" target="_blank">
                                                                    <i class="fs-4 ti ti-printer fs-5"></i></a>
                                                            </div>
                                                        @endif
                                                        <table class="table table-bordered mt-3">
                                                            <tr>
                                                                <td class="text-muted fw-semibold"> Dibuat oleh :</td>
                                                                <td> {{ $item->user->name }} </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="text-muted fw-semibold"> Nama Siswa :</td>
                                                                <td class="text-capitalize"> {{ $item->student_name }}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="text-muted fw-semibold"> Tempat, Tanggal Lahir :
                                                                </td>
                                                                <td>
                                                                    {{ $item->birth_place }},
                                                                    {{ formatDate($item->birth_date) }}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="text-muted fw-semibold"> Jenis Kelamin :</td>
                                                                <td class="text-capitalize">
                                                                    {{ $item->gender == 'male' ? 'Laki-laki' : 'Perempuan' }}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="text-muted fw-semibold"> Agama :</td>
                                                                <td class="text-capitalize"> {{ $item->religion }} </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="text-muted fw-semibold"> Kelas :</td>
                                                                <td> {{ $item->class }} SMP</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="text-muted fw-semibold"> NISN :</td>
                                                                <td> {{ $item->nisn }} </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="text-muted fw-semibold"> Sekolah Tujuan :</td>
                                                                <td> {{ $item->destination_school }} </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="text-muted fw-semibold"> Alamat Siswa :</td>
                                                                <td> {{ $item->student_address }} </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="text-muted fw-semibold"> Alasan Pindah :</td>
                                                                <td> {{ $item->reason }} </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="text-muted fw-semibold"> Tanggal buat : </td>
                                                                <td> {{ formatDate($item->created_at) }}
                                                            </tr>
                                                            <tr>
                                                                <td class="text-muted fw-semibold"> Status :</td>
                                                                <td>
                                                                    <span
                                                                        class="text-capitalize badge {{ $item->status_color }} rounded-3 fw-semibold fs-2">
                                                                        {{ $item->status }}
                                                                    </span>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- End Modal detail letter -->

                                        <!-- Modal -->
                                        <div class="modal fade" id="modal-update-{{ $item->id }}" tabindex="-1"
                                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h1 class="modal-title fs-5 text-capitalize"
                                                            id="exampleModalLabel">
                                                            Update Nomor Surat | {{ $item->student_name }}
                                                        </h1>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <form action="{{ route('transfer-outs.update-number', $item->id) }}"
                                                        method="post">
                                                        @csrf
                                                        @method('put')
                                                        <div class="modal-body">
                                                            <h6 class="line-clamp">Detail {{ $item->letter }}</h6>
                                                            <div>
                                                                <label for="number" class="form-label">Nomor
                                                                    Surat</label>
                                                                <input type="text" id="number" class="form-control"
                                                                    name="number" value="{{ $item->number }}"
                                                                    placeholder=".../.../.../..." required>
                                                                <small
                                                                    class="text-muted
                                                                    text-danger">*contoh
                                                                    : <b>470 / 34 / 409.12 / 2024</b></small>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-sm btn-light"
                                                                data-bs-dismiss="modal">Close</button>
                                                            <button type="submit"
                                                                class="btn btn-sm btn-primary">Update</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center">
                                        <p class="fs-3 text-dark mb-0">Data tidak ditemukan</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class='px-4 mt-3'>{{ $transfer_outs->links() }}</div>
            </div>
        </div>
    </div>
@endsection
