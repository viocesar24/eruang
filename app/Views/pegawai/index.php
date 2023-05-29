<h2>
    <?= esc($title) ?>
</h2>

<?php if (!empty($pegawai) && is_array($pegawai)): ?>

    <?php foreach ($pegawai as $pegawai_item): ?>

        <h3>
            <?= esc($pegawai_item['id']) ?>
        </h3>

        <div class="main">
            <?= esc($pegawai_item['nama']) ?>
        </div>

    <?php endforeach ?>

<?php else: ?>

    <h3>Tidak Ada Pegawai</h3>

    <p>Unable to find any pegawai for you.</p>

<?php endif ?>