<?php

namespace Controller;

require_once __DIR__ . '/../Config/Database.php';
require_once __DIR__ . '/../Helpers/Auth.php';

use Database;

class PenitipanController {
    public function index()
    {
        require_login();

        $_SESSION['active_page'] = 'penitipan';
        $_SESSION['page_title'] = 'Data Penitipan';

        $pdo = Database::getInstance()->getConnection();

        $user_id = $_SESSION['user']['id'];
        $role = $_SESSION['user']['role'];

        if ($role === 'admin') {
            $sql = "SELECT DISTINCT
                        penitipan.id AS id_penitipan,
                        users.nama_lengkap,
                        loker.nomor_loker,
                        penitipan.tanggal_penitipan,
                        penitipan.tanggal_pengambilan,
                        penitipan.status_penitipan,
                        transaksi.id AS id_transaksi,
                        transaksi.total_biaya AS biaya_layanan,
                        transaksi.status_pembayaran
                    FROM penitipan
                    INNER JOIN loker ON loker.id = penitipan.loker_id
                    INNER JOIN users ON users.id = penitipan.user_id
                    INNER JOIN penitipan_barang ON penitipan_barang.penitipan_id = penitipan.id
                    LEFT JOIN transaksi ON transaksi.penitipan_id = penitipan.id
                    WHERE penitipan.status_penitipan != 'selesai'
                    ORDER BY penitipan.tanggal_pengambilan DESC
            ";
            $stmt = $pdo->query($sql);
        } else {
            $sql = "SELECT DISTINCT
                        penitipan.id AS id_penitipan,
                        users.nama_lengkap,
                        loker.nomor_loker,
                        penitipan.tanggal_penitipan,
                        penitipan.tanggal_pengambilan,
                        penitipan.status_penitipan,
                        transaksi.total_biaya AS biaya_layanan,
                        transaksi.status_pembayaran
                    FROM penitipan
                    INNER JOIN loker ON loker.id = penitipan.loker_id
                    INNER JOIN users ON users.id = penitipan.user_id
                    INNER JOIN penitipan_barang ON penitipan_barang.penitipan_id = penitipan.id
                    LEFT JOIN transaksi ON transaksi.penitipan_id = penitipan.id
                    WHERE penitipan.user_id = :user_id
                    ORDER BY
                    CASE
                        WHEN penitipan.status_penitipan = 'aktif' THEN 1
                        WHEN penitipan.status_penitipan = 'pending' THEN 2
                        WHEN penitipan.status_penitipan = 'batal' THEN 3
                        WHEN penitipan.status_penitipan = 'selesai' THEN 4
                        ELSE 5
                    END,
                    penitipan.id DESC
            ";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['user_id' => $user_id]);
        }

        $data_penitipan = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        require_once __DIR__ . '/../Views/Penitipan/Index.php';
    }

