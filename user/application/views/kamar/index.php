<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Kamar</title>
    <link rel="stylesheet" href="/assets/css/user.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body class="user-body-default">

    <header class="user-header">
        <div class="user-header-content">
            <a href="<?= site_url('dashboard') ?>" class="header-logo"><i class="fas fa-arrow-left"></i></a>
            <h1 class="header-title-page">Daftar Kamar</h1>
            <div class="header-user-info">
                <span>Halo, <strong><?= $this->session->userdata('nama') ?></strong></span>
                |
                <a href="<?= site_url('logout') ?>" class="btn-logout-user">Logout</a>
            </div>
        </div>
    </header>

    <div class="user-container mt-40">

        <div class="row card-kamar-list">
            <?php if (empty($kamar)): ?>
                <div class="col-12">
                    <div class="alert-info-user">
                        <i class="fas fa-info-circle"></i> Maaf, saat ini tidak ada kamar yang terdaftar.
                    </div>
                </div>
            <?php endif; ?>

            <?php foreach ($kamar as $k) : ?>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="kamar-card shadow-sm">
                        <div class="kamar-image">
                            <?php if (!empty($k->foto)) : ?>
                                <img src="<?= base_url('../assets/fotokamar/' . $k->foto) ?>" alt="<?= $k->nama_kamar ?>">
                            <?php else : ?>
                                <div class="kamar-image-placeholder">
                                    <i class="fas fa-bed"></i>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="kamar-body">
                            <h5 class="kamar-title"><?= $k->nama_kamar ?></h5>

                            <?php if (isset($k->harga)): ?>
                                <p class="kamar-price">Rp <?= number_format($k->harga, 0, ',', '.') ?> / Bulan</p>
                            <?php else: ?>
                                <p class="kamar-price">Harga tidak tersedia</p>
                            <?php endif; ?>

                            <div class="fasilitas-singkat mb-3" style="font-size: 0.8rem; color: #666;">
                                <?php
                                if (!empty($k->fasilitas)) {
                                    $items = explode(',', $k->fasilitas);
                                    $show = array_slice($items, 0, 3);
                                    echo '<i class="fas fa-box"></i> ' . implode(', ', $show);
                                }
                                ?>
                            </div>

                            <div class="kamar-status status-<?= strtolower($k->status) ?> mb-3">
                                <i class="fas fa-check-circle"></i> <?= ucfirst($k->status) ?>
                            </div>

                            <a style="text-decoration: none;" href="<?= base_url('kamar/detail/' . $k->id_kamar) ?>" class="btn-primary-user btn-full btn-kamar-detail">
                                Lihat Detail Kamar
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

    </div>

</body>

</html>