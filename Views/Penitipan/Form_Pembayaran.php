<?php include COMPONENT_PATH . 'Layout_Header.php'; ?>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center justify-content-between">
                                <h3 class="card-title">Form Tambah User</h3>
                                <a href="<?= BASE_URL ?>penitipan" class="btn btn-danger btn-xs">Tabel Data Penitipan</a>
                            </div>
                        </div>

                        <div class="card-body">
                            <form action="<?= BASE_URL ?>penitipan/pembayaran/update" method="POST" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-sm-12 col-md-4">
                                        <div class="border rounded p-2 text-sm">
                                            <p class="mb-0"><span class="text-danger">*</span>Pembayaran yang bisa dilakukan di tempat: </p>
                                            <p class="mb-0">> Qris</p>
                                            <p class="mb-0">> Cash</p>
                                            <p class="mb-0">> Lainnya</p>
                                        </div>
                                        <input type="hidden" name="id_transaksi" value="<?= $pembayaran['id_transaksi'] ?>">
                                        <input type="hidden" name="id_penitipan" value="<?= $pembayaran['id_penitipan'] ?>">

                                        <div class="form-group mb-1">
                                            <label for="biaya-layanan" class="form-label mb-0">Biaya Layanan</label>
                                            <input type="text" id="biaya-layanan" name="biaya_layanan" class="form-control form-control-sm" value="Rp<?= number_format($pembayaran['total_biaya']) ?>" readonly>
                                        </div>

                                        <div class="form-group">
                                            <label for="metode-pembayaran" class="form-label mb-0">Metode Pembayaran<span class="text-danger">*</span></label>
                                            <select id="metode-pembayaran" class="form-control form-control-sm" name="metode_pembayaran" autofocus>
                                                <option disabled selected>Default Selected</option>
                                                <option value="va">Virtual Account</option>
                                                <option value="transfer_bank">Transfer Bank</option>
                                                <option value="qris">Qris</option>
                                                <option value="e_wallet">E-Wallet</option>
                                                <option value="cash">Cash</option>
                                                <option value="lainnya">Lainnya</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="bukti-transaksi" class="form-label mb-0">Bukti Transaksi<span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" name="bukti_transfer" id="exampleInputFile">
                                                    <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                                </div>
                                            </div>
                                        </div>

                                        <div>
                                            <button class="btn btn-primary btn-sm">Kirim</button>
                                        </div>
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