    public function create()
    {
        require_login();

        $_SESSION['active_page'] = 'penitipan';
        $_SESSION['page_title'] = 'Form Ajukan Penitipan Barang';

        $user_id = $_SESSION['user']['id'];

        if (!$user_id) {
            $_SESSION['toast'] = [
                'type' => 'danger',
                'title' => 'Data User',
                'subtitle' => 'Error',
                'body' => "Data user dengan ID: $id tidak ada."
            ];
            header("Location: " . BASE_URL . 'penitipan');
            exit;
        }

        $pdo = Database::getInstance()->getConnection();
        $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$user_id]);
        $user = $stmt->fetch(\PDO::FETCH_ASSOC);

        $stmtLoker = $pdo->query("SELECT * FROM loker ORDER BY nomor_loker, id ASC");
        $lokers = $stmtLoker->fetchAll(\PDO::FETCH_ASSOC);

        require_once __DIR__ . '/../Views/Penitipan/Create.php';
    }

    public function store()
    {
        require_login();

        $user_id = $_SESSION['user']['id'];
        $pdo = Database::getInstance()->getConnection();

        try {
            $pdo->beginTransaction();

            $stmt = $pdo->prepare("INSERT INTO penitipan (user_id, loker_id, tanggal_penitipan, tanggal_pengambilan, status_penitipan) VALUES (?, ?, ?, ?, 'pending')");
            $stmt->execute([
                $user_id,
                $_POST['id_loker'],
                $_POST['tanggal_penitipan'],
                $_POST['tanggal_pengambilan']
            ]);

            $penitipan_id = $pdo->lastInsertId();

            $nama_barang = $_POST['nama_barang'];
            $jenis_barang = $_POST['jenis_barang'];
            $berat_barang = $_POST['berat_barang'];
            $deskripsi_barang = $_POST['deskripsi_barang'];

            for ($i = 0; $i < count($nama_barang); $i++) {
                $stmtBarang = $pdo->prepare("INSERT INTO barang (user_id, nama_barang, jenis_barang, deskripsi_barang, berat, created_at) VALUES (?, ?, ?, ?, ?, NOW())");
                $stmtBarang->execute([
                    $user_id,
                    $nama_barang[$i],
                    $jenis_barang[$i],
                    $deskripsi_barang[$i],
                    $berat_barang[$i]
                ]);

                $barang_id = $pdo->lastInsertId();

                $stmtPivot = $pdo->prepare("INSERT INTO penitipan_barang (penitipan_id, barang_id) VALUES (?, ?)");
                $stmtPivot->execute([
                    $penitipan_id,
                    $barang_id
                ]);
            }

            $tanggal_penitipan = new \DateTime($_POST['tanggal_penitipan']);
            $tanggal_pengambilan = new \DateTime($_POST['tanggal_pengambilan']);
            $durasi = $tanggal_penitipan->diff($tanggal_pengambilan)->days;

            $stmtTransaksi = $pdo->prepare("INSERT INTO transaksi (user_id, penitipan_id, durasi, status_pembayaran) VALUES (?, ?, ?, 'pending')");
            $stmtTransaksi->execute([
                $user_id,
                $penitipan_id,
                $durasi
            ]);

            $stmtUser = $pdo->prepare("SELECT no_telp, alamat FROM users WHERE id = ?");
            $stmtUser->execute([$user_id]);
            $userData = $stmtUser->fetch(\PDO::FETCH_ASSOC);

            $nomor_telepon = $_POST['nomor_telepon'];
            $alamat = $_POST['alamat'];

            if (!empty($nomor_telepon) && strpos($nomor_telepon, '0') === 0) {
                $nomor_telepon = '62' . substr($nomor_telepon, 1);
            }

            if (
                empty($userData['no_telp']) || $userData['nomor_telepon'] != $nomor_telepon ||
                empty($userData['alamat']) || $userData['alamat'] != $alamat
            ) {
                $stmtUpdateUser = $pdo->prepare("UPDATE users SET no_telp = ?, alamat = ? WHERE id = ?");
                $stmtUpdateUser->execute([
                    $nomor_telepon,
                    $alamat,
                    $user_id
                ]);
            }

            $stmtUpdate = $pdo->prepare("UPDATE loker SET status = 'booked' WHERE id = ?");
            $stmtUpdate->execute([$_POST['id_loker']]);

            $pdo->commit();

            $_SESSION['toast'] = [
                'type' => 'success',
                'title' => 'Pengajuan Penitipan Barang',
                'subtitle' => '',
                'body' => "Berhasil membuat pengajuan penitipan barang."
            ];

            header("Location: " . BASE_URL . "penitipan");
            exit();
        } catch (Exception $e) {
            $pdo->rollback();

            die($e->getMessage());
        }
    }

    public function detail()
    {
        require_login();

        $id_penitipan = $_GET['id'];
        $pdo = Database::getInstance()->getConnection();

        $_SESSION['active_page'] = 'penitipan/detail/' . $id_penitipan;
        $_SESSION['page_title'] = 'Data Penitipan';

        $stmt = $pdo->prepare("SELECT
                                    penitipan_barang.id AS penitipan_barang_id,
                                    penitipan_barang.barang_id AS barang_id,
                                    penitipan_barang.penitipan_id AS penitipan_id,
                                    barang.nama_barang,
                                    barang.jenis_barang,
                                    barang.berat,
                                    barang.deskripsi_barang,
                                    penitipan.loker_id AS loker_id,
                                    penitipan.tanggal_penitipan,
                                    penitipan.tanggal_pengambilan,
                                    penitipan.status_penitipan,
                                    loker.nomor_loker,
                                    loker.kapasitas,
                                    loker.status AS status_loker,
                                    transaksi.id AS transaksi_id,
                                    transaksi.total_biaya AS biaya_layanan,
                                    transaksi.status_pembayaran
                                FROM penitipan_barang
                                    INNER JOIN penitipan ON penitipan.id = penitipan_barang.penitipan_id
                                    INNER JOIN barang ON barang.id = penitipan_barang.barang_id
                                    INNER JOIN loker ON loker.id = penitipan.loker_id
                                    INNER JOIN transaksi ON transaksi.penitipan_id = penitipan.id
                                WHERE penitipan_barang.penitipan_id = ?");
        $stmt->execute([$id_penitipan]);
        $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        if (!$rows) {
            die("Data tidak ditemukan.");
        }

        // Ambil info penitipan dari baris pertama
        $penitipan = [
            'penitipan_id'       => $rows[0]['penitipan_id'],
            'id_loker'           => $rows[0]['loker_id'],
            'nomor_loker'        => $rows[0]['nomor_loker'],
            'tanggal_penitipan'  => $rows[0]['tanggal_penitipan'],
            'tanggal_pengambilan'=> $rows[0]['tanggal_pengambilan'],
            'status_penitipan'   => $rows[0]['status_penitipan'],
        ];

        $transaksi = [
            'transaksi_id' => $rows[0]['transaksi_id'],
            'biaya_layanan' => $rows[0]['biaya_layanan'],
            'status_pembayaran' => $rows[0]['status_pembayaran']
        ];

        // Ambil data semua barang
        $barangs = [];
        foreach ($rows as $row) {
            $barangs[] = [
                'nama'      => $row['nama_barang'],
                'jenis'     => $row['jenis_barang'],
                'berat'     => $row['berat'],
                'deskripsi' => $row['deskripsi_barang'],
            ];
        }

        require_once __DIR__ . '/../Views/Penitipan/Detail.php';
    }

    public function update_payment()
    {
        require_login();

        $transaksi_id = $_POST['id_transaksi'];
        $total_biaya = $_POST['nominal'];

        $pdo = Database::getInstance()->getConnection();

        if (!$transaksi_id) {
            $_SESSION['toast'] = [
                'type' => 'warning',
                'title' => 'Update Biaya Penitipan',
                'subtitle' => '',
                'body' => "Transaksi belum terdaftar di admin."
            ];

            header("Location: " . BASE_URL . "penitipan");
            exit;
        }

        $stmt = $pdo->prepare("UPDATE transaksi SET total_biaya = ? WHERE id = ?");
        $stmt->execute([
            $total_biaya,
            $transaksi_id
        ]);

        $_SESSION['toast'] = [
            'type' => 'success',
            'title' => 'Update Biaya Layanan',
            'subtitle' => '',
            'body' => "Berhasil menambahkan biaya layanan pada customer."
        ];

        header("Location: " . BASE_URL . "penitipan");
        exit;
    }

    public function pengajuan_penitipan()
    {
        require_login();

        $penitipan_id = $_POST['penitipan_id'];
        $pdo = Database::getInstance()->getConnection();

        if (!$penitipan_id) {
            $_SESSION['toast'] = [
                'type' => 'warning',
                'title' => 'Update Biaya Penitipan',
                'subtitle' => '',
                'body' => "Transaksi belum terdaftar di admin."
            ];

            header("Location: " . BASE_URL . "penitipan");
            exit;
        }

        $checkPayment = $pdo->prepare("SELECT transaksi.status_pembayaran, penitipan.status_penitipan, penitipan.loker_id FROM penitipan INNER JOIN transaksi ON transaksi.penitipan_id = penitipan.id WHERE penitipan.id = ?");
        $checkPayment->execute([$penitipan_id]);

        $status = $checkPayment->fetch(\PDO::FETCH_ASSOC);
        $loker_id = $status['loker_id'];

        if ($status['status_pembayaran'] !== 'selesai') {
            $_SESSION['toast'] = [
                'type' => 'warning',
                'title' => 'Approve Pengajuan Pentipan',
                'subtitle' => '',
                'body' => 'Customer masih belum melakukan pembayaran.'
            ];

            header("Location: " . BASE_URL . "penitipan");
            exit;
        }

        if ($status['status_penitipan'] === 'pending') {
            $stmtPayment = $pdo->prepare("UPDATE penitipan SET status_penitipan = 'aktif' WHERE id = ?");
            $stmtPayment->execute([$penitipan_id]);

            $_SESSION['toast'] = [
                'type' => 'success',
                'title' => 'Pengajuan Penitipan Data',
                'subtitle' => 'Success',
                'body' => "Pengajuan penitipan barang berhasil disetujui."
            ];
            header("Location: " . BASE_URL . "penitipan");
        } elseif ($status['status_penitipan'] === 'aktif') {
            $stmtPayment = $pdo->prepare("UPDATE penitipan SET status_penitipan = 'selesai' WHERE id = ?");
            $stmtPayment->execute([$penitipan_id]);

            $stmtUpdateLoker = $pdo->prepare("UPDATE loker SET status = 'kosong' WHERE id = ?");
            $stmtUpdateLoker->execute([$loker_id]);

            $_SESSION['toast'] = [
                'type' => 'success',
                'title' => 'Pengajuan Penitipan Data',
                'subtitle' => 'Success',
                'body' => "Penitipan barang telah selesai."
            ];
            header("Location: " . BASE_URL . "penitipan");
        }
        exit;
    }

    public function pembayaran_user()
    {
        require_login();

        $_SESSION['active_page'] = 'penitipan';
        $_SESSION['page_title'] = 'Form Pembayaran Customer';

        $penitipan_id = $_GET['id'];
        $user_id = $_SESSION['user']['id'];

        $pdo = Database::getInstance()->getConnection();

        $stmt = $pdo->prepare("SELECT transaksi.id AS id_transaksi, transaksi.total_biaya, transaksi.metode_pembayaran, penitipan.id AS id_penitipan FROM penitipan INNER JOIN transaksi ON transaksi.penitipan_id = penitipan.id WHERE penitipan.id = ? AND penitipan.user_id = ?");
        $stmt->execute([
            $penitipan_id,
            $user_id
        ]);
        $pembayaran = $stmt->fetch(\PDO::FETCH_ASSOC);

        require_once __DIR__ . '/../Views/Penitipan/Form_Pembayaran.php';
    }

    public function pembayaran_update()
    {
        require_login();

        $id_transaksi = $_POST['id_transaksi'];
        $metode_pembayaran = $_POST['metode_pembayaran'];
        $bukti_transfer = null;
        $id_penitipan = $_POST['id_penitipan'];

        $pdo = Database::getInstance()->getConnection();

        $metodeTanpaBukti = ['qris', 'cash', 'lainnya'];

        if (!in_array($metode_pembayaran, $metodeTanpaBukti)) {
            if (isset($_FILES['bukti_transfer']) && $_FILES['bukti_transfer']['error'] === UPLOAD_ERR_OK) {
                $file_temp = $_FILES['bukti_transfer']['tmp_name'];
                $file_name = time() . '-' . basename($_FILES['bukti_transfer']['name']);
                $upload_dir = __DIR__ . '/../Uploads/BuktiTransfer/';

                if (!is_dir($upload_dir)) {
                    mkdir($upload_dir, 0755, true);
                }

                $destination = $upload_dir . $file_name;

                if (move_uploaded_file($file_temp, $destination)) {
                    $bukti_transfer = $file_name;
                } else {
                    $_SESSION['toast'] = [
                        'type' => 'danger',
                        'title' => 'Gagal Upload',
                        'body' => 'Gagal menyimpan bukti transfer.'
                    ];
                    header("Location: " . BASE_URL . "penitipan");
                    exit;
                }
            }  else {
                $_SESSION['toast'] = [
                    'type' => 'danger',
                    'title' => 'Bukti Transfer Wajib',
                    'subtitle' => '',
                    'body' => 'Metode pembayaran ini membutuhkan bukti transfer.'
                ];
                header("Location: " . BASE_URL . "penitipan/pembayaran-user?id=$id_penitipan");
                exit;
            }
        }

        $stmt = $pdo->prepare("UPDATE transaksi SET metode_pembayaran = ?, status_pembayaran = 'selesai', bukti_transfer = ?, payment_date = NOW() WHERE id = ?");
        $stmt->execute([
            $metode_pembayaran,
            $bukti_transfer,
            $id_transaksi
        ]);

        $_SESSION['toast'] = [
            'type' => 'success',
            'title' => 'Pembayaran',
            'subtitle' => '',
            'body' => 'Data pembayaran berhasil disimpan.'
        ];

        header("Location: " . BASE_URL . "penitipan");
        exit;
    }

    public function penitipan_cancel()
    {
        require_login();

        $penitipan_id = $_GET['id'];
        $pdo = Database::getInstance()->getConnection();

        if (!$penitipan_id) {
            $_SESSION['toast'] = [
                'type' => 'warning',
                'title' => 'Update Biaya Penitipan',
                'subtitle' => '',
                'body' => "Transaksi belum terdaftar di admin."
            ];

            header("Location: " . BASE_URL . "penitipan");
            exit;
        }

        $stmtChecker = $pdo->prepare("SELECT transaksi.id AS id_transaksi, transaksi.status_pembayaran, transaksi.total_biaya, penitipan.status_penitipan, penitipan.loker_id FROM penitipan INNER JOIN transaksi ON transaksi.penitipan_id = penitipan.id WHERE penitipan.id = ?");
        $stmtChecker->execute([$penitipan_id]);
        $data = $stmtChecker->fetch(\PDO::FETCH_ASSOC);
        $transaksi_id = $data['id_transaksi'];
        $loker_id = $data['loker_id'];

        if ($data['status_penitipan'] === 'pending') {
            $stmtUpdateStatusPenitipan = $pdo->prepare("UPDATE penitipan SET status_penitipan = 'batal' WHERE id = ?");
            $stmtUpdateStatusPenitipan->execute([$penitipan_id]);
            $stmtUpdateStatusPembayaran = $pdo->prepare("UPDATE transaksi SET status_pembayaran = 'batal' WHERE id = ?");
            $stmtUpdateStatusPembayaran->execute([$transaksi_id]);
            $stmtUpdateStatusLoker = $pdo->prepare("UPDATE loker SET status = 'kosong' WHERE id = ?");
            $stmtUpdateStatusLoker->execute([$loker_id]);

            $_SESSION['toast'] = [
                'type' => 'success',
                'title' => 'Cancel Pengajuan Penitipan',
                'subtitle' => 'Success',
                'body' => "Pengajuan penitipan berhasil dibatalkan."
            ];
            header("Location: " . BASE_URL . "penitipan");
            exit;
        } elseif ($data['status_penitipan'] === 'aktif') {
            $stmtUpdateStatusPenitipan = $pdo->prepare("UPDATE penitipan SET status_penitipan = 'batal' WHERE id = ?");
            $stmtUpdateStatusPenitipan->execute([$penitipan_id]);
            $stmtUpdateStatusPembayaran = $pdo->prepare("UPDATE transaksi SET status_pembayaran = 'refund' WHERE id = ?");
            $stmtUpdateStatusPembayaran->execute([$transaksi_id]);
            $stmtUpdateStatusLoker = $pdo->prepare("UPDATE loker SET status = 'kosong' WHERE id = ?");
            $stmtUpdateStatusLoker->execute([$loker_id]);
            $_SESSION['toast'] = [
                'type' => 'success',
                'title' => 'Cancel Pengajuan Penitipan',
                'subtitle' => 'Success',
                'body' => "Pengajuan penitipan berhasil dibatalkan & akan direfund."
            ];
            header("Location: " . BASE_URL . "penitipan");
            exit;
        }
    }
}
