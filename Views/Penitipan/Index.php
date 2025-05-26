<?php include COMPONENT_PATH . 'Layout_Header.php'; ?>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header d-flex align-items-center justify-content-between">
                            <a href="<?= BASE_URL ?>penitipan/create" class="btn btn-primary btn-xs">Ajukan Penitipan</a>
                        </div>
                        <div class="card-body">
                            <table id="data-user" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nomor Loker</th>
                                        <th>Customer</th>
                                        <th>Tanggal Penitipan</th>
                                        <th>Biaya</th>
                                        <th>Status Penitipan</th>
                                        <?php if ($role === 'admin') : ?>
                                            <th>Status Pembayaran</th>
                                        <?php endif; ?>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($data_penitipan)) : ?>
                                        <?php $no = 1; ?>
                                        <?php foreach ($data_penitipan as $row) : ?>
                                            <tr>
                                                <td><?= $no++ ?></td>
                                                <td><?= htmlspecialchars($row['nomor_loker']) ?></td>
                                                <td>
                                                    <?= ucfirst($row['nama_lengkap']) ?>
                                                </td>
                                                <td>
                                                    <?= dateCustom($row['tanggal_penitipan']) ?>
                                                </td>
                                                <td>
                                                    <?php if ($row['biaya_layanan'] === null) : ?>
                                                        <?php if ($role === 'admin') : ?>
                                                            <?php if ($row['status_penitipan'] === 'batal') : ?>
                                                                Pengajuan Penitipan Dibatalkan
                                                            <?php else : ?>
                                                                <form action="<?= BASE_URL ?>penitipan/transaksi/update-biaya" method="POST">
                                                                    <input type="hidden" name="id_transaksi" value="<?= $row['id_transaksi'] ?>">
                                                                    <div class="input-group">
                                                                        <div class="form-group mr-2">
                                                                            <input type="number" name="nominal" class="form-control form-control-sm" placeholder="Biaya Layanan">
                                                                        </div>
                                                                        <div>
                                                                            <button type="submit" class="btn btn-primary btn-xs">Update</button>
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            <?php endif; ?>
                                                        <?php else : ?>
                                                            <?php if ($row['status_pembayaran'] === 'batal') : ?>
                                                                Pengajuan Penitipan Dibatalkan
                                                            <?php else : ?>
                                                                Sedang Menunggu Admin
                                                            <?php endif; ?>
                                                        <?php endif; ?>
                                                    <?php else : ?>
                                                        Rp<?= number_format($row['biaya_layanan']) ?>
                                                        <?php if ($row['status_pembayaran'] === 'refund') : ?>
                                                            (Biaya akan direfund)
                                                        <?php endif; ?>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <span
                                                        class="
                                                            badge
                                                            <?php if ($row['status_penitipan'] === 'selesai') : ?>
                                                                badge-success
                                                            <?php elseif ($row['status_penitipan'] === 'aktif') : ?>
                                                                badge-primary
                                                            <?php elseif ($row['status_penitipan'] === 'pending') : ?>
                                                                badge-warning
                                                            <?php elseif ($row['status_penitipan'] === 'batal') : ?>
                                                                badge-danger
                                                            <?php else : ?>
                                                                badge-secondary
                                                            <?php endif; ?>
                                                        "
                                                    >
                                                        <?php if ($row['status_penitipan'] === 'batal') : ?>
                                                            Dibatalkan
                                                        <?php else : ?>
                                                            <?= ucfirst($row['status_penitipan']) ?>
                                                        <?php endif; ?>
                                                    </span>
                                                </td>
                                                <?php if ($role === 'admin') : ?>
                                                    <td>
                                                        <?php if ($row['status_pembayaran'] === 'pending') : ?>
                                                            <span class="badge badge-warning">
                                                                <?= ucfirst($row['status_pembayaran']) ?>
                                                            </span>
                                                        <?php elseif ($row['status_pembayaran'] === 'selesai') : ?>
                                                            <span class="badge badge-success">
                                                                <?= ucfirst($row['status_pembayaran']) ?>
                                                            </span>
                                                        <?php elseif ($row['status_pembayaran'] === 'refund') : ?>
                                                            <span class="badge badge-danger">
                                                                <?= ucfirst($row['status_pembayaran']) ?>
                                                            </span>
                                                        <?php else : ?>
                                                            <span class="badge badge-secondary">Tidak ada pembayaran</span>
                                                        <?php endif; ?>
                                                    </td>
                                                <?php endif; ?>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <?php if ($role === 'admin') : ?>
                                                            <?php if ($row['status_penitipan'] === 'pending') : ?>
                                                                <form action="<?= BASE_URL ?>penitipan/pengajuan" method="POST">
                                                                    <input type="hidden" name="penitipan_id" value="<?= $row['id_penitipan'] ?>">
                                                                    <button class="btn btn-success btn-xs mr-1">Approve</button>
                                                                </form>
                                                            <?php elseif ($row['status_penitipan'] === 'batal') : ?>
                                                            <?php else : ?>
                                                                <form action="<?= BASE_URL ?>penitipan/pengajuan" method="POST">
                                                                    <input type="hidden" name="penitipan_id" value="<?= $row['id_penitipan'] ?>">
                                                                    <button class="btn btn-success btn-xs mr-1">Selesai</button>
                                                                </form>
                                                            <?php endif; ?>
                                                        <?php else : ?>
                                                            <?php if (
                                                                $row['status_pembayaran'] !== 'selesai' &&
                                                                $row['status_pembayaran'] !== 'batal' &&
                                                                $row['status_pembayaran'] !== 'refund' &&
                                                                $row['biaya_layanan'] !== null
                                                            ) : ?>
                                                                <a href="<?= BASE_URL ?>penitipan/pembayaran-user?id=<?= $row['id_penitipan'] ?>" class="btn btn-info btn-xs mr-1">Bayar</a>
                                                            <?php endif; ?>
                                                        <?php endif; ?>

                                                        <a href="<?= BASE_URL ?>penitipan/detail?id=<?= $row['id_penitipan'] ?>" class="btn btn-primary btn-xs mr-1"><i class="fas fa-eye"></i></a>

                                                        <?php if ($row['status_penitipan'] !== 'selesai' && $row['status_penitipan'] !== 'batal') : ?>
                                                            <a href="<?= BASE_URL ?>penitipan/cancel?id=<?= $row['id_penitipan'] ?>" onclick="return confirm('Yakin ingin membatalkan penitipan ini?')" class="btn btn-danger btn-xs">Cancel</a>
                                                        <?php endif; ?>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else : ?>
                                        <tr>
                                            <td colspan="6" class="text-center">Belum ada data</td>
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
