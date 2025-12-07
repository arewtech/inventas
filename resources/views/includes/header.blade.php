<header class="app-header">
    <nav class="navbar navbar-expand-lg navbar-light">
        <ul class="navbar-nav">
            <li class="nav-item d-block d-xl-none">
                <a class="nav-link sidebartoggler nav-icon-hover" id="headerCollapse" href="javascript:void(0)">
                    <i class="ti ti-menu-2"></i>
                </a>
            </li>
            <li class="nav-item d-none d-lg-block">
                <i class="fs-5 ti ti-world"></i>
                <span class="ms-2 fs-2">{{ formatDateFull(now()) }} ~ Waktu
                    Indonesia
                    Barat</span>
            </li>
        </ul>
        <div class="navbar-collapse justify-content-end px-0" id="navbarNav">
            <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-end">
                <li class="nav-item dropdown">
                    <a class="nav-link nav-icon-hover" href="javascript:void(0)" id="drop2"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <img style="object-fit: cover" src="{{ auth()->user()->avatar_url }}" alt=""
                            width="35" height="35" class="rounded-circle ">
                    </a>
                    <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up" aria-labelledby="drop2">
                        <div class="d-flex flex-column align-items-center py-8 mx-7 border-bottom">
                            <img style="object-fit: cover" src="{{ auth()->user()->avatar_url }}" class="rounded-circle"
                                width="80" height="80" alt="">
                            <div class="mt-3 text-center">
                                <h5 class="mb-1 fs-3 line-clamp text-capitalize">{{ auth()->user()->name }}</h5>
                                <span class="mb-1 d-block text-lowercase">{{ auth()->user()->role }}</span>
                                <p class="mb-0 d-flex align-items-center gap-2">
                                    <i class="ti ti-mail fs-4"></i>
                                    <span class="line-clamp">
                                        {{ auth()->user()->email }}
                                    </span>
                                </p>
                            </div>
                        </div>
                        <div class="message-body mb-3 px-3">
                            <a href="{{ route('profile') }}" class="d-flex align-items-center gap-2 dropdown-item">
                                <i class="ti ti-user-circle fs-6"></i>
                                <p class="mb-0 fs-3">Profile</p>
                            </a>
                            @if (auth()->user()->isNotPrincipal())
                                <a href="{{ route('settings.index') }}"
                                    class="d-flex align-items-center gap-2 dropdown-item">
                                    <i class="ti ti-settings fs-6"></i>
                                    <p class="mb-0 fs-3">Settings</p>
                                </a>
                            @endif
                            <form action="{{ route('logout') }}" method="post">
                                @csrf
                                <a href="javascript:void(0)" onclick="this.closest('form').submit(); return false;"
                                    class="btn
                                    btn-outline-danger btn-sm mx-3 my-2 d-block">Logout</a>
                            </form>
                            <a href="{{ route('home') }}" class="backto text-muted fs-2 d-block text-center mt-2">back
                                to website</a>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
</header>
