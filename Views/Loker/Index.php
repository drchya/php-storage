<?php include COMPONENT_PATH . 'Layout_Header.php'; ?>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <form action="<?= BASE_URL ?>loker/store" method="POST">
                                <div class="row">
                                    <div class="col-sm-12 col-md-6">
                                        <div class="form-group mb-2">
                                            <label for="nomor-loker" class="form-label mb-0 text-sm">Nomor Loker<span class="text-danger">*</span></label>
                                            <input type="text" id="nomor-loker" name="nomor_loker" class="form-control form-control-sm" placeholder="Nomor Loker">
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <div class="form-group mb-2">
                                            <label for="kapasitas" class="form-label mb-0 text-sm">Kapasitas<span class="text-danger">*</span></label>
                                            <input type="number" id="kapasitas" name="kapasitas" class="form-control form-control-sm" placeholder="Kapasitas Loker">
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <button type="submit" class="btn btn-primary btn-xs">Tambah Data Loker</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="card-body">
                            <table id="data-user" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nomor Loker</th>
                                        <th class="d-flex align-items-center">Kapasitas <p class="font-weight-normal text-xs ml-1">/ KG</p></th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($lokers)) : ?>
                                        <?php $no = 1; ?>
                                        <?php foreach ($lokers as $loker) : ?>
                                            <tr>
                                                <td><?= $no++ ?></td>
                                                <td><?= $loker['nomor_loker'] ?></td>
                                                <td><?= $loker['kapasitas'] ?></td>
                                                <td>
                                                    <?php if ($loker['status'] === 'kosong') : ?>
                                                        <span class="badge badge-primary"><?= ucfirst($loker['status']) ?></span>
                                                    <?php elseif ($loker['status'] === 'booked') : ?>
                                                        <span class="badge badge-secondary"><?= ucfirst($loker['status']) ?></span>
                                                    <?php else : ?>
                                                        Tidak ada status
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <a href="<?= BASE_URL ?>loker/edit?id=<?= $loker['id'] ?>" class="btn btn-warning btn-xs mr-1"><i class="fas fa-pencil-alt"></i></a>
                                                        <a href="<?= BASE_URL ?>loker/delete?id=<?= $loker['id'] ?>" onclick="return confirm('Yakin ingin menghapus user ini?')" class="btn btn-danger btn-xs"><i class="fas fa-trash"></i></a>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else : ?>
                                        <tr>
                                            <td colspan="5" class="text-center">Belum ada data</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php include COMPONENT_PATH . 'Layout_Footer.php'; ?>
