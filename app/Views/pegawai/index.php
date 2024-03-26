<?php if (session()->has('pegawaiSuccess')): ?>
    <div class="alert alert-success alert-dismissible" role="alert">
        <div>
            <?= session()->getFlashdata('pegawaiSuccess') ?>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php elseif (session()->has('pegawaiError')): ?>
    <div class="alert alert-danger alert-dismissible" role="alert">
        <div>
            <?= session()->getFlashdata('pegawaiError') ?>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<h2>
    <?= esc($title) ?>
</h2>

<?php if (!empty($pegawai) && is_array($pegawai)): ?>

    <?php foreach ($pegawai as $pegawai_item): ?>

        <h3>
            <?= esc($pegawai_item['urutan']) ?>
        </h3>

        <div class="main">
            <?= esc($pegawai_item['nama']) ?>
        </div>

        <a type="button" class="btn btn-primary" href="/pegawai/<?= esc($pegawai_item['id']) ?>">Lihat</a>

        <!-- Button trigger modal -->
        <a type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#hapuspegawaimodal<?= esc($pegawai_item['id']) ?>">
            Hapus
        </a>

        <!-- Modal -->
        <div class="modal fade" id="hapuspegawaimodal<?= esc($pegawai_item['id']) ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="hapuspegawaimodal<?= esc($pegawai_item['id']) ?>Label" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="hapuspegawaimodal<?= esc($pegawai_item['id']) ?>Label">Hapus Pegawai</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Apakah Anda yakin ingin menghapus data Pegawai dengan Nama:<br>
                        <b><?= esc($pegawai_item['nama']) ?></b>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tidak</button>
                        <!-- Form untuk menghapus pegawai -->
                        <form action="/pegawai/delete" method="post">
                            <?= csrf_field() ?>
                            <input type="hidden" name="id" value="<?= esc($pegawai_item['id']) ?>" />
                            <button type="submit" class="btn btn-primary">Iya</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    <?php endforeach ?>

<?php else: ?>

    <h3>Tidak Ada Pegawai</h3>

    <p>Unable to find any pegawai for you.</p>

<?php endif ?>