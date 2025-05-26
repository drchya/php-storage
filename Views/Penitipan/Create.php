<?php include COMPONENT_PATH . 'Layout_Header.php'; ?>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center justify-content-between">
                                <h3 class="card-title">Form Ajukan Penitipan</h3>
                                <a href="<?= BASE_URL ?>penitipan" class="btn btn-danger btn-xs">Data Penitipan</a>
                            </div>
                        </div>

                        <div class="card-body">
                            <form action="<?= BASE_URL ?>penitipan/store" method="POST">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <h6 class="text-secondary text-uppercase mb-0" style="font-weight: 600">Data Barang</h6>
                                        <hr class="my-2" />
                                    </div>

                                    <div id="barang-wrapper" class="col-sm-12">
                                        <div class="row barang-item mb-2">
                                            <div class="col-md-3">
                                                <label for="jenis-barang" class="form-label mb-0">Nama Barang<span class="text-danger">*</span></label>
                                                <input type="text" name="nama_barang[]" class="form-control form-control-sm" placeholder="Nama Barang" required>
                                            </div>

                                            <div class="col-md-3">
                                                <label for="jenis-barang" class="form-label mb-0">Jenis Barang<span class="text-danger">*</span></label>
                                                <select name="jenis_barang[]" class="form-control form-control-sm" required>
                                                    <option disabled selected>Default Selected</option>
                                                    <option value="pakaian">Pakaian</option>
                                                    <option value="elektronik">Elektronik</option>
                                                    <option value="dokumen">Dokumen</option>
                                                    <option value="makanan">Makanan</option>
                                                    <option value="sepatu">Sepatu</option>
                                                    <option value="tas">Tas</option>
                                                    <option value="mainan">Mainan</option>
                                                    <option value="lainnya">Lainnya</option>
                                                </select>
                                            </div>

                                            <div class="col-md-2">
                                                <label for="jenis-barang" class="form-label mb-0">Berat Barang<span class="text-danger">*</span></label>
                                                <input type="number" name="berat_barang[]" min="0.00" class="form-control form-control-sm berat-barang" step="0.01" placeholder="Berat (kg)" required>
                                            </div>
                                            <div class="col-md-3">
                                                <label for="jenis-barang" class="form-label mb-0">Deskripsi Barang<span class="text-danger">*</span></label>
                                                <textarea name="deskripsi_barang[]" class="form-control form-control-sm" rows="1" placeholder="Deskripsi Barang"></textarea>
                                            </div>
                                            <div class="col-md-1 d-flex align-items-end mt-2">
                                                <button type="button" class="btn btn-danger btn-sm remove-barang">&minus;</button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-12 mb-2">
                                        <button type="button" class="btn btn-xs btn-secondary" id="add-barang">Tambah Barang</button>
                                    </div>

                                    <div class="col-sm-12 col-md-4">
                                        <div class="form-group">
                                            <label for="tanggal-penitipan" class="form-label mb-0">Tanggal Penitipan</label>
                                            <div class="input-group date" id="tanggal-penitipan" data-target-input="nearest">
                                                <input type="text" name="tanggal_penitipan" class="form-control form-control-sm datetimepicker-input" data-target="#tanggal-penitipan" placeholder="Tanggal Penitipan" required />
                                                <div class="input-group-append" data-target="#tanggal-penitipan" data-toggle="datetimepicker">
                                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-12 col-md-4">
                                        <div class="form-group">
                                            <label for="tanggal-pengambilan" class="form-label mb-0">Tanggal Pengambilan</label>
                                            <div class="input-group date" id="tanggal-pengambilan" data-target-input="nearest">
                                                <input type="text" name="tanggal_pengambilan" class="form-control form-control-sm datetimepicker-input" data-target="#tanggal-pengambilan" placeholder="Tanggal Penitipan" required />
                                                <div class="input-group-append" data-target="#tanggal-pengambilan" data-toggle="datetimepicker">
                                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-12 col-md-4">
                                        <div class="form-group">
                                            <label for="total-berat" class="form-label mb-0">Total Berat Barang<span class="text-danger">*</span></label>
                                            <input type="number" id="total-berat" step="0.01" min="0.00" class="form-control form-control-sm" placeholder="Berat Barang" required>
                                        </div>
                                    </div>

                                    <div class="col-sm-12">
                                        <h6 class="text-secondary text-uppercase mb-0" style="font-weight: 600">Data Customer </h6>
                                        <p class="mb-0 text-secondary text-xs">Data di bawah menggunakan data default user<span class="text-danger">*</span></p>
                                        <hr class="mb-2 mt-0" />
                                    </div>

                                    <div class="col-sm-12 col-md-4">
                                        <div class="form-group">
                                            <label for="nama-customer" class="form-label mb-0">Nama Customer<span class="text-danger">*</span></label>
                                            <input type="text" id="nama-customer" name="nama_customer" class="form-control form-control-sm" placeholder="Nama Customer" value="<?= $user['nama_lengkap'] ?>" required>
                                        </div>
                                    </div>

                                    <div class="col-sm-12 col-md-4">
                                        <div class="form-group">
                                            <label for="email-customer" class="form-label mb-0">Email Customer<span class="text-danger">*</span></label>
                                            <input type="email" id="email-customer" name="email_customer" class="form-control form-control-sm" placeholder="Email Customer" value="<?= $user['email'] ?>" required>
                                        </div>
                                    </div>

                                    <div class="col-sm-12 col-md-4">
                                        <div class="form-group">
                                            <label for="nomor-telepon" class="form-label mb-0">Nomor Telepon<span class="text-danger">*</span></label>
                                            <input type="number" id="nomor-telepon" name="nomor_telepon" class="form-control form-control-sm" placeholder="Nomor Telepon" value="<?= $user['no_telp'] ?>" required>
                                        </div>
                                    </div>

                                    <div class="col-sm-12 col-md-5">
                                        <div class="form-group">
                                            <label for="alamat" class="form-label mb-0">Alamat<span class="text-danger">*</span></label>
                                            <textarea rows="1" type="text" id="alamat" name="alamat" class="form-control form-control-sm" placeholder="Alamat Customer" required><?= $user['alamat'] ?></textarea>
                                        </div>
                                    </div>

                                    <div class="col-sm-12 col-md-3">
                                        <div class="form-group">
                                            <label for="layanan-pengiriman" class="form-label mb-0">Layanan Pengiriman<span class="text-danger">*</span></label>
                                            <select id="layanan-pengiriman" name="layanan_pengiriman" class="form-control form-control-sm" placeholder="Alamat Customer" value="<?= $user['alamat'] ?>" required>
                                                <option selected disabled>Default Selected</option>
                                                <option value="pribadi">Pribadi</option>
                                                <option value="go_send">Go-Send</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-sm-12">
                                        <h6 class="text-secondary text-uppercase mb-0" style="font-weight: 600">Tempat Penyimpanan</h6>
                                        <div class="d-flex align-items-center my-1 text-xs">
                                            <div class="d-flex align-items-center mr-2">
                                                <i class="fas fa-square mr-1 text-secondary"></i>
                                                <span>Tersedia</span>
                                            </div>
                                            <div class="d-flex align-items-center mr-2">
                                                <i class="fas fa-square mr-1 text-primary"></i>
                                                <span>Booked</span>
                                            </div>
                                            <div class="d-flex align-items-center mr-2">
                                                <i class="fas fa-square mr-1 text-success"></i>
                                                <span>Dipilih</span>
                                            </div>
                                        </div>
                                        <hr class="mb-2 mt-0" />
                                    </div>

                                    <?php
                                        $groupedLokers = [];
                                        foreach ($lokers as $loker) {
                                            $row = strtoupper(substr($loker['nomor_loker'], 0, 1));
                                            $groupedLokers[$row][] = $loker;
                                        }
                                        ksort($groupedLokers);
                                    ?>

                                    <div class="container col-sm-12">
                                        <div class="row">
                                            <?php foreach ($groupedLokers as $row => $lokersInRow) : ?>
                                                <div class="col-md-12">
                                                    <div class="d-flex flex-wrap gap-2">
                                                        <?php foreach ($lokersInRow as $loker) : ?>
                                                            <div
                                                                class="
                                                                    card card-loker text-center p-2
                                                                    <?php if ($loker['status'] === 'kosong') echo 'bg-secondary' ?>
                                                                    <?php if ($loker['status'] === 'booked') echo 'bg-primary'; ?>
                                                                "
                                                                data-id="<?= $loker['id'] ?>"
                                                                data-nomor="<?= $loker['nomor_loker'] ?>"
                                                                data-status="<?= $loker['status'] ?>"
                                                                data-kapasitas="<?= $loker['kapasitas'] ?>"
                                                                onclick="selectLoker(this)"
                                                                style="
                                                                    width: 70px;
                                                                    height: 70px;
                                                                    font-size: 12px;
                                                                    cursor: pointer;
                                                                    transition: 0.3s;
                                                                "
                                                            >
                                                                <div class="d-flex flex-column align-items-center justify-content-center h-100">
                                                                    <strong><?= $loker['nomor_loker'] ?></strong>
                                                                    <small><?= $loker['kapasitas'] ?> kg</small>
                                                                </div>
                                                            </div>
                                                        <?php endforeach; ?>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>

                                    <input type="hidden" name="id_loker" id="id_loker" required>
                                    <input type="hidden" name="nomor_loker" id="nomor_loker" required>

                                    <div class="col-sm-12">
                                        <button class="btn btn-primary btn-sm">Kirim</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php include COMPONENT_PATH . 'Layout_Footer.php'; ?>
