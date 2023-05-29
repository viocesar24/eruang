<?php if (session()->has('editBerhasil')): ?>
    <div class="alert alert-success alert-dismissible" role="alert">
        <div>
            <?= session()->getFlashdata('editBerhasil') ?>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
    </div>
<?php elseif (session()->has('editGagal')): ?>
    <div class="alert alert-danger alert-dismissible" role="alert">
        <div>
            <?= session()->getFlashdata('editGagal') ?>
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
<?php elseif (session()->has('loginBerhasil')): ?>
    <div class="alert alert-success alert-dismissible" role="alert">
        <div>
            <?= session()->getFlashdata('loginBerhasil') ?>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
    </div>
<?php elseif (session()->has('pinjamBerhasil')): ?>
    <div class="alert alert-success alert-dismissible" role="alert">
        <div>
            <?= session()->getFlashdata('pinjamBerhasil') ?>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
    </div>
<?php elseif (session()->has('pinjamGagal')): ?>
    <div class="alert alert-warning alert-dismissible" role="alert">
        <div>
            <?= session()->getFlashdata('pinjamGagal') ?>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
    </div>
<?php endif; ?>

<h2>
    <?= esc($title) ?>
</h2>

<a class="btn btn-lg btn-info mb-3" href="/peminjaman/create/<?= esc(session()->get('pegawai_id'), 'url') ?>"
    role="button">Pinjam Ruangan</a>

