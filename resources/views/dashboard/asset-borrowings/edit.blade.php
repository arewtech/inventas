@extends('layouts.app', ['title' => 'Edit Peminjaman Aset'])

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="px-4 py-3 border-bottom">
                <div class="d-flex align-items-center justify-content-between">
                    <h5 class="card-title fw-semibold mb-0">Edit Peminjaman Aset</h5>
                    <a href="{{ route('asset-borrowings.index') }}"
                        class="btn btn-outline-primary btn-sm d-flex align-items-center gap-1">
                        <i class="ti ti-arrow-left fs-4"></i> Kembali
                    </a>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('asset-borrowings.update', $assetBorrowing->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Display Asset Info (Read Only) -->
                    <div class="alert alert-info d-flex align-items-center mb-4" role="alert">
                        <i class="ti ti-info-circle fs-5 me-2"></i>
                        <div>
                            Aset: <strong>{{ $assetBorrowing->asset->name }}</strong> |
                            Lokasi: <strong>{{ $assetBorrowing->asset->location->name }}</strong> |
                            Jumlah Dipinjam: <strong>{{ $assetBorrowing->quantity }}</strong>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="location_id" class="form-label">Pilih Lokasi</label>
                            <select class="form-select" id="location_id" name="location_id" required>
                                <option value="">Pilih Lokasi</option>
                                @foreach ($locations as $location)
                                    <option value="{{ $location->id }}"
                                        {{ old('location_id', $assetBorrowing->asset->location_id) == $location->id ? 'selected' : '' }}>
                                        {{ $location->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('location_id')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="asset_id" class="form-label">Pilih Aset</label>
                            <select class="form-select" id="asset_id" name="asset_id" required>
                                <option value="">Pilih aset</option>
                                @foreach ($assets as $asset)
                                    <option value="{{ $asset->id }}" data-stock="{{ $asset->quantity }}"
                                        {{ old('asset_id', $assetBorrowing->asset_id) == $asset->id ? 'selected' : '' }}>
                                        {{ $asset->name }} ({{ $asset->asset_number }}) - Stok: {{ $asset->quantity }}
                                    </option>
                                @endforeach
                            </select>
                            <small id="asset-loading" class="text-muted" style="display: none;">
                                <i class="spinner-border spinner-border-sm me-1"></i> Memuat data aset...
                            </small>
                            @error('asset_id')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="quantity" class="form-label">Jumlah</label>
                            <input type="number" class="form-control" id="quantity" name="quantity"
                                value="{{ old('quantity', $assetBorrowing->quantity) }}" min="1" required>
                            <small id="stock-info" class="text-muted">Pastikan jumlah tidak melebihi stok yang
                                tersedia</small>
                            @error('quantity')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="borrower_name" class="form-label">Nama Peminjam</label>
                            <input type="text" class="form-control" id="borrower_name" name="borrower_name"
                                value="{{ old('borrower_name', $assetBorrowing->borrower_name) }}" required>
                            @error('borrower_name')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="borrower_phone" class="form-label">Nomor Telepon</label>
                            <input type="text" class="form-control" id="borrower_phone" name="borrower_phone"
                                value="{{ old('borrower_phone', $assetBorrowing->borrower_phone) }}" required>
                            @error('borrower_phone')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="borrower_address" class="form-label">Alamat Peminjam (Opsional)</label>
                        <textarea class="form-control" id="borrower_address" name="borrower_address" rows="2">{{ old('borrower_address', $assetBorrowing->borrower_address) }}</textarea>
                        @error('borrower_address')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="borrowed_at" class="form-label">Tanggal Peminjaman</label>
                            <input type="date" class="form-control" id="borrowed_at"
                                value="{{ $assetBorrowing->borrowed_at->format('Y-m-d') }}" readonly disabled>
                            <small class="text-muted">Tanggal peminjaman tidak dapat diubah</small>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="expected_return_date" class="form-label">Tanggal Pengembalian</label>
                            <input type="date" class="form-control" id="expected_return_date" name="expected_return_date"
                                value="{{ old('expected_return_date', $assetBorrowing->expected_return_date->format('Y-m-d')) }}"
                                required>
                            @error('expected_return_date')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="actual_return_date" class="form-label">Tanggal Dikembalikan</label>
                            <input type="date" class="form-control" id="actual_return_date" name="actual_return_date"
                                value="{{ old('actual_return_date', $assetBorrowing->actual_return_date ? $assetBorrowing->actual_return_date->format('Y-m-d') : '') }}">
                            <small class="text-muted">Kosongkan jika belum dikembalikan</small>
                            @error('actual_return_date')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status" required>
                            <option value="borrowed"
                                {{ old('status', $assetBorrowing->status) == 'borrowed' ? 'selected' : '' }}>
                                Dipinjam
                            </option>
                            <option value="returned"
                                {{ old('status', $assetBorrowing->status) == 'returned' ? 'selected' : '' }}>
                                Dikembalikan
                            </option>
                            <option value="lost"
                                {{ old('status', $assetBorrowing->status) == 'lost' ? 'selected' : '' }}>
                                Hilang
                            </option>
                        </select>
                        @error('status')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="notes" class="form-label">Catatan (Opsional)</label>
                        <textarea class="form-control" id="notes" name="notes" rows="3">{{ old('notes', $assetBorrowing->notes) }}</textarea>
                        @error('notes')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('asset-borrowings.index') }}" class="btn bg-light-gray text-dark">Batal</a>
                        <button type="submit" class="btn btn-primary">Perbarui</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const statusSelect = document.getElementById('status');
            const actualReturnDateInput = document.getElementById('actual_return_date');
            const locationSelect = document.getElementById('location_id');
            const assetSelect = document.getElementById('asset_id');
            const quantityInput = document.getElementById('quantity');
            const assetLoading = document.getElementById('asset-loading');

            // Function to load assets based on selected location
            function loadAssets(locationId, selectedAssetId = null) {
                if (!locationId) {
                    assetSelect.innerHTML = '<option value="">Pilih lokasi terlebih dahulu</option>';
                    return;
                }

                // Show loading indicator
                assetLoading.style.display = 'block';
                assetSelect.innerHTML = '<option value="">Memuat...</option>';

                // Make AJAX request
                fetch(`/dashboard/asset-borrowings/location/${locationId}/assets`)
                    .then(response => response.json())
                    .then(data => {
                        // Hide loading indicator
                        assetLoading.style.display = 'none';

                        // Clear current options
                        assetSelect.innerHTML = '<option value="">Pilih Aset</option>';

                        if (data.length > 0) {
                            // Add assets to select
                            data.forEach(asset => {
                                const option = document.createElement('option');
                                option.value = asset.id;
                                option.textContent =
                                    `${asset.name} (${asset.asset_number}) - Stok: ${asset.quantity}`;
                                option.dataset.stock = asset.quantity;

                                // Select the asset if it matches the selectedAssetId
                                if (selectedAssetId && asset.id == selectedAssetId) {
                                    option.selected = true;
                                }

                                assetSelect.appendChild(option);
                            });
                        } else {
                            assetSelect.innerHTML =
                                '<option value="">Tidak ada aset tersedia di lokasi ini</option>';
                        }
                    })
                    .catch(error => {
                        console.error('Error loading assets:', error);
                        assetLoading.style.display = 'none';
                        assetSelect.innerHTML = '<option value="">Error memuat data aset</option>';
                    });
            }

            // Function to check stock availability
            function checkStock() {
                if (assetSelect.selectedIndex > 0) {
                    const selectedOption = assetSelect.options[assetSelect.selectedIndex];
                    const availableStock = parseInt(selectedOption.dataset.stock);
                    const requestedQuantity = parseInt(quantityInput.value);
                    const stockInfo = document.getElementById('stock-info');

                    if (requestedQuantity > availableStock) {
                        stockInfo.className = 'text-danger';
                        stockInfo.textContent = `Peringatan: Jumlah melebihi stok tersedia (${availableStock})`;
                    } else {
                        stockInfo.className = 'text-success';
                        stockInfo.textContent = `Stok tersedia: ${availableStock}`;
                    }
                }
            }

            function updateActualReturnDate() {
                if (statusSelect.value === 'returned' && !actualReturnDateInput.value) {
                    // Auto-fill today's date when status is set to returned
                    const today = new Date();
                    const formattedDate = today.toISOString().slice(0, 10);
                    actualReturnDateInput.value = formattedDate;
                }
            }

            // Event listeners
            statusSelect.addEventListener('change', updateActualReturnDate);
            quantityInput.addEventListener('input', checkStock);
            assetSelect.addEventListener('change', checkStock);

            locationSelect.addEventListener('change', function() {
                const locationId = this.value;
                loadAssets(locationId);
            });

            // Initial load of assets for the current location
            const currentLocationId = locationSelect.value;
            const currentAssetId = '{{ old('asset_id', $assetBorrowing->asset_id) }}';
            if (currentLocationId) {
                loadAssets(currentLocationId, currentAssetId);
                // Check stock after assets are loaded
                setTimeout(checkStock, 500);
            }
        });
    </script>
@endsection
