<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Kamar: <?= $kamar->nama_kamar ?></title>
    <link rel="stylesheet" href="/assets/css/user.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
    <style>
        .fasilitas-container-box {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(75px, 1fr));
            gap: 12px;
            margin-top: 15px;
        }

        .fasilitas-card-vertical {
            background: #ffffff;
            border-radius: 12px;
            padding: 12px 5px;
            text-align: center;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
            border: 1px solid #f0f0f0;
            transition: 0.3s;
        }

        .fasilitas-card-vertical:hover {
            transform: translateY(-3px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        .fasilitas-card-vertical i {
            display: block;
            font-size: 22px;
            color: #7a3e3e; 
            margin-bottom: 6px;
        }

        .fasilitas-card-vertical span {
            display: block;
            font-size: 10px;
            font-weight: bold;
            color: #555;
            text-transform: capitalize;
        }

        .deskripsi-user-box {
            margin-top: 20px;
            padding: 15px;
            background: rgba(122, 62, 62, 0.05);
            border-radius: 10px;
            border-left: 4px solid #7a3e3e;
            font-size: 14px;
            color: white;
            line-height: 1.6;
        }

        .divider-thin {
            border: 0;
            border-top: 1px solid #eee;
            margin: 20px 0;
        }
    </style>
</head>

<body class="user-body-default">

    <header class="user-header">
        <div class="user-header-content">
            <a href="<?= site_url('kamar') ?>" class="header-logo"><i class="fas fa-arrow-left"></i></a>
            <h1 class="header-title-page">Detail Kamar Kost</h1>
            <div class="header-user-info">
                <span>Halo, <strong><?= $this->session->userdata('nama') ?></strong></span>
                |
                <a href="<?= site_url('logout') ?>" class="btn-logout-user">Logout</a>
            </div>
        </div>
    </header>

    <div class="pr-user-container mt-40">
        <div class="detail-wrapper shadow-lg">
            <div class="row">
                <div class="col-md-5 detail-image-col">
                    <div class="detail-image main-img-container">
                        <?php if (!empty($kamar->foto)) : ?>
                            <img src="<?= base_url('../assets/fotokamar/' . $kamar->foto) ?>"
                                alt="<?= $kamar->nama_kamar ?>"
                                class="img-fluid rounded-30 shadow">
                        <?php else : ?>
                            <div class="detail-image-placeholder">
                                <i class="fas fa-bed"></i>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="detail-status status-<?= strtolower($kamar->status) ?> mt-3 text-center">
                        <i class="fas fa-info-circle"></i> Status: <strong><?= ucfirst($kamar->status) ?></strong>
                    </div>
                </div>

                <div class="col-md-7 detail-info-col">
                    <div class="header-detail-text">
                        <h2 class="detail-kamar-title"><?= $kamar->nama_kamar ?></h2>
                        <p class="location-text"><i class="fas fa-map-marker-alt"></i> Lokasi Strategis, Dekat Kampus/Kantor</p>
                    </div>

                    <?php if (isset($kamar->harga)): ?>
                        <p class="detail-kamar-price">Rp <?= number_format($kamar->harga, 0, ',', '.') ?> <span class="per-month">/ Bulan</span></p>
                    <?php else: ?>
                        <p class="detail-kamar-price">Harga tidak tersedia</p>
                    <?php endif; ?>

                    <hr class="divider">

                    <h4 class="info-title"><i class="fas fa-star icon-gold"></i> Fasilitas Kamar</h4>

                    <div class="fasilitas-container-box">
                        <?php 
                        if(!empty($kamar->fasilitas)):
                            $items = explode(',', $kamar->fasilitas);
                            foreach($items as $item): 
                                $item = trim($item);
                                $icon = 'fa-check-circle';
                                if($item == 'Kasur') $icon = 'fa-bed';
                                if($item == 'AC') $icon = 'fa-wind';
                                if($item == 'Lemari') $icon = 'fa-door-closed';
                                if($item == 'Jendela') $icon = 'fa-window-maximize';
                                if($item == 'Meja') $icon = 'fa-table';
                                if($item == 'Kursi') $icon = 'fa-chair';
                                if($item == 'Km. dalam') $icon = 'fa-bath';
                        ?>
                            <div class="fasilitas-card-vertical">
                                <i class="fas <?= $icon ?>"></i>
                                <span><?= $item ?></span>
                            </div>
                        <?php 
                            endforeach; 
                        endif; 
                        ?>
                    </div>
                    <hr class="divider-thin">
                    <?php if (!empty($kamar->deskripsi)) : ?>
                        <div class="deskripsi-user-box">
                            <strong>Deskripsi kamar</strong><br>
                            <?= nl2br($kamar->deskripsi) ?>
                        </div>
                    <?php endif; ?> 
                    <hr class="divider-thin">
                    <div class="detail-action-area">
                        <?php if ($kamar->status == 'tersedia') : ?>
                            <div class="d-grid gap-2">
                                <a href="<?= site_url('pemesanan/tambah/' . $kamar->id_kamar) ?>" class="btn-primary-user btn-lg-user">
                                    <i class="fas fa-calendar-check"></i> Ajukan Sewa Sekarang
                                </a>
                                <a href="https://wa.me/6282280786705" target="_blank" class="btn-wa-user text-center">
                                    <i class="fab fa-whatsapp"></i> Tanya Pemilik
                                </a>
                            </div>
                        <?php else : ?>
                            <button class="btn-secondary-user btn-lg-user btn-disabled w-100" disabled>
                                <i class="fas fa-times-circle"></i> Kamar Sedang Terisi
                            </button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>