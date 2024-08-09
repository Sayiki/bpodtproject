<?= $this->extend('layout') ?>

<?= $this->section('content') ?>

<div class="container mt-5">
    <h2 class="text-center mb-4">Gallery</h2>
    <div class="row">
        <?php foreach ($gallery as $item): ?>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <img src="<?= base_url($item['image_path']) ?>" class="card-img-top" alt="<?= $item['title'] ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?= $item['title'] ?></h5>
                        <?php if ($item['featured']): ?>
                            <span class="badge bg-primary">Featured</span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?= $this->endSection() ?>