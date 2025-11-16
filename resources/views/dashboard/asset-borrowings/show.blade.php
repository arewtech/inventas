@extends('layouts.app', ['title' => 'Detail Peminjaman Aset'])

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="px-4 py-3 border-bottom">
                <div class="d-flex align-items-center justify-content-between">
                    <h5 class="card-title fw-semibold mb-0">Detail Peminjaman Aset</h5>
                    <a href="{{ route('asset-borrowings.index') }}"
                        class="btn btn-outline-primary btn-sm d-flex align-items-center gap-1">
                        <i class="ti ti-arrow-left fs-4"></i> Kembali
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-8">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <tr>
                                    <th class="bg-light" style="vertical-align: middle;" width="200">Aset</th>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if ($assetBorrowing->asset->image)
                                                <img src="{{ asset('storage/' . $assetBorrowing->asset->image) }}"
                                                    alt="{{ $assetBorrowing->asset->name }}" class="rounded me-2"
                                                    style="width: 50px; height: 50px; object-fit: cover;">
                                            @else
                                                <div class="rounded bg-light d-flex align-items-center justify-content-center me-2"
                                                    style="width: 50px; height: 50px;">
                                                    <i class="ti ti-photo-off text-muted"></i>
                                                </div>
                                            @endif
                                            <div>
                                                <h6 class="fw-semibold mb-0">{{ $assetBorrowing->asset->name }}</h6>
                                                <a href="{{ route('assets.show', $assetBorrowing->asset) }}"
                                                    class="text-decoration-none">
                                                    <span
                                                        class="fs-3 text-primary">{{ $assetBorrowing->asset->asset_number }}</span>
                                                </a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Status</th>
                                    <td>
                                        <span
                                            class="badge {{ getBorrowingColors($assetBorrowing->status) }} rounded-3 fw-semibold fs-2">
                                            {{ getBorrowingStatuses($assetBorrowing->status) }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Jumlah</th>
                                    <td>{{ $assetBorrowing->quantity }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Lokasi</th>
                                    <td>{{ $assetBorrowing->asset->location->name ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Peminjam</th>
                                    <td>{{ $assetBorrowing->borrower_name }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Nomor Telepon</th>
                                    <td>{{ $assetBorrowing->borrower_phone }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Alamat</th>
                                    <td>{{ $assetBorrowing->borrower_address ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Tanggal Peminjaman</th>
                                    <td>{{ $assetBorrowing->borrowed_at->format('d F Y, H:i') }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Tanggal Pengembalian</th>
                                    <td>{{ $assetBorrowing->expected_return_date->format('d F Y') }}</td>
                                </tr>
                                @if ($assetBorrowing->actual_return_date)
                                    <tr>
                                        <th class="bg-light">Tanggal Dikembalikan</th>
                                        <td>{{ $assetBorrowing->actual_return_date->format('d F Y, H:i') }}</td>
                                    </tr>
                                @endif
                                <tr>
                                    <th class="bg-light">Catatan</th>
                                    <td>{{ $assetBorrowing->notes ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Dicatat Oleh</th>
                                    <td>{{ $assetBorrowing->user->name ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Dibuat Pada</th>
                                    <td>{{ $assetBorrowing->created_at->format('d F Y, H:i') }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Diperbarui Pada</th>
                                    <td>{{ $assetBorrowing->updated_at->format('d F Y, H:i') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-4">
                        @if (auth()->user()->isNotPrincipal())
                            <div class="card">
                                <div class="card-header bg-primary text-white">
                                    <h5 class="card-title text-white mb-0">Aksi</h5>
                                </div>
                                <div class="card-body">
                                    <div class="d-grid gap-2">
                                        <a href="{{ route('asset-borrowings.edit', $assetBorrowing->id) }}"
                                            class="btn btn-outline-primary">
                                            <i class="ti ti-pencil me-1"></i> Edit Data Peminjaman
                                        </a>

                                        @if ($assetBorrowing->status == 'borrowed')
                                            <form action="{{ route('asset-borrowings.return', $assetBorrowing->id) }}"
                                                method="POST">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="btn btn-success w-100">
                                                    <i class="ti ti-check me-1"></i> Tandai Sebagai Dikembalikan
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="card {{ auth()->user()->isNotPrincipal() ? 'mt-4' : '' }}">
                            <div class="card-header bg-dark text-white">
                                <h5 class="card-title text-white mb-0">Status Peminjaman</h5>
                            </div>
                            <div class="card-body">
                                <ul class="list-group">
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        Status
                                        @if ($assetBorrowing->status == 'borrowed')
                                            <span class="badge bg-warning-subtle text-warning rounded-3 fw-semibold fs-2">
                                                Dipinjam
                                            </span>
                                        @elseif ($assetBorrowing->status == 'returned')
                                            <span class="badge bg-success-subtle text-success rounded-3 fw-semibold fs-2">
                                                Dikembalikan
                                            </span>
                                        @else
                                            <span class="badge bg-danger-subtle text-danger rounded-3 fw-semibold fs-2">
                                                Hilang
                                            </span>
                                        @endif
                                    </li>

                                    @if ($assetBorrowing->status == 'borrowed')
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            Durasi Peminjaman
                                            <span class="badge bg-primary-subtle text-primary rounded-3 fw-semibold fs-2">
                                                {{ $assetBorrowing->borrowed_at->diffInDays(now()) }} hari
                                            </span>
                                        </li>

                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            Sisa Waktu
                                            @php
                                                $daysLeft = now()->diffInDays(
                                                    $assetBorrowing->expected_return_date,
                                                    false,
                                                );
                                            @endphp

                                            @if ($daysLeft > 0)
                                                <span
                                                    class="badge bg-success-subtle text-success rounded-3 fw-semibold fs-2">
                                                    {{ $daysLeft }} hari lagi
                                                </span>
                                            @elseif($daysLeft == 0)
                                                <span
                                                    class="badge bg-warning-subtle text-warning rounded-3 fw-semibold fs-2">
                                                    Hari ini
                                                </span>
                                            @else
                                                <span class="badge bg-danger-subtle text-danger rounded-3 fw-semibold fs-2">
                                                    Terlambat {{ abs($daysLeft) }} hari
                                                </span>
                                            @endif
                                        </li>
                                    @endif

                                    @if ($assetBorrowing->status == 'returned')
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            Durasi Peminjaman
                                            <span class="badge bg-primary-subtle text-primary rounded-3 fw-semibold fs-2">
                                                {{ $assetBorrowing->borrowed_at->diffInDays($assetBorrowing->actual_return_date) }}
                                                hari
                                            </span>
                                        </li>

                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            Status Pengembalian
                                            @php
                                                $returnStatus = $assetBorrowing->expected_return_date->diffInDays(
                                                    $assetBorrowing->actual_return_date,
                                                    false,
                                                );
                                            @endphp

                                            @if ($returnStatus <= 0)
                                                <span
                                                    class="badge bg-success-subtle text-success rounded-3 fw-semibold fs-2">
                                                    Tepat Waktu
                                                </span>
                                            @else
                                                <span class="badge bg-danger-subtle text-danger rounded-3 fw-semibold fs-2">
                                                    Terlambat {{ $returnStatus }} hari
                                                </span>
                                            @endif
                                        </li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
