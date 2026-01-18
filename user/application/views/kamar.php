<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Daftar Kamar</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        body {
            background-color: #f1f1f1;
        }
        .top-bar {
            background-color: #d18b8b;
            padding: 15px;
            border-bottom: 3px solid #b34b4b;
        }
        .card img {
            height: 140px;
            object-fit: cover;
            background: #ddd;
        }
        .footer {
            background-color: #b34b4b;
            padding: 20px;
            border-radius: 10px;
        }
        .carousel-indicators [data-bs-target] {
            background-color: #b34b4b;
        }
    </style>
</head>

<body>

    <!-- TOP BAR -->
    <div class="top-bar d-flex justify-content-end align-items-center">
        <a href="<?= site_url('auth/login') ?>" class="btn btn-light btn-sm me-2">Login</a>
        <a href="<?= site_url('auth/register') ?>" class="btn btn-light btn-sm">Register</a>
    </div>

    <!-- CAROUSEL -->
    <div id="bannerCarousel" class="carousel slide mt-3" data-bs-ride="carousel">

        <!-- Indicators -->
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#bannerCarousel" data-bs-slide-to="0" class="active"></button>
            <button type="button" data-bs-target="#bannerCarousel" data-bs-slide-to="1"></button>
            <button type="button" data-bs-target="#bannerCarousel" data-bs-slide-to="2"></button>
        </div>

        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="https://placehold.co/600x180" class="d-block w-100 rounded">
            </div>
            <div class="carousel-item">
                <img src="https://placehold.co/600x180?text=Banner+2" class="d-block w-100 rounded">
            </div>
            <div class="carousel-item">
                <img src="https://placehold.co/600x180?text=Banner+3" class="d-block w-100 rounded">
            </div>
        </div>
    </div>

    <!-- SEARCH BAR -->
    <div class="container mt-4">
        <form method="get" action="<?= site_url('kamar/search') ?>">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Cari kamar...">
                <button class="btn btn-success">Search</button>
            </div>
        </form>
    </div>

    <!-- GRID KAMAR -->
    <div class="container mt-4">

        <div class="row">
            <?php if (!empty($rooms)) : ?>
                <?php foreach ($rooms as $r): ?>
                    <div class="col-6 col-md-4 mb-4">
                        <div class="card shadow-sm">
                            <img src="<?= $r->foto ?>" alt="">
                            <div class="card-body text-center">
                                <a href="<?= site_url('kamar/detail/'.$r->id) ?>" class="btn btn-primary btn-sm">Pesan</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else : ?>
                <div class="col-12 text-center py-4">
                    Tidak ada kamar ditemukan.
                </div>
            <?php endif; ?>
        </div>

    </div>

    <!-- PAGINATION DOTS -->
    <div class="text-center mb-4">
        <span class="mx-1">•</span>
        <span class="mx-1">•</span>
        <span class="mx-1">•</span>
    </div>

    <!-- FOOTER -->
    <div class="container mb-4">
        <div class="footer text-center text-white">
            <div>
                <i class="fab fa-instagram mx-2"></i>
                <i class="fab fa-facebook mx-2"></i>
                <i class="fab fa-whatsapp mx-2"></i>
            </div>
            <div class="mt-2">
                © 2025 Kostku Company All Rights Reserved
            </div>
        </div>
    </div>


    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
