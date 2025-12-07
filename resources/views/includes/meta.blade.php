    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon"
        href="{{ setting('app_logo') !== null ? asset('storage/' . setting('app_logo')) : asset('assets/images/logos/water.png') }}"
        type="image/x-icon" />
    <meta name="author" content="">
    <meta name="description"
        content="{{ isset($meta_description) ? $meta_description : setting('app_description', 'Aplikasi Inventaris Sekolah') }}">
    <meta name="keywords"
        content="{{ isset($meta_keywords) ? $meta_keywords : setting('app_keywords', 'inventaris, aplikasi, manajemen') }}">
    <meta name="robots" content="index, follow">
    <meta property="og:title"
        content="{{ isset($title) ? $title . ' | ' . setting('app_title', 'My App') : setting('app_title', 'My App') }}">
    <meta property="og:description"
        content="{{ isset($meta_description) ? $meta_description : setting('app_description', 'Aplikasi Inventaris Sekolah') }}">
    <meta property="og:image"
        content="{{ setting('app_logo') !== null ? asset('storage/' . setting('app_logo')) : asset('assets/images/logos/water.png') }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="website">
    <title>{{ isset($title) ? $title . ' | ' . setting('app_title', 'My App') : setting('app_title', 'My App') }}
    </title>
