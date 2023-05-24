<?php if (session()->has('editBerhasil')): ?>
    <div class="alert alert-success" role="alert">
        <?= session()->getFlashdata('editBerhasil') ?>
    </div>
<?php elseif (session()->has('hapusBerhasil')): ?>
    <div class="alert alert-warning" role="alert">
        <?= session()->getFlashdata('hapusBerhasil') ?>
    </div>
<?php endif; ?>

<h2>
    <?= esc($title) ?>
</h2>

<a href="/peminjaman/create/<?= esc(session()->get('pegawai_id'), 'url') ?>">
    <button class="button button-primary">
        <span class="button__icon"><i class="bx bx-plus"></i></span>
        <span class="button__text2">Booking Ruangan</span>
    </button>
</a>

<div class="table-responsive">
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
                <th scope="col">Edit</th>
                <th scope="col">Hapus</th>
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

                                <form action="/peminjaman/edit" method="post">
                                    <?= csrf_field() ?>
                                    <!-- Button trigger modal -->
                                    <button type="button" class="btn btn-primary btn-sm btn-warning" data-bs-toggle="modal"
                                        data-bs-target="#modalEdit<?= esc($peminjaman_item['id']) ?>">
                                        Edit
                                    </button>
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
                                                        aria-label="Close"></button>
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
                                                                value="<?= esc($peminjaman_item['id_pegawai']) ?>"><?= esc($peminjaman_item['nama_pegawai']) ?></option>
                                                        </select>
                                                    </div>

                                                    <div class="input-group mb-3">
                                                        <label class="input-group-text" for="inputGroupSelect02">
                                                            Nama Ruangan</label>
                                                        <select name="id_ruangan" class="form-select" id="inputGroupSelect02">
                                                            <option name="id_ruangan"
                                                                value="<?= esc($peminjaman_item['id_ruangan']) ?>"><?= esc($peminjaman_item['nama_ruangan']) ?></option>
                                                            <option selected>Pilih...</option>
                                                            <?php if (!empty($ruangan) && is_array($ruangan)): ?>
                                                                <?php foreach ($ruangan as $ruangan_item): ?>
                                                                    <option name="id_ruangan" value="<?= esc($ruangan_item['id']) ?>"><?= esc($ruangan_item['nama']) ?></option>
                                                                <?php endforeach ?>
                                                            <?php else: ?>
                                                                <h3>Tidak Ada Ruangan</h3>
                                                                <p>Unable to find any ruangan for you.</p>
                                                            <?php endif ?>
                                                        </select>
                                                    </div>

                                                    <div class="input-group mb-3">
                                                        <span class="input-group-text">Detail Acara</span>
                                                        <textarea class="form-control" name="acara"
                                                            aria-label="Detail Acara"><?= esc($peminjaman_item['acara']) ?></textarea>
                                                    </div>

                                                    <div class="input-group mb-3">
                                                        <label for="birthday">Tanggal Peminjaman:</label>
                                                        <input type="date" id="birthday" name="tanggal"
                                                            value="<?= esc($peminjaman_item['tanggal']) ?>">
                                                    </div>

                                                    <div class="input-group mb-3">
                                                        <label for="waktu_mulai">Waktu Mulai:</label>
                                                        <input type="time" id="waktu_mulai" name="waktu_mulai"
                                                            value="<?= esc($peminjaman_item['waktu_mulai']) ?>">
                                                    </div>

                                                    <div class="input-group mb-3">
                                                        <label for="waktu_selesai">Waktu Selesai:</label>
                                                        <input type="time" id="waktu_selesai" name="waktu_selesai"
                                                            value="<?= esc($peminjaman_item['waktu_selesai']) ?>">
                                                    </div>

                                                    <!-- Mengakhiri input form -->
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" name="submit" class="btn btn-primary">Simpan</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            <?php } ?>
                        </td>
                        <td>
                            <?php if (session()->get('pegawai_id') === esc($peminjaman_item['id_pegawai'])) { ?>
                                <?= session()->getFlashdata('error') ?>
                                <?= validation_list_errors() ?>

                                <form action="/peminjaman/hapus" method="post">
                                    <!-- Button trigger modal -->
                                    <?= csrf_field() ?>
                                    <button type="button" class="btn btn-primary btn-sm btn-danger" data-bs-toggle="modal"
                                        data-bs-target="#modalHapus<?= esc($peminjaman_item['id']) ?>">
                                        Hapus
                                    </button>
                                    <!-- Modal -->
                                    <div class="modal fade" id="modalHapus<?= esc($peminjaman_item['id']) ?>" tabindex="-1"
                                        aria-labelledby="exampleModalLabelHapus<?= esc($peminjaman_item['id']) ?>"
                                        aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5"
                                                        id="exampleModalLabelHapus<?= esc($peminjaman_item['id']) ?>">Hapus
                                                        Peminjaman
                                                        <?= esc($peminjaman_item['id']) ?></h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body text-center">
                                                    <div class="input-group mb-3">
                                                        <span class="input-group-text" id="hapusID">Hapus Item Peminjaman ID:</span>
                                                        <input type="text" class="form-control text-center" placeholder="ID"
                                                            aria-label="ID" aria-describedby="hapusID" name="id"
                                                            value="<?= esc($peminjaman_item['id']) ?>" readonly>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Close</button>
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