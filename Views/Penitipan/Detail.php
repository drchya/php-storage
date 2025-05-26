<?php include COMPONENT_PATH . 'Layout_Header.php'; ?>
<section class="content">
    <div class="container-fluid">
    <div class="row">
        <div class="col-12">
        <div class="callout callout-info">
            <h5><i class="fas fa-info"></i> Info:</h5>
            Detail penitipan barang dan loker.
        </div>

        <div class="invoice p-3 mb-3">
            <div class="row">
                <div class="col-12">
                    <h4>
                        <i class="fas fa-lock"></i> Detail Penitipan
                        <small class="float-right">Tanggal Penitipan: <?= dateCustom($penitipan['tanggal_penitipan']) ?></small>
                    </h4>
                </div>
            </div>

            <div class="row invoice-info">
                <div class="col-sm-12 col-md-6 mb-2">
                    <strong>Informasi Penitipan</strong><br>
                    <b>Loker:</b> <?= htmlspecialchars($penitipan['nomor_loker']) ?><br>
                    <b>Tanggal Pengambilan:</b> <?= dateCustom($penitipan['tanggal_pengambilan']) ?><br>
                    <b>Status Pengajuan:</b>
                    <?php if ($penitipan['status_penitipan'] === 'batal') : ?>
                        Pengajuan telah dibatalkan<br />
                    <?php else : ?>
                        <?= htmlspecialchars(ucwords(str_replace('_', ' ', $penitipan['status_penitipan']))) ?><br>
                    <?php endif; ?>

                    <b>Status Pembayaran: </b>
                    <?php if ($transaksi['status_pembayaran'] === 'refund') : ?>
                        Biaya akan direfund<br />
                    <?php elseif ($transaksi['status_pembayaran'] === 'batal') : ?>
                        Pembayaran telah dibatalkan<br />
                    <?php else : ?>
                        <?= ucfirst($transaksi['status_pembayaran']) ?><br />
                    <?php endif; ?>

                    <b>Biaya Layanan: </b>
                    <?php if ($transaksi['status_pembayaran'] === 'batal'): ?>
                        Penitipan dibatalkan
                    <?php elseif (is_null($transaksi['biaya_layanan'])): ?>
                        Sedang menunggu admin
                    <?php else: ?>
                        Rp<?= number_format($transaksi['biaya_layanan']) ?>
                    <?php endif; ?>
                </div>
                <div class="col-sm-12 col-md-6 mb-2">
                    <strong>Informasi Customer</strong><br />
                    <b>Nama Lengkap: </b> <?= $nama_lengkap ?><br />
                    <b>Nomor Telepon: </b> <?= $no_telp ?><br />
                    <b>Alamat: </b> <?= $alamat ?><br />
                </div>
            </div>

            <!-- Table Barang -->
            <div class="row mt-3">
                <div class="col-12 table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Barang</th>
                                <th>Jenis</th>
                                <th>Berat (kg)</th>
                                <th>Deskripsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($barangs as $i => $barang): ?>
                                <tr>
                                    <td><?= $i + 1 ?></td>
                                    <td><?= htmlspecialchars($barang['nama']) ?></td>
                                    <td><?= htmlspecialchars($barang['jenis']) ?></td>
                                    <td><?= htmlspecialchars($barang['berat']) ?></td>
                                    <td><?= htmlspecialchars($barang['deskripsi']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Action -->
            <div class="row no-print mt-4">
                <div class="col-12">
                    <a href="<?= BASE_URL ?>penitipan" class="btn btn-danger btn-xs float-right">Kembali ke Tabel</a>
                </div>
            </div>
        </div>
        </div>
    </div>
    </div>
</section>
<?php include COMPONENT_PATH . 'Layout_Footer.php'; ?>
