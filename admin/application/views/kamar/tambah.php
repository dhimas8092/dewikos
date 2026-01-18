<!DOCTYPE html>
<html>

<head>
    <title>Tambah Kamar Admin</title>
    <link rel="stylesheet" href="/assets/css/admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
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
                <h2>Tambah Kamar</h2>
                <div class="notification-icon">🔔</div>
            </header>

            <div class="content-body">
                <div class="form-container">
                    <h4 class="form-title">Tambah Kamar Baru</h4>

                    <form method="post" action="<?= site_url('kamar/simpan') ?>" enctype="multipart/form-data">

                        <div class="form-group">
                            <label>Nama Kamar</label>
                            <input type="text" name="nama_kamar" placeholder="Contoh: Kamar Tipe A" required class="form-input">
                        </div>

                        <div class="form-group">
                            <label>Deskripsi</label>
                            <textarea name="deskripsi" placeholder="Deskripsi Kamar (sesuai PDF)" class="form-input" rows="3"></textarea>
                        </div>

                        <div class="form-group">
                            <label>Fasilitas Kamar</label><br>
                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-top: 10px;">
                                <label><input type="checkbox" name="fasilitas[]" value="Kasur"> Kasur</label>
                                <label><input type="checkbox" name="fasilitas[]" value="Lemari"> Lemari</label>
                                <label><input type="checkbox" name="fasilitas[]" value="AC"> AC</label>
                                <label><input type="checkbox" name="fasilitas[]" value="Jendela"> Jendela</label>
                                <label><input type="checkbox" name="fasilitas[]" value="Meja"> Meja</label>
                                <label><input type="checkbox" name="fasilitas[]" value="Kursi"> Kursi</label>
                                <label><input type="checkbox" name="fasilitas[]" value="Km. dalam"> Km. dalam</label>
                            </div>
                        </div>

                        <div class="form-group price-group">
                            <label>Harga / Bulan</label>
                            <div class="input-with-label">
                                <span class="currency-label">Rp</span>
                                <input type="number" name="harga" placeholder="Contoh: 1000000" required class="form-input price-input">
                            </div>
                        </div>

                        <div class="form-group file-upload-group">
                            <label>Foto Kamar</label>
                            <input type="file" name="foto_kamar" class="file-input">
                            <small class="text-muted">Maksimal ukuran file 2MB.</small>
                        </div>

                        <div class="form-action">
                            <button type="submit" class="btn-primary">SIMPAN</button>
                            <a href="<?= site_url('kamar') ?>" class="btn-secondary">BATAL</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</body>

</html>