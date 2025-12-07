@extends('layouts.blank', ['title' => 'Laporan Peminjaman Aset'])
@section('content')
    <div class="p-1">
        <div class="d-flex justify-content-between align-items-start mb-4">
            <div>
                <h3 class="mb-3">Laporan Peminjaman Aset</h3>
                <h5>Tanggal Cetak: <span class="fw-normal">{{ date('d/m/Y H:i') }}</span></h5>
            </div>
            <div class="no-print">
                <a href="javascript:window.print()" class="btn btn-sm btn-primary">
                    <i class="ti ti-printer"></i> Print
                </a>
            </div>
        </div>

        <div class="table-responsive mt-3">
            <table class="table align-middle mb-0 table-bordered">
                <thead>
                    <tr class="text-muted fw-semibold">
                        <th scope="col" class="text-center">No</th>
                        <th scope="col">Nama Aset</th>
                        <th scope="col">Peminjam</th>
                        <th class="text-center" scope="col">Jumlah</th>
                        <th>Lokasi</th>
                        <th scope="col">Tanggal Pinjam</th>
                        <th scope="col">Tanggal Kembali</th>
                        <th scope="col">Status</th>
                        <th scope="col">Catatan</th>
                    </tr>
                </thead>
                <tbody class="border-top">
                    @forelse ($borrowings as $borrowing)
                        <tr>
                            <td class="text-center">
                                <p class="mb-0">
                                    {{ $loop->iteration }}
                                </p>
                            </td>
                            <td>
                                <div class="mb-0 fs-3">
                                    {{ $borrowing->asset->name }}
                                </div>
                            </td>
                            <td>
                                <p class="mb-0">
                                    {{ $borrowing->borrower_name }}<br>
                                    <small>{{ $borrowing->borrower_phone }}</small>
                                </p>
                            </td>
                            <td class="text-center">
                                <p class="fs-3 text-dark mb-0">
                                    {{ $borrowing->quantity }}
                                </p>
                            </td>
                            <td>
                                <p class="mb-0">
                                    {{ $borrowing->asset->location->name ?? 'Tidak diketahui' }}
                                </p>
                            </td>
                            <td>
                                <p class="mb-0">
                                    {{ $borrowing->borrowed_at->format('d/m/Y') }}
                                </p>
                            </td>
                            <td>
                                <p class="mb-0">
                                    {{ $borrowing->actual_return_date ? $borrowing->actual_return_date->format('d/m/Y') : 'Belum dikembalikan' }}
                                </p>
                            </td>
                            <td>
                                {{ $borrowing->status == 'borrowed' ? 'Dipinjam' : ($borrowing->status == 'returned' ? 'Dikembalikan' : 'Hilang') }}
                            </td>
                            <td>
                                <p class="mb-0">
                                    {{ $borrowing->notes ?? '-' }}
                                </p>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center">
                                <p class="fs-3 text-muted mb-0">Data tidak ditemukan</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <hr>
        <div class="d-flex justify-content-end mt-3">
            <div>
                <h5>Total Peminjaman: {{ $borrowings->count() }}</h5>
                <h5>Total Aset yang Dipinjam: {{ $borrowings->sum('quantity') }}</h5>
            </div>
        </div>
    </div>
    <script>
        window.print();
    </script>
@endsection
