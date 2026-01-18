<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Pemesanan</title>
    <link rel="stylesheet" href="/assets/css/user.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
    <style>
        /* Styling untuk Modal/Pop-up */
        .modal-overlay {
            display: none; /* Sembunyikan secara default */
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background: rgba(0, 0, 0, 0.6); /* Latar gelap transparan */
            z-index: 9999;
            align-items: center;
            justify-content: center;
            backdrop-filter: blur(4px); /* Efek blur kekinian */
        }

        .modal-card {
            background: white;
            width: 90%;
            max-width: 350px;
            border-radius: 20px;
            padding: 0;
            box-shadow: 0 20px 40px rgba(0,0,0,0.3);
            animation: popUp 0.3s ease-out;
            overflow: hidden;
            position: relative;
        }

        @keyframes popUp {
            from { transform: scale(0.8); opacity: 0; }
            to { transform: scale(1); opacity: 1; }
        }

        .modal-header {
            background: #8c4141;
            color: white;
            padding: 20px;
            text-align: center;
            position: relative;
        }

        .btn-close-modal {
            position: absolute;
            top: 15px; right: 20px;
            color: white;
            background: none;
            border: none;
            font-size: 24px;
            cursor: pointer;
        }

        .modal-body {
            padding: 20px;
        }

        .detail-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 12px;
            border-bottom: 1px dashed #eee;
            padding-bottom: 8px;
            font-size: 14px;
            color: #555;
        }

        .detail-item strong {
            color: #333;
        }

        .lunas-badge {
            background: #e8f5e9;
            color: #2e7d32;
            padding: 5px 15px;
            border-radius: 50px;
            font-weight: bold;
            font-size: 12px;
            display: inline-block;
            margin-bottom: 15px;
            border: 1px solid #c8e6c9;
        }

        .modal-footer {
            padding: 15px;
            background: #f8f9fa;
            display: flex;
            gap: 10px;
        }

        .btn-modal {
            flex: 1;
            padding: 12px;
            border: none;
            border-radius: 12px;
            font-size: 14px;
            font-weight: bold;
            cursor: pointer;
            text-align: center;
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
        }

        .btn-wa { background: #25D366; color: white; }
        .btn-print { background: #fff; border: 1px solid #8c4141; color: #8c4141; }
    </style>
</head>

<body class="user-body-default">
    
    <header class="user-header">
        <div class="user-header-content">
            <a href="<?= site_url('profil') ?>" class="header-logo" style="width: 100px;">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>

            <h1 class="header-title-page">Riwayat Pemesanan</h1>

            <div class="header-user-info" style="width: 100px; text-align: right;">
                <a href="<?= site_url('logout') ?>" class="btn-logout-user" style="color: white; font-size: 12px;">Logout</a>
            </div>
        </div>
    </header>

    <div class="user-container mt-40">
        <div class="card-list-wrapper">
            
            <?php if (empty($pemesanan)) : ?>
                <div class="alert-info-user text-center shadow-lg" style="padding: 40px; border-radius: 20px; background: white;">
                    <i class="fas fa-search fa-3x" style="color: #ccc; margin-bottom: 15px;"></i>
                    <p style="color: #666;">Belum ada riwayat pemesanan.</p>
                </div>
            <?php else : ?>
                
                <?php foreach ($pemesanan as $p) : ?>
                    <div class="history-card">
                        <div class="history-main-info">
                            <h3><?= $p->nama_kamar ?? 'Kamar Kost' ?></h3>
                            <div class="history-sub-info">
                                <p><i class="far fa-calendar-alt"></i> <span>Tgl Pesan:</span> <strong><?= date('d M Y', strtotime($p->tanggal_pesan)) ?></strong></p>
                                <p><i class="fas fa-history"></i> <span>Lama Sewa:</span> <strong><?= $p->lama_sewa ?> Bulan</strong></p>
                                <p><i class="fas fa-tag"></i> <span>Total:</span> <strong style="color: #a34949;">Rp <?= number_format((float)($p->total_harga ?? 0), 0, ',', '.') ?></strong></p>
                            </div>
                        </div>

                        <div class="history-status-area">
                            <div class="status-pill status-<?= strtolower(str_replace(' ', '-', $p->status_pemesanan ?? 'menunggu')) ?>">
                                <i class="fas fa-circle" style="font-size: 7px; vertical-align: middle; margin-right: 5px;"></i>
                                <?= ucfirst($p->status_pemesanan ?? 'Menunggu') ?>
                            </div>
                            
                            <div class="mt-2">
                                <?php if ($p->status_pemesanan == 'menunggu') : ?>
                                    
                                    <a href="<?= base_url('pembayaran/pilih_metode/' . $p->id_pemesanan) ?>" class="btn-action-history">
                                        <i class="fas fa-wallet"></i> Bayar Sekarang
                                    </a>

                                <?php elseif ($p->status_pemesanan == 'dibatalkan') : ?>
                                    
                                    <span style="color: #c62828; font-size: 12px; font-weight: bold; opacity: 0.6;">Pesanan Dibatalkan</span>

                                <?php else : ?>
                                    
                                    <button type="button" class="btn-action-history" 
                                            style="background-color: #555; color: white; border: none; width: 100%; cursor: pointer;"
                                            onclick="bukaDetail(
                                                '#ORD-<?= $p->id_pemesanan ?>',
                                                '<?= addslashes($p->nama_kamar) ?>',
                                                '<?= date('d M Y', strtotime($p->tanggal_pesan)) ?>',
                                                '<?= $p->lama_sewa ?> Bulan',
                                                'Rp <?= number_format((float)$p->total_harga, 0, ',', '.') ?>'
                                            )">
                                        <i class="fas fa-info-circle"></i> Detail
                                    </button>

                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

    <div id="modalDetail" class="modal-overlay">
        <div class="modal-card">
            <div class="modal-header">
                <button class="btn-close-modal" onclick="tutupDetail()">&times;</button>
                <h3 style="margin: 0; font-size: 18px;">Bukti Pembayaran</h3>
            </div>
            
            <div class="modal-body">
                <div style="text-align: center;">
                    <span class="lunas-badge">LUNAS</span>
                </div>

                <div class="detail-item">
                    <span>ID Transaksi</span>
                    <strong id="m_id">...</strong>
                </div>
                <div class="detail-item">
                    <span>Kamar</span>
                    <strong id="m_kamar">...</strong>
                </div>
                <div class="detail-item">
                    <span>Tanggal Pesan</span>
                    <strong id="m_tgl">...</strong>
                </div>
                <div class="detail-item">
                    <span>Durasi Sewa</span>
                    <strong id="m_durasi">...</strong>
                </div>
                <div class="detail-item" style="border-bottom: none; margin-top: 15px;">
                    <span style="font-size: 16px;">Total Bayar</span>
                    <strong id="m_total" style="font-size: 18px; color: #8c4141;">...</strong>
                </div>
            </div>

            <div class="modal-footer">
                <button onclick="window.print()" class="btn-modal btn-print">
                    <i class="fas fa-print"></i> Simpan
                </button>
                <a href="https://wa.me/62812345678?text=Halo,%20saya%20sudah%20bayar%20kost.%20Mohon%20info%20kunci." target="_blank" class="btn-modal btn-wa">
                    <i class="fab fa-whatsapp"></i> Hubungi
                </a>
            </div>
        </div>
    </div>

    <script>
        function bukaDetail(id, nama, tgl, durasi, total) {
            document.getElementById('m_id').innerText = id;
            document.getElementById('m_kamar').innerText = nama;
            document.getElementById('m_tgl').innerText = tgl;
            document.getElementById('m_durasi').innerText = durasi;
            document.getElementById('m_total').innerText = total;
            document.getElementById('modalDetail').style.display = 'flex';
        }
        function tutupDetail() {
            document.getElementById('modalDetail').style.display = 'none';
        }
        window.onclick = function(event) {
            var modal = document.getElementById('modalDetail');
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script>

</body>
</html>