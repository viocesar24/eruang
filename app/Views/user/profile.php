<?php if (session()->has('success')): ?>
    <div class="alert alert-success alert-dismissible" role="alert">
        <div>
            <?= session()->getFlashdata('success') ?>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
    </div>
<?php elseif (session()->has('error')): ?>
    <div class="alert alert-danger alert-dismissible" role="alert">
        <div>
            <?= session()->getFlashdata('error') ?>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
    </div>
<?php endif; ?>

<?php if (!empty($user) && is_array($user)): ?>

    <div class="card">
        <div class="card-body">
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
                        <h3>
                            username:
                            <?= esc($user['username']) ?>
                        </h3>
                        <h3>Ganti Password</h3>
                        <form action="<?= base_url('changePassword') ?>" method="post">
                            <?= csrf_field() ?>
                            <input type="password" name="old_password" placeholder="Old Password" required>
                            <input type="password" name="new_password" placeholder="New Password" required>
                            <input type="password" name="confirm_password" placeholder="Confirm Password" required>
                            <button type="submit" class="btn btn-primary">Change Password</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php else: ?>

    <h3>Tidak Ada Pegawai</h3>

    <p>Unable to find any user for you.</p>

<?php endif ?>