<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
<div class="container mx-auto p-6">
<div class="flex items-center">
        <h1 class="text-3xl font-bold mr-4">Data Wisata - Caldera Insight</h1>
        <a href="<?= base_url('form_data'); ?>"
           class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Add New Data</a>
    </div>
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex justify-between mb-4">
            <div class="text-lg font-semibold">Data List</div>
            <div>
                <button type="submit" form="deleteForm"
                    class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded"
                    id="deleteSelected">Delete Selected</button>
            </div>
        </div>
        <form id="deleteForm" action="<?= base_url('wisata/delete_multiple') ?>" method="post">
            <div class="overflow-x-auto">
                <table class="w-full border-collapse">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="border-b p-2 text-left"><input type="checkbox" id="selectAll"></th>
                            <th class="border-b p-2 text-left">No</th>
                            <th class="border-b p-2 text-left">Nama Wisata</th>
                            <th class="border-b p-2 text-left">Deskripsi</th>
                            <th class="border-b p-2 text-left">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($wisata) && is_array($wisata)): ?>
                            <?php foreach ($wisata as $key => $item): ?>
                                <tr class="hover:bg-gray-50">
                                    <td class="border-b p-2"><input type="checkbox" name="delete[]"
                                            value="<?= $item['wisata_id'] ?>"></td>
                                    <td class="border-b p-2">
                                        <?= $pager->getPerPage() * ($pager->getCurrentPage() - 1) + $key + 1 ?>
                                    </td>
                                    <td class="border-b p-2"><?= $item['nama_wisata'] ?></td>
                                    <td class="border-b p-2"><?= substr($item['deskripsi'], 0, 100) ?>...</td>
                                    <td class="border-b p-2">
                                        <button
                                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 rounded text-sm edit-btn"
                                            data-id="<?= $item['wisata_id'] ?>">
                                            <i class="fas fa-pencil-alt"></i>
                                        </button>
                                        <button
                                            class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded text-sm delete-btn"
                                            data-id="<?= $item['wisata_id'] ?>">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="border-b p-2 text-center">No data available</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </form>
        <div class="mt-4 flex justify-between items-center">
            <div>Showing <?= $pager->getPerPage() * ($pager->getCurrentPage() - 1) + 1 ?> to
                <?= min($pager->getPerPage() * $pager->getCurrentPage(), $pager->getTotal()) ?> of
                <?= $pager->getTotal() ?> entries
            </div>
            <div class="mt-4">
                <?= $pager->links('default', 'buttons_pagination') ?>
            </div>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
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
        $('.edit-btn').on('click', function (e) {
            e.preventDefault(); // Prevent the default form submission behavior
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
            console.log('Delete button clicked for ID:', id);

            if (confirm('Are you sure you want to delete this item?')) {
                $.ajax({
                    url: '<?= base_url('wisata/delete/') ?>' + id,
                    type: 'POST',
                    dataType: 'json',
                    success: function (response) {
                        console.log('Delete response:', response);
                        if (response.success) {
                            location.reload();
                        } else {
                            alert('Failed to delete item');
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error('Delete error:', error);
                        console.log('XHR status:', status);
                        console.log('XHR response:', xhr.responseText);
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

<?= $this->endSection() ?>