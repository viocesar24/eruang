<h2>Edit Ruangan: <?= esc($ruangan['nama']) ?></h2>

<?= session()->getFlashdata('error') ?>
<?= validation_list_errors() ?>

<form action="/ruangan/update/<?= esc($ruangan['id']) ?>" method="post">
    <?= csrf_field() ?>

    <label for="nama">NAMA RUANGAN</label>
    <input name="nama" type="text" class="form-control" placeholder="Nama" aria-label="Nama" aria-describedby="basic-addon1" value="<?= esc($ruangan['nama']) ?>" readonly>
    <br>

    <label for="status">STATUS RUANGAN</label>
    <select name="status" class="form-control" aria-label="Status" aria-describedby="basic-addon1">
        <option value="Aktif" <?= set_select('status', 'Aktif', ($ruangan['status'] === 'Aktif')) ?>>Aktif</option>
        <option value="Nonaktif" <?= set_select('status', 'Nonaktif', ($ruangan['status'] === 'Nonaktif')) ?>>Nonaktif</option>
    </select>
    <br>

    <input type="submit" name="submit" value="Simpan Perubahan Status Ruangan">
</form>