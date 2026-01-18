<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <title>Pilih Pembayaran</title>
    <link rel="stylesheet" href="/assets/css/user.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" 
        data-client-key="asdasdasdasdasdasdsdasdasdasdas"></script>
</head>
<body class="user-body-default">

    <div class="payment-card">
        <div class="payment-left">
            <h2 class="payment-title">Kamar</h2>
            <div class="room-detail-box">
                <div class="room-icon-circle"></div>
                <div style="text-align: left;">
                    <div style="font-weight: bold; font-size: 0.9rem;"><?= $kamar->nama_kamar ?></div>
                    <div style="font-size: 0.8rem;">
                        <i class="fas fa-home"></i> Rp <?= number_format($kamar->harga * $pemesanan->lama_sewa, 0, ',', '.') ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="payment-right">
            <h2 class="payment-title">Pembayaran</h2>
            
            <div class="payment-options">
                <a href="<?= site_url('pembayaran/qris/' . $pemesanan->id_pemesanan) ?>" class="option-box">
                    <i class="fas fa-qrcode"></i>
                    <span>QRIS</span>
                </a>

                <button id="btn-transfer" class="option-box">
                    <i class="fas fa-credit-card"></i>
                    <span>Transfer / VA</span>
                </button>
            </div>

            <div style="margin-top: 20px;">
                 <a href="<?= site_url('pembayaran/finish?order_id='.$id_pembayaran_final) ?>" class="btn btn-sm btn-warning" style="text-decoration:none; color: orange; font-size: 12px; border: 1px solid orange; padding: 5px; border-radius: 5px;">
                    <i class="fas fa-sync"></i> Cek Status Pembayaran
                </a>
            </div>

            <div style="margin-top: 30px;">
                <a href="<?= site_url('pemesanan') ?>" style="color: rgba(255,255,255,0.7); font-size: 0.7rem; text-decoration: none;">
                    ← Bayar Nanti (Masuk Riwayat)
                </a>
            </div>
        </div>
    </div>

    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="Mid-client-X3TcsmQM75h2b69O"></script>
    
    <script>
        document.getElementById('btn-transfer').addEventListener('click', function () {
            window.snap.pay('<?= $snapToken ?>', {
        
                onSuccess: function (result) { 
                    window.location.href = "<?= site_url('pembayaran/finish?order_id=') ?>" + result.order_id; 
                },
                onPending: function (result) { 
                    window.location.href = "<?= site_url('pembayaran/finish?order_id=') ?>" + result.order_id; 
                },
                onError: function (result) { 
                    alert('Pembayaran gagal'); 
                    location.reload();
                },
                onClose: function(){
                    alert('Anda menutup pembayaran tanpa menyelesaikan transaksi.');
                }
            });
        });
    </script>
</body>
</html>