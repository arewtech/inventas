@extends('layouts.app', ['title' => 'Tambah Peminjaman Aset'])

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="px-4 py-3 border-bottom">
                <div class="d-flex align-items-center justify-content-between">
                    <h5 class="card-title fw-semibold mb-0">Tambah Peminjaman Aset</h5>
                    <a href="{{ route('asset-borrowings.index') }}"
                        class="btn btn-outline-primary btn-sm d-flex align-items-center gap-1">
                        <i class="ti ti-arrow-left fs-4"></i> Kembali
                    </a>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('asset-borrowings.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="location_id" class="form-label">Pilih Lokasi</label>
                            <select class="form-select" id="location_id" name="location_id" required>
                                <option value="">Pilih Lokasi</option>
                                @foreach ($locations as $location)
                                    <option value="{{ $location->id }}"
                                        {{ old('location_id') == $location->id ? 'selected' : '' }}>
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
                            <select class="form-select" id="asset_id" name="asset_id" required disabled>
                                <option value="">Pilih lokasi terlebih dahulu</option>
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
                                value="{{ old('quantity', 1) }}" min="1" required disabled>
                            <small id="stock-info" class="text-muted">Pilih aset terlebih dahulu</small>
                            @error('quantity')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="borrower_name" class="form-label">Nama Peminjam</label>
                            <input type="text" class="form-control" id="borrower_name" name="borrower_name"
                                value="{{ old('borrower_name') }}" placeholder="Masukkan nama peminjam" required>
                            @error('borrower_name')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="borrower_phone" class="form-label">Nomor Telepon</label>
                            <input type="text" class="form-control" id="borrower_phone" name="borrower_phone"
                                value="{{ old('borrower_phone') }}" placeholder="Contoh: 08123456789" required>
                            @error('borrower_phone')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="borrower_address" class="form-label">Alamat Peminjam (Opsional)</label>
                        <textarea class="form-control" id="borrower_address" name="borrower_address" rows="2"
                            placeholder="Masukkan alamat peminjam">{{ old('borrower_address') }}</textarea>
                        @error('borrower_address')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="borrowed_at" class="form-label">Tanggal Peminjaman</label>
                            <input type="date" class="form-control" id="borrowed_at" name="borrowed_at"
                                value="{{ old('borrowed_at', date('Y-m-d')) }}" required>
                            @error('borrowed_at')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="expected_return_date" class="form-label">Tanggal Pengembalian</label>
                            <input type="date" class="form-control" id="expected_return_date" name="expected_return_date"
                                value="{{ old('expected_return_date', date('Y-m-d', strtotime('+7 days'))) }}" required>
                            @error('expected_return_date')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="notes" class="form-label">Catatan (Opsional)</label>
                        <textarea class="form-control" id="notes" name="notes" rows="3"
                            placeholder="Masukkan catatan tambahan jika diperlukan">{{ old('notes') }}</textarea>
                        @error('notes')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('asset-borrowings.index') }}" class="btn bg-light-gray text-dark">Batal</a>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const locationSelect = document.getElementById('location_id');
            const assetSelect = document.getElementById('asset_id');
            const quantityInput = document.getElementById('quantity');
            const stockInfo = document.getElementById('stock-info');
            const assetLoading = document.getElementById('asset-loading');

            // Function to load assets based on selected location
            function loadAssets(locationId) {
                if (!locationId) {
                    assetSelect.innerHTML = '<option value="">Pilih lokasi terlebih dahulu</option>';
                    assetSelect.disabled = true;
                    quantityInput.disabled = true;
                    stockInfo.textContent = 'Pilih aset terlebih dahulu';
                    stockInfo.className = 'text-muted';
                    return;
                }

                // Show loading indicator
                assetLoading.style.display = 'block';
                assetSelect.disabled = true;
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
                                assetSelect.appendChild(option);
                            });
                            assetSelect.disabled = false;
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

                    if (requestedQuantity > availableStock) {
                        stockInfo.className = 'text-danger';
                        stockInfo.textContent = `Peringatan: Jumlah melebihi stok tersedia (${availableStock})`;
                    } else {
                        stockInfo.className = 'text-success';
                        stockInfo.textContent = `Stok tersedia: ${availableStock}`;
                    }
                } else {
                    stockInfo.className = 'text-muted';
                    stockInfo.textContent = 'Pilih aset terlebih dahulu';
                }
            }

            // Event listeners
            locationSelect.addEventListener('change', function() {
                const locationId = this.value;
                loadAssets(locationId);

                // Reset quantity input and info
                quantityInput.value = 1;
                quantityInput.disabled = true;
                stockInfo.textContent = 'Pilih aset terlebih dahulu';
                stockInfo.className = 'text-muted';
            });

            assetSelect.addEventListener('change', function() {
                if (this.selectedIndex > 0) {
                    quantityInput.disabled = false;
                    checkStock();
                } else {
                    quantityInput.disabled = true;
                    stockInfo.textContent = 'Pilih aset terlebih dahulu';
                    stockInfo.className = 'text-muted';
                }
            });

            quantityInput.addEventListener('input', checkStock);

            // Initial check if there are old values (for validation errors)
            @if (old('location_id'))
                loadAssets('{{ old('location_id') }}');
            @endif
        });
    </script>
@endsection
