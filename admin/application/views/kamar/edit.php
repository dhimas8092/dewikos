<!DOCTYPE html>
<html>

<head>
    <title>Edit Kamar Admin</title>
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
                    <li class="menu-item logout-link"><a href="<?= site_url('login/logout') ?>">
                            <i class="fas fa-sign-out-alt"></i> <span>Logout</span></a></li>
                </ul>
            </nav>
        </div>

        <div class="main-content">
            <header class="header">
                <button class="menu-toggle">≡</button>
                <h2>Edit Kamar</h2>
                <div class="notification-icon">🔔</div>
            </header>

            <div class="content-body">
                <div class="form-container">
                    <h4 class="form-title">Edit Kamar: <?= $kamar->nama_kamar ?></h4>

                    <form method="post" action="<?= site_url('kamar/update/' . $kamar->id_kamar) ?>" enctype="multipart/form-data">

                        <div class="form-group">
                            <label>Nama Kamar</label>
                            <input type="text" name="nama_kamar" value="<?= $kamar->nama_kamar ?>" required class="form-input">
                        </div>

                        <div class="form-group">
                            <label>Deskripsi</label>
                            <textarea name="deskripsi" placeholder="Deskripsi Kamar" class="form-input" rows="3"><?= isset($kamar->deskripsi) ? $kamar->deskripsi : '' ?></textarea>
                        </div>

                        <?php $current_fasilitas = explode(',', $kamar->fasilitas); ?>
                        <div class="form-group">
                            <label>Fasilitas Kamar</label><br>
                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
                                <?php
                                $list_fasilitas = ['Kasur', 'Lemari', 'AC', 'Jendela', 'Meja', 'Kursi', 'Km. dalam'];
                                foreach ($list_fasilitas as $f): ?>
                                    <label>
                                        <input type="checkbox" name="fasilitas[]" value="<?= $f ?>"
                                            <?= in_array($f, $current_fasilitas) ? 'checked' : '' ?>> <?= $f ?>
                                    </label>
                                <?php endforeach; ?>
                            </div>
                        </div>

                        <div class="form-group price-group">
                            <label>Harga / Bulan</label>
                            <div class="input-with-label">
                                <span class="currency-label">Rp</span>
                                <input type="number" name="harga" value="<?= $kamar->harga ?>" required class="form-input price-input">
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Status</label>
                            <select name="status" class="form-input">
                                <option value="tersedia" <?= $kamar->status == 'tersedia' ? 'selected' : '' ?>>Tersedia</option>
                                <option value="terisi" <?= $kamar->status == 'terisi' ? 'selected' : '' ?>>Terisi</option>
                            </select>
                        </div>

                        <div class="form-group file-upload-group">
                            <label>Ganti Foto Baru</label>
                            <input type="file" name="foto_kamar_baru" class="file-input">
                            <small class="text-muted">Foto saat ini: *Foto Kamar* (<?= isset($kamar->foto_kamar) ? $kamar->foto_kamar : 'Belum ada foto' ?>)</small>
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