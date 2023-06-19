<?php if (session()->has('pinjamBerhasil')): ?>
    <div class="alert alert-success alert-dismissible" role="alert">
        <div>
            <?= session()->getFlashdata('pinjamBerhasil') ?>
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
    <div class="px-4 py-5 px-md-5 bg-body-tertiary">
        <div class="container">
            <div class="row gx-lg-5 align-items-center">
                <div class="col-lg-6 mb-5 mb-lg-0 text-center text-lg-start">
                    <h1 class="my-5 display-3 fw-bold ls-tight">
                        Formulir<br />
                        <span class="text-primary">Peminjaman Ruangan</span>
                    </h1>
                    <p style="color: hsl(217, 10%, 50.8%)">
                        Cek daftar peminjaman pada Beranda. Pastikan waktu dan ruangan yang ingin Anda pinjam belum
                        dipinjam oleh orang lain.
                        Hubungi Admin jika mengalami kesulitan.
                    </p>
                </div>

                <div class="col-lg-6 mb-5 mb-lg-0">
                    <div class="card">
                        <div class="card-body py-5 px-md-5">

                            <form action="/peminjaman/create" method="post">
                                <?= csrf_field() ?>

                                <?php if (!session()->has('pegawai_id') || (session()->get('pegawai_id') != 58 && session()->get('pegawai_id') != 35)) { ?>
                                    <!-- Nama Pegawai sudah ditentukan berdasarkan siapa yang login -->
                                    <div class="form-outline mb-3">
                                        <div class="form-outline">
                                            <label class="form-label" for="inputGroupSelect01">Nama Pegawai</label>
                                            <select name="id_pegawai" class="form-select" id="inputGroupSelect01">
                                                <option name="id_pegawai" value="<?= esc($user['pegawai_id']) ?>" selected>
                                                    <?= esc($user['nama']) ?></option>
                                            </select>
                                        </div>
                                    </div>
                                <?php } else { ?>
                                    <!-- Menampilkan input semua nama pegawai jika Admin yang login -->
                                    <div class="form-outline mb-3">
                                        <div class="form-outline">
                                            <label class="form-label" for="inputGroupSelect01">Nama Pegawai</label>
                                            <select name="id_pegawai" class="form-select" id="inputGroupSelect01">
                                                <option selected disabled>Pilih Nama Pegawai...</option>
                                                <?php if (!empty($pegawai) && is_array($pegawai)): ?>
                                                    <?php foreach ($pegawai as $pegawai_item): ?>
                                                        <option name="id_pegawai" value="<?= esc($pegawai_item['id']) ?>"><?= esc($pegawai_item['nama']) ?></option>
                                                    <?php endforeach ?>
                                                <?php else: ?>
                                                    <option selected>Tidak Ada Daftar Pegawai</option>
                                                <?php endif ?>
                                            </select>
                                        </div>
                                    </div>
                                <?php } ?>

                                <!-- Nama Ruangan yang dipinjam -->
                                <div class="form-outline mb-3">
                                    <label class="form-label" for="id_ruangan">Nama Ruangan</label>
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
                                </div>

                                <!-- Nama Acara atau Detail Acara Peminjam -->
                                <div class="form-outline mb-3">
                                    <label class="form-label" for="detail_acara">Tujuan Pemakaian</label>
                                    <textarea class="form-control" name="acara" id="detail_acara"
                                        aria-label="Tujuan Pemakaian" required></textarea>
                                </div>

                                <!-- Tanggal Peminjaman -->
                                <div class="form-outline mb-3">
                                    <label class="form-label" for="tanggal_peminjaman">Tanggal Peminjaman:</label>
                                    <input type="text" class="form-control" id="tanggal_peminjaman" name="tanggal"
                                        required>
                                </div>

                                <!-- Waktu Kapan Ruangan Akan Dipinjam -->
                                <div class="form-outline mb-3">
                                    <label class="form-label" for="waktu_mulai">Waktu Mulai Peminjaman</label>
                                    <input type="text" id="waktu_mulai" name="waktu_mulai" class="form-control"
                                        onfocus="(this.type='time')" onblur="if(this.value==''){this.type='text'}"
                                        required>
                                </div>

                                <!-- Waktu Kapan Ruangan Selesai Dipinjam -->
                                <div class="form-outline mb-3">
                                    <label class="form-label" for="waktu_selesai">Waktu Selesai Peminjaman</label>
                                    <input type="text" id="waktu_selesai" name="waktu_selesai" class="form-control"
                                        onfocus="(this.type='time')" onblur="if(this.value==''){this.type='text'}"
                                        required>
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