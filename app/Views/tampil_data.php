<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Data Tampil - Caldera Insight</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body>
    <div class="container">
                <h2 class="text-left mb-5">Data Wisata - Caldera Insight</h2>
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
                                            <td><?= $item['nama'] ?></td>
                                            <td><?= $item['deskripsi'] ?></td>
                                            <td>
                                                <a href="<?= base_url('wisata/detail/' . $item['id']) ?>" class="btn btn-info btn-sm">Detail &Lokasi</a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="5" class="text-center">No data available</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
    </body>