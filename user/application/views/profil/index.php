<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil User</title>
    <link rel="stylesheet" href="/assets/css/user.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
    <style>
        .modal-overlay {
            display: none;
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background: rgba(0,0,0,0.6);
            z-index: 9999;
            align-items: center; justify-content: center;
            backdrop-filter: blur(2px);
        }
        .modal-card {
            background: white;
            width: 85%; max-width: 380px;
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.3);
            animation: slideUp 0.3s ease-out;
            position: relative;
        }
        @keyframes slideUp {
            from { transform: translateY(50px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }
    
        .btn-close-modal {
            position: absolute; top: 15px; right: 15px;
            background: none; border: none; font-size: 24px; cursor: pointer; color: #999;
        }

        .about-content { text-align: center; padding: 10px 0; }
        .app-icon { font-size: 40px; color: #8c4141; margin-bottom: 10px; }
        .app-version { font-size: 12px; color: #999; margin-top: 5px; }
        .app-desc { font-size: 14px; color: #555; line-height: 1.5; margin: 15px 0; }

        .faq-item { margin-bottom: 12px; border-bottom: 1px solid #eee; padding-bottom: 8px; text-align: left; }
        .faq-question { font-weight: bold; color: #8c4141; font-size: 14px; margin-bottom: 4px; display: flex; align-items: center; gap: 8px;}
        .faq-answer { font-size: 13px; color: #555; padding-left: 24px; }
    </style>
</head>

<body class="user-body-default" style="background-color: #f4f4f4;">

    <div class="profile-card-top shadow">
        <a href="<?= site_url('dashboard') ?>" class="btn-back-profile">
            <i class="fas fa-arrow-right"></i> 
        </a>
        <div class="profile-avatar-circle">
            <i class="fas fa-user"></i>
        </div>
        <div class="profile-info-text">
            <h2><?= $user->nama ?></h2> 
            <p><?= !empty($user->no_hp) ? $user->no_hp : 'Nomor HP Belum Diatur' ?></p> 
        </div>
    </div>

    <div class="profile-menu-container">
        
        <a href="<?= site_url('profil/edit') ?>" class="menu-list-item">Edit Profil</a>
        <a href="javascript:void(0)" onclick="openSetting()" class="menu-list-item">Peraturan umum </a>
        <a href="<?= site_url('pemesanan') ?>" class="menu-list-item">Riwayat Pemesanan</a>
        <div class="menu-group-bottom">
            <a href="javascript:void(0)" onclick="openFaq()" class="menu-list-item">FAQ / Bantuan</a>
            <a href="https://wa.me/62812345678" target="_blank" class="menu-list-item">Tanya Pemilik</a>
        </div>
        <a href="<?= site_url('logout') ?>" class="menu-list-item" style="background-color: #555; color: white; margin-top: 20px;">
            <i class="fas fa-sign-out-alt"></i> Logout</a>
    </div>
    <div id="modalSetting" class="modal-overlay">
        <div class="modal-card">
            <button class="btn-close-modal" onclick="closeModal('modalSetting')">&times;</button>
            
            <div class="about-content">
                <i class="fas fa-home app-icon"></i>
                <h3 style="margin:0; color:#333;">Kost Dewi</h3>
                <p class="app-version">Versi 1.0.0</p>
                
                <p class="app-desc">
                    Aplikasi ini dibuat untuk memudahkan penghuni dalam mengecek tagihan, riwayat pembayaran, dan informasi seputar kost.
                </p>

                <hr style="border:0; border-top:1px solid #eee; margin: 15px 0;">
                
                <div style="text-align: left; font-size: 13px; color: #555;">
                    <div style="margin-bottom: 8px;"><strong>Peraturan umum kost:</strong></div>
                    <ul style="padding-left: 20px; margin: 0;">
                        <li>Dilarang melakukan kegiatan ilegal</li>
                        <li>Teman nginap wajib izin atau lapor</li>
                        <li>Teman lawan jenis tidak boleh menginap</li>
                        <li>Wajib menjaga kebersihan bersama</li>
                        <li>Pembayaran ngaret maksimal 2 hari (usahakan tepat waktu ya😊)</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>


    <div id="modalFaq" class="modal-overlay">
        <div class="modal-card">
            <button class="btn-close-modal" onclick="closeModal('modalFaq')">&times;</button>
            <h3 style="margin-top:0; margin-bottom:15px; color:#8c4141;">Pertanyaan Umum</h3>
            
            <div style="max-height: 300px; overflow-y: auto;">
                <div class="faq-item">
                    <div class="faq-question"><i class="fas fa-bolt"></i> Listrik?</div>
                    <div class="faq-answer">Menggunakan token masing-masing kamar.</div>
                </div>

                <div class="faq-item">
                    <div class="faq-question"><i class="fas fa-key"></i> Kunci?</div>
                    <div class="faq-answer">Penghuni pegang kunci kamar & gerbang sendiri.</div>
                </div>

                <div class="faq-item">
                    <div class="faq-question"><i class="fas fa-users"></i> Tamu?</div>
                    <div class="faq-answer">Dilarang membawa tamu lawan jenis masuk kamar.</div>
                </div>
                
                <div class="faq-item" style="border:none;">
                    <div class="faq-question"><i class="fas fa-wifi"></i> Wifi?</div>
                    <div class="faq-answer">Password akan diberikan oleh admin setelah lunas.</div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function openSetting() {
            document.getElementById('modalSetting').style.display = 'flex';
        }
        function openFaq() {
            document.getElementById('modalFaq').style.display = 'flex';
        }
        function closeModal(id) {
            document.getElementById(id).style.display = 'none';
        }
        window.onclick = function(event) {
            if (event.target.classList.contains('modal-overlay')) {
                event.target.style.display = 'none';
            }
        }
    </script>

</body>
</html>