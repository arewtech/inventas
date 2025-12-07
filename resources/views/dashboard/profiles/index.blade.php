@extends('layouts.app', ['title' => 'Profile Settings'])
@section('content')
    <div class="container-fluid">
        <h5 class="card-title fw-semibold mb-4">Profile Settings</h5>
        <div class="col-12">
            @foreach ($errors->all() as $error)
                {{ $error }}
            @endforeach
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Error!</strong> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @include('includes.flash-message.session')
            <div class="row mb-4">
                <div class="col-lg-6 d-flex align-items-stretch">
                    <div class="card w-100 position-relative overflow-hidden">
                        <div class="card-body p-4">
                            <h5 class="card-title fw-semibold">Change Profile</h5>
                            <p class="card-subtitle mb-4">Ganti profile anda disini</p>
                            <div class="text-center">
                                <img src="{{ auth()->user()->avatar_url }}" id="uploadedAvatar" alt="avatar"
                                    class="rounded-circle object-fit-contain" width="120" height="120">
                                <div class=" d-flex align-items-center justify-content-center my-4 gap-6">
                                    <button class="btn btn-primary position-relative overflow-hidden">
                                        Upload
                                        <input style="left: 0; opacity: 0;" class="position-absolute account-file-input"
                                            type="file" name="photo" id="upload-profile" accept="image/*">
                                    </button>
                                    <button class="btn bg-danger-subtle text-danger account-image-reset">Reset</button>
                                </div>
                                <p class="mb-0">Allowed JPG, JPEG or PNG. Max size of 1MB</p>
                                <hr>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 d-flex align-items-stretch">
                    <div class="card w-100 position-relative overflow-hidden">
                        <div class="card-body p-4">
                            <h5 class="card-title fw-semibold">Change Password</h5>
                            <p class="card-subtitle mb-4">Ganti password anda disini</p>
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
                                <div class="">
                                    <label for="exampleInputPassword3" class="form-label">Konfirmasi Password
                                        Baru</label>
                                    <input type="password" class="form-control" name="password_confirmation"
                                        id="exampleInputPassword3" placeholder="************">
                                </div>
                                <div class="d-flex align-items-center justify-content-end gap-2 mt-4">
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="card w-100 position-relative overflow-hidden mb-0">
                        <div class="card-body p-4">
                            <h5 class="card-title fw-semibold">General Information</h5>
                            <p class="card-subtitle mb-4">Ganti data anda disini</p>
                            <form action="{{ route('user-profile-information.update') }}" method="post"
                                enctype="multipart/form-data" id="profileForm">
                                @csrf
                                @method('put')
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="mb-3 mb-md-4">
                                            <label for="name" class="form-label fw-semibold">Name</label>
                                            <input type="text" class="form-control" name="name" id="name"
                                                required placeholder="Rizky Ramadhan" value="{{ auth()->user()->name }}">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3 mb-md-4">
                                            <label for="username" class="form-label fw-semibold">Username</label>
                                            <input
                                                style="{{ auth()->user()->role !== 'admin' ? 'pointer-events: none;' : '' }}"
                                                id="username" type="text" value="{{ auth()->user()->username }}"
                                                class="form-control @error('username', 'updateProfileInformation') is-invalid @enderror {{ auth()->user()->role !== 'admin' ? 'bg-disabled' : '' }}"
                                                {{ auth()->user()->role !== 'admin' ? 'readonly' : '' }} name="username">
                                            @error('username', 'updateProfileInformation')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                            @if (auth()->user()->role !== 'admin')
                                                <small class="text-muted">*hubungi admin jika ingin mengubah
                                                    Username</small>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3 mb-md-4">
                                            <label for="email" class="form-label fw-semibold">Email</label>
                                            <input type="email" class="form-control" name="email" id="email"
                                                required placeholder="Rizky Ramadhan"
                                                value="{{ auth()->user()->email }}">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3 mb-md-4">
                                            <label for="occupation" class="form-label">Phone</label>
                                            <input type="text" class="form-control" name="phone" id="phone"
                                                placeholder="081234567890" value="{{ auth()->user()->phone }}">
                                            <small class="text-muted">opsional: boleh tidak disi</small>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="d-flex align-items-center justify-content-end gap-2">
                                            <button type="submit" class="btn btn-primary"
                                                onclick="updateProfile()">Update</button>
                                        </div>
                                    </div>
                                </div>
                                @if (auth()->user()->role == 'student')
                                    <div class="alert alert-info alert-dismissible mt-3 mb-2" role="alert">
                                        <strong>Perhatian!</strong> Untuk data tanggal lahir, nomor telepon, dan alamat
                                        jika ingin mengubahnya silahkan hubungi operator. Terima kasih.
                                    </div>
                                @endif
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        // preview object URL
        $('input#accountActivation').on('change', function() {
            $('button.deactivate-account').attr('disabled', !$(this).is(':checked'));
        });
        document.addEventListener('DOMContentLoaded', function(e) {
            (function() {
                // Update/reset user image of account page
                let accountUserImage = document.getElementById('uploadedAvatar');
                const fileInput = document.querySelector('.account-file-input'),
                    resetFileInput = document.querySelector('.account-image-reset');
                if (accountUserImage) {
                    const resetImage = accountUserImage.src;
                    fileInput.onchange = () => {
                        if (fileInput.files[0]) {
                            accountUserImage.src = window.URL.createObjectURL(fileInput.files[0]);
                        }
                    };
                    resetFileInput.onclick = () => {
                        fileInput.value = '';
                        accountUserImage.src = resetImage;
                    };
                }
            })
            ();
        });
    </script>

    <script>
        function updateProfile() {
            const form = document.getElementById('profileForm');
            const formData = new FormData(form);

            // Mengambil file input avatar
            const avatarInput = document.getElementById('upload-profile');
            if (avatarInput.files.length > 0) {
                formData.append('photo', avatarInput.files[0]);
            }
            // Kirim form menggunakan Ajax
            $.ajax({
                type: form.method,
                url: form.action,
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    // Handle success response
                    console.log(response);
                },
                error: function(error) {
                    // Handle error response
                    console.error(error);
                }
            });
        }
    </script>
@endsection
