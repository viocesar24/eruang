<?php if (session()->has('pinjamBerhasil')): ?>
    <div class="alert alert-success alert-dismissible" role="alert">
        <div>
            <?= session()->getFlashdata('pinjamBerhasil') ?>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php elseif (session()->has('pinjamGagal')): ?>
    <div class="alert alert-warning alert-dismissible" role="alert">
        <div>
            <?= session()->getFlashdata('pinjamGagal') ?>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<?php if (validation_errors()): ?>
    <div class="alert alert-danger">
        <?= validation_list_errors() ?>
    </div>
<?php endif ?>
<div class="text-center">
    <main class="w-25 m-auto">
        <form action="/peminjaman/create" method="post" class="needs-validation" novalidate>
            <?= csrf_field() ?>

            <img class="img-fluid" src="/E-RUANG.svg" alt="" width="100" height="100">
            <h1 class="h3 mb-3 fw-normal">Buat Peminjaman</h1>

            <div class="input-group mb-3">
                <label class="input-group-text" for="inputGroupSelect01">Nama Pegawai</label>
                <select name="id_pegawai" class="form-select" id="inputGroupSelect01">
                    <option name="id_pegawai" value="<?= esc($user['pegawai_id']) ?>" selected><?= esc($user['nama']) ?>
                    </option>
                </select>
            </div>

            <div class="input-group mb-3">
                <label class="input-group-text" for="inputGroupSelect02">Nama Ruangan</label>
                <select name="id_ruangan" class="form-select" id="inputGroupSelect02">
                    <option value="<?= null ?>" selected>Pilih...</option>
                    <?php if (!empty($ruangan) && is_array($ruangan)): ?>
                        <?php foreach ($ruangan as $ruangan_item): ?>
                            <option name="id_ruangan" value="<?= esc($ruangan_item['id']) ?>"><?= esc($ruangan_item['nama']) ?>
                            </option>
                        <?php endforeach ?>
                    <?php else: ?>
                        <h3>Tidak Ada Ruangan</h3>
                        <p>Unable to find any ruangan for you.</p>
                    <?php endif ?>
                </select>
            </div>

            <div class="input-group mb-3">
                <span class="input-group-text">Detail Acara</span>
                <textarea class="form-control" name="acara" aria-label="Detail Acara" required></textarea>
            </div>

            <div class="input-group mb-3">
                <span class="input-group-text" for="birthday">Tanggal Peminjaman:</span>
                <input type="date" id="birthday" name="tanggal" class="form-control" required>
            </div>

            <div class="input-group mb-3">
                <span class="input-group-text" for="waktu_mulai">Waktu Mulai:</span>
                <input type="time" id="waktu_mulai" name="waktu_mulai" class="form-control" required>
            </div>

            <div class="input-group mb-3">
                <span class="input-group-text" for="waktu_selesai">Waktu Selesai:</span>
                <input type="time" id="waktu_selesai" name="waktu_selesai" class="form-control" required>
            </div>

            <br>
            <input type="submit" name="submit" value="Buat Peminjaman Baru" class="btn btn-primary">
        </form>
    </main>
</div>