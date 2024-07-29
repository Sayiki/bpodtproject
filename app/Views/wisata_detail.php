<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $wisata['nama_wisata'] ?> - Caldera Insight</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="<?= base_url() ?>">
                <span style="color: #ffffff;">Caldera</span> <span style="color: #ff0000;">Insight</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url() ?>">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('#datawisata') ?>">Data Wisata</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('login') ?>">Login Admin</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h1><?= $wisata['nama_wisata'] ?></h1>
        <p><strong>Deskripsi:</strong> <?= $wisata['deskripsi'] ?></p>
        <?php if (!empty($wisata['image'])): ?>
            <img src="<?= base_url('public/' . $wisata['image']) ?>" alt="<?= $wisata['nama_wisata'] ?>" class="img-fluid mt-3">
        <?php endif; ?>
        <?php if (!empty($wisata['peta'])): ?>
            <div class="mt-3">
                <h3>Lokasi</h3>
                <img src="<?= base_url('public/' . $wisata['peta']) ?>" alt="<?= $wisata['nama_wisata'] ?>" class="img-fluid mt-3">
            </div>
        <?php endif; ?>
        <a href="<?= base_url() ?>" class="btn btn-primary mt-3">Back to Home</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>