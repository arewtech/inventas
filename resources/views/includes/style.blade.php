{{-- <link
    href="{{ setting('app_logo') !== null ? asset('storage/' . setting('app_logo')) : asset('assets/images/logos/water.png') }}"
    rel="icon"> --}}
<link rel="stylesheet" href="{{ asset('assets/css/styles.min.css') }}" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
@stack('select2:css')
@stack('before:css')
<style>
    @media print {
        .no-print {
            display: none;
        }
    }

    ::-webkit-scrollbar {
        width: 7px;
        height: 7px;
    }

    ::-webkit-scrollbar-track {
        box-shadow: inset 0 0 3px rgba(0 0 0 / 0.15);
    }

    ::-webkit-scrollbar-thumb {
        background: linear-gradient(125deg, #696cff, #60a5fa);
        border-radius: 10px;
    }

    .custom-alert {
        opacity: 1;
        display: block;
        transition: opacity 0.5s ease;
    }

    .custom-alert-hide {
        opacity: 0;
        display: none;
        transition: opacity 0.5s ease;
    }

    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .line-clamp {
        display: -webkit-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .bg-disabled {
        background-color: #eaeff4;
    }

    .backto {
        text-decoration: underline;
    }

    .backto:hover {
        text-decoration: none;
    }

    .note-editable ul {
        list-style: disc !important;
        list-style-position: inside !important;
    }

    .note-editable ol {
        list-style: decimal !important;
        list-style-position: inside !important;
    }
</style>
<script>
    const popupCenter = ({
        url,
        title,
        w,
        h
    }) => {
        // Fixes dual-screen position                             Most browsers      Firefox
        const dualScreenLeft = window.screenLeft !== undefined ? window.screenLeft : window.screenX;
        const dualScreenTop = window.screenTop !== undefined ? window.screenTop : window.screenY;

        const width = window.innerWidth ? window.innerWidth : document.documentElement.clientWidth ? document
            .documentElement.clientWidth : screen.width;
        const height = window.innerHeight ? window.innerHeight : document.documentElement.clientHeight ? document
            .documentElement.clientHeight : screen.height;

        const systemZoom = width / window.screen.availWidth;
        const left = (width - w) / 2 / systemZoom + dualScreenLeft
        const top = (height - h) / 2 / systemZoom + dualScreenTop
        const newWindow = window.open(url, title,
            `scrollbars=yes, width=${w / systemZoom}, height=${h / systemZoom}, top=${top}, left=${left}`
        )
        if (window.focus) newWindow.focus();
    }
</script>
