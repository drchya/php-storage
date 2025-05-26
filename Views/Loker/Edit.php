<?php include COMPONENT_PATH . 'Layout_Header.php'; ?>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center justify-content-between">
                                <h3 class="card-title">Form Tambah Loker</h3>
                                <a href="<?= BASE_URL ?>loker" class="btn btn-danger btn-xs">Tabel Loker</a>
                            </div>
                        </div>

                        <div class="card-body">
                            <form action="<?= BASE_URL ?>loker/update" method="POST">
                                <input type="hidden" name="id" value="<?= $loker['id'] ?>">
                                <div class="row">
                                    <div class="col-sm-12 col-md-4">
                                        <div class="form-group">
                                            <label for="nomor-loker" class="form-label mb-0">Nomor Loker<span class="text-danger">*</span></label>
                                            <input type="text" id="nomor-loker" name="nomor_loker" class="form-control form-control-sm" value="<?= $loker['nomor_loker'] ?>" required autofocus>
                                        </div>

                                        <div class="form-group">
                                            <label for="kapasitas" class="form-label mb-0">Kapasitas<span class="text-danger">*</span></label>
                                            <input type="number" id="kapasitas" name="kapasitas" class="form-control form-control-sm" value="<?= $loker['kapasitas'] ?>" required>
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
