<!DOCTYPE html>
<html>
<head>
    <title>Login Admin</title>
    <link rel="stylesheet" href="/assets/css/admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"> </head>
<body class="login-body">

    <div class="login-container">
        <h1 class="welcome-text">WELCOMEBACK</h1>
        <p class="subtitle">welcomeback, please enter your detail</p>

        <?php if ($this->session->flashdata('error')): ?>
            <div class="alert alert-danger custom-alert">
                <?= $this->session->flashdata('error') ?>
            </div>
        <?php endif; ?>

        <form method="post" action="<?= site_url('login/proses') ?>">

            <div class="input-group-custom">
                <i class="fas fa-envelope icon"></i>
                <input type="text" name="username" placeholder="Enter your email" required>
            </div>

            <div class="input-group-custom">
                <i class="fas fa-lock icon"></i>
                <input type="password" name="password" placeholder="Enter password" required>
            </div>

            <button type="submit" class="login-button">Login</button>
        </form>
    </div>

</body>
</html>