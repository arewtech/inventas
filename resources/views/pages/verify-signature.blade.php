@extends('layouts.blank', ['title' => 'Verifikasi Tanda Tangan Elektronik'])
@section('content')
    <div class="container mt-5 mb-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-lg">
                    <div class="card-header bg-primary text-white text-center py-4">
                        <img src="{{ setting('app_logo') !== null ? asset('storage/' . setting('app_logo')) : asset('assets/images/logos/water.png') }}"
                            alt="Logo" class="rounded-circle mb-3" style="width: 80px; height: 80px; object-fit: cover;">
                        <h3 class="text-white">VERIFIKASI TANDA TANGAN ELEKTRONIK</h3>
                        <h1 class="mb-0 text-white">{{ setting('app_school_name') ?? 'Sistem Informasi' }}</h1>
                    </div>
                    <div class="card-body p-2 p-md-5">
                        <div class="text-center mb-4">
                            <div class="badge bg-success-subtle text-success px-4 py-2 fs-5">
                                <i class="ti ti-circle-check fs-4 me-1"></i> TERVERIFIKASI
                            </div>
                        </div>

                        <div class="alert alert-info" role="alert">
                            <i class="ti ti-info-circle me-2"></i>
                            <strong>Dokumen ini telah ditandatangani secara elektronik dan telah diverifikasi oleh
                                sistem.</strong>
                        </div>

                        <table class="table table-borderless mt-4">
                            <tbody>
                                <tr>
                                    <td width="35%" class="fw-semibold text-muted">Jenis Surat:</td>
                                    <td>{{ $letterType }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold text-muted">Nomor Surat:</td>
                                    <td><strong>{{ $letter->number ?? '-' }}</strong></td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <hr>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold text-muted">Ditandatangani Oleh:</td>
                                    <td><strong>{{ $letter->signer_name }}</strong></td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold text-muted">Jabatan:</td>
                                    <td>{{ $letter->signer_position }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold text-muted">Tanggal Tanda Tangan:</td>
                                    <td>{{ $letter->signed_at->locale('id')->translatedFormat('l, d F Y H:i') }} WIB</td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold text-muted">Status Dokumen:</td>
                                    <td>
                                        <span class="badge bg-success">{{ ucfirst($letter->status) }}</span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <div class="alert alert-warning mt-4" role="alert">
                            <small>
                                <i class="ti ti-alert-triangle me-1"></i>
                                <strong>Perhatian:</strong> Tanda tangan elektronik ini memiliki kekuatan hukum yang sama
                                dengan tanda tangan basah sesuai dengan
                                UU No. 11 Tahun 2008 tentang Informasi dan Transaksi Elektronik.
                            </small>
                        </div>

                        <div class="text-center mt-4">
                            @if (auth()->check() && (auth()->user()->isAdmin() || auth()->user()->isOperatorLetter()))
                                @if ($type == 'transfer-in')
                                    <a href="{{ route('transfer-ins.print', $letter->id) }}"
                                        class="btn btn-outline-primary me-2" target="_blank">
                                        <i class="ti ti-printer me-1"></i> Cetak Surat
                                    </a>
                                @elseif($type == 'transfer-out')
                                    <a href="{{ route('transfer-outs.print', $letter->id) }}"
                                        class="btn btn-outline-primary me-2" target="_blank">
                                        <i class="ti ti-printer me-1"></i> Cetak Surat
                                    </a>
                                @elseif($type == 'active-teaching')
                                    <a href="{{ route('active-teachings.print', $letter->id) }}"
                                        class="btn btn-outline-primary me-2" target="_blank">
                                        <i class="ti ti-printer me-1"></i> Cetak Surat
                                    </a>
                                @endif
                            @endif
                            <a href="{{ route('home') }}" class="btn btn-secondary">
                                <i class="ti ti-home me-1"></i> Kembali ke Beranda
                            </a>
                        </div>
                    </div>
                    <div class="card-footer text-center text-muted py-3">
                        <small>
                            <i class="ti ti-shield-check me-1"></i>
                            Dokumen ini dilindungi dengan enkripsi dan tanda tangan elektronik
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
