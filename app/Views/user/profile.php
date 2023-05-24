<h2>
    <?= esc($title) ?>
</h2>

<?php if (!empty($user) && is_array($user)): ?>

    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <img src="https://upload.wikimedia.org/wikipedia/commons/e/e0/Antu_edit-image-face-add.svg"
                    class="rounded-circle" alt="Profile Picture">
            </div>
            <div class="col-md-8">
                <h1 class="display-4">
                    <?= esc($user['nama']) ?>
                </h1>
                <h5>
                    username: <?= esc($user['username']) ?>
                </h5>
            </div>
        </div>
    </div>

<?php else: ?>

    <h3>Tidak Ada Pegawai</h3>

    <p>Unable to find any user for you.</p>

<?php endif ?>