<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="google" content="notranslate">
    <title>E-RUANG</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css" rel="stylesheet">
    <!-- Link ke file CSS Bootstrap Datepicker -->
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/css/bootstrap-datepicker3.standalone.min.css">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.css" />
    <link rel="icon" type="image/x-icon" href="<?= base_url() ?>/favicon.ico">
</head>

<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="/peminjaman">
                <img src="/E-RUANG-LOGO.svg" alt="Logo" width="50" height="50"
                    class="d-inline-block align-text-top"></a>
            <a class="navbar-brand" href="/peminjaman">E-RUANG</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar"
                aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar"
                aria-labelledby="offcanvasNavbarLabel">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title" id="offcanvasNavbarLabel">E-RUANG</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="/peminjaman">Beranda</a>
                        </li>
                        <?php if (session()->get('user_id') !== null): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="/view">Peminjaman</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link"
                                    href="/profile">Profil</a>
                            </li>
                            <?php if (session()->get('pegawai_id') == 58 || session()->get('pegawai_id') == 35) { ?>
                                <li class="nav-item">
                                    <a class="nav-link" href="/user">User</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="/ruangan">Ruangan</a>
                                </li>
                            <?php } ?>
                            <li class="nav-item">
                                <a class="nav-link" href="/logout">Keluar</a>
                            </li>
                        <?php else: ?>
                            <li class="nav-item">
                                <a class="nav-link" href="/signup">Daftar</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/login">Masuk</a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <div class="container-fluid px-5 py-5">