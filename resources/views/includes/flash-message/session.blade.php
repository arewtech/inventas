@if (session('status') == 'profile-information-updated')
    <div class="alert alert-success alert-dismissible fade show animate__animated animate__fadeIn" role="alert"
        id="profile-updated-alert">
        <strong>Success!</strong>
        Profile information updated.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <script>
        var profileUpdatedAlert = document.getElementById('profile-updated-alert');

        // Menyembunyikan pesan setelah 3 detik dengan animasi
        setTimeout(function() {
            profileUpdatedAlert.classList.add('animate__fadeOut');

            // Tambahkan event listener untuk menghapus elemen setelah animasi selesai
            profileUpdatedAlert.addEventListener('animationend', function() {
                profileUpdatedAlert.remove();
            });
        }, 3000);
    </script>
@endif
@if (session('status') == 'password-updated')
    <div class="alert alert-success alert-dismissible fade show animate__animated animate__fadeIn" role="alert"
        id="password-updated-alert">
        <strong>Success!</strong>
        Password updated.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>

    <script>
        var passwordUpdatedAlert = document.getElementById('password-updated-alert');

        // Menyembunyikan pesan setelah 3 detik dengan animasi
        setTimeout(function() {
            passwordUpdatedAlert.classList.add('animate__fadeOut');

            // Tambahkan event listener untuk menghapus elemen setelah animasi selesai
            passwordUpdatedAlert.addEventListener('animationend', function() {
                passwordUpdatedAlert.remove();
            });
        }, 3000);
    </script>
@endif
