@extends('layouts.app', ['title' => 'Edit Aset'])

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="px-4 py-3 border-bottom">
                <div class="d-flex align-items-center justify-content-between">
                    <h5 class="card-title fw-semibold mb-0">Edit Aset: {{ $asset->name }}</h5>
                    <a href="{{ route('assets.index') }}"
                        class="btn btn-outline-primary btn-sm d-flex align-items-center gap-1">
                        <i class="ti ti-arrow-left fs-4"></i> Kembali
                    </a>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('assets.update', $asset) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="alert alert-info">
                        <strong>Info!</strong>
                        Data aset yang ditambahkan semua berasal dari kepala yayasan. Pastikan data yang dimasukkan sudah
                        benar.
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label">Nama Aset</label>
                            <input type="text" class="form-control" id="name" name="name"
                                value="{{ old('name', $asset->name) }}" placeholder="Contoh: Laptop Lenovo" required>
                            @error('name')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="category_id" class="form-label">Kategori</label>
                            <select class="form-select" id="category_id" name="category_id" required>
                                <option value="">Pilih Kategori</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ old('category_id', $asset->category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="location_id" class="form-label">Lokasi</label>
                            <select class="form-select" id="location_id" name="location_id" required>
                                <option value="">Pilih Lokasi</option>
                                @foreach ($locations as $location)
                                    <option value="{{ $location->id }}"
                                        {{ old('location_id', $asset->location_id) == $location->id ? 'selected' : '' }}>
                                        {{ $location->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('location_id')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="quantity" class="form-label">Jumlah</label>
                            <input type="number" class="form-control" id="quantity" name="quantity"
                                value="{{ old('quantity', $asset->quantity) }}" min="1" required>
                            @error('quantity')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="condition" class="form-label">Kondisi</label>
                            <select class="form-select" id="condition" name="condition" required>
                                <option value="">Pilih Kondisi</option>
                                <option value="baik"
                                    {{ old('condition', $asset->condition) == 'baik' ? 'selected' : '' }}>Baik</option>
                                <option value="rusak"
                                    {{ old('condition', $asset->condition) == 'rusak' ? 'selected' : '' }}>Rusak</option>
                            </select>
                            @error('condition')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="image" class="form-label">Gambar Aset</label>
                        <input type="file" class="form-control" id="image" name="image" accept="image/*"
                            onchange="previewImage()">
                        <div class="mt-2">
                            @if ($asset->image)
                                <img id="image-preview" src="{{ asset('storage/' . $asset->image) }}" alt="Gambar Aset"
                                    class="img-thumbnail" style="max-height: 200px">
                            @else
                                <img id="image-preview" src="#" alt="Preview Gambar" class="img-thumbnail d-none"
                                    style="max-height: 200px">
                            @endif
                        </div>
                        <small class="text-muted">Format yang didukung: JPEG, PNG, JPG, GIF. Maksimal 2MB.</small>
                        @error('image')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Deskripsi</label>
                        <textarea class="form-control" id="description" name="description" rows="3" placeholder="Deskripsi detail aset">{{ old('description', $asset->description) }}</textarea>
                        @error('description')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="additional_info" class="form-label">Informasi Tambahan</label>
                        <textarea class="form-control" id="additional_info" name="additional_info" rows="2"
                            placeholder="Informasi tambahan (opsional)">{{ old('additional_info', $asset->additional_info) }}</textarea>
                        @error('additional_info')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('assets.index') }}" class="btn bg-light-gray text-dark">Batal</a>
                        <button type="submit" class="btn btn-primary">Perbarui</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        function previewImage() {
            const imageInput = document.getElementById('image');
            const imagePreview = document.getElementById('image-preview');

            if (imageInput.files && imageInput.files[0]) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    imagePreview.src = e.target.result;
                    imagePreview.classList.remove('d-none');
                }

                reader.readAsDataURL(imageInput.files[0]);
            }
        }
    </script>
@endsection
