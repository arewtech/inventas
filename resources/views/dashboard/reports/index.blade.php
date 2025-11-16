@extends('layouts.app', ['title' => 'Form Report'])
@section('content')
    <div class="container-fluid">
        <div class="d-sm-flex d-block align-items-center justify-content-between mb-7">
            <div class="mb-3 mb-sm-0">
                <h5 class="card-title fw-semibold">Form Report</h5>
                <p class="card-subtitle mb-0">Filter data berdasarkan kriteria yang diinginkan</p>
            </div>
        </div>

        <div class="row">
            <!-- Asset Reports Form -->
            <div class="col-md-6">
                <div class="card w-100">
                    <div class="card-body">
                        <h5 class="card-title mb-3">Laporan Aset</h5>
                        <form action="{{ route('reports.assets') }}" method="get" target="_blank">
                            <div class="mb-3">
                                <label for="category_id" class="form-label">Kategori</label>
                                <select class="form-select" name="category_id">
                                    <option value="">Semua Kategori</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="location_id" class="form-label">Lokasi</label>
                                <select class="form-select" name="location_id">
                                    <option value="">Semua Lokasi</option>
                                    @foreach ($locations as $location)
                                        <option value="{{ $location->id }}">
                                            {{ $location->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">
                                    <i class="ti ti-printer me-1"></i> Cetak Laporan Aset
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Asset Borrowing Reports Form -->
            <div class="col-md-6">
                <div class="card w-100">
                    <div class="card-body">
                        <h5 class="card-title mb-3">Laporan Peminjaman Aset</h5>
                        <form action="{{ route('reports.asset-borrowings') }}" method="get" target="_blank">
                            <div class="mb-3">
                                <label for="location_id_borrowing" class="form-label">Lokasi</label>
                                <select class="form-select" id="location_id_borrowing" name="location_id_borrowing">
                                    <option value="">Semua Lokasi</option>
                                    @foreach ($locations as $location)
                                        <option value="{{ $location->id }}">
                                            {{ $location->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="asset_id" class="form-label">Aset</label>
                                <select class="form-select" id="asset_id" name="asset_id" disabled>
                                    <option value="">Pilih lokasi terlebih dahulu</option>
                                </select>
                                <small id="asset-loading-borrowing" class="text-muted" style="display: none;">
                                    <i class="spinner-border spinner-border-sm me-1"></i> Memuat data aset...
                                </small>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="start_date" class="form-label">Tanggal Mulai</label>
                                    <input type="date" class="form-control" name="start_date">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="end_date" class="form-label">Tanggal Selesai</label>
                                    <input type="date" class="form-control" name="end_date">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select class="form-select" name="status">
                                    <option value="">Semua Status</option>
                                    <option value="borrowed">Dipinjam</option>
                                    <option value="returned">Dikembalikan</option>
                                    <option value="lost">Hilang</option>
                                </select>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">
                                    <i class="ti ti-printer me-1"></i> Cetak Laporan Peminjaman
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const locationBorrowingSelect = document.getElementById('location_id_borrowing');
            const assetSelect = document.getElementById('asset_id');
            const assetLoading = document.getElementById('asset-loading-borrowing');

            // Function to load assets based on selected location
            function loadAssets(locationId) {
                if (!locationId) {
                    assetSelect.innerHTML = '<option value="">Pilih lokasi terlebih dahulu</option>';
                    assetSelect.disabled = true;
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
                        assetSelect.innerHTML = '<option value="">Semua Aset</option>';

                        if (data.length > 0) {
                            // Add assets to select
                            data.forEach(asset => {
                                const option = document.createElement('option');
                                option.value = asset.id;
                                option.textContent = `${asset.name} (${asset.asset_number})`;
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

            // Event listener for location change
            locationBorrowingSelect.addEventListener('change', function() {
                const locationId = this.value;
                loadAssets(locationId);
            });
        });
    </script>
@endsection
