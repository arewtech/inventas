@extends('layouts.guest', ['title' => 'Login'])
@section('content')
    <div class="d-flex align-items-center justify-content-center w-100">
        <div class="row justify-content-center w-100">
            <div class="col-md-7 col-lg-4">
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
                        <p class="text-center">Masuk ke akun {{ setting('app_title', 'My App') }} anda</p>
                        <form action="{{ route('login') }}" method="post">
                            @csrf
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                    name="email" id="exampleInputEmail1" value="{{ old('email') }}"
                                    aria-describedby="emailHelp" placeholder="john@gmail.com" required>
                                @error('email')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <label for="exampleInputPassword1" class="form-label">Password</label>
                                <input type="password" name="password"
                                    class="form-control @error('password') is-invalid @enderror" id="exampleInputPassword1"
                                    placeholder="****************" required>
                                @error('password')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary w-100 py-8 fs-4 mb-4 rounded-2">Masuk</button>
                            <span class="d-block text-center mb-4">Data yang anda masukkan akan di enkripsi dan tidak akan
                                disalahgunakan</span>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
