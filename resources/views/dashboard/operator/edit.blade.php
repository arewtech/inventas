@extends('layouts.app', ['title' => 'Edit ' . $operator->name])
@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="px-4 py-3 border-bottom">
                <div class="d-flex align-items-center justify-content-between">
                    <h5 class="card-title fw-semibold mb-0">Edit Operator: {{ $operator->name }}</h5>
                    <a href="{{ route('operator.index') }}"
                        class="btn btn-outline-primary btn-sm d-flex align-items-center gap-1">
                        <i class="ti ti-arrow-left fs-4"></i> Kembali
                    </a>
                </div>
            </div>
            <div class="card-body">
                @foreach ($errors->all() as $error)
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Error!</strong> {{ $error }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endforeach

                <!-- Status Switch in Alert Box -->
                <div class="alert alert-info d-flex align-items-center justify-content-between mb-4" role="alert">
                    <div class="d-flex align-items-center">
                        <i class="ti ti-info-circle fs-5 me-2"></i>
                        <div>Status Operator</div>
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" name="status" type="checkbox" form="profileForm"
                            value="{{ $operator->status }}" {{ $operator->status == 'active' ? 'checked' : '' }}
                            id="status">
                        <label class="form-check-label" for="status">
                            Active
                        </label>
                    </div>
                </div>

                <form action="{{ route('operator.update', $operator) }}" method="post" id="profileForm">
                    @csrf
                    @method('put')
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label">Nama</label>
                            <input type="text" class="form-control" name="name" id="name" required
                                placeholder="Alex" value="{{ old('name', $operator->name) }}">
                            @error('name')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input id="username" type="text" value="{{ old('username', $operator->username) }}"
                                class="form-control" name="username" placeholder="alex27" required>
                            @error('username')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input id="email" type="email" value="{{ old('email', $operator->email) }}"
                                placeholder="alex@gmail.com" required class="form-control" name="email">
                            @error('email')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="phone" class="form-label">Phone</label>
                            <input id="phone" type="number" value="{{ old('phone', $operator->phone) }}"
                                placeholder="08123*****" required class="form-control" name="phone">
                            @error('phone')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input id="password" type="password" placeholder="**********" class="form-control"
                                name="password">
                            <small class="text-muted">Kosongkan jika tidak ingin mengubah password.</small>
                            @error('password')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('operator.index') }}" class="btn bg-light-gray text-dark">Batal</a>
                        <button type="submit" class="btn btn-primary">Perbarui</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
