<?= $this->extend('layout') ?>

<?= $this->section('content') ?>

<div class="container mx-auto p-6">
    <h1 class="text-3xl font-bold mb-6">Manage Featured Galleries</h1>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <form action="<?= site_url('gallery/update-featured') ?>" method="post">
        <?= csrf_field() ?>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <?php foreach ($galleries as $gallery): ?>
                <div class="border p-4 rounded">
                    <img src="<?= base_url('public/' . $gallery['image']) ?>" alt="<?= $gallery['title'] ?>" class="w-full h-40 object-cover mb-2">
                    <div class="flex items-center">
                        <input type="checkbox" name="featured[]" value="<?= $gallery['id'] ?>" <?= $gallery['is_featured'] ? 'checked' : '' ?> class="mr-2">
                        <label><?= $gallery['title'] ?></label>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="mt-6">
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Update Featured Galleries
            </button>
        </div>
    </form>
</div>

<?= $this->endSection() ?>