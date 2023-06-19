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
                    <button type="button" class="btn btn-lg btn-info mb-3" data-bs-toggle="modal"
                        data-bs-target="#modalBuat">Buat User</button>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover table-responsive" id="tableUserAdmin">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">username</th>
                                <th scope="col">id_pegawai</th>
                                <th scope="col">aksi</th>
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
                                            <?= esc($user_item['pegawai_id']) ?>
                                        </td>
                                        <td>
                                            <!-- Button trigger modal -->
                                            <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                                data-bs-target="#modalEdit<?= esc($user_item['id']) ?>">
                                                Edit
                                            </button>
                                            <!-- Button trigger modal -->
                                            <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                                data-bs-target="#modalHapus<?= esc($user_item['id']) ?>">
                                                Hapus
                                            </button>
                                            <!-- Form Modal -->
                                            <form action="/edit" method="post">
                                                <?= csrf_field() ?>
                                                <!-- Modal -->
                                                <div class="modal fade" id="modalEdit<?= esc($user_item['id']) ?>" tabindex="-1"
                                                    aria-labelledby="exampleModalLabelEdit<?= esc($user_item['id']) ?>"
                                                    aria-hidden="true">
                                                    <div
                                                        class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h1 class="modal-title fs-5"
                                                                    id="exampleModalLabelEdit<?= esc($user_item['id']) ?>">
                                                                    Edit User oleh Admin
                                                                    <?= session()->get('pegawai_id_user') ?>
                                                                </h1>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                    aria-label="Tutup"></button>
                                                            </div>
                                                            <div class="modal-body">

                                                                <!-- Memulai input form -->
                                                                <div class="py-1 px-5">

                                                                    <div class="text-center text-lg-start">
                                                                        <h2 class="fw-bold text-uppercase">
                                                                            Edit User</h2>
                                                                        <p class="text-black-50 mb-3">Dimohon untuk mengisi
                                                                            semua bagian!</p>
                                                                    </div>

                                                                    <input type="text" class="form-control" name="id"
                                                                        id="input00" value="<?= esc($user_item['id']) ?>"
                                                                        readonly hidden>

                                                                    <div class="form-outline form-white mb-3">
                                                                        <label class="form-label"
                                                                            for="inputGroup01">Username</label>
                                                                        <input type="text" name="username" class="form-control"
                                                                            id="inputGroup01"
                                                                            value="<?= esc($user_item['username']) ?>" readonly>
                                                                    </div>

                                                                    <div class="form-outline form-white mb-3">
                                                                        <label class="form-label" for="password">
                                                                            Kata Sandi</label>
                                                                        <input type="password" name="password" id="password"
                                                                            class="form-control form-control-lg" required />
                                                                    </div>

                                                                    <div class="form-outline form-white mb-3">
                                                                        <label class="form-label" for="pegawai_id">Pilih Nama
                                                                            Pegawai</label>
                                                                        <select name="pegawai_id" id="pegawai_id"
                                                                            class="form-select form-select-lg"
                                                                            aria-label="Pilih Nama Pegawai..." required>
                                                                            <option selected disabled>Pilih Nama Pegawai...
                                                                            </option>
                                                                            <?php if (!empty($pegawai) && is_array($pegawai)): ?>
                                                                                <?php foreach ($pegawai as $pegawai_item): ?>
                                                                                    <option name="pegawai_id"
                                                                                        value="<?= esc($pegawai_item['id']) ?>"><?= esc($pegawai_item['nama']) ?></option>
                                                                                <?php endforeach ?>
                                                                            <?php else: ?>
                                                                                <option selected>Tidak Ada Daftar Pegawai</option>
                                                                            <?php endif ?>
                                                                        </select>
                                                                    </div>

                                                                </div>
                                                                <!-- Mengakhiri input form -->

                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">Tutup</button>
                                                                <button type="submit" name="submit"
                                                                    class="btn btn-primary">Simpan</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                            <form action="/hapus" method="post">
                                                <?= csrf_field() ?>
                                                <!-- Modal -->
                                                <div class="modal fade" id="modalHapus<?= esc($user_item['id']) ?>"
                                                    tabindex="-1"
                                                    aria-labelledby="exampleModalLabelHapus<?= esc($user_item['id']) ?>"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h1 class="modal-title fs-5"
                                                                    id="exampleModalLabelHapus<?= esc($user_item['id']) ?>">
                                                                    Hapus User</h1>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                    aria-label="Tutup"></button>
                                                            </div>
                                                            <div class="modal-body text-center">
                                                                <h2>Apakah Anda Yakin?</h2>
                                                                <input type="hidden" class="form-control text-center"
                                                                    placeholder="ID" aria-label="ID" aria-describedby="hapusID"
                                                                    name="id" value="<?= esc($user_item['id']) ?>" readonly>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">Tutup</button>
                                                                <button type="submit" class="btn btn-primary">Hapus</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                            <form action="/signupadmin" method="post">
                                                <?= csrf_field() ?>
                                                <!-- Modal -->
                                                <div class="modal fade" id="modalBuat" tabindex="-1"
                                                    aria-labelledby="exampleModalLabelBuat" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h1 class="modal-title fs-5" id="exampleModalLabelBuat">Buat
                                                                    User</h1>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                    aria-label="Tutup"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="form-outline mb-4">
                                                                    <label class="form-label" for="username">Username</label>
                                                                    <input type="text" name="username" id="username"
                                                                        class="form-control form-control-lg" required />
                                                                </div>

                                                                <div class="form-outline mb-4">
                                                                    <label class="form-label" for="password">Kata Sandi</label>
                                                                    <input type="password" name="password" id="password"
                                                                        class="form-control form-control-lg" required />
                                                                </div>

                                                                <div class="form-outline mb-4">
                                                                    <label class="form-label" for="pegawai_id">Pilih Nama
                                                                        Pegawai</label>
                                                                    <select name="pegawai_id" id="pegawai_id"
                                                                        class="form-select form-select-lg"
                                                                        aria-label="Pilih Nama Pegawai..." required>
                                                                        <option selected disabled>Pilih Nama Pegawai...</option>
                                                                        <?php if (!empty($filtered_pegawai) && is_array($filtered_pegawai)): ?>
                                                                            <?php foreach ($filtered_pegawai as $item): ?>
                                                                                <option name="pegawai_id"
                                                                                    value="<?= esc($item['id']) ?>"><?= esc($item['nama']) ?></option>
                                                                            <?php endforeach ?>
                                                                        <?php else: ?>
                                                                            <option selected>Tidak Ada Daftar Pegawai</option>
                                                                        <?php endif ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">Tutup</button>
                                                                <button type="submit" class="btn btn-primary">Daftar</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach ?>
                            <?php else: ?>
                                <h3 class="text-center">Tidak Ada User</h3>
                                <p class="text-center">Unable to find any user for you.</p>
                            <?php endif ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>