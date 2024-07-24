<!-- app/Views/form_data.php -->
<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
<div class="container mt-5">
    <h2 class="mb-4">Input Data Wisata - Caldera Insight</h2>

    <?php if(session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= session()->getFlashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <form action="<?= base_url('tambah_data'); ?>" method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="nama_wisata" class="form-label">Nama Wisata</label>
            <input type="text" class="form-control" id="nama_wisata" name="nama_wisata" required>
        </div>
        <div class="mb-3">
            <label for="deskripsi_wisata" class="form-label">Deskripsi Wisata</label>
            <textarea class="form-control" id="deskripsi_wisata" name="deskripsi_wisata" rows="3" required></textarea>
        </div>
        <div class="mb-3">
            <label for="gambar_wisata" class="form-label">Gambar Wisata</label>
            <input type="file" class="form-control" id="gambar_wisata" name="gambar_wisata" accept="image/*">
            <small class="form-text text-muted">Upload gambar wisata (format: JPG, PNG, GIF)</small>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>
<?= $this->endSection() ?>