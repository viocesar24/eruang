<?php if (session()->has('pinjamBerhasil')): ?>
    <div class="alert alert-success alert-dismissible" role="alert">
        <div>
            <?= session()->getFlashdata('pinjamBerhasil') ?>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php elseif (session()->has('pinjamGagal')): ?>
    <div class="alert alert-danger alert-dismissible" role="alert">
        <div>
            <?= session()->getFlashdata('pinjamGagal') ?>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php elseif (session()->has('error')): ?>
    <div class="alert alert-danger alert-dismissible" role="alert">
        <div>
            <?= session()->getFlashdata('error') ?>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<?php if (validation_errors()): ?>
    <div class="alert alert-danger">
        <?= validation_list_errors() ?>
    </div>
<?php endif ?>
<div class="container text-center">
    <div class="row">
        <div class="col-1"></div>
        <div class="col-10">
            <form action="/peminjaman/create" method="post" class="needs-validation" novalidate>
                <?= csrf_field() ?>

                <img class="img-fluid" src="/E-RUANG.svg" alt="" width="100" height="100">
                <h1 class="h3 mb-3 fw-normal">Buat Peminjaman</h1>

                <select name="id_pegawai" class="form-select mb-3" id="inputGroupSelect01">
                    <option name="id_pegawai" value="<?= esc($user['pegawai_id']) ?>" selected><?= esc($user['nama']) ?>
                    </option>
                </select>

                <select name="id_ruangan" class="form-select mb-3" id="inputGroupSelect02">
                    <option value="<?= null ?>" selected>Pilih Ruangan...</option>
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

                <textarea class="form-control mb-3" name="acara" aria-label="Detail Acara" placeholder="Detail Acara"
                    required></textarea>

                <input type="text" id="birthday" name="tanggal" class="form-control mb-3" placeholder="Tanggal Acara"
                    onfocus="(this.type='date')" onblur="if(this.value==''){this.type='text'}" min="<?= date('Y-m-d') ?>" required>

                <input type="text" id="waktu_mulai" name="waktu_mulai" class="form-control mb-3"
                    placeholder="Waktu Mulai Acara" onfocus="(this.type='time')"
                    onblur="if(this.value==''){this.type='text'}" required>

                <input type="text" id="waktu_selesai" name="waktu_selesai" class="form-control mb-3"
                    placeholder="Waktu Selesai Acara" onfocus="(this.type='time')"
                    onblur="if(this.value==''){this.type='text'}" required>

                <br>
                <input type="submit" name="submit" value="Buat Peminjaman Baru" class="btn btn-primary">
            </form>
        </div>
        <div class="col-1"></div>
    </div>
</div>