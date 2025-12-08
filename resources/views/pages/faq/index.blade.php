@extends('layouts.front', ['title' => 'FAQ'])
@section('content')
    <section>
        <div class="container">
            <div class="intro-faq py-4">
                <h4 class="badge-blue m-auto">FAQ</h4>

                <div class="accordion accordion-flush col-md-8 col m-auto my-4" id="accordionFlushExample">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="flush-headingOne">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                                Apa itu {{ setting('app_title') ?? 'My App' }}?
                            </button>
                        </h2>
                        <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne"
                            data-bs-parent="#accordionFlushExample">
                            <div class="accordion-body">
                                <p>
                                    {{ setting('app_title') ?? 'My App' }} adalah platform pembuatan surat online untuk sekolah yang dapat
                                    Anda gunakan untuk membuat berbagai jenis surat secara online seperti
                                    surat keterangan mutasi terima, surat keterangan mutasi keluar,
                                    surat keterangan aktif mengajar, dan lain-lain.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="flush-headingTwo">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
                                Apakah Aplikasi {{ setting('app_title') ?? 'My App' }} sangat membantu bagi masyarakat?
                            </button>
                        </h2>
                        <div id="flush-collapseTwo" class="accordion-collapse collapse" aria-labelledby="flush-headingTwo"
                            data-bs-parent="#accordionFlushExample">
                            <div class="accordion-body">
                                <p>
                                    Ya, Aplikasi {{ setting('app_title') ?? 'My App' }} sangat membantu bagi masyarakat. Dengan
                                    {{ setting('app_title') ?? 'My App' }} tanpa harus datang langsung ke sekolah. Platform ini
                                    memudahkan masyarakat dalam membuat surat-surat seperti surat
                                    keterangan mutasi, surat keterangan aktif mengajar, dan berbagai
                                    surat resmi sekolah lainnya.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="flush-headingThree">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#flush-collapseThree" aria-expanded="false"
                                aria-controls="flush-collapseThree">
                                Apakah Aplikasi {{ setting('app_title') ?? 'My App' }} tersedia untuk umum?
                            </button>
                        </h2>
                        <div id="flush-collapseThree" class="accordion-collapse collapse"
                            aria-labelledby="flush-headingThree" data-bs-parent="#accordionFlushExample">
                            <div class="accordion-body">
                                <p>
                                    Ya, Aplikasi {{ setting('app_title') ?? 'My App' }} tersedia untuk umum. Siapa saja dapat
                                    mendaftar dan menggunakan layanan pembuatan surat online di {{ setting('app_title') ?? 'My App' }}.
                                    Anda hanya perlu membuat akun terlebih dahulu untuk dapat mengakses
                                    dan membuat surat-surat yang Anda butuhkan.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="flush-headingFour">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#flush-collapseFour" aria-expanded="false"
                                aria-controls="flush-collapseFour">
                                Bagaimana alur setelah mengisi formulir surat di {{ setting('app_title') ?? 'My App' }}?
                            </button>
                        </h2>
                        <div id="flush-collapseFour" class="accordion-collapse collapse" aria-labelledby="flush-headingFour"
                            data-bs-parent="#accordionFlushExample">
                            <div class="accordion-body">
                                <p>
                                    Setelah mengisi formulir surat di {{ setting('app_title') ?? 'My App' }}, surat Anda akan masuk
                                    ke dalam sistem untuk diproses oleh admin sekolah. Anda dapat melihat
                                    status surat di halaman riwayat. Ketika surat Anda sudah disetujui
                                    (approved) oleh admin dan nomor surat sudah diisi, Anda dapat langsung
                                    mencetak (print) surat tersebut secara online. Jika Anda tidak dapat
                                    mengakses secara online, Anda juga bisa datang langsung ke alamat
                                    sekolah untuk membuat surat melalui operator sekolah.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="flush-headingFive">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#flush-collapseFive" aria-expanded="false"
                                aria-controls="flush-collapseFive">
                                Untuk siapa layanan surat ini diperuntukkan?
                            </button>
                        </h2>
                        <div id="flush-collapseFive" class="accordion-collapse collapse" aria-labelledby="flush-headingFive"
                            data-bs-parent="#accordionFlushExample">
                            <div class="accordion-body">
                                <p>
                                    Layanan pembuatan surat di platform {{ setting('app_title') ?? 'My App' }} ini khusus diperuntukkan
                                    untuk keperluan surat-menyurat yang berkaitan dengan Yayasan Al-Khairiyah
                                    dan Sekolah Al Khairiyah, terkhusus untuk SMP Al Khairiyah. Surat-surat
                                    yang dibuat melalui platform ini hanya berlaku untuk keperluan administrasi
                                    dan keterangan resmi dari SMP Al Khairiyah.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
