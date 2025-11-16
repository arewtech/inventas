@extends('layouts.app', ['title' => 'Dashboard'])
@section('content')
    <div class="container-fluid">
        <!-- Jika user adalah admin atau operator -->
        <div class="row">
            <div class="col-lg-8 d-flex align-items-start">
                <div class="card w-100 bg-light-info overflow-hidden shadow-none">
                    <div class="card-body position-relative">
                        <div class="row">
                            <div class="col-sm-7">
                                <div class="d-flex align-items-center mb-4">
                                    <div class="rounded-circle overflow-hidden me-6">
                                        <img src="{{ auth()->user()->avatar_url }}" alt="avatar" width="40"
                                            height="40">
                                    </div>
                                    <h5 class="fw-semibold mb-0 fs-5 line-clamp text-capitalize">Selamat Datang
                                        {{ auth()->user()->name }}!
                                    </h5>
                                </div>
                                <p class="text-dark">Selamat datang di aplikasi {{ setting('app_title', 'My App') }}.
                                    <br>
                                    Cuaca hari ini sangat cerah, semoga harimu menyenangkan dan selamat beraktivitas. 🫶🏻
                                </p>
                            </div>
                            <div class="col-sm-5">
                                <div class="welcome-bg-img mb-n7 text-end">
                                    <img src="{{ asset('assets/images/svg/welcome-bg.svg') }}" alt=""
                                        class="img-fluid">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-2 d-flex align-items-stretch">
                <div class="card w-100">
                    <div class="card-body p-4">
                        <h4 class="fw-semibold">{{ $categoryCount }}</h4>
                        <p class="mb-2 fs-3">Kategori</p>
                        <img src="{{ asset('assets/images/svg/list2.svg') }}" alt="" class="img-fluid"
                            width="90%">
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-2 d-flex align-items-stretch">
                <div class="card w-100">
                    <div class="card-body p-4">
                        <h4 class="fw-semibold">{{ $assetCount }}</h4>
                        <p class="mb-2 fs-3">Aset</p>
                        <img src="{{ asset('assets/images/svg/articles.svg') }}" alt="" class="img-fluid"
                            width="85%">
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-6 col-lg-6 d-flex align-items-stretch">
                <div class="card w-100 h-100">
                    <div class="card-body">
                        <h5 class="card-title fw-semibold">Kategori Aset</h5>
                        <p class="card-subtitle mb-2">Jumlah aset per kategori tahun
                            {{ Carbon\Carbon::now()->format('Y') }}.
                        </p>
                        <div id="categories-chart" class="mb-4">
                            {!! $categoriesChart->container() !!}
                        </div>
                        <hr class="mt-0">
                        <div class="d-flex align-items-center justify-content-between">
                            <p class="fs-2 text-center mb-0">
                                Total aset yang terdaftar adalah <span class="fw-semibold">{{ $assetCount }}</span>
                                buah.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-6 d-flex align-items-stretch">
                <div class="card w-100 h-100">
                    <div class="card-body">
                        <h5 class="card-title fw-semibold">Status Peminjaman</h5>
                        <p class="card-subtitle mb-2">Data status peminjaman aset tahun
                            {{ Carbon\Carbon::now()->format('Y') }}.
                        </p>
                        <div id="borrowings-chart" class="mb-4">
                            {!! $borrowingsChart->container() !!}
                        </div>
                        <hr class="mt-0">
                        <div class="d-flex align-items-center justify-content-between">
                            <p class="fs-2 text-center mb-0">
                                Total transaksi peminjaman yang tercatat adalah <span
                                    class="fw-semibold">{{ $totalBorrowings }}</span>
                                kali.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ $categoriesChart->cdn() }}"></script>
    <script src="{{ $borrowingsChart->cdn() }}"></script>

    {{ $categoriesChart->script() }}
    {{ $borrowingsChart->script() }}
@endsection
