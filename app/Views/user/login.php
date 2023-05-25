<?= validation_list_errors() ?>

<?php if (session()->has('signupBerhasil')): ?>
    <div class="alert alert-success" role="alert">
        <?= session()->getFlashdata('signupBerhasil') ?>
    </div>
<?php elseif (session()->has('error')): ?>
    <div class="alert alert-warning" role="alert">
        <?= session()->getFlashdata('error') ?>
    </div>
<?php endif; ?>

<div class="text-center">
    <main class="form-signin w-25 m-auto">
        <form action="/user/login" method="post">
            <?= csrf_field() ?>
            <img class="img-fluid" src="/E-RUANG.svg" alt="" width="250" height="250">
            <h1 class="h3 mb-3 fw-normal">Please sign in</h1>

            <div class="form-floating mb-3">
                <input type="text" name="username" class="form-control" id="username" placeholder="Username" required>
                <label for="username">Username</label>
            </div>
            <div class="form-floating mb-3">
                <input type="password" name="password" class="form-control" id="password" placeholder="Password"
                    required>
                <label for="password">Password</label>
            </div>
            <div class="btn-group" role="group" aria-label="Login-SignUp">
                <button type="submit" class="btn btn-lg btn-primary mb-3">Login</button>
                <a class="btn btn-lg btn-secondary mb-3" href="/signup" role="button">Sign Up</a>
            </div>
            <p class="mt-5 mb-3 text-body-secondary">&copy; 2023–2023</p>
        </form>
    </main>
</div>