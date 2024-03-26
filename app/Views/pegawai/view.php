<h2><?= esc($title) ?></h2>

<?= session()->getFlashdata('error') ?>

<form action="/pegawai/edit" method="post">
    <?= csrf_field() ?>

    <input name="id" type="hidden" value="<?= esc($pegawai['id']) ?>">
    <br>
    <label for="nama">NAMA</label>
    <input name="nama" type="text" class="form-control" placeholder="Nama" aria-label="Nama" aria-describedby="basic-addon1" value="<?= esc($pegawai['nama']) ?>">
    <br>
    <label for="urutan">URUTAN</label>
    <input name="urutan" type="number" class="form-control" placeholder="Urutan" aria-label="Urutan" aria-describedby="basic-addon2" value="<?= esc($pegawai['urutan']) ?>">
    <br>

    <input type="submit" name="submit" value="Simpan Perubahan">
</form>