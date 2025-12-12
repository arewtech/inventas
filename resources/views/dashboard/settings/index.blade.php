@extends('layouts.app', ['title' => 'Pengaturan Aplikasi'])
@section('content')
    <div class="container-fluid">
        <h5 class="card-title fw-semibold mb-4">App Settings</h5>
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
            <form class="needs-validation" action="{{ route('settings.store') }}" method="post"
                enctype="multipart/form-data">
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
                                    style="width: 280px" id="logo" placeholder="Lavor">
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-4">
                                <div class="mb-3 mb-md-4">
                                    <label for="nameWebsite" class="form-label fw-semibold">Nama Website</label>
                                    <input type="text" class="form-control" name="app_title" id="nameWebsite"
                                        value="{{ setting('app_title') }}" placeholder="Inventas">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3 mb-md-4">
                                    <label for="email" class="form-label fw-semibold">Email</label>
                                    <input type="email" class="form-control" name="app_email" id="email"
                                        value="{{ setting('app_email') }}" placeholder="example@sch.id">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3 mb-md-4">
                                    <label for="phone" class="form-label fw-semibold">
                                        No. Telp</label>
                                    <input type="text" class="form-control" name="app_phone" id="phone"
                                        value="{{ setting('app_phone') }}" placeholder="0828318231">
                                </div>
                            </div>
                        </div>
                        <div class="row">
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
                    <div class="card-body p-4 pb-2 border-bottom">
                        <!-- question -->
                        <h5 class="fs-4 fw-semibold ">Pengaturan Surat</h5>
                        <p class="text-muted mb-4">Pengaturan untuk surat cetak data ( print )</p>
                        <div class="payments">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3 mb-md-4">
                                        <label for="lead" class="form-label fw-semibold">
                                            Nama
                                        </label>
                                        <input type="text" class="form-control" name="app_lead"
                                            value="{{ setting('app_lead') }}" id="lead"
                                            placeholder="Muhammad Fauzi, S.Pd">
                                        <small class="text-muted">*Nama lengkap penandatangan surat</small>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3 mb-md-4">
                                        <label for="nip" class="form-label fw-semibold">
                                            NIP ( Optional )
                                        </label>
                                        <input type="number" class="form-control" name="app_nip"
                                            value="{{ setting('app_nip') }}" id="app_nip"
                                            placeholder="19650412 199003 1 001">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3 mb-md-4">
                                        <label for="occupation" class="form-label fw-semibold">
                                            Jabatan
                                        </label>
                                        <select class="form-select" name="app_occupation" id="occupation">
                                            <option value="" disabled selected>Pilih Jabatan</option>
                                            <option value="Kepala Desa" @if (setting('app_occupation') == 'Kepala Desa') selected @endif>
                                                Kepala Desa</option>
                                            <option value="Sekretaris Desa"
                                                @if (setting('app_occupation') == 'Sekretaris Desa') selected @endif>
                                                Sekretaris Desa</option>
                                            <option value="Kepala Sekolah"
                                                @if (setting('app_occupation') == 'Kepala Sekolah') selected @endif>
                                                Kepala Sekolah</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-md-4">
                                    <div class="mb-3 mb-md-4">
                                        <label for="lead" class="form-label fw-semibold">
                                            NSS
                                        </label>
                                        <input type="text" class="form-control" name="app_nss"
                                            value="{{ setting('app_nss') }}" id="lead" placeholder="202052015006">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3 mb-md-4">
                                        <label for="nip" class="form-label fw-semibold">
                                            NPSN
                                        </label>
                                        <input type="number" class="form-control" name="app_npsn"
                                            value="{{ setting('app_npsn') }}" id="app_npsn" placeholder="20548768">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3 mb-md-4">
                                        <label for="nip" class="form-label fw-semibold">
                                            Kode Pos
                                        </label>
                                        <input type="text" class="form-control" name="app_postal_code"
                                            value="{{ setting('app_postal_code') }}" id="app_postal_code"
                                            placeholder="67284">
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-md-4">
                                    <div class="mb-3 mb-md-4">
                                        <label for="lead" class="form-label fw-semibold">
                                            Nama Yayasan
                                        </label>
                                        <input type="text" class="form-control" name="app_foundation_name"
                                            value="{{ setting('app_foundation_name') }}" id="lead"
                                            placeholder="Yayasan Al-Khairiyah">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3 mb-md-4">
                                        <label for="nip" class="form-label fw-semibold">
                                            Nama Sekolah
                                        </label>
                                        <input type="text" class="form-control" name="app_school_name"
                                            value="{{ setting('app_school_name') }}" id="app_school_name"
                                            placeholder="SMA Al Khairiyah">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3 mb-md-4">
                                        <label for="nip" class="form-label fw-semibold">
                                            Terakreditasi
                                        </label>
                                        <input type="text" class="form-control" name="app_accreditation"
                                            value="{{ setting('app_accreditation') }}" id="app_accreditation"
                                            maxlength="1" placeholder="B">
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-md-4">
                                    <div class="mb-3 mb-md-4">
                                        <label for="city" class="form-label fw-semibold">Kabupaten</label>
                                        <input type="city" class="form-control" name="app_city" id="email"
                                            value="{{ setting('app_city') }}" placeholder="Probolinggo">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3 mb-md-4">
                                        <label for="district" class="form-label fw-semibold">Kecamatan</label>
                                        <input type="text" class="form-control" name="app_district" id="district"
                                            value="{{ setting('app_district') }}" placeholder="Paiton">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3 mb-md-4">
                                        <label for="village" class="form-label fw-semibold">Desa</label>
                                        <input type="text" class="form-control" name="app_village" id="village"
                                            value="{{ setting('app_village') }}" placeholder="Sukodadi">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3 mb-md-4">
                                        <label for="mailing_address" class="form-label fw-semibold">
                                            Alamat Surat
                                        </label>
                                        <input type="text" class="form-control" name="app_mailing_address"
                                            value="{{ setting('app_mailing_address') }}" id="app_mailing_address"
                                            placeholder="Jl. Raya Wangkal Gading Probolinggo-67285">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center justify-content-center gap-4 mb-2">
                                        <div class="position-relative">
                                            <div class="border border-2 border-dark-subtle rounded-circle">
                                                <img id="uploadedTTD" style="object-fit: cover"
                                                    src="{{ setting('app_ttd') !== null ? asset('storage/' . setting('app_ttd')) : asset('assets/images/fake-ttd.png') }}"
                                                    class="rounded-circle m-1" alt="user1" width="70"
                                                    height="70">
                                            </div>
                                            <span
                                                class="cursor-pointer ttd-image-reset position-absolute top-0 start-100 translate-middle fw-bold badge rounded-pill text-bg-danger">
                                                X
                                                <span class="visually-hidden">unread messages</span>
                                            </span>
                                        </div>
                                        <div class="mb-3 mb-md-4">
                                            <label for="ttd" class="form-label fw-semibold">Upload TTD</label>
                                            <input type="file" class="form-control ttd-file-input" name="app_ttd"
                                                id="ttd">
                                            <small class="text-muted">*Upload gambar tanda tangan yg transparant</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body px-4 pb-2 pt-3 border-bottom">
                        <h5 class="fs-4 fw-semibold ">Setting Pagination ( Global )</h5>
                        <p class="text-muted mb-4">Pengaturan jumlah data yang ditampilkan per halaman</p>
                        <div class="paginations">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3 mb-md-4">
                                        <label for="pagination" class="form-label fw-semibold">
                                            Set Global Pagination
                                        </label>
                                        <input type="number" class="form-control" name="app_pagination" id="pagination"
                                            value="{{ setting('app_pagination') }}" placeholder="10">
                                    </div>
                                </div>
                                {{-- <hr class=""> --}}
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
                                    <a href="javacript:void(0)" data-bs-toggle="modal" data-bs-target="#detailFormat"
                                        style="font-size: 0.9rem" class="text-decoration-none text-primary">format
                                        address</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Format -->
    <div class="modal fade" id="detailFormat" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">
                        Format Penulisan
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>
                        <b>Alamat Website #1:</b> Jl. Raya Panglima Sudirman Sumberlele Kec. Kraksaan Kab. Probolinggo
                    </p>
                    <p>
                        <b>Alamat Website #2:</b> Jl. Raya P. Sudirman Sumberlele Kraksaan Probolinggo 67284
                    </p>
                    <p>
                        <b>Alamat Surat:</b> Jl. Raya Panglima Sudirman Sumberlele Kec. Kraksaan Kab. Probolinggo
                    </p>
                    <p>
                        <b>Social Media:</b> https://www.facebook.com/
                    </p>
                </div>
            </div>
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
