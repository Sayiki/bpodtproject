<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Landing Page - Caldera Insight</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <style>
        .hero {
            color: black;
            text-align: center;
            padding: 100px 0;
        }
        .hero h1 {
            font-size: 4rem;
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }
        .petalokasi {
            padding: 50px 0;
        }
        #map {
            width: 100%;
            height: 500px;
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <span style="color: #ffffff;">Caldera</span> <span style="color: #ff0000;">Insight</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#datawisata">Data Wisata</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#testimonials">Testimonials</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#galeri">Galeri</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('login') ?>">Login Admin</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero" style="background-image: url('public/images/bg-lake-toba.jpg'); background-size: cover; background-position: center;">
        <div class="container">
            <h1>Selamat Datang di <span style="color: #ffffff;">Caldera</span> <span style="color: #ff0000;">Insight</span></h1>
            <p>Jelajahi Keindahan Wisata Caldera disini.</p>
            <a href="#datawisata" class="btn btn-primary btn-lg">Pelajari Selengkapnya</a>
        </div>
    </section>

    <!-- Peta Lokasi Section -->
    <section class="petalokasi">
        <div class="container">
            <h2 class="text-center mb-5">Peta Lokasi Wisata Caldera Toba</h2>
            <div id="map"></div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section id="testimonials" class="py-5 bg-light">
        <div class="container">
            <h2 class="text-center mb-5">Jangkauan Lokasi Wisata</h2>
            <div class="row">
                <p>
                    Wisata yang masuk dalam jangkauan dari website ini meliputi Wisata Kaldera Toba yang menjadi titik utama pembahasan dari website ini. Lokasi dari wisata ini juga menyangkut wilayah yang sesuai dengan tugas BPODT secara Otoritatif. Lokasi tersebut adalah lokasi-lokasi yang berhubungan langsung dengan wilayah Caldera yang dijadikan sebagai tempat wisata dengan luas yang diketahui yaitu 386,72 ha. Dalam website ini juga nantinya akan selalu melakukan update terhadap situasi yang terbaru terkait wahana yang ada di Caldera dari waktu ke waktu. Dalam konteks wisata, website ini mencoba menghadirkan insight dan info lebih terkait wisata yang ada di Caldera kepada para pengunjung untuk menarik perhatian mereka terhadap keindahan Danau Toba yang terletak persis dengan Caldera. Oleh karena itu jangkauan lokasi wisata yang ada di Caldera akan diusahakan ada pada website ini. Terima Kasih dan Sampai Jumpa Di Caldera.
                </p>
            </div>
        </div>
    </section>

    <!-- Galeri Section -->
    <section id="galeri" class="galerywisata py-5 bg-light">
        <div class="container">
            <h2 class="text-center mb-5">Galeri Top Caldera</h2>
            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="public/images/wisata1.jpeg" class="card-img-top" alt="Wisata 1">
                        <div class="card-body">
                            <h5 class="card-title">Wisata 1</h5>
                            <!-- <p class="card-text">Deskripsi singkat tentang wisata 1.</p> -->
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="public/images/wisata2.jpeg" class="card-img-top" alt="Wisata 2">
                        <div class="card-body">
                            <h5 class="card-title">Wisata 2</h5>
                            <!-- <p class="card-text">Deskripsi singkat tentang wisata 2.</p> -->
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="public/images/wisata3.jpeg" class="card-img-top" alt="Wisata 3">
                        <div class="card-body">
                            <h5 class="card-title">Wisata 3</h5>
                            <!-- <p class="card-text">Deskripsi singkat tentang wisata 3.</p> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Data Wisata Section -->
    <section id="datawisata" class="py-5">
        <div class="container">
            <h2 class="text-center mb-5">Data Wisata</h2>
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Wisata</th>
                                <th>Deskripsi</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($wisata) && is_array($wisata)): ?>
                                <?php foreach ($wisata as $key => $item): ?>
                                    <tr>
                                        <td><?= $key + 1 ?></td>
                                        <td><?= $item['nama_wisata'] ?></td>
                                        <td><?= $item['deskripsi'] ?></td>
                                        <td>
                                            <a href="<?= base_url('wisata/detail/' . $item['wisata_id']) ?>" class="btn btn-info btn-sm">Details</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="4" class="text-center">No data available</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <?php if (!empty($wisata) && is_array($wisata)): ?>
        <?php foreach ($wisata as $item): ?>
            <div class="modal fade" id="detailModal<?= $item['wisata_id'] ?>" tabindex="-1" aria-labelledby="detailModalLabel<?= $item['wisata_id'] ?>" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="detailModalLabel<?= $item['wisata_id'] ?>"><?= $item['nama_wisata'] ?></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p><?= $item['deskripsi'] ?></p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>

    <!-- Footer -->
    <footer id="contact" class="py-5 bg-dark text-white">
        <div class="container text-center">
            <p>Contact us at info@bpodt.id</p>
            <p>&copy; 2024 BPODT. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var map = L.map('map').setView([2.606848, 98.945844], 10); // Center on Caldera Toba
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);
            var marker = L.marker([2.606848, 98.945844]).addTo(map);
            marker.bindPopup("<b>Caldera Toba</b>").openPopup();
        });
    </script>
</body>
</html>
