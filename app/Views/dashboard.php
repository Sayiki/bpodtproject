<!-- app/Views/dashboard.php -->
<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
<div class="container mt-5">
    <h1>Welcome to Admin Dashboard - Caldera Insight</h1>
    <h2>Dashboard Statistics</h2>

<div class="row">
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Total Wisata Locations</h5>
                <p class="card-text"><?= $totalWisata ?? 'N/A' ?></p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Total Site Visits</h5>
                <p class="card-text"><?= $totalVisits ?? 'N/A' ?></p>
            </div>
        </div>
    </div>
</div>

<?php if (isset($mostVisitedWisata) && !empty($mostVisitedWisata)): ?>
<h3 class="mt-4">Most Visited Wisata Locations</h3>
<table class="table">
    <thead>
        <tr>
            <th>Wisata Name</th>
            <th>Visit Count</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($mostVisitedWisata as $wisata): ?>
        <tr>
            <td><?= $wisata['nama_wisata'] ?></td>
            <td><?= $wisata['visit_count'] ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php endif; ?>
</div>
<?= $this->endSection() ?>