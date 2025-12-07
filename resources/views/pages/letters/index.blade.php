@extends('layouts.front', ['title' => 'Pelayanan Surat Online'])
@section('content')
    <section>
        <div class="container">
            <div class="intro-letters py-4">
                <h4 class="badge-blue m-auto">Pelayanan Surat Online</h4>
                <div class="py-2">
                    <!-- intro letters -->
                    <div class="col-md-6 m-auto text-center">
                        <h3 class="mt-3">
                            List Surat Online yang Dapat Dibuat:
                        </h3>
                    </div>
                    <!-- end intro letters -->

                    <!-- list card letters -->
                    <div class="d-flex flex-wrap justify-content-center align-items-center gap-3 py-4">
                        <div class="col-md-5">
                            <div class="card card-latter shadow-xd">
                                <div class="card-body">
                                    <h5 class="card-title">Surat Keterangan Mutasi Terima 📥</h5>
                                    <p class="card-text line-clamp-3">
                                        Surat keterangan mutasi terima adalah surat yang menerangkan bahwa
                                        sekolah menerima siswa pindahan dari sekolah lain.
                                    </p>
                                    <a href="{{ route('transfer-in-sites.create') }}"
                                        class="btn btn-sm btn-outline-primary">Buat
                                        Surat</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="card card-latter shadow-xd">
                                <div class="card-body">
                                    <h5 class="card-title">Surat Keterangan Mutasi Keluar 📤</h5>
                                    <p class="card-text line-clamp-3">
                                        Surat keterangan mutasi keluar adalah surat yang menerangkan bahwa
                                        siswa mengajukan pindah dari sekolah ini ke sekolah lain.
                                    </p>
                                    <a href="{{ route('transfer-out-sites.create') }}"
                                        class="btn btn-sm btn-outline-primary">Buat
                                        Surat</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="card card-latter shadow-xd">
                                <div class="card-body">
                                    <h5 class="card-title">Surat Keterangan Aktif Mengajar 👨‍🏫</h5>
                                    <p class="card-text line-clamp-3">
                                        Surat keterangan aktif mengajar adalah surat yang menerangkan bahwa
                                        guru tersebut masih aktif mengajar di sekolah ini.
                                    </p>
                                    <a href="{{ route('active-teaching-sites.create') }}"
                                        class="btn btn-sm btn-outline-primary">Buat
                                        Surat</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end list card letters -->
                </div>
            </div>
        </div>
    </section>
@endsection
