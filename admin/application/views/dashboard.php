<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Admin</title>
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
                <li class="menu-item active"><a href="<?= site_url('dashboard') ?>"><i class="fas fa-home"></i> <span>Dashboard</span></a></li>
                <li class="menu-item"><a href="<?= site_url('pemesanan') ?>"><i class="fas fa-shopping-bag"></i> <span>Pemesanan</span></a></li>
                <li class="menu-item"><a href="<?= site_url('pembayaran') ?>"><i class="fas fa-exchange-alt"></i> <span>Transaksi</span></a></li>
                <li class="menu-item"><a href="<?= site_url('kamar') ?>"><i class="fas fa-bed"></i> <span>Kamar</span></a></li>
                <li class="menu-item logout-link"><a href="<?= site_url('login/logout') ?>"><i class="fas fa-sign-out-alt"></i> <span>Logout</span></a></li>
            </ul>
        </nav>
    </div>

    <div class="main-content">
        <header class="header">
            <button class="menu-toggle">≡</button> 
            <h2>Dashboard Overview</h2>
            <div class="notification-icon">🔔</div>
        </header>

        <div class="content-body">
            <div class="stats-row">
                <div class="stat-card available-rooms">
                    <h4>Kamar Tersedia</h4>
                    <p class="number"><?= $kamar_tersedia ?></p>
                    <p class="detail">Tersedia <?= $kamar_tersedia ?> Kamar Kosong</p>
                    <i class="icon fas fa-building"></i>
                </div>

                <div class="stat-card occupied-rooms">
                    <h4>Kamar Terisi</h4>
                    <p class="number"><?= $kamar_terisi ?></p>
                    <p class="detail"><?= $kamar_terisi ?> Kamar Sudah Terisi</p>
                    <i class="icon fas fa-bed"></i>
                </div>
            </div>

            <div class="chart-area" style="background: white; padding: 20px; border-radius: 10px; margin-top: 20px;">
                <h4 class="chart-title" style="color: #7a3e3e; margin-bottom: 15px;">Statistik Transaksi Mingguan</h4>
                <div style="height: 300px;">
                    <canvas id="adminChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const ctx = document.getElementById('adminChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: <?= $grafik_labels ?>,
            datasets: [{
                label: 'Jumlah Transaksi',
                data: <?= $grafik_data ?>,
                borderColor: '#7a3e3e',
                backgroundColor: 'rgba(122, 62, 62, 0.1)',
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: { beginAtZero: true, ticks: { stepSize: 1 } }
            }
        }
    });
</script>
</body>
</html>