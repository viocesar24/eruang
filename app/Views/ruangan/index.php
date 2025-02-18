<p><a class="btn btn-primary" href="/ruangan/create" role="button">Buat Ruangan</a></p>

<?php if (!empty($ruangan) && is_array($ruangan)) : ?>

    <?php foreach ($ruangan as $ruangan_item) : ?>

        <h3><?= esc($ruangan_item['id']) ?></h3>

        <div class="main">
            <?= esc($ruangan_item['nama']) ?>
            <br>
            Status: <?= esc($ruangan_item['status']) ?>
        </div>
        <p>
            <a href="/ruangan/<?= esc($ruangan_item['id'], 'url') ?>">Lihat Ruangan</a> |
            <a href="/ruangan/edit/<?= esc($ruangan_item['id'], 'url') ?>">Edit Status</a> |
            <a href="/ruangan/delete/<?= esc($ruangan_item['id'], 'url') ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus ruangan ini?')">Hapus</a>
        </p>

    <?php endforeach ?>

<?php else : ?>

    <h3>Tidak Ada Ruangan</h3>

    <p>Unable to find any ruangan for you.</p>

<?php endif ?>