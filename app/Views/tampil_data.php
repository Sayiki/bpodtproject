<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Dashboard Admin' ?> - Caldera Insight</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <style>
        body {
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            min-width: 250px;
            max-width: 250px;
            background-color: #343a40;
            padding: 20px;
            color: #fff;
        }

        .sidebar a {
            display: block;
            padding: 10px;
            color: #fff;
            text-decoration: none;
            margin-bottom: 5px;
            border-radius: 5px;
        }

        .sidebar a:hover {
            background-color: #495057;
        }

        .content {
            flex: 1;
            padding: 20px;
        }

        .sidebar h3 {
            margin-bottom: 20px;
        }

        .sidebar h3::after {
            content: " Insight";
            color: #ff0000;
        }
    </style>
</head>

<body>
    <div class="sidebar">
        <h3>Caldera</h3>
        <a href="<?= base_url('dashboard'); ?>">Home Dashboard</a>
        <a href="<?= base_url('form_data'); ?>">Tambah Data</a>
        <a href="<?= base_url('tampil_data'); ?>">Data Wisata</a>
        <a href="<?= base_url('logout'); ?>" class="btn btn-danger mt-3">Logout</a>
    </div>
    <div class="container mt-5">
        <h2 class="mb-4">Data Wisata - Caldera Insight</h2>
        <form id="deleteForm" action="<?= base_url('wisata/delete_multiple') ?>" method="post">
            <div class="mb-3">
                <button type="submit" class="btn btn-danger" id="deleteSelected">Delete Selected</button>
            </div>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th><input type="checkbox" id="selectAll"></th>
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
                                <td><input type="checkbox" name="delete[]" value="<?= $item['wisata_id'] ?>"></td>
                                <td><?= $pager->getPerPage() * ($pager->getCurrentPage() - 1) + $key + 1 ?></td>
                                <td><?= $item['nama_wisata'] ?></td>
                                <td><?= $item['deskripsi'] ?></td>
                                <td>
                                    <button class="btn btn-primary btn-sm edit-btn"
                                        data-id="<?= $item['wisata_id'] ?>">Edit</button>
                                    <button class="btn btn-danger btn-sm delete-btn"
                                        data-id="<?= $item['wisata_id'] ?>">Delete</button>
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
        </form>
        <nav aria-label="Page navigation">
    <?= $pager->links('custom_pager') ?>
</nav>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Wisata</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editForm" enctype="multipart/form-data">
                        <input type="hidden" id="wisata_id" name="wisata_id">
                        <div class="mb-3">
                            <label for="nama_wisata" class="form-label">Nama Wisata</label>
                            <input type="text" class="form-control" id="nama_wisata" name="nama_wisata" required>
                        </div>
                        <div class="mb-3">
                            <label for="deskripsi" class="form-label">Deskripsi</label>
                            <textarea class="form-control" id="deskripsi" name="deskripsi" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="detail_url" class="form-label">Detail URL</label>
                            <input type="url" class="form-control" id="detail_url" name="detail_url">
                        </div>
                        <div class="mb-3">
                            <label for="image" class="form-label">Image</label>
                            <input type="file" class="form-control" id="image" name="image" accept="image/*">
                            <small class="form-text text-muted">Leave empty to keep the current image.</small>
                            <img id="current_image" src="" alt="Current Image"
                                style="max-width: 100px; margin-top: 10px; display: none;">
                        </div>
                        <div class="mb-3">
                            <label for="peta" class="form-label">Peta (Map)</label>
                            <input type="file" class="form-control" id="peta" name="peta" accept="image/*">
                            <small class="form-text text-muted">Leave empty to keep the current map image.</small>
                            <img id="current_peta" src="" alt="Current Peta"
                                style="max-width: 100px; margin-top: 10px; display: none;">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="saveChanges">Save changes</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            $('.edit-btn').on('click', function () {
                var id = $(this).data('id');
                console.log('Edit button clicked for ID:', id);
                $('#editModal').modal('show');

                $.ajax({
                    url: '<?= base_url('wisata/edit/') ?>' + id,
                    type: 'GET',
                    dataType: 'json',
                    success: function (response) {
                        console.log('AJAX response:', response);
                        $('#wisata_id').val(response.wisata_id);
                        $('#nama_wisata').val(response.nama_wisata);
                        $('#deskripsi').val(response.deskripsi);
                        $('#detail_url').val(response.detail_url);

                        if (response.image) {
                            $('#current_image').attr('src', '<?= base_url('public/') ?>' + response.image).show();
                        } else {
                            $('#current_image').hide();
                        }

                        if (response.peta) {
                            $('#current_peta').attr('src', '<?= base_url('public/') ?>' + response.peta).show();
                        } else {
                            $('#current_peta').hide();
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error('AJAX error:', error);
                    }
                });
            });

            $('#saveChanges').on('click', function () {
                var id = $('#wisata_id').val();
                var formData = new FormData($('#editForm')[0]);

                $.ajax({
                    url: '<?= base_url('wisata/update/') ?>' + id,
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    dataType: 'json',
                    success: function (response) {
                        if (response.success) {
                            alert(response.message);
                            $('#editModal').modal('hide');
                            location.reload();
                        } else {
                            alert('Failed to update data');
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error('Update error:', error);
                    }
                });
            });

            $('.delete-btn').on('click', function () {
                var id = $(this).data('id');
                console.log('Delete button clicked for ID:', id); // Add this line to log the ID

                if (confirm('Are you sure you want to delete this item?')) {
                    $.ajax({
                        url: '<?= base_url('wisata/delete/') ?>' + id,
                        type: 'POST',
                        dataType: 'json',
                        success: function (response) {
                            console.log('Delete response:', response); // Add this line to log the response
                            if (response.success) {
                                location.reload();
                            } else {
                                alert('Failed to delete item');
                            }
                        },
                        error: function (xhr, status, error) {
                            console.error('Delete error:', error);
                            console.log('XHR status:', status); // Add this line for more error details
                            console.log('XHR response:', xhr.responseText); // Add this line to see the server's response
                            alert('An error occurred while deleting the item');
                        }
                    });
                }
            });

            // Select All checkbox
            $('#selectAll').on('change', function () {
                $('input[name="delete[]"]').prop('checked', $(this).is(':checked'));
            });

            // Delete selected items
            $('#deleteSelected').on('click', function (e) {
                e.preventDefault();
                if ($('input[name="delete[]"]:checked').length > 0) {
                    if (confirm('Are you sure you want to delete the selected items?')) {
                        $('#deleteForm').submit();
                    }
                } else {
                    alert('Please select at least one item to delete.');
                }
            });
        });

    </script>



</body>

</html>