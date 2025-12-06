@extends('layouts.front', ['title' => 'Histori Surat'])
@section('content')
    <section>
        <div class="container">
            <div class="intro-letters py-4">
                <h4 class="badge-blue m-auto">Histori Surat</h4>

                <div class="py-2">
                    <!-- intro letters -->
                    <div class="col-md-6 m-auto text-center">
                        <h4 class="mt-3">
                            List histori Surat yang telah dibuat oleh
                            pengguna.
                        </h4>
                    </div>
                    <!-- end intro letters -->

                    <hr id="scrollLetters" />
                    <!-- list card letters -->
                    <h6 class="mt-4 mt-md-5 text-center">List Histori Surat</h6>
                    <div class="d-flex flex-wrap justify-content-center align-items-center gap-3 py-4">
                        @forelse ($combinedHistories as $letter)
                            <div class="col-md-5">
                                <div class="card card-latter shadow-xd">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $letter->letter }} {{ formatIcon($letter->type) }}</h5>
                                        <p class="card-text" style="font-size: 0.95rem">
                                            {{ $letter->letter }} selesai dibuat, tunggu informasi selanjutnya dari admin.
                                        </p>
                                        <hr />
                                        <p style="font-size: 0.9rem" class="card-text text-muted mb-1">
                                            Dibuat pada {{ formatDateFull($letter->created_at) }} WIB
                                        </p>
                                        <div class="d-flex align-items-center gap-2">
                                            <span class="badge bg-primary-subtle text-primary-subtle">Terkirim</span>
                                            |
                                            <span
                                                class="text-capitalize badge {{ $letter->status_color }}">{{ $letter->status == 'pending' ? 'pending' : 'selesai' }}</span>
                                            @if ($letter->status == 'approved')
                                                |
                                                <a href="javacript:void(0)" data-bs-toggle="modal"
                                                    data-bs-target="#detailNote{{ $letter->created_at->format('His') }}"
                                                    style="font-size: 0.9rem"
                                                    class="text-decoration-none text-primary">Detail
                                                    Pesan</a>
                                            @else
                                                |
                                                <form style="transform: translateY(-1px)"
                                                    action="{{ getDestroyRoute($letter->type, $letter->id) }}"
                                                    method="post">
                                                    @csrf
                                                    @method('delete')
                                                    <a style="font-size: 0.9rem;" class="text-decoration-none text-danger"
                                                        onclick="event.preventDefault(); if(confirm('Apakah Anda yakin ingin menghapusnya?')) { this.closest('form').submit(); }"
                                                        href="javascript:void(0)">
                                                        Hapus
                                                    </a>
                                                </form>
                                            @endif

                                            <!-- Modal Catatan -->
                                            <div class="modal fade" id="detailNote{{ $letter->created_at->format('His') }}"
                                                tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h1 class="modal-title fs-5" id="exampleModalLabel">
                                                                Detail Pesan dari Admin
                                                            </h1>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>
                                                                <b>Catatan:</b> {{ $letter->letter }} selesai dibuat
                                                                dan dapat diambil di kantor kelurahan setempat.
                                                            </p>
                                                            <p class="text-muted text-md">
                                                                *Baca juga paduan pengambilan surat di <a
                                                                    href="{{ route('faq-site') }}">sini</a>.
                                                            </p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <div
                                                                class="w-100 d-flex flex-wrap align-items-center gap-2 justify-content-md-between justify-content-center">
                                                                <small class="text-muted">
                                                                    update terbaru pada
                                                                    {{ formatDateFull($letter->updated_at) }} WIB
                                                                </small>
                                                                <button type="button" class="btn btn-sm btn-secondary"
                                                                    data-bs-dismiss="modal">Terima kasih</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-md-6">
                                <div class="alert alert-secondary text-center">
                                    <i class="bi bi-info-circle me-2"></i>
                                    <small>Belum ada histori surat yang dibuat, silahkan klik
                                        <a href="{{ route('letters-site') }}">buat surat</a> untuk
                                        membuat surat baru.</small>
                                </div>
                            </div>
                        @endforelse
                    </div>
                    <!-- end list card  -->
                </div>
            </div>
        </div>
    </section>
@endsection
@push('after:script')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let scrollTo = "{{ session('scrollTo') }}";
            if (scrollTo) {
                document.getElementById(scrollTo).scrollIntoView();
            }
        });
    </script>
@endpush
