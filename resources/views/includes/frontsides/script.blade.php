<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
</script>
<script src="{{ asset('assets/js/jquery.mask.min.js') }}"></script>
<!-- Script untuk animasi scroll ke atas -->
<script>
    $(document).ready(function() {
        var scrollButton = $(".scroll-to-top");

        // Saat dokumen di-load, sembunyikan tombol scroll-to-top
        scrollButton.hide();

        // Fungsi untuk menampilkan atau menyembunyikan tombol scroll-to-top berdasarkan posisi scroll
        $(window).scroll(function() {
            if ($(this).scrollTop() > 100) {
                scrollButton.fadeIn();
            } else {
                scrollButton.fadeOut();
            }
        });

        // Fungsi untuk membuat tombol scroll-to-top mengambang
        scrollButton.click(function() {
            $("html, body").animate({
                scrollTop: 0
            }, 800);
            return false;
        });

        // Fungsi untuk membuat tombol scroll-to-top mengambang saat posisi scroll di bawah
        $(window).scroll(function() {
            if ($(this).scrollTop() > 900) {
                scrollButton.addClass("floating");
            } else {
                scrollButton.removeClass("floating");
            }
        });
    });
</script>
<script>
    $(document).ready(function() {
        $('.rupiah').mask("#.##0", {
            reverse: true
        });
    });
</script>
