@extends('layouts.front', ['title' => 'Ubah Password'])
@section('content')
    <section>
        <div class="container">
            <div class="col-md-8 m-auto py-4">
                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Error!</strong> {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @include('includes.flash-message.session')
                <!-- form -->
                <div class="card p-3 border-0 rounded-4">
                    <div class="card-header bg-white border-0">
                        <h4 class="fw-medium">Ubah Password</h4>
                    </div>
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="card-body">
                        <div class="row">
                            <form action="{{ route('user-password.update') }}" method="post">
                                @csrf
                                @method('put')
                                <div class="mb-3">
                                    <label for="exampleInputPassword1" class="form-label">Password Lama</label>
                                    <input type="password" name="current_password"
                                        class="form-control @error('current_password', 'updatePassword') is-invalid @enderror"
                                        id="exampleInputPassword1" placeholder="************">
                                    @error('current_password', 'updatePassword')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="exampleInputPassword2" class="form-label">Password Baru</label>
                                    <input type="password"
                                        class="form-control @error('password', 'updatePassword') is-invalid @enderror"
                                        name="password" id="exampleInputPassword2" placeholder="************">
                                    @error('password', 'updatePassword')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="exampleInputPassword3" class="form-label">Konfirmasi Password
                                        Baru</label>
                                    <input type="password" class="form-control" name="password_confirmation"
                                        id="exampleInputPassword3" placeholder="************">
                                </div>
                                {{-- <div class="d-flex align-items-center justify-content-end gap-2 mt-4">
                                        <button type="submit" class="btn btn-primary">Update</button>
                                    </div> --}}
                                <div class="col">
                                    <button type="submit" class="btn btn-sm btn-primary">
                                        Update
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
