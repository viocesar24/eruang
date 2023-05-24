<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>NYILIH KAMAR</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <style>
        /* Style untuk splash screen */
        #splash-screen {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: white;
            z-index: 9999;
            text-align: center;
            /* Animasi fade-in dan fade-out */
            animation-name: fadeInOut;
            animation-duration: 5s;
        }

        /* Keyframes untuk animasi fade-in dan fade-out */
        @keyframes fadeInOut {
            0% {
                opacity: 0;
            }

            50% {
                opacity: 1;
            }

            100% {
                opacity: 0;
            }
        }

        /* Style untuk menampilkan tulisan di tengah-tengah halaman */
        #splash-screen h1 {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }
    </style>
</head>

<body class="text-center">
    <!-- Splash screen -->
    <div id="splash-screen">
        <!-- <h1>Selamat Datang di E-Ruang</h1> -->
        <img src="/splash_screen.webp" class="img-fluid" alt="Splash Screen">
    </div>
    <script>
        // Fungsi untuk mengarahkan pengguna ke halaman /peminjaman/
        function redirectToPeminjaman() {
            window.location.href = "<?= base_url('/peminjaman/'); ?>";
        }

        // Fungsi untuk mengakhiri splash screen
        function endSplashScreen() {
            document.getElementById("splash-screen").style.display = "none";
            clearTimeout(splashScreenTimeout);
            window.location.href = "<?= base_url('/peminjaman/'); ?>";
        }

        // Mengatur splash screen untuk diakhiri setelah 4 detik
        var splashScreenTimeout = setTimeout(redirectToPeminjaman, 5000);

        // Menambahkan event listener untuk mengakhiri splash screen ketika pengguna melakukan klik kiri pada layar
        document.addEventListener("click", endSplashScreen);
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
        crossorigin="anonymous"></script>
</body>

</html>