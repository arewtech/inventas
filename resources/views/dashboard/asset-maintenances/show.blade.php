@extends('layouts.app', ['title' => 'Detail Pemeliharaan Aset'])

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="px-4 py-3 border-bottom">
                <div class="d-flex align-items-center justify-content-between">
                    <h5 class="card-title fw-semibold mb-0">Detail Pemeliharaan Aset</h5>
                    <div class="d-flex gap-2">
                        <a href="{{ route('asset-maintenances.edit', $asset_maintenance->id) }}"
                            class="btn btn-warning btn-sm d-flex align-items-center gap-1">
                            <i class="ti ti-edit fs-4"></i> Edit
                        </a>
                        <a href="{{ route('asset-maintenances.index') }}"
                            class="btn btn-outline-primary btn-sm d-flex align-items-center gap-1">
                            <i class="ti ti-arrow-left fs-4"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <!-- Asset Information -->
                <div class="card bg-light mb-4">
                    <div class="card-header bg-transparent">
                        <h6 class="mb-0 fw-semibold">Informasi Aset</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <table class="table table-borderless mb-0">
                                    <tr>
                                        <td width="150" class="text-muted">Nomor Aset</td>
                                        <td>: <strong>{{ $asset_maintenance->asset->asset_number }}</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Nama Aset</td>
                                        <td>: {{ $asset_maintenance->asset->name }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Kategori</td>
                                        <td>: {{ $asset_maintenance->asset->category->name }}</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <table class="table table-borderless mb-0">
                                    <tr>
                                        <td width="150" class="text-muted">Lokasi</td>
                                        <td>: {{ $asset_maintenance->asset->location->name }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Kondisi Saat Ini</td>
                                        <td>:
                                            @if ($asset_maintenance->asset->condition == 'baik')
                                                <span class="badge bg-success-subtle text-success">Baik</span>
                                            @elseif ($asset_maintenance->asset->condition == 'rusak')
                                                <span class="badge bg-danger-subtle text-danger">Rusak</span>
                                            @else
                                                <span class="badge bg-warning-subtle text-warning">Perbaikan</span>
                                            @endif
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Maintenance Record Information -->
                <div class="card">
                    <div class="card-header bg-transparent">
                        <h6 class="mb-0 fw-semibold">Detail Pemeliharaan</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-borderless">
                                    <tr>
                                        <td width="200" class="text-muted">Kondisi</td>
                                        <td>:
                                            @if ($asset_maintenance->condition == 'baik')
                                                <span class="badge bg-success-subtle text-success">Baik</span>
                                            @elseif ($asset_maintenance->condition == 'rusak')
                                                <span class="badge bg-danger-subtle text-danger">Rusak</span>
                                            @else
                                                <span class="badge bg-warning-subtle text-warning">Perbaikan</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @if ($asset_maintenance->condition == 'perbaikan' && $asset_maintenance->nominal)
                                        <tr>
                                            <td class="text-muted">Biaya Perbaikan</td>
                                            <td>: <strong class="text-danger">Rp
                                                    {{ number_format($asset_maintenance->nominal, 0, ',', '.') }}</strong>
                                            </td>
                                        </tr>
                                    @endif
                                    <tr>
                                        <td class="text-muted">Tanggal Pemeliharaan</td>
                                        <td>: {{ $asset_maintenance->created_at->format('d/m/Y H:i') }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Terakhir Diperbarui</td>
                                        <td>: {{ $asset_maintenance->updated_at->format('d/m/Y H:i') }}</td>
                                    </tr>
                                    @if ($asset_maintenance->notes)
                                        <tr>
                                            <td class="text-muted align-top">Catatan</td>
                                            <td>: {{ $asset_maintenance->notes }}</td>
                                        </tr>
                                    @endif
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="d-flex justify-content-end gap-2 mt-4">
                    <form action="{{ route('asset-maintenances.destroy', $asset_maintenance->id) }}" method="POST"
                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus record pemeliharaan ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="ti ti-trash me-1"></i> Hapus
                        </button>
                    </form>
                    <a href="{{ route('asset-maintenances.edit', $asset_maintenance->id) }}" class="btn btn-warning">
                        <i class="ti ti-edit me-1"></i> Edit
                    </a>
                    <a href="{{ route('asset-maintenances.index') }}" class="btn btn-outline-primary">
                        <i class="ti ti-arrow-left me-1"></i> Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
