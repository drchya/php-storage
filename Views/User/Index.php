<?php include COMPONENT_PATH . 'Layout_Header.php'; ?>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header d-flex align-items-center justify-content-between">
                            <a href="<?= BASE_URL ?>user/create" class="btn btn-primary btn-xs">Tambah Data User</a>
                        </div>
                        <div class="card-body">
                            <table id="data-user" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nama Lengkap</th>
                                        <th>Email</th>
                                        <th>Telepon</th>
                                        <th>Alamat</th>
                                        <th>Role</th>
                                        <?php if ($user_id === 1) : ?>
                                            <th>Update Terakhir</th>
                                        <?php endif; ?>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($users)) : ?>
                                        <?php $no = 1; ?>
                                        <?php foreach ($users as $user) : ?>
                                            <tr>
                                                <td><?= $no++ ?></td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <span><?= htmlspecialchars($user['nama_lengkap']) ?></span>
                                                        <?php if ($user_id === $user['id']) : ?>
                                                            <span class="badge badge-success ml-1">Sedang Login</span>
                                                        <?php endif;?>
                                                    </div>
                                                </td>
                                                <td><?= htmlspecialchars($user['email']) ?></td>
                                                <td><?= htmlspecialchars($user['no_telp']) ?></td>
                                                <td><?= htmlspecialchars($user['alamat']) ?></td>
                                                <td><?= htmlspecialchars(ucfirst($user['role'])) ?></td>
                                                <?php if ($user_id === 1) : ?>
                                                    <?php if (empty($user['updated_at'])) : ?>
                                                        <td><?= dateCustom($user['created_at']) ?></td>
                                                    <?php else : ?>
                                                        <td><?= dateCustom($user['updated_at']) ?></td>
                                                    <?php endif; ?>
                                                <?php endif;  ?>
                                                <td>
                                                    <?php if ($user_id === $user['id']) : ?>
                                                        <span>#</span>
                                                    <?php elseif ($user['id'] === 1) : ?>
                                                        <span>Akses terbatas</span>
                                                    <?php else : ?>
                                                        <div class="d-flex align-items-center">
                                                            <a href="<?= BASE_URL ?>user/edit?id=<?= $user['id'] ?>" class="btn btn-warning btn-xs mr-1"><i class="fas fa-pencil-alt"></i></a>
                                                            <a href="<?= BASE_URL ?>user/delete?id=<?= $user['id'] ?>" onclick="return confirm('Yakin ingin menghapus user ini?')" class="btn btn-danger btn-xs"><i class="fas fa-trash"></i></a>
                                                        </div>
                                                    <?php endif; ?>
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
