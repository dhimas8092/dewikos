<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard User - Website Kost</title>
    <link rel="stylesheet" href="/assets/css/user.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        #roomContainer {
            -ms-overflow-style: none;
            scrollbar-width: none;
            display: flex;
            overflow-x: auto;
            scroll-behavior: smooth;
            gap: 15px;
            padding-bottom: 10px;
            scroll-snap-type: x mandatory;
        }

        #roomContainer::-webkit-scrollbar {
            display: none;
        }

        .room-item {
            flex: 0 0 calc(50% - 8px);
            min-width: calc(50% - 8px);
            scroll-snap-align: start;
            text-decoration: none;
        }

        .dot {
            cursor: pointer;
            transition: all 0.3s ease;
            height: 10px;
            width: 10px;
            background-color: #bbb;
            border-radius: 50%;
            display: inline-block;
            margin: 0 5px;
        }

        .dot.active {
            background-color: #7a3e3e !important;
            width: 30px;
            border-radius: 10px;
        }

        @media (max-width: 600px) {
            .room-item {
                flex: 0 0 100%;
                min-width: 100%;
            }
        }
    </style>
</head>

<body class="user-body-default">

    <header class="user-header">
        <div class="user-header-content">
            <a href="<?= site_url('profil') ?>" class="logo-link" title="Buka Profil Saya">
                <div class="header-logo-circle">Logo</div>
            </a>

            <div class="header-auth-buttons">
                <?php if ($this->session->userdata('login')): ?>
                    <span class="text-white me-3" style="font-size: 13px;">Halo, <?= $this->session->userdata('nama') ?></span>
                    <a href="<?= site_url('logout') ?>" class="btn-nav-white">Logout</a>
                <?php else: ?>
                    <a href="<?= site_url('login') ?>" class="btn-nav-white">Login</a>
                    <a href="<?= site_url('register') ?>" class="btn-nav-white">Register</a>
                <?php endif; ?>
            </div>
        </div>
    </header>

    <section class="hero-section">
        <div class="hero-content text-center">
            <div class="line-placeholder"></div>
            <div class="line-placeholder short"></div>
            <h2 style="color: #7a3e3e; font-weight: bold; margin-top: 10px;">Cari Kost Impianmu</h2>
        </div>
    </section>

    <div class="search-container-fixed">
    <form action="<?= site_url('kamar') ?>" method="get" class="search-wrapper">
        <input type="text" name="keyword" placeholder="Cari Kost (contoh: AC, KM Dalam)..." class="search-input-pill" required>
        <button type="submit" class="btn-search-pill">
            <i class="fas fa-search"></i> Cari
        </button>
    </form>
</div>

    <div class="user-container">
        <a href="<?= site_url('kamar') ?>" style="text-decoration: none;">
            <div class="main-feature-card">
                <div class="feature-img-box">
                    <i class="fas fa-bed"></i>
                </div>
                <div class="feature-text-box">
                    <h3 style="color: white; margin-bottom: 5px; font-weight: bold;">Lihat Semua Kamar Tersedia</h3>
                    <p style="color: #ffd1d1; font-size: 13px;">Temukan berbagai pilihan kamar kost terbaik.</p>
                    <div class="line-text"></div>
                    <div class="line-text"></div>
                </div>
            </div>
        </a>

        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
            <h4 style="color: #7a3e3e; font-weight: bold; margin: 0;">Rekomendasi Kamar</h4>
            <a href="<?= site_url('kamar') ?>" style="color: #7a3e3e; font-weight: bold; text-decoration: none; font-size: 14px;">Lihat Semua <i class="fas fa-chevron-right"></i></a>
        </div>

        <div class="room-grid-wrapper" style="position: relative;">
            <div class="room-grid" id="roomContainer">
                <?php if (!empty($rekomendasi)): ?>
                    <?php foreach ($rekomendasi as $r): ?>
                        <a href="<?= site_url('kamar/detail/' . $r->id_kamar) ?>" class="room-item">
                            <div class="room-card">
                                <div class="room-img-top">
                                    <?php if (!empty($r->foto)): ?>
                                        <img src="<?= base_url('../assets/fotokamar/' . $r->foto) ?>" style="width:100%; height:100%; object-fit:cover; border-radius:15px;">
                                    <?php else: ?>
                                        <div style="height:150px; background:#eee; display:flex; align-items:center; justify-content:center; border-radius:15px;">
                                            <i class="fas fa-image fa-2x" style="color:#ccc;"></i>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="room-badge shadow-sm">Rp. <?= number_format($r->harga ?? 0, 0, ',', '.') ?>/bln</div>
                                <p style="color:white; font-weight:bold; margin-top:10px; text-align:center;"><?= $r->nama_kamar ?></p>
                            </div>
                        </a>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>Kamar tidak ditemukan.</p>
                <?php endif; ?>
            </div>

            <button onclick="scrollKanan()" class="next-arrow-circle" style="border:none; cursor:pointer;">
                <i class="fas fa-arrow-right"></i>
            </button>
        </div>

        <div class="pagination-dots" id="dotContainer">
            <?php
            if (!empty($rekomendasi)):
                $totalDots = ceil(count($rekomendasi) / 2);
                for ($i = 0; $i < $totalDots; $i++):
            ?>
                    <span class="dot <?= $i === 0 ? 'active' : '' ?>" onclick="scrollToGroup(<?= $i ?>)"></span>
            <?php
                endfor;
            endif;
            ?>
        </div>
    </div>

    <footer class="user-footer-main">
        <div class="social-icons-row">
            <a href="#"><i class="fab fa-instagram"></i></a>
            <a href="#"><i class="fab fa-facebook"></i></a>
            <a href="#"><i class="fab fa-whatsapp"></i></a>
        </div>
        <p class="copyright-text">© 2025 DNG. All Rights Reserved</p>
    </footer>

    <script>
        const container = document.getElementById('roomContainer');
        const dotContainer = document.getElementById('dotContainer');
        const totalItems = <?= count($rekomendasi) ?>;

        function renderDots() {
            dotContainer.innerHTML = '';
            const isMobile = window.innerWidth <= 600;
            const itemsPerView = isMobile ? 1 : 2;
            const totalDots = Math.ceil(totalItems / itemsPerView);

            for (let i = 0; i < totalDots; i++) {
                const span = document.createElement('span');
                span.className = `dot ${i === 0 ? 'active' : ''}`;
                span.onclick = () => scrollToGroup(i);
                dotContainer.appendChild(span);
            }
        }

        function scrollKanan() {
            container.scrollBy({
                left: container.clientWidth,
                behavior: 'smooth'
            });
        }

        function scrollToGroup(index) {
            container.scrollTo({
                left: container.clientWidth * index,
                behavior: 'smooth'
            });
        }

        container.addEventListener('scroll', () => {
            const dots = document.querySelectorAll('.dot');
            const activeIndex = Math.round(container.scrollLeft / container.clientWidth);

            dots.forEach((dot, i) => {
                dot.classList.toggle('active', i === activeIndex);
            });
        });
        renderDots();
        window.addEventListener('resize', renderDots);
    </script>
    <script>
    <?php if($this->session->flashdata('status') == 'login_sukses'): ?>
        Swal.fire({
            icon: 'success',
            title: 'Login Berhasil!',
            text: 'Selamat datang kembali, <?= $this->session->userdata('nama') ?>!',
            confirmButtonColor: '#7a3e3e',
            timer: 2000,
            showConfirmButton: false
        });
    <?php endif; ?>
</script>
</body>

</html>