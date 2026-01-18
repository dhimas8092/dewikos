<div id="modalDetail" class="modal-overlay" style="display: none;">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Bukti Pembayaran</h3>
            <button onclick="closeModal()" class="close-btn">&times;</button>
        </div>
        
        <div class="modal-body">
            <div style="text-align: center; margin-bottom: 20px;">
                <i class="fas fa-check-circle" style="font-size: 50px; color: #4CAF50;"></i>
                <h2 style="margin: 10px 0; color: #4CAF50;">LUNAS</h2>
                <p style="color: #777; font-size: 12px;">Terima kasih, pembayaran Anda berhasil.</p>
            </div>

            <div class="detail-row">
                <span>ID Pesanan</span>
                <span id="d_id_pesanan" style="font-weight: bold;">#ORD-000</span>
            </div>
            <div class="detail-row">
                <span>Kamar</span>
                <span id="d_nama_kamar">Kamar 00</span>
            </div>
            <div class="detail-row">
                <span>Tanggal Check-in</span>
                <span id="d_tgl_masuk">01 Jan 2026</span>
            </div>
            <div class="detail-row">
                <span>Durasi</span>
                <span id="d_durasi">1 Bulan</span>
            </div>
            
            <hr style="border: 0; border-top: 1px dashed #ddd; margin: 15px 0;">

            <div class="detail-row">
                <span>Total Bayar</span>
                <span id="d_total" style="color: #8c4141; font-weight: 800; font-size: 16px;">Rp 0</span>
            </div>
        </div>

        <div class="modal-footer">
            <button onclick="window.print()" class="btn-action secondary">
                <i class="fas fa-print"></i> Cetak
            </button>
            <a href="https://wa.me/62812345678" target="_blank" class="btn-action primary">
                <i class="fab fa-whatsapp"></i> Hubungi Pemilik
            </a>
        </div>
    </div>
</div>