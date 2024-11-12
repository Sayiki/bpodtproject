<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
<div class="container mx-auto p-6">
    <h1 class="text-3xl font-bold mb-6">Welcome to Admin Dashboard - Caldera Insight</h1>
    <div class="bg-white rounded-lg shadow-md p-6">
        <h2 class="text-2xl font-semibold mb-4">Dashboard Statistics</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-blue-100 rounded-lg p-4">
                <h5 class="text-xl font-semibold mb-2">Total Wisata Locations</h5>
                <p class="text-3xl font-bold text-blue-600"><?= $totalWisata ?? 'N/A' ?></p>
            </div>
            <div class="bg-green-100 rounded-lg p-4">
                <h5 class="text-xl font-semibold mb-2">Total Site Visits</h5>
                <p class="text-3xl font-bold text-green-600"><?= $totalVisits ?? 'N/A' ?></p>
            </div>
        </div>

        <?php if (isset($mostVisitedWisata) && !empty($mostVisitedWisata)): ?>
        <h3 class="text-xl font-semibold mt-8 mb-4">Most Visited Attraction Pages</h3>
        <ul class="space-y-4">
            <?php foreach ($mostVisitedWisata as $wisata): ?>
            <li class="flex items-center justify-between bg-gray-50 p-4 rounded">
                <span class="font-semibold"><?= $wisata['nama_wisata'] ?></span>
                <span class="bg-blue-500 text-white px-3 py-1 rounded-full"><?= $wisata['visit_count'] ?> visits</span>
            </li>
            <?php endforeach; ?>
        </ul>
        <?php endif; ?>
    </div>
</div>
<?= $this->endSection() ?>