<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="google" content="notranslate">
    <title>E-RUANG</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css" rel="stylesheet">
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

        <?php if (session()->has('editBerhasil')): ?>
            <div class="alert alert-success alert-dismissible" role="alert">
                <div>
                    <?= session()->getFlashdata('editBerhasil') ?>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
            </div>
        <?php elseif (session()->has('hapusBerhasil')): ?>
            <div class="alert alert-warning alert-dismissible" role="alert">
                <div>
                    <?= session()->getFlashdata('hapusBerhasil') ?>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
            </div>
        <?php elseif (session()->has('signupBerhasil')): ?>
            <div class="alert alert-success alert-dismissible" role="alert">
                <div>
                    <?= session()->getFlashdata('signupBerhasil') ?>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
            </div>
        <?php elseif (session()->has('error')): ?>
            <div class="alert alert-danger alert-dismissible" role="alert">
                <div>
                    <?= session()->getFlashdata('error') ?>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
            </div>
        <?php endif; ?>

        <section>
            <div class="card bg-body-tertiary">
                <div class="card-header text-center">
                    <h2>
                        <?= esc($title) ?>
                    </h2>
                </div>
                <div class="card-body">
                    <div class="container px-3 py-3 px-md-3">
                        <div class="d-grid">
                            <button type="button" class="btn btn-lg btn-info mb-3" data-bs-toggle="modal" data-bs-target="#modalBuat">Buat User</button>
                            <form action="/signupadmin" method="post">
                                <?= csrf_field() ?>
                                <!-- Modal -->
                                <div class="modal fade" id="modalBuat" tabindex="-1" aria-labelledby="exampleModalLabelBuat" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="exampleModalLabelBuat">Buat
                                                    User</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="form-outline mb-4">
                                                    <label class="form-label" for="username">Username</label>
                                                    <input type="text" name="username" id="username" class="form-control form-control-lg" required minlength="3" maxlength="20" pattern="[a-zA-Z0-9]+" title="Hanya huruf dan angka yang diperbolehkan." autocomplete="username" />
                                                </div>

                                                <div class="form-outline mb-4">
                                                    <label class="form-label" for="password">Kata Sandi</label>
                                                    <input type="password" name="password" id="password" class="form-control form-control-lg" required autocomplete="current-password" />
                                                </div>

                                                <div class="form-outline mb-4">
                                                    <label class="form-label" for="pegawai_id">Pilih Nama
                                                        Pegawai</label>
                                                    <select name="pegawai_id" id="pegawai_id" class="form-select form-select-lg" aria-label="Pilih Nama Pegawai..." required>
                                                        <option selected disabled>Pilih Nama Pegawai...</option>
                                                        <?php if (!empty($filtered_pegawai) && is_array($filtered_pegawai)): ?>
                                                            <?php foreach ($filtered_pegawai as $item): ?>
                                                                <option name="pegawai_id" value="<?= esc($item['id']) ?>">
                                                                    <?= esc($item['nama']) ?>
                                                                </option>
                                                            <?php endforeach ?>
                                                        <?php else: ?>
                                                            <option selected>Tidak Ada Daftar Pegawai</option>
                                                        <?php endif ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                                <button type="submit" class="btn btn-primary">Daftar</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover table-responsive" id="tableUserAdmin">
                                <thead>
                                    <tr>
                                        <th scope="col">ID</th>
                                        <th scope="col">Username</th>
                                        <th scope="col">Nama</th>
                                        <th scope="col">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($user) && is_array($user)): ?>
                                        <?php foreach ($user as $user_item): ?>
                                            <tr>
                                                <th scope="row">
                                                    <?= esc($user_item['id']) ?>
                                                </th>
                                                <td>
                                                    <?= esc($user_item['username']) ?>
                                                </td>
                                                <td>
                                                    <?= esc($user_item['nama_pegawai']) ?>
                                                </td>
                                                <td>
                                                    <!-- Button trigger modal -->
                                                    <button type="button" class="btn btn-sm btn-warning btn-edit" data-id="<?= $user_item['id'] ?>" data-username="<?= $user_item['username'] ?>" data-nama="<?= $user_item['pegawai_id'] ?>" data-bs-toggle="modal" data-bs-target="#modalUniversal">
                                                        Edit
                                                    </button>
                                                    <!-- Button trigger modal -->
                                                    <button type="button" class="btn btn-sm btn-danger btn-hapus" data-id-hapus="<?= $user_item['id'] ?>" data-bs-toggle="modal" data-bs-target="#modalHapusUniversal">
                                                        Hapus
                                                    </button>
                                                </td>
                                            </tr>
                                        <?php endforeach ?>
                                    <?php else: ?>
                                        <h3 class="text-center">Tidak Ada User</h3>
                                        <p class="text-center">Unable to find any user for you.</p>
                                    <?php endif ?>
                                </tbody>
                            </table>

                            <!-- Modal Edit di luar looping -->
                            <div class="modal fade" id="modalUniversal" tabindex="-1" aria-labelledby="modalUniversalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="modalUniversalLabel">Edit User</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <!-- Form diisi oleh JavaScript -->
                                            <form id="formEditUser" action="/edit" method="post">
                                                <?= csrf_field() ?>
                                                <input type="hidden" name="id" id="modalInputId">
                                                <div class="mb-3">
                                                    <label for="modalInputUsername" class="form-label">Username</label>
                                                    <input type="text" class="form-control" name="username" id="modalInputUsername" required autocomplete="off">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="modalInputNama" class="form-label">Pilih Nama Pegawai</label>
                                                    <!-- <input type="text" class="form-control" name="nama" id="modalInputNama" required> -->
                                                    <select name="pegawai_id" id="modalInputNama" class="form-select" aria-label="Pilih Nama Pegawai..." required>
                                                        <option selected disabled>Pilih Nama Pegawai...
                                                        </option>
                                                        <?php if (!empty($pegawai) && is_array($pegawai)): ?>
                                                            <?php foreach ($pegawai as $pegawai_item): ?>
                                                                <option name="pegawai_id" value="<?= esc($pegawai_item['id']) ?>">
                                                                    <?= esc($pegawai_item['nama']) ?>
                                                                </option>
                                                            <?php endforeach ?>
                                                        <?php else: ?>
                                                            <option selected>Tidak Ada Daftar Pegawai</option>
                                                        <?php endif ?>
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="modalInputPassword" class="form-label">Password</label>
                                                    <input type="password" class="form-control" name="password" id="modalInputPassword" required autocomplete="off">
                                                </div>
                                                <button type="submit" class="btn btn-primary">Simpan</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Modal Hapus di luar looping -->
                            <div class="modal fade" id="modalHapusUniversal" tabindex="-1" aria-labelledby="modalHapusUniversalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="modalHapusUniversalLabel">Hapus User</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form id="formHapusUser" action="/hapus" method="post">
                                                <?= csrf_field() ?>
                                                <input type="hidden" class="form-control text-center" placeholder="ID" aria-label="ID" aria-describedby="hapusID" name="id" id="modalInputIdHapus" readonly>
                                                <h2>Apakah Anda Yakin?</h2>
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                                <button type="submit" class="btn btn-primary">Hapus</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <!-- Link ke file Popper -->
    <script src="https://unpkg.com/@popperjs/core@2"></script>
    <!-- Link ke file JavaScript jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <!-- Link ke file Bootstrap Datepicker jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/js/bootstrap-datepicker.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/locales/bootstrap-datepicker.id.min.js"></script>
    <!-- Datatables CDN -->
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
    <!-- tableUserAdmin -->
    <script>
        // Wait for the HTML document to finish loading
        $(document).ready(function() {
            // Initialize the DataTables plugin on the table with id "tableUserAdmin"
            $('#tableUserAdmin').DataTable();
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('modalUniversal');
            const formEditUser = document.getElementById('formEditUser');
            const modalInputId = document.getElementById('modalInputId');
            const modalInputUsername = document.getElementById('modalInputUsername');
            const modalInputNama = document.getElementById('modalInputNama');

            document.querySelectorAll('.btn-edit').forEach(button => {
                button.addEventListener('click', function() {
                    const userId = this.getAttribute('data-id');
                    const username = this.getAttribute('data-username');
                    const nama = this.getAttribute('data-nama');

                    // Isi data modal
                    modalInputId.value = userId;
                    modalInputUsername.value = username;
                    modalInputNama.value = nama;
                });
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('modalHapusUniversal');
            const formHapusUser = document.getElementById('formHapusUser');
            const modalInputId = document.getElementById('modalInputIdHapus');

            document.querySelectorAll('.btn-hapus').forEach(button => {
                button.addEventListener('click', function() {
                    const userId = this.getAttribute('data-id-hapus');
                    modalInputId.value = userId;
                });
            });
        });
    </script>
</body>

</html>