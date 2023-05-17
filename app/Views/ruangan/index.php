<h2><?= esc($title) ?></h2>

<?php if (!empty($ruangan) && is_array($ruangan)) : ?>

    <?php foreach ($ruangan as $ruangan_item) : ?>

        <h3><?= esc($ruangan_item['id']) ?></h3>

        <div class="main">
            <?= esc($ruangan_item['nama']) ?>
        </div>
        <p><a href="/ruangan/<?= esc($ruangan_item['id'], 'url') ?>">Lihat Ruangan</a></p>

    <?php endforeach ?>

<?php else : ?>

    <h3>Tidak Ada Ruangan</h3>

    <p>Unable to find any ruangan for you.</p>

<?php endif ?>