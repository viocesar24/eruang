<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>E-RUANG</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <!-- Link ke file CSS DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand" href="/peminjaman">
                <img src="/E-RUANG-LOGO.svg" alt="Logo" width="50" height="50" class="d-inline-block align-text-top"></a>
            <a class="navbar-brand" href="/peminjaman">E-RUANG</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/peminjaman">Beranda</a>
                    </li>
                    <?php if (session()->get('user_id') !== null): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="/view/<?= esc(session()->get('pegawai_id'), 'url') ?>">Peminjaman</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/profile/<?= esc(session()->get('pegawai_id'), 'url') ?>">Profile</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/logout">Log Out</a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="/signup">Sign Up</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/login">Login</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container-fluid px-5 py-5">