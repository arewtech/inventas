@extends('layouts.app', ['title' => 'Pengaturan Aplikasi'])
@section('content')
    <div class="container-fluid">
        <h5 class="card-title fw-semibold mb-4">App Settings</h5>
        <div class="col-12">
            <form class="needs-validation" action="{{ route('settings.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="card">
                    <div class="card-body p-4 border-bottom">
                        <h5 class="fs-4 fw-semibold mb-4">Form Settings</h5>
                        <div class="d-flex align-items-center justify-content-center gap-4 mb-5">
                            <div class="position-relative">
                                <div class="border border-dark-subtle rounded-circle">
                                    <img id="uploadedLogo" style="object-fit: cover"
                                        src="{{ setting('app_logo') !== null ? asset('storage/' . setting('app_logo')) : asset('assets/images/logos/water.png') }}"
                                        class="rounded-circle m-1" alt="user1" width="70" height="70">
                                </div>
                                <span
                                    class="cursor-pointer logo-image-reset position-absolute top-0 start-100 translate-middle fw-bold badge rounded-pill text-bg-danger">
                                    X
                                    <span class="visually-hidden">unread messages</span>
                                </span>
                            </div>
                            <div>
                                <label for="logo" class="form-label fw-semibold">App Logo</label>
                                <input type="file" class="form-control logo-file-input" name="app_logo"
                                    style="width: 280px" id="logo" placeholder="App">
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-4">
                                <div class="mb-3 mb-md-4">
                                    <label for="nameWebsite" class="form-label fw-semibold">Nama Website</label>
                                    <input type="text" class="form-control" name="app_title" id="nameWebsite"
                                        value="{{ setting('app_title') }}" placeholder="Inventarisku">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3 mb-md-4">
                                    <label for="nameSchool" class="form-label fw-semibold">Nama Sekolah</label>
                                    <input type="text" class="form-control" name="app_school" id="nameSchool"
                                        value="{{ setting('app_school') }}" placeholder="Secana School">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3 mb-md-4">
                                    <label for="email" class="form-label fw-semibold">Email Website</label>
                                    <input type="email" class="form-control" name="app_email" id="email"
                                        value="{{ setting('app_email') }}" placeholder="example@sch.id">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3 mb-md-4">
                                    <label for="phone" class="form-label fw-semibold">
                                        No. Telp</label>
                                    <input type="text" class="form-control" name="app_phone" id="phone"
                                        value="{{ setting('app_phone') }}" placeholder="0828318231">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-2">
                                    <label for="address" class="form-label fw-semibold">Alamat</label>
                                    <textarea class="form-control" name="app_address"
                                        placeholder="Jl. Raya Pakuniran No.354, Dusun Kota Sukodadi, Sukodadi, Kec. Paiton, Kabupaten Probolinggo, Jawa Timur 67291"
                                        id="address" rows="3">{{ setting('app_address') }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body px-4 py-3">
                        <div class="row">
                            <div class="col">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center gap-2">
                                        <a href="{{ route('dashboard') }}"
                                            class="btn bg-light-gray text-bg-light-gray">Kembali</a>
                                        <button type="submit" class="btn btn-primary">Update</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', function(e) {
            function handleImagePreview(fileInput, imageElement, resetButton) {
                const resetImage = imageElement.src;

                fileInput.onchange = () => {
                    if (fileInput.files[0]) {
                        imageElement.src = window.URL.createObjectURL(fileInput.files[0]);
                    }
                };

                resetButton.onclick = () => {
                    fileInput.value = '';
                    imageElement.src = resetImage;
                };
            }

            // Update/reset app logo image
            let appLogoImage = document.getElementById('uploadedLogo');
            const logoFileInput = document.querySelector('.logo-file-input');
            const resetLogoInput = document.querySelector('.logo-image-reset');

            if (appLogoImage) {
                handleImagePreview(logoFileInput, appLogoImage, resetLogoInput);
            }

            // Update/reset app signature image
            let appSignatureImage = document.getElementById('uploadedTTD');
            const signatureFileInput = document.querySelector('.ttd-file-input');
            const resetSignatureInput = document.querySelector('.ttd-image-reset');

            if (appSignatureImage) {
                handleImagePreview(signatureFileInput, appSignatureImage, resetSignatureInput);
            }
        });
    </script>
@endsection
