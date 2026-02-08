@extends('layouts.app', ['title' => 'Edit Pemeliharaan Aset'])

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="px-4 py-3 border-bottom">
                <div class="d-flex align-items-center justify-content-between">
                    <h5 class="card-title fw-semibold mb-0">Edit Pemeliharaan Aset</h5>
                    <a href="{{ route('asset-maintenances.index') }}"
                        class="btn btn-outline-primary btn-sm d-flex align-items-center gap-1">
                        <i class="ti ti-arrow-left fs-4"></i> Kembali
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="alert alert-info">
                    <strong>Info!</strong>
                    Edit informasi pemeliharaan aset. Anda dapat mengubah kondisi, nominal, dan catatan pemeliharaan.
                </div>

                <!-- Asset Details Card (Read-Only) -->
                <div class="card bg-light mb-4">
                    <div class="card-body">
                        <h6 class="card-title mb-3">Detail Aset</h6>
                        <div class="row">
                            <div class="col-md-6">
                                <p class="mb-2"><strong>Nomor Aset:</strong> {{ $asset_maintenance->asset->asset_number }}
                                </p>
                                <p class="mb-2"><strong>Nama:</strong> {{ $asset_maintenance->asset->name }}</p>
                                <p class="mb-0"><strong>Kategori:</strong>
                                    {{ $asset_maintenance->asset->category->name }}</p>
                            </div>
                            <div class="col-md-6">
                                <p class="mb-2"><strong>Lokasi:</strong> {{ $asset_maintenance->asset->location->name }}
                                </p>
                                <p class="mb-0"><strong>Kondisi Saat Ini:</strong>
                                    @if ($asset_maintenance->asset->condition == 'baik')
                                        <span class="badge bg-success">Baik</span>
                                    @elseif ($asset_maintenance->asset->condition == 'rusak')
                                        <span class="badge bg-danger">Rusak</span>
                                    @else
                                        <span class="badge bg-warning">Perbaikan</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <form action="{{ route('asset-maintenances.update', $asset_maintenance->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="condition" class="form-label">Kondisi <span class="text-danger">*</span></label>
                            <select class="form-select @error('condition') is-invalid @enderror" id="condition"
                                name="condition" required onchange="toggleNominal()">
                                <option value="">-- Pilih Kondisi --</option>
                                <option value="baik"
                                    {{ old('condition', $asset_maintenance->condition) == 'baik' ? 'selected' : '' }}>Baik
                                </option>
                                <option value="rusak"
                                    {{ old('condition', $asset_maintenance->condition) == 'rusak' ? 'selected' : '' }}>Rusak
                                </option>
                                <option value="perbaikan"
                                    {{ old('condition', $asset_maintenance->condition) == 'perbaikan' ? 'selected' : '' }}>
                                    Perbaikan</option>
                            </select>
                            @error('condition')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3" id="nominal-field"
                            style="display: {{ old('condition', $asset_maintenance->condition) == 'perbaikan' ? 'block' : 'none' }};">
                            <label for="nominal" class="form-label">Nominal Biaya Perbaikan <span
                                    class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" class="form-control @error('nominal') is-invalid @enderror"
                                    id="nominal" name="nominal" value="{{ old('nominal', $asset_maintenance->nominal) }}"
                                    min="0" step="0.01" placeholder="0">
                            </div>
                            @error('nominal')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="notes" class="form-label">Catatan Pemeliharaan</label>
                        <textarea class="form-control @error('notes') is-invalid @enderror" id="notes" name="notes" rows="4"
                            placeholder="Catatan detail pemeliharaan (opsional)">{{ old('notes', $asset_maintenance->notes) }}</textarea>
                        @error('notes')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <small class="text-muted">
                            <i class="ti ti-info-circle"></i>
                            Terakhir diperbarui: {{ $asset_maintenance->updated_at->format('d/m/Y H:i') }}
                        </small>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('asset-maintenances.index') }}" class="btn bg-light-gray text-dark">Batal</a>
                        <button type="submit" class="btn btn-primary">
                            <i class="ti ti-device-floppy me-1"></i> Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        function toggleNominal() {
            const condition = document.getElementById('condition').value;
            const nominalField = document.getElementById('nominal-field');
            const nominalInput = document.getElementById('nominal');

            if (condition === 'perbaikan') {
                nominalField.style.display = 'block';
                nominalInput.required = true;
            } else {
                nominalField.style.display = 'none';
                nominalInput.required = false;
                nominalInput.value = '';
            }
        }
    </script>
@endsection
