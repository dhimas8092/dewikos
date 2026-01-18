<body class="user-body-default">
    <div class="user-container mt-40">
        <div class="detail-wrapper shadow text-center" style="background:white; padding:40px; border-radius:20px;">
            <h3>Konfirmasi Pembayaran Kost</h3>
            <hr>
            <p>Status: <strong><?= strtoupper($pemesanan->status_pemesanan) ?></strong></p>
            
            <?php if($pemesanan->status_pemesanan == "menunggu"): ?>
                <button id="pay-button" class="btn-primary-user" style="margin-top:20px; padding: 15px 30px;">
                    BAYAR SEKARANG
                </button>
            <?php else: ?>
                <div class="alert alert-success">Pembayaran Telah Diterima. Silakan hubungi pemilik kost.</div>
                <a href="<?= site_url('pemesanan') ?>" class="btn-secondary-user">Kembali ke Riwayat</a>
            <?php endif; ?>
        </div>
    </div>

    <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="SB-Mid-client-XXXXXX"></script>
    <script type="text/javascript">
        var payButton = document.getElementById('pay-button');
        payButton.addEventListener('click', function () {
            window.snap.pay('<?= $snapToken ?>', {
                onSuccess: function(result){ window.location.reload(); },
                onPending: function(result){ window.location.reload(); },
                onError: function(result){ alert("Terjadi kesalahan!"); }
            });
        });
    </script>
</body>