<div class="table-responsive p-3">
    <table class="table table-striped table-hover table-responsive" id="myTable">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Nama Peminjam</th>
                <th scope="col">Nama Ruangan</th>
                <th scope="col">Acara</th>
                <th scope="col">Tanggal</th>
                <th scope="col">Waktu Mulai</th>
                <th scope="col">Waktu Selesai</th>
                <th scope="col">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($peminjaman) && is_array($peminjaman)): ?>
                <?php foreach ($peminjaman as $peminjaman_item): ?>
                    <tr>
                        <th scope="row">
                            <?= esc($peminjaman_item['id']) ?>
                        </th>
                        <td>
                            <?= esc($peminjaman_item['nama_pegawai']) ?>
                        </td>
                        <td>
                            <?= esc($peminjaman_item['nama_ruangan']) ?>
                        </td>
                        <td>
                            <?= esc($peminjaman_item['acara']) ?>
                        </td>
                        <td>
                            <?= esc($peminjaman_item['tanggal']) ?>
                        </td>
                        <td>
                            <?= esc($peminjaman_item['waktu_mulai']) ?>
                        </td>
                        <td>
                            <?= esc($peminjaman_item['waktu_selesai']) ?>
                        </td>
                        <td>
                            <?php if (session()->get('pegawai_id') === esc($peminjaman_item['id_pegawai'])) { ?>
                                <?= session()->getFlashdata('error') ?>
                                <?= validation_list_errors() ?>
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                    data-bs-target="#modalEdit<?= esc($peminjaman_item['id']) ?>">
                                    Edit
                                </button>
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                    data-bs-target="#modalHapus<?= esc($peminjaman_item['id']) ?>">
                                    Hapus
                                </button>
                                <!-- Form Modal -->
                                <form action="/peminjaman/edit" method="post">
                                    <?= csrf_field() ?>
                                    <!-- Modal -->
                                    <div class="modal fade" id="modalEdit<?= esc($peminjaman_item['id']) ?>" tabindex="-1"
                                        aria-labelledby="exampleModalLabelEdit<?= esc($peminjaman_item['id']) ?>"
                                        aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5"
                                                        id="exampleModalLabelEdit<?= esc($peminjaman_item['id']) ?>">Edit Peminjaman
                                                        <?= esc($peminjaman_item['id']) ?></h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Tutup"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <!-- Memulai input form -->
                                                    <div class="input-group mb-3">
                                                        <label class="input-group-text" for="input00">ID Peminjaman</label>
                                                        <input type="text" name="id" id="input00"
                                                            value="<?= esc($peminjaman_item['id']) ?>" readonly>
                                                    </div>

                                                    <div class="input-group mb-3">
                                                        <label class="input-group-text" for="inputGroupSelect01">
                                                            Nama Pegawai</label>
                                                        <select name="id_pegawai" class="form-select" id="inputGroupSelect01">
                                                            <option name="id_pegawai"
                                                                value="<?= esc($peminjaman_item['id_pegawai']) ?>" selected><?= esc($peminjaman_item['nama_pegawai']) ?></option>
                                                        </select>
                                                    </div>

                                                    <div class="input-group mb-3">
                                                        <label class="input-group-text" for="inputGroupSelect02">
                                                            Nama Ruangan</label>
                                                        <select name="id_ruangan" class="form-select" id="inputGroupSelect02"
                                                            required>
                                                            <option name="id_ruangan"
                                                                value="<?= esc($peminjaman_item['id_ruangan']) ?>" selected><?= esc($peminjaman_item['nama_ruangan']) ?></option>
                                                            <?php if (!empty($ruangan) && is_array($ruangan)): ?>
                                                                <?php foreach ($ruangan as $ruangan_item): ?>
                                                                    <?php if ($ruangan_item['id'] != $peminjaman_item['id_ruangan']): ?>
                                                                        <option name="id_ruangan" value="<?= esc($ruangan_item['id']) ?>"><?= esc($ruangan_item['nama']) ?></option>
                                                                    <?php endif ?>
                                                                <?php endforeach ?>
                                                            <?php else: ?>
                                                                <h3>Tidak Ada Ruangan</h3>
                                                                <p>Unable to find any ruangan for you.</p>
                                                            <?php endif ?>
                                                        </select>
                                                    </div>

                                                    <div class="input-group mb-3">
                                                        <span class="input-group-text">Detail Acara</span>
                                                        <textarea class="form-control" name="acara" aria-label="Detail Acara"
                                                            required><?= esc($peminjaman_item['acara']) ?></textarea>
                                                    </div>

                                                    <div class="input-group mb-3">
                                                        <label for="birthday">Tanggal Peminjaman:</label>
                                                        <input type="date" id="birthday" name="tanggal"
                                                            value="<?= esc($peminjaman_item['tanggal']) ?>"
                                                            min="<?= date('Y-m-d') ?>" required>
                                                    </div>

                                                    <div class="input-group mb-3">
                                                        <label for="waktu_mulai">Waktu Mulai:</label>
                                                        <input type="time" id="waktu_mulai" name="waktu_mulai"
                                                            value="<?= esc($peminjaman_item['waktu_mulai']) ?>" required>
                                                    </div>

                                                    <div class="input-group mb-3">
                                                        <label for="waktu_selesai">Waktu Selesai:</label>
                                                        <input type="time" id="waktu_selesai" name="waktu_selesai"
                                                            value="<?= esc($peminjaman_item['waktu_selesai']) ?>" required>
                                                    </div>

                                                    <!-- Mengakhiri input form -->
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Tutup</button>
                                                    <button type="submit" name="submit" class="btn btn-primary">Simpan</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <form action="/peminjaman/hapus" method="post">
                                    <?= csrf_field() ?>
                                    <!-- Modal -->
                                    <div class="modal fade" id="modalHapus<?= esc($peminjaman_item['id']) ?>" tabindex="-1"
                                        aria-labelledby="exampleModalLabelHapus<?= esc($peminjaman_item['id']) ?>"
                                        aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5"
                                                        id="exampleModalLabelHapus<?= esc($peminjaman_item['id']) ?>">Hapus
                                                        Peminjaman </h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Tutup"></button>
                                                </div>
                                                <div class="modal-body text-center">
                                                    <h2>Apakah Anda Yakin?</h2>
                                                    <input type="hidden" class="form-control text-center" placeholder="ID"
                                                        aria-label="ID" aria-describedby="hapusID" name="id"
                                                        value="<?= esc($peminjaman_item['id']) ?>" readonly>
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
                            <?php } ?>
                        </td>
                    </tr>
                <?php endforeach ?>
            <?php else: ?>
                <h3 class="text-center">Tidak Ada Peminjaman</h3>
                <p class="text-center">Unable to find any peminjaman for you.</p>
            <?php endif ?>
        </tbody>
    </table>
</div>