<!DOCTYPE html>
<html>

<head>
    <title>Pemesanan Admin</title>
    <link rel="stylesheet" href="/assets/css/admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>

    <div class="dashboard-wrapper">

        <div class="sidebar">
            <div class="profile-placeholder"></div>
            <nav class="main-menu">
                <ul>
                    <li class="menu-item">
                        <a href="<?= site_url('dashboard') ?>">
                            <i class="fas fa-home"></i> <span>Dashboard</span>
                        </a>
                    </li>
                    <li class="menu-item active">
                        <a href="<?= site_url('pemesanan') ?>">
                            <i class="fas fa-shopping-bag"></i> <span>Pemesanan</span>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="<?= site_url('pembayaran') ?>">
                            <i class="fas fa-exchange-alt"></i> <span>Transaksi</span>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="<?= site_url('kamar') ?>">
                            <i class="fas fa-bed"></i> <span>Kamar</span>
                        </a>
                    </li>
                    <li class="menu-item logout-link">
                        <a href="<?= site_url('login/logout') ?>">
                            <i class="fas fa-sign-out-alt"></i> <span>Logout</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>

        <div class="main-content">
            <header class="header">
                <button class="menu-toggle">≡</button>
                <h2>Pemesanan Admin</h2>
                <div class="notification-icon">🔔</div>
            </header>

            <div class="content-body">
                <div class="data-table-container">
                    <h4 class="table-title">Daftar Pemesanan</h4>

                    <div class="table-controls">
                        <input type="text" placeholder="Cari Nama" class="search-input">
                    </div>

                    <div class="table-responsive">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>ID Pemesanan</th>
                                    <th>Nama Kamar</th>
                                    <th>Tanggal Pesan</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($pemesanan as $p): ?>
                                    <tr>
                                        <td><?= $p->id_pemesanan ?></td>
                                        <td><?= $p->nama_kamar ?></td>
                                        <td><?= $p->tanggal_pesan ?></td>
                                        <td>
                                            <span class="status-badge status-<?= strtolower(trim($p->status_pemesanan)) ?>">
                                                <?= ($p->status_pemesanan) ? $p->status_pemesanan : 'menunggu' ?>
                                            </span>
                                        </td>
                                        <td>
                                            <a href="<?= site_url('pemesanan/update/' . $p->id_pemesanan . '/dibayar') ?>" class="btn-action btn-dibayar">Set Dibayar</a>
                                            <a href="<?= site_url('pemesanan/update/' . $p->id_pemesanan . '/selesai') ?>" class="btn-action btn-selesai">Set Selesai</a>
                                            <a href="<?= site_url('pemesanan/update/' . $p->id_pemesanan . '/batal') ?>"
                                                class="btn-action btn-batal"
                                                onclick="return confirm('Yakin ingin membatalkan pesanan ini?')">Batalkan</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>