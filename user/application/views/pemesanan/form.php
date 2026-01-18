<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pemesanan User</title>
    <link rel="stylesheet" href="/assets/css/user.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body class="user-body-default">

    <header class="user-header">
        <div class="user-header-content">
            <a href="<?= site_url('kamar') ?>" class="header-logo"><i class="fas fa-arrow-left"></i></a>
            <h1 class="header-title-page">Pemesanan</h1>
            <div class="header-user-info">
                <span>Halo, <strong><?= $this->session->userdata('nama') ?></strong></span>
                |
                <a href="<?= site_url('logout') ?>" class="btn-logout-user">Logout</a>
            </div>
        </div>
    </header>

    <div class="p-user-container">
        <div class="order-card">
            <h2 style="font-weight: bold;">Pemesanan</h2>

            <div class="image-placeholder" style="width: 100%; height: 200px; background: #eee; border-radius: 40px; overflow: hidden; display: flex; align-items: center; justify-content: center;">
                <?php if (!empty($kamar->foto_kamar)): ?>
                    <img src="<?= base_url('../assets/fotokamar/' . $kamar->foto_kamar) ?>"
                        alt="<?= $kamar->nama_kamar ?>"
                        style="width: 100%; height: 100%; object-fit: cover;">
                <?php elseif (!empty($kamar->foto)): ?>
                    <img src="<?= base_url('../assets/fotokamar/' . $kamar->foto) ?>"
                        alt="<?= $kamar->nama_kamar ?>"
                        style="width: 100%; height: 100%; object-fit: cover;">
                <?php else: ?>
                    <div style="color: #666; text-align: center;">
                        <i class="fAas fa-image fa-3x"></i>
                        <p style="font-size: 12px; margin-top: 5px;">Gambar tidak tersedia</p>
                    </div>
                <?php endif; ?>
            </div>

            <form action="<?= site_url('pemesanan/proses') ?>" method="post">
                <input type="hidden" name="id_kamar" value="<?= $kamar->id_kamar ?>">

                <label class="form-label">Nama Kamar</label>
                <input type="text" class="input-readonly" value="<?= $kamar->nama_kamar ?>" readonly>

                <label class="form-label">Tanggal Pesan</label>
                <div class="row-date">
                    <input type="text" class="input-custom" style="flex: 1;" value="<?= date('d') ?>" readonly>
                    <input type="text" class="input-custom" style="flex: 1;" value="<?= date('M') ?>" readonly>
                    <input type="text" class="input-custom" style="flex: 1;" value="<?= date('Y') ?>" readonly>
                </div>

                <label class="form-label">Lama Sewa (Bulan)</label>
                <input type="number" name="lama_sewa" class="input-custom" min="1" placeholder="Masukkan jumlah bulan" required>

                <button type="submit" class="btn-bayar-custom">
                    Bayar Sekarang
                </button>
            </form>
        </div>
    </div>

</body>

</html>