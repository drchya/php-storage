<?php include COMPONENT_PATH . 'Layout_Header.php'; ?>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header pb-2">
                            <h6 class="card-title">Profil User</h6>
                        </div>
                        <div class="card-body">
                            <form action="<?= BASE_URL ?>user/update" method="POST" class="form-horizontal">
                                <input type="hidden" name="id" value="<?= $user_id ?>">
                                <input type="hidden" name="type_page" value="profile">

                                <div class="form-group row">
                                    <label for="nama-lengkap" class="col-sm-2 col-form-label">Nama Lengkap</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="nama-lengkap" name="nama_lengkap" placeholder="Nama Lengkap" value="<?= $nama_lengkap ?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="email" class="col-sm-2 col-form-label">Email</label>
                                    <div class="col-sm-10">
                                        <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="<?= $email ?>">
                                    </div>
                                </div>
                                <div class="form-group row mb-1">
                                    <label for="no-telepon" class="col-sm-2 col-form-label">No Telepon</label>
                                    <div class="col-sm-10">
                                        <input type="number" class="form-control" id="no-telepon" name="no_telp" placeholder="No Telepon" value="<?= $no_telp ?>">
                                        <span class="text-sm text-danger">* Gunakan 62</span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="alamat" class="col-sm-2 col-form-label">Alamat</label>
                                    <div class="col-sm-10">
                                        <textarea class="form-control" id="alamat" name="alamat" name="alamat" placeholder="Alamat"><?= $alamat ?></textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="role" class="col-sm-2 col-form-label">Role</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control text-capitalize" name="role" id="role" placeholder="Role" value="<?= $role ?>" readonly>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-sm-12 col-md-6 mb-0">
                                        <label for="password" class="form-label mb-0">Password Baru</label>
                                        <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                                    </div>
                                    <div class="form-group col-sm-12 col-md-6 mb-0">
                                        <label for="confirm-password" class="form-label mb-0">Retype Password</label>
                                        <input type="password" name="confirm_password" class="form-control" id="confirm-password" placeholder="Retype Password">
                                    </div>

                                    <div class="col-sm-12 mb-2">
                                        <span class="text-sm text-danger">* Minimal 8 karakter</span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <button type="submit" class="btn btn-primary btn-sm">Ubah Data</button>
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
