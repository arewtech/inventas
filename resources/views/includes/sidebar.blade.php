<aside class="left-sidebar">
    <!-- Sidebar scroll-->
    <div>
        <div class="brand-logo d-flex align-items-center justify-content-between">
            <a href="{{ route('dashboard') }}" class="text-nowrap logo-img d-flex align-items-center">
                @if (setting('app_logo') !== null)
                    <img class="rounded-circle me-1" src="{{ asset('storage/' . setting('app_logo')) }}" alt="logo"
                        style="width: 50px; height: 50px; object-fit: cover; object-position: center;">
                @else
                    <img class="rounded-circle" src="{{ asset('assets/images/logos/water.png') }}" alt="logo"
                        width="55">
                @endif
                <span class="text-dark fw-semibold text-capitalize fs-5">{{ setting('app_title') ?? 'My App' }}</span>
            </a>
            <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
                <i class="ti ti-x fs-8"></i>
            </div>
        </div>
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
            <ul id="sidebarnav">
                <!-- ============================= Main ============================== -->
                <li class="nav-small-cap">
                    <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                    <span class="hide-menu">Main</span>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link @if (url()->current() == route('dashboard')) active @endif"
                        href="{{ route('dashboard') }}" aria-expanded="false">
                        <span>
                            <i class="ti ti-dashboard"></i>
                        </span>
                        <span class="hide-menu">Dashboard</span>
                    </a>
                </li>
                <li class="nav-small-cap">
                    <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                    <span class="hide-menu">Menu</span>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link {{ Route::is('categories*') ? 'active' : '' }}"
                        href="{{ route('categories.index') }}" aria-expanded="false">
                        <span>
                            <i class="ti ti-category"></i>
                        </span>
                        <span class="hide-menu">Kategori</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link {{ Route::is('locations*') ? 'active' : '' }}"
                        href="{{ route('locations.index') }}" aria-expanded="false">
                        <span>
                            <i class="ti ti-map"></i>
                        </span>
                        <span class="hide-menu">Lokasi</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link {{ Route::is('assets*') ? 'active' : '' }}"
                        href="{{ route('assets.index') }}" aria-expanded="false">
                        <span>
                            <i class="ti ti-box"></i>
                        </span>
                        <span class="hide-menu">Aset</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link {{ Route::is('asset-borrowings*') ? 'active' : '' }}"
                        href="{{ route('asset-borrowings.index') }}" aria-expanded="false">
                        <span>
                            <i class="ti ti-clipboard"></i>
                        </span>
                        <span class="hide-menu">Peminjaman</span>
                    </a>
                </li>
                <li class="nav-small-cap">
                    <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                    <span class="hide-menu">Letters</span>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link {{ Route::is('transfer-ins*') ? 'active' : '' }}"
                        href="{{ route('transfer-ins.index') }}" aria-expanded="false">
                        <span>
                            <i class="ti ti-mail"></i>
                        </span>
                        <span class="hide-menu">Surat Mutasi Terima</span>
                    </a>
                </li>
                <li class="nav-small-cap">
                    <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                    <span class="hide-menu">Lainnya</span>
                </li>
                @if (auth()->user()->isAdmin())
                    <li class="sidebar-item">
                        <a class="sidebar-link {{ Route::is('operator*') ? 'active' : '' }}"
                            href="{{ route('operator.index') }}" aria-expanded="false">
                            <span>
                                <i class="ti ti-user"></i>
                            </span>
                            <span class="hide-menu">User</span>
                        </a>
                    </li>
                @endif
                <li class="sidebar-item">
                    <a class="sidebar-link {{ Route::is('reports*') ? 'active' : '' }}"
                        href="{{ route('reports.index') }}" aria-expanded="false">
                        <span>
                            <i class="ti ti-report"></i>
                        </span>
                        <span class="hide-menu">Report</span>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>
