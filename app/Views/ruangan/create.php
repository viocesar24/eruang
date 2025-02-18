<form action="/ruangan/create" method="post">
    <?= csrf_field() ?>

    <label for="nama">NAMA RUANGAN</label>
    <input name="nama" type="text" class="form-control" placeholder="Nama" aria-label="Nama" aria-describedby="basic-addon1" value="<?= set_value('nama') ?>">
    <br>

    <label for="status">STATUS RUANGAN</label>
    <select name="status" class="form-control" aria-label="Status" aria-describedby="basic-addon1">
        <option value="Aktif" <?= set_select('status', 'Aktif', true) ?>>Aktif</option>
        <option value="Nonaktif" <?= set_select('status', 'Nonaktif') ?>>Nonaktif</option>
    </select>
    <br>

    <input type="submit" name="submit" value="Buat Ruangan Baru">
</form>