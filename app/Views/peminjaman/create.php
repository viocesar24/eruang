<h2><?= esc($title) ?></h2>

<?= session()->getFlashdata('error') ?>
<?= validation_list_errors() ?>

<form action="/peminjaman/create" method="post">
    <?= csrf_field() ?>

    <div class="input-group mb-3">
        <label class="input-group-text" for="inputGroupSelect01">Nama Pegawai</label>
        <select name="id_pegawai" class="form-select" id="inputGroupSelect01">
            <option selected>Pilih...</option>
            <?php if (!empty($pegawai) && is_array($pegawai)) : ?>
                <?php foreach ($pegawai as $pegawai_item) : ?>
                    <option name="id_pegawai" value="<?= esc($pegawai_item['id']) ?>"><?= esc($pegawai_item['nama']) ?></option>
                <?php endforeach ?>
            <?php else : ?>
                <h3>Tidak Ada Pegawai</h3>
                <p>Unable to find any pegawai for you.</p>
            <?php endif ?>
        </select>
    </div>

    <div class="input-group mb-3">
        <label class="input-group-text" for="inputGroupSelect02">Nama Ruangan</label>
        <select name="id_ruangan" class="form-select" id="inputGroupSelect02">
            <option selected>Pilih...</option>
            <?php if (!empty($ruangan) && is_array($ruangan)) : ?>
                <?php foreach ($ruangan as $ruangan_item) : ?>
                    <option name="id_ruangan" value="<?= esc($ruangan_item['id']) ?>"><?= esc($ruangan_item['nama']) ?></option>
                <?php endforeach ?>
            <?php else : ?>
                <h3>Tidak Ada Ruangan</h3>
                <p>Unable to find any ruangan for you.</p>
            <?php endif ?>
        </select>
    </div>

    <label for="birthday">Tanggal Peminjaman:</label>
    <input type="date" id="birthday" name="tanggal">

    <label for="waktu_mulai">Waktu Mulai:</label>
    <input type="time" id="waktu_mulai" name="waktu_mulai">

    <label for="waktu_selesai">Waktu Selesai:</label>
    <input type="time" id="waktu_selesai" name="waktu_selesai">

    <input type="submit" name="submit" value="Buat Peminjaman Baru">
</form>