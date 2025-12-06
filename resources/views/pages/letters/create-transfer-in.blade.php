@extends('layouts.front', ['title' => 'Buat Surat Keterangan Mutasi Terima'])
@section('content')
    <section>
        <div class="container">
            <div class="col-md-8 m-auto py-md-5 py-4">
                <a href="{{ route('letters-site') }}" class="btn btn-sm btn-outline-primary mb-3"><i
                        class="bi bi-arrow-left"></i> Kembali</a>
                <!-- header title -->
                <div class="header-complaint d-flex align-items-center">
                    <div class="col-md-8">
                        <h2>Surat Keterangan Mutasi Terima</h2>
                        <p class="text-secondary">
                            Isi formulir di bawah ini untuk mengirimkan permintaan surat
                            keterangan mutasi terima siswa.
                        </p>
                    </div>
                    <div class="col-md-4 text-center">
                        <img width="120" src="{{ asset('assets/frontsides/images/svg/certificate.svg') }}"
                            alt="Ilustrasi Pengaduan" class="img-fluid" />
                    </div>
                </div>
                <!-- end header title -->

                <!-- form -->
                <div class="card p-3 border-0 rounded-4 mt-4">
                    <div class="card-header bg-white border-0">
                        <h4 class="fw-medium">Form Surat Keterangan Mutasi Terima</h4>
                    </div>
                    <div class="card-body">
                        @foreach ($errors->all() as $item)
                            {{ $item }}
                        @endforeach
                        <form action="{{ route('transfer-in-sites.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="student_name" class="form-label">Nama Lengkap Siswa</label>
                                <input type="text" class="form-control" id="student_name" name="student_name" required
                                    placeholder="Masukkan nama lengkap siswa" />
                            </div>
                            <div class="mb-3">
                                <label for="birth_place" class="form-label">Tempat Lahir</label>
                                <input type="text" class="form-control" id="birth_place" name="birth_place"
                                    placeholder="Masukkan tempat lahir siswa" required />
                                <small class="text-secondary">contoh: Probolinggo</small>
                            </div>
                            <div class="mb-3">
                                <label for="birth_date" class="form-label">Tanggal Lahir</label>
                                <input type="date" class="form-control" id="birth_date" name="birth_date" required />
                            </div>
                            <div class="mb-3">
                                <label for="gender" class="form-label">Jenis Kelamin</label>
                                <select class="form-select" id="gender" name="gender" required>
                                    <option value="">Pilih Jenis Kelamin</option>
                                    <option value="male">Laki-laki</option>
                                    <option value="female">Perempuan</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="religion" class="form-label">Agama</label>
                                <select class="form-select" id="religion" name="religion" required>
                                    <option value="">Pilih Agama</option>
                                    <option value="Islam">Islam</option>
                                    <option value="Kristen">Kristen</option>
                                    <option value="Katolik">Katolik</option>
                                    <option value="Hindu">Hindu</option>
                                    <option value="Buddha">Buddha</option>
                                    <option value="Konghucu">Konghucu</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="class" class="form-label">Kelas ( SMP )</label>
                                <select class="form-select" id="class" name="class" required>
                                    <option value="">Pilih Kelas</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="previous_school" class="form-label">Sekolah Asal</label>
                                <input type="text" class="form-control" id="previous_school" name="previous_school"
                                    placeholder="Masukkan nama sekolah asal siswa" required />
                                <small class="text-secondary">sekolah sebelumnya / tempat mutasi dari</small>
                            </div>
                            <div class="mb-3">
                                <label for="student_address" class="form-label">Alamat Siswa</label>
                                <textarea class="form-control" id="student_address" name="student_address" rows="3"
                                    placeholder="Dusun Kramat Rt. 014 Rw. 005 Desa Wangkal Kec. Gading Kab. Probolinggo" required></textarea>
                                <small class="text-secondary">lihat
                                    <a href="javacript:void(0)" data-bs-toggle="modal" data-bs-target="#detailFormat"
                                        style="font-size: 0.9rem" class="text-dark">format
                                        penulisan</a> alamat surat
                                </small>
                            </div>
                            <div class="mb-3">
                                <p>
                                    <b>NB :</b> Sebelum tekan tombol kirim permintaan, pastikan
                                    data yang Anda masukkan sudah benar, karena data yang sudah
                                    dikirimkan tidak dapat diubah kembali.
                                </p>
                            </div>
                            <button type="submit" class="btn btn-sm btn-primary">
                                Kirim Permintaan
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @include('includes.frontsides.modal.rules')
@endsection
