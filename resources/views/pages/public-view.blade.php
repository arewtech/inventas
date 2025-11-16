<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informasi Aset: {{ $asset->name }}</title>

    <!-- SEO Meta Tags -->
    <meta name="description"
        content="Detail informasi aset {{ $asset->name }} dari kategori {{ $asset->category->name }} yang berlokasi di {{ $asset->location }}">
    <meta name="keywords"
        content="aset, inventaris, {{ $asset->name }}, {{ $asset->category->name }}, {{ setting('app_school') ?? 'My School' }}">
    <meta name="author" content="{{ setting('app_school') ?? 'My School' }}">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ request()->fullUrl() }}">
    <meta property="og:title" content="Informasi Aset: {{ $asset->name }} | {{ setting('app_title') ?? 'My App' }}">
    <meta property="og:description"
        content="Detail informasi aset {{ $asset->name }} dari kategori {{ $asset->category->name }} yang berlokasi di {{ $asset->location }}">
    @if ($asset->image)
        <meta property="og:image" content="{{ asset('storage/' . $asset->image) }}">
    @endif

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ request()->fullUrl() }}">
    <meta property="twitter:title"
        content="Informasi Aset: {{ $asset->name }} | {{ setting('app_title') ?? 'My App' }}">
    <meta property="twitter:description"
        content="Detail informasi aset {{ $asset->name }} dari kategori {{ $asset->category->name }} yang berlokasi di {{ $asset->location }}">
    @if ($asset->image)
        <meta property="twitter:image" content="{{ asset('storage/' . $asset->image) }}">
    @endif

    <!-- Canonical URL -->
    <meta rel="canonical" href="{{ request()->fullUrl() }}">
    <link rel="icon"
        href="{{ setting('app_logo') !== null ? asset('storage/' . setting('app_logo')) : asset('assets/images/logos/water.png') }}"
        type="image/x-icon" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@2.30.0/tabler-icons.min.css">
    <style>
        body {
            background-color: #f7f9fc;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
        }

        .asset-container {
            max-width: 500px;
            width: 95%;
            margin: 2rem auto;
            padding: 0 10px;
        }

        .header-logo {
            margin-bottom: 1.5rem;
            text-align: center;
        }

        .header-logo img {
            max-height: 60px;
        }

        .card {
            border: none;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            border-radius: 12px;
        }

        .card-header {
            background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);
            color: white;
            border-radius: 12px 12px 0 0 !important;
            padding: 1rem 1.5rem;
        }

        .badge {
            padding: 0.5rem 0.75rem;
            font-weight: 500;
        }

        .asset-img {
            width: 100%;
            max-height: 200px;
            object-fit: contain;
            margin-bottom: 1rem;
            background: #f8f9fa;
            border-radius: 8px;
        }

        .copyright {
            margin-top: 1.5rem;
            text-align: center;
            font-size: 0.85rem;
            color: #6c757d;
        }

        @media (max-width: 576px) {
            .asset-container {
                margin: 1rem auto;
            }

            .card-body {
                padding: 1rem !important;
            }

            h4 {
                font-size: 1.25rem;
            }
        }
    </style>
</head>

<body>
    <div class="asset-container">
        <div class="header-logo">
            <h3>{{ setting('app_title') ?? 'My App' }}</h3>
        </div>

        <div class="card">
            <div class="card-header">
                <h5 class="mb-0 d-flex align-items-center">
                    <i class="ti ti-clipboard-check me-2"></i>
                    Informasi Aset
                </h5>
            </div>
            <div class="card-body p-4">
                @if ($asset->image)
                    <div class="text-center mb-3">
                        <img src="{{ asset('storage/' . $asset->image) }}" alt="{{ $asset->name }}"
                            class="asset-img">
                    </div>
                @else
                    <div class="mb-3 rounded m-auto bg-light d-flex align-items-center justify-content-center"
                        style="width: 120px; height: 120px;">
                        <i class="ti ti-photo-off text-muted" style="font-size: 2.3rem"></i>
                    </div>
                @endif

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="mb-0">{{ $asset->name }}</h4>
                    <i class="ti ti-checklist fs-4 me-2"></i>
                </div>

                <hr>

                <div class="row g-3 mb-3">
                    <div class="col-12">
                        <div class="d-flex align-items-center">
                            <div style="width: 35px">
                                <i class="ti ti-category fs-5 text-muted"></i>
                            </div>
                            <div>
                                <small class="text-muted d-block">Kategori</small>
                                <span class="badge bg-primary-subtle text-primary">{{ $asset->category->name }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="d-flex align-items-center">
                            <div style="width: 35px">
                                <i class="ti ti-boxes fs-5 text-muted"></i>
                            </div>
                            <div>
                                <small class="text-muted d-block">Jumlah</small>
                                <strong>{{ $asset->quantity }}</strong>
                            </div>
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="d-flex align-items-center">
                            <div style="width: 35px">
                                <i class="ti ti-map-pin fs-5 text-muted"></i>
                            </div>
                            <div>
                                <small class="text-muted d-block">Lokasi</small>
                                <strong>{{ $asset->location }}</strong>
                            </div>
                        </div>
                    </div>

                    @if ($asset->description)
                        <div class="col-12">
                            <div class="d-flex align-items-start">
                                <div style="width: 35px">
                                    <i class="ti ti-file-description fs-5 text-muted"></i>
                                </div>
                                <div>
                                    <small class="text-muted d-block">Deskripsi</small>
                                    <p class="mb-0">{{ $asset->description }}</p>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if ($asset->additional_info)
                        <div class="col-12">
                            <div class="d-flex align-items-start">
                                <div style="width: 35px">
                                    <i class="ti ti-info-circle fs-5 text-muted"></i>
                                </div>
                                <div>
                                    <small class="text-muted d-block">Informasi Tambahan</small>
                                    <p class="mb-0">{{ $asset->additional_info }}</p>
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="col-6">
                        <div class="d-flex align-items-center">
                            <div style="width: 35px">
                                <i class="ti ti-calendar-plus fs-5 text-muted"></i>
                            </div>
                            <div>
                                <small class="text-muted d-block">Dibuat pada</small>
                                <strong>{{ $asset->created_at->format('d/m/Y') }}</strong>
                            </div>
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="d-flex align-items-center">
                            <div style="width: 35px">
                                <i class="ti ti-calendar-event fs-5 text-muted"></i>
                            </div>
                            <div>
                                <small class="text-muted d-block">Diperbarui pada</small>
                                <strong>{{ $asset->updated_at->format('d/m/Y') }}</strong>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="text-center mt-4">
                    <small class="text-muted">Dipindai pada {{ date('d F Y H:i') }}</small>
                </div>
            </div>
        </div>

        <div class="copyright">
            <p class="mb-0">&copy; {{ date('Y') }} {{ setting('app_school') ?? 'My School' }}. Hak Cipta
                Dilindungi
                Undang-Undang.</p>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
