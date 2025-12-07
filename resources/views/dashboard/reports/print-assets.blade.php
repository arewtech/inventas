@extends('layouts.blank', ['title' => 'Laporan Daftar Aset'])
@section('content')
    <div class="p-1">
        <div class="d-flex justify-content-between align-items-start mb-4">
            <div>
                <h3 class="mb-3">Laporan Daftar Aset</h3>
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
                        <th class="text-center" scope="col">Kategori</th>
                        <th class="text-center" scope="col">Jumlah</th>
                        <th scope="col">Lokasi</th>
                        <th scope="col">Info Tambahan</th>
                    </tr>
                </thead>
                <tbody class="border-top">
                    @forelse ($assets as $asset)
                        <tr>
                            <td class="text-center">
                                <p class="mb-0">
                                    {{ $loop->iteration }}
                                </p>
                            </td>
                            <td>
                                <div class="mb-0 fs-3">
                                    {{ $asset->name }}
                                </div>
                            </td>
                            <td class="text-center">
                                <p class="mb-0">
                                    {{ $asset->category->name }}
                                </p>
                            </td>
                            <td class="text-center">
                                <p class="fs-3 text-dark mb-0">
                                    {{ $asset->quantity }}
                                </p>
                            </td>
                            <td>
                                <p class="mb-0">
                                    {{ $asset->location->name ?? '-' }}
                                </p>
                            </td>
                            <td>
                                <p class="mb-0">
                                    {{ $asset->additional_info ?? '-' }}
                                </p>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">
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
                <h5>Total Aset: {{ $assets->count() }}</h5>
                <h5>Total Kuantitas: {{ $assets->sum('quantity') }}</h5>
            </div>
        </div>
    </div>
    <script>
        window.print();
    </script>
@endsection
