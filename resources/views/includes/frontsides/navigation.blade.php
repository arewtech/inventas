<nav class="navbar navbar-expand-lg bg-white">
    <div class="container">
        {{-- <a class="navbar-brand font-lora text-primary-subtle fw-semibold" href="/">🚨 --}}
        <a class="navbar-brand font-lora  d-flex align-items-center" href="{{ route('home') }}">
            @if (setting('app_logo') !== null)
                <img class="rounded-circle me-1" src="{{ asset('storage/' . setting('app_logo')) }}" alt="logo"
                    style="width: 40px; height: 40px; object-fit: cover; object-position: center;">
            @else
                <img class="rounded-circle" src="{{ asset('assets/images/logos/water.png') }}" alt="logo"
                    width="35">
            @endif
            {{ setting('app_title') ?? 'My App' }}
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mb-2 mb-lg-0 d-flex gap-3 justify-content-end w-100">
                <li class="nav-item">
                    <a class="nav-link @if (url()->current() == route('home')) active @endif" aria-current="page"
                        href="{{ route('home') }}">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link @if (url()->current() == route('letters-site') || Route::is('income-certificate-site*')) active @endif"
                        href="{{ route('letters-site') }}">Surat</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link @if (url()->current() == route('faq-site')) active @endif"
                        href="{{ route('faq-site') }}">FAQ</a>
                </li>
                @guest
                    <li class="nav-item">
                        <div class="nav-link">
                            <a class="btn btn-outline-primary btn-sm" href="{{ route('login') }}">Masuk</a>
                        </div>
                    </li>
                @else
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-dark text-capitalize" href="javascript:void(0)"
                            role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <img style="width: 25px; height: 25px" src="{{ Auth::user()->avatar_url }}" alt="Foto Pengaduan"
                                class="img-fluid me-1 rounded-circle documantion-image" />
                            {{ Auth::user()->name }}
                        </a>

                        <ul class="dropdown-menu dropdown-menu-lg-end">
                            @if (Auth::user()->role == 'admin' || Auth::user()->role == 'operator')
                                <li>
                                    <a class="dropdown-item" href="{{ route('dashboard') }}">Dashboard</a>
                                </li>
                            @else
                                <li>
                                    <a class="dropdown-item" href="{{ route('profile-site') }}">Edit Profil</a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('histories-site') }}">List Histori</a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('change-password-site') }}">Ubah Password</a>
                                </li>
                            @endif
                            <hr style="margin: 8px 0" />
                            <li>
                                <form action="{{ route('logout') }}" method="post">
                                    @csrf
                                    <a class="dropdown-item mt-1"
                                        onclick="event.preventDefault();this.closest('form').submit();"
                                        href="javascript:void(0)">Logout</a>
                                </form>
                            </li>
                        </ul>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>
