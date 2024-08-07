<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
<<<<<<< Updated upstream
=======
        body {
            background: url('<?= base_url('public/images/bg-lake-toba.jpg') ?>') no-repeat center center fixed;
            background-size: cover;
            height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            margin: 0;
        }
>>>>>>> Stashed changes
        .login-container {
            display: flex;
            justify-content: center;
            align-items: center;
<<<<<<< Updated upstream
            height: 100vh;
=======
            flex-grow: 1;
            background: rgba(0, 0, 0, 0.5); /* Overlay untuk darken */
            padding: 20px;
>>>>>>> Stashed changes
        }
        .login-form {
            width: 300px;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 10px;
            background: #fff;
        }
        .footer {
            text-align: center;
            color: white;
            background: rgba(0, 0, 0, 0.5); /* Overlay untuk darken */
            padding: 10px 0;
        }
        .footer p {
            margin: 0;
            font-weight: bold; /* Mempertebal teks */
        }
    </style>
</head>
<body>
    <div class="container login-container">
        <div class="login-form">
            <h3 class="text-center">Login Admin</h3>
            <?php if(session()->getFlashdata('msg')): ?>
                <div class="alert alert-danger"><?= session()->getFlashdata('msg') ?></div>
            <?php endif; ?>
            <form action="<?= base_url('validate_login') ?>" method="post">
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username" name="username" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Login</button>
            </form>
        </div>
<<<<<<< Updated upstream
=======
    </div>
    <div class="footer">
        <p>© 2024 Badan Pelaksana Otorita Danau Toba (BPODT)</p>
>>>>>>> Stashed changes
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>