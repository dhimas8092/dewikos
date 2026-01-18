<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profil</title>
    <link rel="stylesheet" href="/assets/css/user.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body class="user-body-default">

    <header class="user-header">
        <div class="user-header-content">
            <a href="<?= site_url('profil') ?>" class="header-logo"><i class="fas fa-arrow-left"></i> Kembali</a>
            <h1 class="header-title-page">Edit Profil Saya</h1>
            <div style="width: 80px;"></div>
        </div>
    </header>

    <div class="user-container mt-40">
        <div class="form-edit-wrapper">
            <div class="pr-detail-wrapper shadow-lg">
                <h2 class="form-title-user">Update Profil</h2>

                <form action="<?= base_url('profil/update') ?>" method="post">
                    <div class="form-group-custom">
                        <label><i class="fas fa-user"></i> Nama Lengkap</label>
                        <input type="text" name="nama" class="form-input" value="<?= $user->nama ?? '' ?>" required>
                    </div>

                    <div class="form-group-custom">
                        <label><i class="fab fa-whatsapp"></i> Nomor WhatsApp</label>
                        <input type="text" name="no_hp" class="form-input" value="<?= $user->no_hp ?? '' ?>" placeholder="0812...." required>
                    </div>

                    <div class="form-group-custom">
                        <label><i class="fas fa-envelope"></i> Email</label>
                        <input type="email" name="email" class="form-input" value="<?= $user->email ?? '' ?>" required>
                    </div>

                    <div class="form-group-custom">
                        <label><i class="fas fa-lock"></i> Password Baru</label>
                        <input type="password" name="password" class="form-input" placeholder="Kosongkan jika tidak diganti">
                    </div>

                    <button type="submit" class="btn-save-premium">
                        <i class="fas fa-check-circle"></i> SIMPAN PERUBAHAN
                    </button>
                </form>
            </div>
        </div>
    </div>

</body>

</html>