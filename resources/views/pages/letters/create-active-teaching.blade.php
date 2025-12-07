@extends('layouts.front', ['title' => 'Buat Surat Keterangan Aktif Mengajar'])
@section('content')
    <section>
        <div class="container">
            <div class="col-md-8 m-auto py-md-5 py-4">
                <a href="{{ route('letters-site') }}" class="btn btn-sm btn-outline-primary mb-3"><i
                        class="bi bi-arrow-left"></i> Kembali</a>
                <!-- header title -->
                <div class="header-complaint d-flex align-items-center">
                    <div class="col-md-8">
                        <h2>Surat Keterangan Aktif Mengajar</h2>
                        <p class="text-secondary">
                            Isi formulir di bawah ini untuk mengirimkan permintaan surat
                            keterangan aktif mengajar.
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
                        <h4 class="fw-medium">Form Surat Keterangan Aktif Mengajar</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('active-teaching-sites.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="teacher_name" class="form-label">Nama Guru</label>
                                <input type="text" class="form-control" id="teacher_name" name="teacher_name" required
                                    placeholder="Masukkan nama guru" value="{{ old('teacher_name') }}" />
                            </div>
                            <div class="mb-3">
                                <label for="birth_place" class="form-label">Tempat Lahir</label>
                                <input type="text" class="form-control" id="birth_place" name="birth_place"
                                    placeholder="Masukkan tempat lahir" required value="{{ old('birth_place') }}" />
                                <small class="text-secondary">contoh: Probolinggo</small>
                            </div>
                            <div class="mb-3">
                                <label for="birth_date" class="form-label">Tanggal Lahir</label>
                                <input type="date" class="form-control" id="birth_date" name="birth_date" required
                                    value="{{ old('birth_date') }}" />
                            </div>
                            <div class="mb-3">
                                <label for="nuptk" class="form-label">NUPTK (Nomor Unik Pendidik dan Tenaga
                                    Kependidikan)</label>
                                <input type="text" class="form-control" id="nuptk" name="nuptk"
                                    placeholder="Masukkan NUPTK" required value="{{ old('nuptk') }}" />
                                <small class="text-secondary">contoh: 1234567890123456</small>
                            </div>
                            <div class="mb-3">
                                <label for="education" class="form-label">Pendidikan Terakhir</label>
                                <input type="text" class="form-control" id="education" name="education"
                                    placeholder="Masukkan pendidikan terakhir" required value="{{ old('education') }}" />
                                <small class="text-secondary">contoh: S1 Pendidikan Matematika</small>
                            </div>
                            <div class="mb-3">
                                <label for="teaching_hours" class="form-label">Jumlah Jam Mengajar</label>
                                <input type="text" class="form-control" id="teaching_hours" name="teaching_hours"
                                    placeholder="Masukkan jumlah jam mengajar" required
                                    value="{{ old('teaching_hours') }}" />
                                <small class="text-secondary">contoh: 24 jam per minggu</small>
                            </div>
                            <div class="mb-3">
                                <label for="teacher_address" class="form-label">Alamat</label>
                                <textarea class="form-control" id="teacher_address" name="teacher_address" rows="3"
                                    placeholder="Dusun Kramat Rt. 014 Rw. 005 Desa Wangkal Kec. Gading Kab. Probolinggo" required>{{ old('teacher_address') }}</textarea>
                                <small class="text-secondary">lihat
                                    <a href="javacript:void(0)" data-bs-toggle="modal" data-bs-target="#detailFormat"
                                        style="font-size: 0.9rem" class="text-dark">format
                                        penulisan</a> alamat surat
                                </small>
                            </div>
                            <div class="mb-3">
                                <label for="tmt" class="form-label">TMT (Terhitung Mulai Tanggal)</label>
                                <input type="date" class="form-control" id="tmt" name="tmt" required
                                    value="{{ old('tmt') }}" />
                                <small class="text-secondary">Tanggal mulai mengajar di sekolah ini</small>
                            </div>
                            <button type="submit" class="btn btn-primary">Kirim</button>
                        </form>
                    </div>
                </div>
                <!-- end form -->
            </div>
        </div>
    </section>

    {{-- Modal Format Address --}}
    <div class="modal fade" id="detailFormat" tabindex="-1" aria-labelledby="detailFormatLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailFormatLabel">Format Penulisan Alamat</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="text-secondary">
                        Format penulisan alamat surat harus mengikuti format berikut:
                    </p>
                    <p class="text-secondary">
                        <strong>Dusun / Rt. / Rw. / Desa / Kec. / Kab.</strong>
                    </p>
                    <p class="text-secondary">
                        <strong>Contoh:</strong>
                    </p>
                    <p class="text-secondary">
                        Dusun Kramat Rt. 014 Rw. 005 Desa Wangkal Kec. Gading Kab. Probolinggo
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
