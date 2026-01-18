<!DOCTYPE html>
<html>

<head>
    <title>Pembayaran Admin</title>
    <link rel="stylesheet" href="/assets/css/admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>

    <div class="dashboard-wrapper">

        <div class="sidebar">
            <div class="profile-placeholder"></div>
            <nav class="main-menu">
                <ul>
                    <li class="menu-item"><a href="<?= site_url('dashboard') ?>"><i class="fas fa-home"></i> <span>Dashboard</span></a></li>
                    <li class="menu-item"><a href="<?= site_url('pemesanan') ?>"><i class="fas fa-shopping-bag"></i> <span>Pemesanan</span></a></li>
                    <li class="menu-item active">
                        <a href="<?= site_url('pembayaran') ?>">
                            <i class="fas fa-exchange-alt"></i> <span>Transaksi</span>
                        </a>
                    </li>
                    <li class="menu-item"><a href="<?= site_url('kamar') ?>"><i class="fas fa-bed"></i> <span>Kamar</span></a></li>
                    <li class="menu-item logout-link"><a href="<?= site_url('login/logout') ?>"><i class="fas fa-sign-out-alt"></i> <span>Logout</span></a></li>
                </ul>
            </nav>
        </div>

        <div class="main-content">
            <header class="header">
                <button class="menu-toggle">≡</button>
                <h2>Pembayaran Admin</h2>
                <div class="notification-icon">🔔</div>
            </header>

            <div class="content-body">

                <div class="stats-row four-cols">
                    <div class="stat-card total-transaksi">
                        <h4>Total Transaksi</h4>
                        <p class="number"><?= $total_trx ?></p>
                        <p class="detail">Total seluruh riwayat transaksi</p>
                        <i class="icon fas fa-wallet"></i>
                    </div>

                    <div class="stat-card waiting">
                        <h4>Menunggu</h4>
                        <p class="number"><?= sprintf("%02d", $total_pending) ?></p>
                        <p class="detail">Transaksi menunggu konfirmasi</p>
                        <i class="icon fas fa-clock"></i>
                    </div>

                    <div class="stat-card completed">
                        <h4>Selesai</h4>
                        <p class="number"><?= sprintf("%02d", $total_diterima) ?></p>
                        <p class="detail">Transaksi yang berhasil</p>
                        <i class="icon fas fa-check-circle"></i>
                    </div>

                    <div class="stat-card failed">
                        <h4>Gagal/Ditolak</h4>
                        <p class="number"><?= sprintf("%02d", $total_ditolak) ?></p>
                        <p class="detail">Transaksi gagal atau ditolak</p>
                        <i class="icon fas fa-times-circle"></i>
                    </div>
                </div>

                <div class="chart-container-full shadow-sm">
                    <h4 class="chart-title">Statistik Transaksi Mingguan</h4>
                    <div style="height: 350px; width: 100%;">
                        <canvas id="trxChart"></canvas>
                    </div>
                </div>

                <div class="data-table-container">
                    <h4 class="table-title">Daftar Pembayaran</h4>

                    <div class="table-responsive">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>User</th>
                                    <th>Kamar</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($pembayaran as $i => $p): ?>
                                    <tr>
                                        <td><?= $i + 1 ?></td>
                                        <td><?= $p->nama ?></td>
                                        <td><?= $p->nama_kamar ?></td>
                                        <td>Rp <?= number_format($p->total, 0, ',', '.') ?></td>

                                        <td>
                                            <?php if ($p->status != 'batal'): ?>
                                                <span class="status-badge status-<?= strtolower($p->status) ?>">
                                                    <?= ucfirst($p->status) ?>
                                                </span>
                                            <?php endif; ?>
                                        </td>

                                        <td>
                                            <?php if ($p->status == 'pending'): ?>
                                                <a href="<?= site_url('pembayaran/terima/' . $p->id_pembayaran) ?>" class="btn-action btn-accept">Terima</a>
                                                <a href="<?= site_url('pembayaran/tolak/' . $p->id_pembayaran) ?>" class="btn-action btn-reject">Tolak</a>
                                            <?php endif; ?>
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
    <script>
        const ctx = document.getElementById('trxChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: <?= $grafik_labels ?>,
                datasets: [{
                    label: 'Jumlah Transaksi',
                    data: <?= $grafik_data ?>,
                    borderColor: '#800000',
                    backgroundColor: 'rgba(128, 0, 0, 0.2)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.3
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });
    </script>
</body>

</html>