@extends('layouts.front', ['title' => 'Profil'])
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
                        <h4 class="fw-medium">Edit Profil</h4>
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
                        <form action="{{ route('user-profile-information.update') }}" method="post"
                            enctype="multipart/form-data" id="profileForm">
                            @csrf
                            @method('put')
                            <div class="row">
                                <div class="col-12 mb-4 text-center">
                                    <div class="d-flex align-items-center flex-wrap gap-2">
                                        <div class="box-image rounded-circle border m-auto mb-1">
                                            <img id="uploadedAvatar" style="width: 120px; height: 120px; object-fit: cover;"
                                                src="{{ auth()->user()->avatar_url }}" alt="Foto Profil"
                                                class="rounded-circle" />
                                            <input id="upload-profile" name="photo" type="file"
                                                class="form-control hide-input account-file-input" accept="image/*" />
                                            {{-- <span class="text-muted">Upload</span> --}}
                                            <div class="delete-image account-image-reset">
                                                <i class="bi bi-x-circle-fill fs-5 text-danger"></i>
                                            </div>
                                        </div>
                                        {{-- <input id="upload-profile" name="photo" type="file"
                                            class="form-control account-file-input" accept="image/*" /> --}}
                                    </div>
                                    <small class="text-muted">Ukuran file maksimal 2MB. Format file: JPG, JPEG,
                                        PNG</small>
                                </div>
                                <hr />
                                <div class="col-md-6 mb-3">
                                    <label for="name" class="form-label">Nama Lengkap</label>
                                    <input type="text" class="form-control" id="name" name="name" required
                                        placeholder="Masukkan nama lengkap Anda" value="{{ auth()->user()->name }}" />
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="username" class="form-label">Username</label>
                                    <input type="text" class="form-control" id="username" name="username" required
                                        placeholder="Masukkan username Anda" value="{{ auth()->user()->username }}" />
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" required
                                        placeholder="Masukkan email Anda" value="{{ auth()->user()->email }}" />
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="phone" class="form-label">No. HP</label>
                                    <input type="text" class="form-control" id="phone" name="phone"
                                        placeholder="Masukkan nomor hp Anda" value="{{ auth()->user()->phone }}" />
                                    <small class="text-muted">Opsional: boleh tidak diisi</small>
                                </div>
                                <div class="col-12">
                                    <button type="submit" onclick="updateProfile()" class="btn btn-sm btn-primary">
                                        Update
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('after:script')
    <script>
        // preview object URL
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
@endpush
