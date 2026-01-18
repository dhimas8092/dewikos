<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register User - Website Kost</title>
    <link rel="stylesheet" href="/assets/css/user.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="user-body">

<div class="user-auth-wrapper">
    <div class="user-form-box wide-form"> 
        
        <h1 class="logo-text">WEBSITE KOST</h1> 
        
        <div class="form-header header-register">
            <h2 class="form-title">DAFTAR AKUN BARU</h2>
            <p class="form-subtitle">Isi data di bawah untuk membuat akun baru.</p>
        </div>

        <?php if ($this->session->flashdata('error')) : ?>
            <div class="alert alert-danger custom-alert">
                <?= $this->session->flashdata('error') ?>
            </div>
        <?php endif; ?>

        <form method="post" action="<?= site_url('auth/proses_register') ?>">

            <div class="form-group">
                <label for="nama"><i class="fas fa-user icon"></i> Nama Lengkap</label>
                <input type="text" id="nama" name="nama" class="form-input" placeholder="Masukkan nama Anda" required>
            </div>

            <div class="form-group">
                <label for="email"><i class="fas fa-envelope icon"></i> Email</label>
                <input type="email" id="email" name="email" class="form-input" placeholder="Masukkan email aktif" required>
            </div>

            <div class="form-group">
                <label for="no_hp"><i class="fas fa-phone icon"></i> No HP</label>
                <input type="text" id="no_hp" name="no_hp" class="form-input" placeholder="Contoh: 0812xxxxxx" required>
            </div>

            <div class="form-group">
                <label for="password"><i class="fas fa-lock icon"></i> Password</label>
                <input type="password" id="password" name="password" class="form-input" placeholder="Buat password" required>
            </div>

            <button type="submit" class="btn-primary-user w-100 mt-2">DAFTAR</button> 
        </form>

        <p class="auth-link-footer">
            Sudah punya akun? <a href="<?= site_url('login') ?>">Login Sekarang</a>
        </p>
    </div>
</div>

</body>
</html>