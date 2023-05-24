<h2 class="mt-4">
    <?= esc($title) ?>
</h2>

<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger">
        <?= session()->getFlashdata('error') ?>
    </div>
<?php endif ?>

<?php if (validation_errors()): ?>
    <div class="alert alert-danger">
        <?= validation_list_errors() ?>
    </div>
<?php endif ?>

<form action="/peminjaman/create" method="post" class="needs-validation" novalidate>
    <?= csrf_field() ?>

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
        <textarea class="form-control" name="acara" aria-label="Detail Acara"></textarea>
    </div>

    <div class="input-group mb-3">
        <label for="birthday">Tanggal Peminjaman:</label>
        <input type="date" id="birthday" name="tanggal" class="form-control">
    </div>

    <div class="input-group mb-3">
        <label for="waktu_mulai">Waktu Mulai:</label>
        <input type="time" id="waktu_mulai" name="waktu_mulai" class="form-control">
    </div>

    <div class="input-group mb-3">
        <label for="waktu_selesai">Waktu Selesai:</label>
        <input type="time" id="waktu_selesai" name="waktu_selesai" class="form-control">
    </div>

    <br>
    <input type="submit" name="submit" value="Buat Peminjaman Baru" class="btn btn-primary">
</form>