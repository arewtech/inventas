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
                            Selamat Datang di Forum
                            <span class="text-primary-subtle">Pengaduan</span> Masyarakat
                            Online
                        </h1>
                        <p class="format-school">
                            Anda dapat mengirimkan pengaduan atau keluhan Anda secara
                            online, dan kami akan segera menindaklanjuti.
                        </p>
                        <p class="format-school mt-2"></p>
                        <div class="d-flex gap-2 flex-wrap mt-4 justify-content-center justify-content-md-start">
                            <a href="{{ route('letters-site') }}"
                                class="btn-intro w-full btn btn-outline-primary px-3 py-2">Buat Surat</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-5 hero-image">
                    <img width="430" src="{{ asset('assets/images/svg/hero.svg') }}" alt="Hero Image"
                        class="img-fluid" />
                </div>
            </div>
        </div>
    </section>
@endsection
