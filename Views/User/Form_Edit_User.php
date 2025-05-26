<?php include COMPONENT_PATH . 'Layout_Header.php'; ?>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center justify-content-between">
                                <h3 class="card-title">Form Edit User</h3>
                                <a href="<?= BASE_URL ?>user" class="btn btn-danger btn-xs">Tabel User</a>
                            </div>
                        </div>

                        <div class="card-body">
                            <form action="<?= BASE_URL ?>user/update" method="POST">
                                <div class="row">
                                    <div class="col-sm-12 col-md-4">
                                        <input type="hidden" name="id" value="<?= htmlspecialchars($user['id']) ?>">
                                        <input type="hidden" name="type_page" value="edit_user">

                                        <div class="form-group">
                                            <label for="nama-lengkap" class="form-label mb-0">Nama Lengkap</label>
                                            <input type="text" id="nama-lengkap" name="nama_lengkap" class="form-control form-control-sm" value="<?= htmlspecialchars($user['nama_lengkap']) ?>" autofocus>
                                        </div>

                                        <div class="form-group">
                                            <label for="email" class="form-label mb-0">Email</label>
                                            <input type="email" id="email" name="email" class="form-control form-control-sm" value="<?= htmlspecialchars($user['email']) ?>" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="no-telepon" class="form-label mb-0">Nomor Telepon</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">+62</span>
                                                </div>
                                                <input type="number" id="no-telepon" name="no_telp" class="form-control" value="<?= htmlspecialchars($user['no_telp']) ?>">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="alamat" class="form-label mb-0">Alamat</label>
                                            <textarea id="alamat" name="alamat" class="form-control form-control-sm"><?= htmlspecialchars($user['alamat']) ?></textarea>
                                        </div>

                                        <?php if ($user_id === 1) : ?>
                                            <div class="form-group">
                                                <label for="role" class="form-label mb-0">Role</label>
                                                <select id="role" name="role" class="form-control form-control-sm">
                                                    <option value="user" <?= $user['role'] === 'user' ? 'selected' : '' ?>>User</option>
                                                    <option value="admin" <?= $user['role'] === 'admin' ? 'selected' : '' ?>>Admin</option>
                                                </select>
                                            </div>
                                        <?php endif; ?>

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
