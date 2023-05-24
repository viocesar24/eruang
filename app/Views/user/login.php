<?= session()->getFlashdata('error') ?>
<?= validation_list_errors() ?>

<div class="container">
    <h1 class="text-center">Login</h1>
    <form action="/user/login" method="post">
        <?= csrf_field() ?>
        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" name="username" class="form-control" id="username" placeholder="Username">
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" name="password" class="form-control" id="password" placeholder="Password">
        </div>
        <button type="submit" class="btn btn-primary">Login</button>
    </form>
    <?php if (isset($data['error'])): ?>
        <p class="alert alert-danger">
            <?php echo $data['error']; ?>
        </p>
    <?php endif; ?>
</div>