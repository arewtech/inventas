<footer class="bg-dark text-light mt-5 mt-md-0 pt-5 pb-4">
    <div class="container">
        <div class="row flex-wrap gap-4 gap-md-0">
            <div class="col-lg-4 col-md-6">
                <h5 class="mb-3">Tentang Kami</h5>
                <p class="text-sm">
                    {{ setting('app_title') ?? 'My App' }} adalah platform penyedia layanan pembuatan surat online,
                    dirancang untuk memudahkan pengguna dalam membuat berbagai jenis surat resmi secara cepat dan
                    efisien.
                </p>
            </div>
            <div class="col-lg-2 col-md-3">
                <h5 class="mb-3">Link Terkait</h5>
                <ul class="list-unstyled text-sm">
                    <li class="mb-2">
                        <a class="text-decoration-none text-white" href="{{ route('home') }}">Home</a>
                    </li>
                    <li class="mb-2">
                        <a class="text-decoration-none text-white" href="{{ route('letters-site') }}">Surat</a>
                    </li>
                    <li class="mb-2">
                        <a class="text-decoration-none text-white" href="{{ route('faq-site') }}">FAQ</a>
                    </li>
                </ul>
            </div>
            <div class="col-lg-3 col-md-3">
                <h5 class="mb-3">Hubungi Kami</h5>
                <p class="text-sm">
                    {{ setting('app_address') ?? '-' }}<br />
                    Email: {{ setting('app_email') ?? '-' }}<br />
                    Telepon: (+62) {{ setting('app_phone') ?? '-' }}
                </p>
            </div>
            <div class="col-lg-3 col-md-5">
                <h5 class="mb-3">Kebijakan Privasi</h5>
                <p class="text-sm">
                    Kebijakan Privasi ini menjelaskan bagaimana kami mengumpulkan,
                    menggunakan, dan melindungi informasi pribadi Anda.
                </p>
            </div>
        </div>
        <hr class="my-4" />
        <div class="row">
            <div class="col-md-6">
                <p class="text-sm text-secondary">
                    &copy; {{ date('Y') }} {{ setting('app_title') ?? 'My App' }}. Hak Cipta Dilindungi
                    Undang-Undang.
                </p>
            </div>
            <div class="col-md-6 text-end">
                <!-- Tambahkan ikon media sosial atau tautan ke halaman media sosial di sini -->
                <a href="{{ setting('app_facebook') ?? '#' }}" class="text-light me-2 text-decoration-none">
                    <i class="bi bi-facebook"></i>
                </a>
                <a href="{{ setting('app_twitter') ?? '#' }}" class="text-light me-2 text-decoration-none">
                    <i class="bi bi-twitter"></i>
                </a>
                <a href="{{ setting('app_instagram') ?? '#' }}" class="text-light text-decoration-none">
                    <i class="bi bi-instagram"></i>
                </a>
            </div>
        </div>
    </div>
</footer>
