<h2>
    <?= esc($title) ?>
</h2>

<?php if (!empty($user) && is_array($user)): ?>

    <div class="table-responsive">
        <table class="table table-hover table-bordered table-sm align-middle">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">username</th>
                    <th scope="col">id_pegawai</th>
                    <th scope="col">aksi</th>
                </tr>
            </thead>
            <tbody class="table-group-divider">
                <?php foreach ($user as $user_item): ?>
                    <tr>
                        <th scope="row">
                            <?= esc($user_item['id']) ?>
                        </th>
                        <td>
                            <?= esc($user_item['username']) ?>
                        </td>
                        <td>
                            <?= esc($user_item['pegawai_id']) ?>
                        </td>
                        <td>
                            <div class="btn-group" role="group" aria-label="Aksi User">
                                <a role="button" class="btn btn-warning btn-sm" href="#">Edit</a>
                                <a role="button" class="btn btn-danger btn-sm" href="#">Hapus</a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>

<?php else: ?>

    <h3>Tidak Ada Pegawai</h3>

    <p>Unable to find any pegawai for you.</p>

<?php endif ?>