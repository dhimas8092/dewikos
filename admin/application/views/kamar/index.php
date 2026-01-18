<!DOCTYPE html>
<html>
<head>
    <title>Daftar Kamar Admin</title>
    <link rel="stylesheet" href="/assets/css/admin.css"> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"> 
    <style>
        .status-badge { padding: 5px 10px; border-radius: 20px; font-size: 12px; font-weight: bold; }
        .status-tersedia { background-color: #d4edda; color: #155724; }
        .status-terisi { background-color: #f8d7da; color: #721c24; }
    </style>
</head>
<body>

<div class="dashboard-wrapper">
    <div class="sidebar">
        <div class="profile-placeholder"></div> 
        <nav class="main-menu">
            <ul>
                <li class="menu-item"><a href="<?= site_url('dashboard') ?>"><i class="fas fa-home"></i> <span>Dashboard</span></a></li>
                <li class="menu-item"><a href="<?= site_url('pemesanan') ?>"><i class="fas fa-shopping-bag"></i> <span>Pemesanan</span></a></li>
                <li class="menu-item"><a href="<?= site_url('pembayaran') ?>"><i class="fas fa-exchange-alt"></i> <span>Transaksi</span></a></li>
                <li class="menu-item active"><a href="<?= site_url('kamar') ?>"><i class="fas fa-bed"></i> <span>Kamar</span></a></li>
                <li class="menu-item logout-link"><a href="<?= site_url('login/logout') ?>"><i class="fas fa-sign-out-alt"></i> <span>Logout</span></a></li>
            </ul>
        </nav>
    </div>

    <div class="main-content">
        <header class="header">
            <button class="menu-toggle">≡</button> 
            <h2>Manajemen Kamar</h2>
            <div class="notification-icon">🔔</div>
        </header>

        <div class="content-body">
            <div class="stats-row">
                <div class="stat-card available-rooms">
                    <h4>Kamar Tersedia</h4>
                    <p class="number"><?= $total_tersedia ?></p>
                    <p class="detail">Unit siap huni</p>
                    <i class="icon fas fa-building"></i>
                </div>
                <div class="stat-card occupied-rooms">
                    <h4>Kamar Terisi</h4>
                    <p class="number"><?= $total_terisi ?></p>
                    <p class="detail">Unit sedang disewa</p>
                    <i class="icon fas fa-bed"></i>
                </div>
            </div>

            <div class="table-controls mb-20" style="justify-content: flex-start; margin-top: 20px;">
                <a href="<?= site_url('kamar/tambah') ?>" class="btn-primary-action">
                    <i class="fas fa-plus"></i> Tambah Kamar Baru
                </a>
            </div>

            <div class="data-table-container">
                <h4 class="table-title">Data Master Kamar</h4>
                <div class="table-responsive">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Kamar</th>
                                <th>Harga / Bulan</th>
                                <th>Status</th>
                                <th style="text-align: center;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php if(!empty($kamar)): ?>
                            <?php foreach ($kamar as $i => $k): ?>
                            <tr>
                                <td><?= $i + 1 ?></td>
                                <td><strong><?= $k->nama_kamar ?></strong></td>
                                <td>Rp <?= number_format($k->harga, 0, ',', '.') ?></td>
                                <td>
                                    <span class="status-badge status-<?= strtolower($k->status) ?>">
                                        <?= ucfirst($k->status) ?>
                                    </span>
                                </td>
                                <td style="text-align: center;">
                                    <a href="<?= site_url('kamar/edit/'.$k->id_kamar) ?>" class="btn-action btn-edit" title="Edit Data">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <a href="<?= site_url('kamar/hapus/'.$k->id_kamar) ?>" class="btn-action btn-delete" onclick="return confirm('Apakah Anda yakin ingin menghapus kamar ini?')" title="Hapus Data">
                                        <i class="fas fa-trash"></i> Hapus
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" style="text-align: center;">Data kamar masih kosong.</td>
                            </tr>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>