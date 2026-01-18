<body class="user-body-default">
    <div class="user-container mt-40">
        <div class="detail-wrapper shadow-lg text-center" style="background: white; border-radius: 30px; padding: 40px;">
            <h3 style="font-weight: bold;">Transfer Bank</h3>
            <p>Total: <strong>Rp <?= number_format($pemesanan->total_harga, 0, ',', '.') ?></strong></p>
            
            <div style="background: #f8f9fa; padding: 20px; border-radius: 15px; margin: 20px 0; text-align: left;">
                <p><strong>Bank BCA</strong><br>
                No. Rekening: 1234567890<br>
                A/N: Nama Kost Anda</p>
            </div>

            <p style="font-size: 12px; color: red;">*Harap simpan bukti transfer untuk dikirim ke Admin.</p>

            <a href="<?= site_url('pemesanan') ?>" class="btn-primary-user" style="display: block; margin-top: 20px; text-decoration: none; line-height: 50px;">
                Ke Riwayat Pemesanan
            </a>
        </div>
    </div>
</body>