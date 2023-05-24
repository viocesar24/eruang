<?= session()->getFlashdata('error') ?>
<?= validation_list_errors() ?>

<div class="container">
    <h1 class="text-center">Signup</h1>
    <form action="/user/signup" method="post" enctype="multipart/form-data">
        <?= csrf_field() ?>
        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" name="username" class="form-control" id="username" placeholder="Username">
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" name="password" class="form-control" id="password" placeholder="Password">
        </div>
        <div class="mb-3">
            <label for="pegawai_id" class="form-label">Nama Pegawai</label>
            <select name="pegawai_id" id="pegawai_id" class="form-select" aria-label="Default select example">
                <option selected>Pilih Nama Pegawai...</option>
                <?php if (!empty($pegawai) && is_array($pegawai)): ?>
                    <?php foreach ($pegawai as $pegawai_item): ?>
                        <option name="pegawai_id" value="<?= esc($pegawai_item['id']) ?>"><?= esc($pegawai_item['nama']) ?>
                        </option>
                    <?php endforeach ?>
                <?php else: ?>
                    <option selected>Tidak Ada Daftar Pegawai</option>
                <?php endif ?>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Signup</button>
    </form>
    <?php if (isset($data['errors'])): ?>
        <ul class="alert alert-danger">
            <?php foreach ($data['errors'] as $error): ?>
                <li>
                    <?php echo $error; ?>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</div>