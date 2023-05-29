<?php if (session()->has('pinjamBerhasil')): ?>
    <div class="alert alert-success alert-dismissible" role="alert">
        <div>
            <?= session()->getFlashdata('pinjamBerhasil') ?>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php elseif (session()->has('pinjamGagal')): ?>
    <div class="alert alert-danger alert-dismissible" role="alert">
        <div>
            <?= session()->getFlashdata('pinjamGagal') ?>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php elseif (session()->has('error')): ?>
    <div class="alert alert-danger alert-dismissible" role="alert">
        <div>
            <?= session()->getFlashdata('error') ?>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<?php if (validation_errors()): ?>
    <div class="alert alert-danger">
        <?= validation_list_errors() ?>
    </div>
<?php endif ?>

<!-- New -->
<!-- Section: Design Block -->
<section class="">
    <!-- Jumbotron -->
    <div class="px-4 py-5 px-md-5 text-center text-lg-start bg-body-tertiary">
        <div class="container">
            <div class="row gx-lg-5 align-items-center">
                <div class="col-lg-6 mb-5 mb-lg-0">
                    <h1 class="my-5 display-3 fw-bold ls-tight">
                        Formulir<br />
                        <span class="text-primary">Peminjaman Ruangan</span>
                    </h1>
                    <p style="color: hsl(217, 10%, 50.8%)">
                        Cek daftar peminjaman pada Beranda. Pastikan waktu dan ruangan yang ingin Anda pinjam belum dipinjam oleh orang lain.
                        Hubungi Admin jika mengalami kesulitan.
                    </p>
                </div>

                <div class="col-lg-6 mb-5 mb-lg-0">
                    <div class="card">
                        <div class="card-body py-5 px-md-5">

                            <form action="/peminjaman/create" method="post" class="needs-validation" novalidate>
                                <?= csrf_field() ?>

                                <!-- Nama Pegawai sudah ditentukan berdasarkan siapa yang login -->
                                <div class="form-outline mb-1">
                                    <div class="form-outline">
                                        <select name="id_pegawai" class="form-select" id="inputGroupSelect01">
                                            <option name="id_pegawai" value="<?= esc($user['pegawai_id']) ?>" selected>
                                                <?= esc($user['nama']) ?>
                                            </option>
                                        </select>
                                        <label class="form-label" for="inputGroupSelect01">Nama Pegawai</label>
                                    </div>
                                </div>

                                <!-- Nama Ruangan yang dipinjam -->
                                <div class="form-outline mb-1">
                                    <select name="id_ruangan" class="form-select" id="inputGroupSelect02">
                                        <option value="<?= null ?>" selected>Pilih Ruangan...</option>
                                        <?php if (!empty($ruangan) && is_array($ruangan)): ?>
                                            <?php foreach ($ruangan as $ruangan_item): ?>
                                                <option name="id_ruangan" value="<?= esc($ruangan_item['id']) ?>"><?= esc($ruangan_item['nama']) ?>
                                                </option>
                                            <?php endforeach ?>
                                        <?php else: ?>
                                            <h3>Tidak Ada Ruangan</h3>
                                            <p>Unable to find any ruangan for you.</p>
                                        <?php endif ?>
                                    </select>
                                    <label class="form-label" for="id_ruangan">Nama Ruangan</label>
                                </div>

                                <!-- Nama Acara atau Detail Acara Peminjam -->
                                <div class="form-outline mb-1">
                                    <textarea class="form-control" name="acara" id="detail_acara"
                                        aria-label="Tujuan Pemakaian" placeholder="Tujuan Pemakaian"
                                        required></textarea>
                                    <label class="form-label" for="detail_acara">Tujuan Pemakaian</label>
                                </div>

                                <!-- Tanggal Peminjaman -->
                                <div class="form-outline mb-1">
                                    <input type="text" id="tanggal_peminjaman" name="tanggal" class="form-control"
                                        placeholder="Tanggal Peminjaman" onfocus="(this.type='date')"
                                        onblur="if(this.value==''){this.type='text'}" min="<?= date('Y-m-d') ?>"
                                        required>
                                    <label class="form-label" for="tanggal_peminjaman">Tanggal Peminjaman</label>
                                </div>

                                <!-- Waktu Kapan Ruangan Akan Dipinjam -->
                                <div class="form-outline mb-1">
                                    <input type="text" id="waktu_mulai" name="waktu_mulai" class="form-control"
                                        placeholder="Waktu Mulai Peminjaman" onfocus="(this.type='time')"
                                        onblur="if(this.value==''){this.type='text'}" required>
                                    <label class="form-label" for="waktu_mulai">Waktu Mulai Peminjaman</label>
                                </div>

                                <!-- Waktu Kapan Ruangan Selesai Dipinjam -->
                                <div class="form-outline mb-1">
                                    <input type="text" id="waktu_selesai" name="waktu_selesai" class="form-control"
                                        placeholder="Waktu Selesai Peminjaman" onfocus="(this.type='time')"
                                        onblur="if(this.value==''){this.type='text'}" required>
                                    <label class="form-label" for="waktu_selesai">Waktu Selesai Peminjaman</label>
                                </div>

                                <!-- Submit button -->
                                <div class="d-grid gap-2">
                                    <input type="submit" name="submit" value="Buat Peminjaman Baru"
                                        class="btn btn-primary mb-1">
                                </div>

                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Jumbotron -->
</section>
<!-- Section: Design Block -->