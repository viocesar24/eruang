<h2><?= esc($title) ?></h2>

<a href="/peminjaman/create/">
    <button class="button button-primary">
        <span class="button__icon"><i class="bx bx-plus"></i></span>
        <span class="button__text2">Booking Ruangan</span>
    </button>
</a>

<div class="table-responsive">
    <table class="table table-striped table-hover table-responsive">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Nama Peminjam</th>
                <th scope="col">Nama Ruangan</th>
                <th scope="col">Tanggal</th>
                <th scope="col">Waktu Mulai</th>
                <th scope="col">Waktu Selesai</th>
                <th scope="col">Lihat Peminjaman</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($peminjaman) && is_array($peminjaman)) : ?>
                <?php foreach ($peminjaman as $peminjaman_item) : ?>
                    <tr>
                        <th scope="row"><?= esc($peminjaman_item['id']) ?></th>
                        <td><?= esc($peminjaman_item['nama_pegawai']) ?></td>
                        <td><?= esc($peminjaman_item['nama_ruangan']) ?></td>
                        <td><?= esc($peminjaman_item['tanggal']) ?></td>
                        <td><?= esc($peminjaman_item['waktu_mulai']) ?></td>
                        <td><?= esc($peminjaman_item['waktu_selesai']) ?></td>
                        <td>
                            <a href="/peminjaman/<?= esc($peminjaman_item['id'], 'url') ?>">
                                <button type="button" class="btn btn-primary btn-sm">Lihat</button>
                            </a>
                        </td>
                    </tr>
                <?php endforeach ?>
            <?php else : ?>
                <h3 class="text-center">Tidak Ada Peminjaman</h3>
                <p class="text-center">Unable to find any peminjaman for you.</p>
            <?php endif ?>
        </tbody>
    </table>
</div>