<!-- app/Views/form_data.php -->
<?= $this->extend('layout') ?>

<?= $this->section('content') ?>

<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success">
        <?= session()->getFlashdata('success') ?>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger">
        <?php
        $error = session()->getFlashdata('error');
        if (is_array($error)) {
            foreach ($error as $err) {
                echo $err . '<br>';
            }
        } else {
            echo $error;
        }
        ?>
    </div>
<?php endif; ?>
<div class="container mt-5">
    <h2 class="mb-4">Input Data Wisata - Caldera Insight</h2>

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
            <label for="nama_wisata" class="form-label">Link Informasi</label>
            <input type="text" class="form-control" id="detail_url" name="detail_url" required>
        </div>
        <div class="mb-3">
            <label for="gambar_wisata" class="form-label">Gambar Wisata</label>
            <input type="file" class="form-control" id="gambar_wisata" name="gambar_wisata" accept="image/*" required>
            <small class="form-text text-muted">Upload gambar wisata (format: JPG, PNG, GIF)</small>
        </div>
        <div class="mb-3">
            <label for="peta_wisata" class="form-label">Peta Wisata</label>
            <input type="file" class="form-control" id="peta_wisata" name="peta_wisata" accept="image/*" required>
            <small class="form-text text-muted">Upload peta wisata (format: JPG, PNG, GIF)</small>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>
<?= $this->endSection() ?>