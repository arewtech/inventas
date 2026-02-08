@extends('layouts.app', ['title' => 'Tambah Pemeliharaan Aset'])

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="px-4 py-3 border-bottom">
                <div class="d-flex align-items-center justify-content-between">
                    <h5 class="card-title fw-semibold mb-0">Tambah Pemeliharaan Aset</h5>
                    <a href="{{ route('asset-maintenances.index') }}"
                        class="btn btn-outline-primary btn-sm d-flex align-items-center gap-1">
                        <i class="ti ti-arrow-left fs-4"></i> Kembali
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="alert alert-info">
                    <strong>Info!</strong>
                    Tambahkan record pemeliharaan untuk aset. Hanya aset dengan kondisi <strong>baik</strong> yang dapat
                    ditambahkan ke pemeliharaan untuk tracking history.
                </div>
                <form action="{{ route('asset-maintenances.store') }}" method="POST">
                    @csrf

                    @if ($assets->isEmpty())
                        <div class="alert alert-warning">
                            <i class="ti ti-alert-triangle me-2"></i>
                            <strong>Tidak ada aset tersedia!</strong> Semua aset sudah memiliki status rusak atau dalam
                            perbaikan. Hanya aset dengan kondisi baik yang dapat ditambahkan ke pemeliharaan.
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="asset_id" class="form-label">Pilih Aset <span class="text-danger">*</span></label>
                            <select class="form-select @error('asset_id') is-invalid @enderror" id="asset_id"
                                name="asset_id" required onchange="showAssetDetails()"
                                {{ $assets->isEmpty() ? 'disabled' : '' }}>
                                <option value="">-- Pilih Aset --</option>
                                @foreach ($assets as $asset)
                                    <option value="{{ $asset->id }}" data-number="{{ $asset->asset_number }}"
                                        data-name="{{ $asset->name }}" data-category="{{ $asset->category->name }}"
                                        data-location="{{ $asset->location->name }}"
                                        data-condition="{{ $asset->condition }}"
                                        {{ old('asset_id') == $asset->id ? 'selected' : '' }}>
                                        {{ $asset->asset_number }} - {{ $asset->name }} ({{ $asset->category->name }})
                                    </option>
                                @endforeach
                            </select>
                            @error('asset_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Asset Details Card -->
                    <div id="asset-details" class="card bg-light mb-3" style="display: none;">
                        <div class="card-body">
                            <h6 class="card-title mb-3">Detail Aset</h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <p class="mb-2"><strong>Nomor Aset:</strong> <span id="detail-number"></span></p>
                                    <p class="mb-2"><strong>Nama:</strong> <span id="detail-name"></span></p>
                                    <p class="mb-0"><strong>Kategori:</strong> <span id="detail-category"></span></p>
                                </div>
                                <div class="col-md-6">
                                    <p class="mb-2"><strong>Lokasi:</strong> <span id="detail-location"></span></p>
                                    <p class="mb-0"><strong>Kondisi Saat Ini:</strong> <span id="detail-condition"></span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="condition" class="form-label">Kondisi <span class="text-danger">*</span></label>
                            <select class="form-select @error('condition') is-invalid @enderror" id="condition"
                                name="condition" required onchange="toggleNominal()">
                                <option value="">-- Pilih Kondisi --</option>
                                <option value="baik" {{ old('condition') == 'baik' ? 'selected' : '' }}>Baik</option>
                                <option value="rusak" {{ old('condition') == 'rusak' ? 'selected' : '' }}>Rusak</option>
                                <option value="perbaikan" {{ old('condition') == 'perbaikan' ? 'selected' : '' }}>Perbaikan
                                </option>
                            </select>
                            @error('condition')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3" id="nominal-field"
                            style="display: {{ old('condition') == 'perbaikan' ? 'block' : 'none' }};">
                            <label for="nominal" class="form-label">Nominal Biaya Perbaikan <span
                                    class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" class="form-control @error('nominal') is-invalid @enderror"
                                    id="nominal" name="nominal" value="{{ old('nominal') }}" min="0"
                                    step="0.01" placeholder="0">
                            </div>
                            @error('nominal')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="notes" class="form-label">Catatan Pemeliharaan</label>
                        <textarea class="form-control @error('notes') is-invalid @enderror" id="notes" name="notes" rows="4"
                            placeholder="Catatan detail pemeliharaan (opsional)">{{ old('notes') }}</textarea>
                        @error('notes')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('asset-maintenances.index') }}" class="btn bg-light-gray text-dark">Batal</a>
                        <button type="submit" class="btn btn-primary" {{ $assets->isEmpty() ? 'disabled' : '' }}>
                            <i class="ti ti-device-floppy me-1"></i> Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        function showAssetDetails() {
            const select = document.getElementById('asset_id');
            const selectedOption = select.options[select.selectedIndex];
            const detailsCard = document.getElementById('asset-details');

            if (selectedOption.value) {
                document.getElementById('detail-number').textContent = selectedOption.dataset.number;
                document.getElementById('detail-name').textContent = selectedOption.dataset.name;
                document.getElementById('detail-category').textContent = selectedOption.dataset.category;
                document.getElementById('detail-location').textContent = selectedOption.dataset.location;

                const condition = selectedOption.dataset.condition;
                let conditionBadge = '';
                if (condition === 'baik') {
                    conditionBadge = '<span class="badge bg-success">Baik</span>';
                } else if (condition === 'rusak') {
                    conditionBadge = '<span class="badge bg-danger">Rusak</span>';
                } else {
                    conditionBadge = '<span class="badge bg-warning">Perbaikan</span>';
                }
                document.getElementById('detail-condition').innerHTML = conditionBadge;

                detailsCard.style.display = 'block';
            } else {
                detailsCard.style.display = 'none';
            }
        }

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

        // Show asset details on page load if asset is already selected (old input)
        document.addEventListener('DOMContentLoaded', function() {
            const assetSelect = document.getElementById('asset_id');
            if (assetSelect.value) {
                showAssetDetails();
            }
        });
    </script>
@endsection
