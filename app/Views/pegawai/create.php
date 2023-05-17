<h2><?= esc($title) ?></h2>

<?= session()->getFlashdata('error') ?>
<?= validation_list_errors() ?>

<form action="/pegawai/create" method="post">
    <?= csrf_field() ?>

    <label for="nama">NAMA</label>
    <input name="nama" type="text" class="form-control" placeholder="Nama" aria-label="Nama" aria-describedby="basic-addon1" value="<?= set_value('nama') ?>">
    <br>

    <input type="submit" name="submit" value="Buat Pegawai Baru">
</form>