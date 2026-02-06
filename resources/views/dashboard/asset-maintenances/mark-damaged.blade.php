@extends('layouts.app', ['title' => 'Tandai Aset Rusak'])

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="px-4 py-3 border-bottom">
                <div class="d-flex align-items-center justify-content-between">
                    <h5 class="card-title fw-semibold mb-0">Tandai Aset Rusak: {{ $asset->name }}</h5>
                    <a href="{{ route('assets.show', $asset->asset_number) }}"
                        class="btn btn-outline-primary btn-sm d-flex align-items-center gap-1">
                        <i class="ti ti-arrow-left fs-4"></i> Kembali
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="alert alert-warning">
                    <strong>Perhatian!</strong>
                    Aset rusak akan dipisahkan dari aset utama. Quantity aset utama akan berkurang sesuai jumlah yang rusak.
                </div>

                <div class="mb-4 p-3 bg-light rounded">
                    <h6 class="fw-semibold">Informasi Aset</h6>
                    <div class="row">
                        <div class="col-md-6">
                            <p class="mb-1"><strong>Nama:</strong> {{ $asset->name }}</p>
                            <p class="mb-1"><strong>Kategori:</strong> {{ $asset->category->name }}</p>
                            <p class="mb-1"><strong>Lokasi:</strong> {{ $asset->location->name }}</p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-1"><strong>Quantity Tersedia:</strong> <span
                                    class="badge bg-success">{{ $asset->quantity }}</span></p>
                            <p class="mb-1"><strong>Quantity Rusak:</strong> <span
                                    class="badge bg-danger">{{ $asset->total_damaged_quantity }}</span></p>
                            <p class="mb-1"><strong>Total Original:</strong> <span
                                    class="badge bg-info">{{ $asset->original_quantity }}</span></p>
                        </div>
                    </div>
                </div>

                <form action="{{ route('assets.store-damaged', $asset->asset_number) }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="quantity" class="form-label">Jumlah yang Rusak <span
                                    class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('quantity') is-invalid @enderror"
                                id="quantity" name="quantity" value="{{ old('quantity', 1) }}" min="1"
                                max="{{ $asset->quantity }}" required>
                            <small class="text-muted">Maksimal: {{ $asset->quantity }} (quantity tersedia)</small>
                            @error('quantity')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Deskripsi Kerusakan <span
                                class="text-danger">*</span></label>
                        <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                            rows="3" placeholder="Jelaskan kondisi dan jenis kerusakan..." required>{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="additional_info" class="form-label">Informasi Tambahan</label>
                        <textarea class="form-control @error('additional_info') is-invalid @enderror" id="additional_info"
                            name="additional_info" rows="2" placeholder="Informasi tambahan (opsional)">{{ old('additional_info') }}</textarea>
                        @error('additional_info')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('assets.show', $asset->asset_number) }}"
                            class="btn bg-light-gray text-dark">Batal</a>
                        <button type="submit" class="btn btn-danger">
                            <i class="ti ti-alert-circle me-1"></i> Tandai Rusak
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
