@extends('layouts.front', ['title' => 'Buat Surat Keterangan Mutasi Keluar'])
@section('content')
    <section>
        <div class="container">
            <div class="col-md-8 m-auto py-md-5 py-4">
                <a href="{{ route('letters-site') }}" class="btn btn-sm btn-outline-primary mb-3"><i
                        class="bi bi-arrow-left"></i> Kembali</a>
                <!-- header title -->
                <div class="header-complaint d-flex align-items-center">
                    <div class="col-md-8">
                        <h2>Surat Keterangan Mutasi Keluar</h2>
                        <p class="text-secondary">
                            Isi formulir di bawah ini untuk mengirimkan permintaan surat
                            keterangan mutasi keluar siswa.
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
                        <h4 class="fw-medium">Form Surat Keterangan Mutasi Keluar</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('transfer-out-sites.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="student_name" class="form-label">Nama Lengkap Siswa</label>
                                <input type="text" class="form-control" id="student_name" name="student_name" required
                                    placeholder="Masukkan nama lengkap siswa" value="{{ old('student_name') }}" />
                            </div>
                            <div class="mb-3">
                                <label for="birth_place" class="form-label">Tempat Lahir</label>
                                <input type="text" class="form-control" id="birth_place" name="birth_place"
                                    placeholder="Masukkan tempat lahir siswa" required value="{{ old('birth_place') }}" />
                                <small class="text-secondary">contoh: Probolinggo</small>
                            </div>
                            <div class="mb-3">
                                <label for="birth_date" class="form-label">Tanggal Lahir</label>
                                <input type="date" class="form-control" id="birth_date" name="birth_date" required
                                    value="{{ old('birth_date') }}" />
                            </div>
                            <div class="mb-3">
                                <label for="gender" class="form-label">Jenis Kelamin</label>
                                <select class="form-select" id="gender" name="gender" required>
                                    <option value="">Pilih Jenis Kelamin</option>
                                    <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Laki-laki
                                    </option>
                                    <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Perempuan
                                    </option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="religion" class="form-label">Agama</label>
                                <select class="form-select" id="religion" name="religion" required>
                                    <option value="">Pilih Agama</option>
                                    <option value="Islam" {{ old('religion') == 'Islam' ? 'selected' : '' }}>Islam</option>
                                    <option value="Kristen" {{ old('religion') == 'Kristen' ? 'selected' : '' }}>Kristen
                                    </option>
                                    <option value="Katolik" {{ old('religion') == 'Katolik' ? 'selected' : '' }}>Katolik
                                    </option>
                                    <option value="Hindu" {{ old('religion') == 'Hindu' ? 'selected' : '' }}>Hindu
                                    </option>
                                    <option value="Buddha" {{ old('religion') == 'Buddha' ? 'selected' : '' }}>Buddha
                                    </option>
                                    <option value="Konghucu" {{ old('religion') == 'Konghucu' ? 'selected' : '' }}>Konghucu
                                    </option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="class" class="form-label">Kelas ( SMA )</label>
                                <select class="form-select" id="class" name="class" required>
                                    <option value="">Pilih Kelas</option>
                                    <option value="10" {{ old('class') == '10' ? 'selected' : '' }}>10</option>
                                    <option value="11" {{ old('class') == '11' ? 'selected' : '' }}>11</option>
                                    <option value="12" {{ old('class') == '12' ? 'selected' : '' }}>12</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="nisn" class="form-label">NISN (Nomor Induk Siswa Nasional)</label>
                                <input type="text" class="form-control" id="nisn" name="nisn"
                                    placeholder="Masukkan NISN siswa" required value="{{ old('nisn') }}" />
                                <small class="text-secondary">contoh: 0012345678</small>
                            </div>
                            <div class="mb-3">
                                <label for="student_address" class="form-label">Alamat Siswa</label>
                                <textarea class="form-control" id="student_address" name="student_address" rows="3"
                                    placeholder="Dusun Kramat Rt. 014 Rw. 005 Desa Wangkal Kec. Gading Kab. Probolinggo" required>{{ old('student_address') }}</textarea>
                                <small class="text-secondary">lihat
                                    <a href="javacript:void(0)" data-bs-toggle="modal" data-bs-target="#detailFormat"
                                        style="font-size: 0.9rem" class="text-dark">format
                                        penulisan</a> alamat surat
                                </small>
                            </div>
                            <div class="mb-3">
                                <label for="destination_school" class="form-label">Sekolah Tujuan</label>
                                <input type="text" class="form-control" id="destination_school"
                                    name="destination_school" placeholder="Masukkan nama sekolah tujuan" required
                                    value="{{ old('destination_school') }}" />
                                <small class="text-secondary">sekolah tempat mutasi ke</small>
                            </div>
                            <div class="mb-3">
                                <label for="reason" class="form-label">Alasan Pindah</label>
                                <textarea class="form-control" id="reason" name="reason" rows="3"
                                    placeholder="Jelaskan alasan pindah sekolah" required>{{ old('reason') }}</textarea>
                            </div>
                            <div class="mb-3">
                                <p>
                                    <small class="text-muted">* Pastikan data yang Anda masukkan sudah benar. Surat
                                        akan diproses setelah diverifikasi oleh admin.</small>
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
