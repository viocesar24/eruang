<?php if (session()->has('signupBerhasil')): ?>
    <div class="alert alert-success alert-dismissible" role="alert">
        <div>
            <?= session()->getFlashdata('signupBerhasil') ?>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
    </div>
<?php elseif (session()->has('error')): ?>
    <div class="alert alert-warning alert-dismissible" role="alert">
        <div>
            <?= session()->getFlashdata('error') ?>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
    </div>
<?php endif; ?>

<div class="container h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col col-xl-10">
            <div class="card" style="border-radius: 1rem;">
                <div class="row g-0">
                    <div class="col-md-6 col-lg-5 d-none d-md-block">
                        <img src="/office.webp" alt="login form" class="img-fluid"
                            style="border-radius: 1rem 0 0 1rem;" />
                    </div>
                    <div class="col-md-6 col-lg-7 d-flex align-items-center">
                        <div class="card-body p-4 p-lg-5 text-black">

                            <form action="/signup" method="post">
                                <?= csrf_field() ?>

                                <div class="d-flex align-items-center mb-3 pb-1">
                                    <img class="img-fluid me-3" src="/E-RUANG-LOGO.svg" alt="" width="50" height="50">
                                    <span class="h1 fw-bold mb-0">E-RUANG</span>
                                </div>

                                <h5 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px;">Daftarkan Diri Anda</h5>

                                <div class="form-outline mb-4">
                                    <label class="form-label" for="username">Username</label>
                                    <input type="text" name="username" id="username"
                                        class="form-control form-control-lg" required />
                                </div>

                                <div class="form-outline mb-4">
                                    <label class="form-label" for="password">Kata Sandi</label>
                                    <input type="password" name="password" id="password"
                                        class="form-control form-control-lg" required />
                                </div>

                                <div class="form-outline mb-4">
                                    <label class="form-label" for="pegawai_id">Pilih Nama Pegawai</label>
                                    <select name="pegawai_id" id="pegawai_id" class="form-select form-select-lg"
                                        aria-label="Pilih Nama Pegawai..." required>
                                        <option selected disabled>Pilih Nama Pegawai...</option>
                                        <?php if (!empty($filtered_pegawai) && is_array($filtered_pegawai)): ?>
                                            <?php foreach ($filtered_pegawai as $item): ?>
                                                <option name="pegawai_id" value="<?= esc($item['id']) ?>"><?= esc($item['nama']) ?></option>
                                            <?php endforeach ?>
                                        <?php else: ?>
                                            <option selected>Tidak Ada Daftar Pegawai</option>
                                        <?php endif ?>
                                    </select>
                                </div>

                                <div class="pt-1 mb-4">
                                    <div class="d-grid gap-2">
                                        <button class="btn btn-dark btn-lg btn-block" type="submit">Daftar</button>
                                    </div>
                                </div>

                                <p class="pb-lg-2" style="color: #393f81;">Sudah punya akun? <a href="/login"
                                        style="color: #393f81;">Silahkan Login</a></p>

                            </form>

                            <?php if (isset($data['errors'])): ?>
                                <ul class="alert alert-danger">
                                    <?php foreach ($data['errors'] as $error): ?>
                                        <li>
                                            <?php echo $error; ?>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php endif; ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>