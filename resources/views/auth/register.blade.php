@extends('layouts.guest', ['title' => 'Register'])
@section('content')
    <div class="d-flex align-items-center justify-content-center w-100">
        <div class="row justify-content-center w-100">
            <div class="col-md-7 col-lg-5">
                <div class="card mb-0">
                    <div class="card-body">
                        <a href="javascript:void(0)" class="text-nowrap logo-img text-center d-block w-100">
                            @if (setting('app_logo') !== null)
                                <img class="rounded-circle mb-2" src="{{ asset('storage/' . setting('app_logo')) }}"
                                    alt="logo"
                                    style="width: 55px; height: 55px; object-fit: cover; object-position: center;">
                            @else
                                <img class="rounded-circle" src="{{ asset('assets/images/logos/water.png') }}"
                                    alt="logo" width="90">
                            @endif
                            <span
                                class="text-dark fw-semibold text-capitalize fs-6">{{ setting('app_title', 'My App') }}</span>
                        </a>
                        <p class="text-center">Daftar akun {{ setting('app_title', 'My App') }} baru</p>
                        <form action="{{ route('register') }}" method="post">
                            @csrf
                            <div class="mb-3">
                                <label for="name" class="form-label">Nama Lengkap</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    name="name" id="name" value="{{ old('name') }}"
                                    placeholder="Masukkan nama lengkap" required>
                                @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" class="form-control @error('username') is-invalid @enderror"
                                    name="username" id="username" value="{{ old('username') }}"
                                    placeholder="Masukkan username" required>
                                @error('username')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                    name="email" id="email" value="{{ old('email') }}" placeholder="john@gmail.com"
                                    required>
                                @error('email')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" name="password"
                                    class="form-control @error('password') is-invalid @enderror" id="password"
                                    placeholder="****************" required>
                                @error('password')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                                <input type="password" name="password_confirmation"
                                    class="form-control @error('password_confirmation') is-invalid @enderror"
                                    id="password_confirmation" placeholder="****************" required>
                                @error('password_confirmation')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary w-100 py-8 fs-4 mb-4 rounded-2">Daftar</button>
                            <div class="d-flex align-items-center justify-content-center">
                                <p class="fs-4 mb-0 fw-bold">Sudah punya akun?</p>
                                <a class="text-primary fw-bold ms-2" href="{{ route('login') }}">Masuk</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
