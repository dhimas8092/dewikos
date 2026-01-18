<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login User - Website Kost</title>
    <link rel="stylesheet" href="/assets/css/user.css"> 
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="user-body"> 
<div class="user-auth-wrapper">
    <div class="user-form-box">
        
        <h1 class="logo-text">LOGIN KOST</h1> 

        <div class="form-header header-login">
            <p class="form-subtitle">Masuk untuk melanjutkan pemesanan kamar.</p>
        </div>

        <?php if ($this->session->flashdata('error')) : ?>
            <div class="alert alert-danger custom-alert">
                <?= $this->session->flashdata('error') ?>
            </div>
        <?php endif; ?>

        <form method="post" action="<?= site_url('auth/proses_login') ?>">
            
            <div class="form-group">
                <label for="email"><i class="fas fa-envelope icon"></i> Email</label>
                <input type="email" id="email" name="email" class="form-input" placeholder="Masukkan email Anda" required>
            </div>
            
            <div class="form-group">
                <label for="password"><i class="fas fa-lock icon"></i> Password</label>
                <input type="password" id="password" name="password" class="form-input" placeholder="Masukkan password" required>
            </div>

            <button type="submit" class="btn-primary-user w-100">LOGIN</button>
        </form>
        
        <p class="auth-link-footer">
            Belum punya akun? <a href="<?= site_url('register') ?>">Daftar Sekarang</a>
        </p>
    </div>
</div>
<script>
    <?php if($this->session->flashdata('success')): ?>
        Swal.fire({
            icon: 'success',
            title: 'Akun Ditambahkan!',
            text: '<?= $this->session->flashdata('success') ?>',
            confirmButtonColor: '#7a3e3e'
        });
    <?php endif; ?>
    <?php if($this->session->flashdata('error')): ?>
        Swal.fire({
            icon: 'error',
            title: 'Registrasi Gagal',
            text: '<?= $this->session->flashdata('error') ?>',
            confirmButtonColor: '#7a3e3e'
        });
    <?php endif; ?>
</script>
</body>
</html>