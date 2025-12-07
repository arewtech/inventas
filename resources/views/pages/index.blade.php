@extends('layouts.front', ['title' => 'Home'])
@section('content')
    <section class="hero">
        <div class="container-fluid">
            <!-- hero image full -->
            <div class="d-flex flex-wrap align-items-center">
                <div class="col-md-7 hero-content text-center text-md-start">
                    <!-- content title -->
                    <div class="content-title">
                        <h1 class="text-dark intro-title fw-medium">
                            Selamat Datang di Platform
                            <span class="text-primary-subtle">Pembuatan Surat</span> Online Al Khairiyah
                        </h1>
                        <p class="format-school">
                            Platform pembuatan surat online untuk keperluan administrasi
                            Yayasan Al-Khairiyah dan SMP Al Khairiyah. Buat surat-surat
                            resmi seperti surat keterangan mutasi, surat keterangan aktif
                            mengajar, dan berbagai surat resmi lainnya secara online dengan mudah.
                        </p>
                        <p class="format-school mt-2"></p>
                        <div class="d-flex gap-2 flex-wrap mt-4 justify-content-center justify-content-md-start">
                            <a href="{{ route('letters-site') }}"
                                class="btn-intro w-full btn btn-outline-primary px-3 py-2">Buat Surat</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-5 hero-image">
                    <img width="430" src="{{ asset('assets/frontsides/images/svg/hero.svg') }}" alt="Hero Image"
                        class="img-fluid" />
                </div>
            </div>
        </div>
    </section>
@endsection
