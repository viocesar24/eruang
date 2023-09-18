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
                        <img src="/office.webp" alt="login form" class="img-fluid" style="border-radius: 1rem 0 0 1rem;" />
                    </div>
                    <div class="col-md-6 col-lg-7 d-flex align-items-center">
                        <div class="card-body p-4 p-lg-5 text-black">
                            <h1>Pendaftaran sementara ditutup, mohon hubungi Admin untuk keterangan lebih lanjut.</h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>