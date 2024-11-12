<?= $this->extend('layout') ?>

<?= $this->section('content') ?>

<html lang="en">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<meta name="X-CSRF-TOKEN" content="<?= csrf_hash() ?>">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gallery Configuration</title>
</head>


<div class="container mx-auto p-6">
    <div class="flex justify-between items-center mb-6">
        <div class="flex items-center">
            <h1 class="text-3xl font-bold">Gallery Configuration - Caldera Insight</h1>
            <button class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded ml-4" id="add-btn">Add
                New Data</button>
        </div>
    </div>
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex justify-between mb-4">
            <div class="text-lg font-semibold">Data List</div>
            <div class="flex space-x-2">
                <button class="bg-gray-300 text-gray-700 px-3 py-1 rounded font-bold" id="save-btn">Save</button>
                <button class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded"
                    id="delete-selected-btn">Delete Selected</button>
                <a href="<?= site_url('gallery/manage-featured') ?>"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Manage Featured Galleries
                </a>
            </div>
        </div>
        <ul id="sortable-list" class="space-y-4">
            <?php foreach ($data as $item): ?>
                <li class="flex items-center space-x-4 bg-gray-50 p-4 rounded" data-id="<?= $item['id'] ?>">
                    <input type="checkbox" class="select-item">
                    <span class="drag-handle">&#9776;</span>
                    <span class="font-semibold"><?= $item['title'] ?></span>
                    <div class="flex-grow"></div>
                    <img src="<?= 'public/' . $item['image'] ?>" alt="<?= $item['title'] ?>"
                        class="w-40 h-30 object-cover rounded">
                    <div class="flex space-x-2">
                        <button
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 rounded text-sm edit-btn"
                            data-id="<?= $item['id'] ?>">
                            <i class="fas fa-pencil-alt"></i>
                        </button>
                        <button
                            class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded text-sm delete-btn"
                            data-id="<?= $item['id'] ?>">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
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



<!-- Modal -->
<div class="modal opacity-0 pointer-events-none fixed w-full h-full top-0 left-0 flex items-center justify-center">
    <div class="modal-overlay absolute w-full h-full bg-gray-900 opacity-50"></div>

    <div class="modal-container bg-white w-11/12 md:max-w-md mx-auto rounded shadow-lg z-50 overflow-y-auto">
        <div class="modal-content py-4 text-left px-6">
            <div class="flex justify-between items-center pb-3">
                <p class="text-2xl font-bold">Add Gallery Item</p>
                <div class="modal-close cursor-pointer z-50">
                    <svg class="fill-current text-black" xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                        viewBox="0 0 18 18">
                        <path
                            d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z">
                        </path>
                    </svg>
                </div>
            </div>

            <form id="gallery-form" enctype="multipart/form-data">
                <input type="hidden" id="edit-id" name="edit-id">
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="title">
                        Title
                    </label>
                    <input
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        id="title" name="title" type="text" placeholder="Enter title">
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="image">
                        Image
                    </label>
                    <input
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        id="image" name="image" type="file" accept="image/*">
                </div>
                <div class="flex justify-end pt-2">
                    <button class="modal-submit px-4 bg-indigo-500 p-3 rounded-lg text-white hover:bg-indigo-400"
                        type="submit">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script type="module">
    import Sortable from 'https://cdn.skypack.dev/sortablejs';

    const sortableList = document.getElementById('sortable-list');
    new Sortable(sortableList, {
        animation: 150,
        handle: '.drag-handle',
        onEnd: function (evt) {
            console.log('Item moved from index ' + evt.oldIndex + ' to ' + evt.newIndex);
        }
    });

    // Modal functionality
    const modal = document.querySelector('.modal');
    const body = document.querySelector('body');
    const addBtn = document.getElementById('add-btn');
    console.log('Add button:', addBtn);
    const closeBtn = document.querySelector('.modal-close');
    const form = document.getElementById('gallery-form');

    function toggleModal() {
        modal.classList.toggle('opacity-0');
        modal.classList.toggle('pointer-events-none');
        body.classList.toggle('modal-active');
        console.log('Modal classes:', modal.classList);
    }

    addBtn.addEventListener('click', function () {
        console.log('Add button clicked'); // Debug log
        resetForm();
        toggleModal();
    });

    document.getElementById('add-btn').addEventListener('click', function () {
        window.location.href = '<?= site_url('gallery/add') ?>';
    });

    closeBtn.addEventListener('click', toggleModal);

    // Close modal on background click
    modal.querySelector('.modal-overlay').addEventListener('click', toggleModal);

    form.addEventListener('submit', function (e) {
        e.preventDefault();
        const formData = new FormData(this);
        const editId = document.getElementById('edit-id').value;

        if (editId) {
            updateGalleryItem(editId, formData);
        } else {
            createGalleryItem(formData);
        }
    });

    // Add event listeners for edit and delete buttons
    sortableList.addEventListener('click', function (e) {
        if (e.target.classList.contains('edit-btn')) {
            console.log('Edit clicked for:', e.target.closest('li').querySelector('.font-semibold').textContent);
        } else if (e.target.classList.contains('delete-btn')) {
            console.log('Delete clicked for:', e.target.closest('li').querySelector('.font-semibold').textContent);
        }
    });

    document.getElementById('save-btn').addEventListener('click', function () {
        console.log('Save button clicked');
    });

    function createGalleryItem(formData) {
        fetch('gallery/create', {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="X-CSRF-TOKEN"]').getAttribute('content')
            }
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    console.log('Success:', data.message);
                    toggleModal();
                    location.reload();
                } else {
                    console.error('Error:', data.message);
                    alert('Failed to create item: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An unexpected error occurred while creating the item.');
            });
    }

    // Add this function to your existing JavaScript
    function deleteGalleryItem(id) {
        if (confirm('Are you sure you want to delete this item?')) {
            fetch(`gallery/delete/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="X-CSRF-TOKEN"]').getAttribute('content')
                }
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        console.log('Success:', data.message);
                        // Remove the deleted item from the DOM
                        document.querySelector(`li[data-id="${id}"]`).remove();
                    } else {
                        console.error('Error:', data.message);
                        alert('Failed to delete item: ' + data.message);
                    }
                })
                .catch((error) => {
                    console.error('Error:', error);
                    alert('An unexpected error occurred while deleting the item.');
                });
        }
    }

    // Update your existing event listener for the delete button
    sortableList.addEventListener('click', function (e) {
        if (e.target.classList.contains('edit-btn')) {
            console.log('Edit clicked for:', e.target.closest('li').querySelector('.font-semibold').textContent);
        } else if (e.target.classList.contains('delete-btn')) {
            const listItem = e.target.closest('li');
            const itemId = listItem.dataset.id;
            deleteGalleryItem(itemId);
        }
    });

    function editGalleryItem(id) {
        fetch(`gallery/edit/${id}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('title').value = data.data.title;
                    document.getElementById('edit-id').value = id;
                    document.querySelector('.modal-content p').textContent = 'Edit Gallery Item';
                    toggleModal();
                } else {
                    alert('Failed to load item data: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An unexpected error occurred while loading item data.');
            });
    }

    function resetForm() {
        form.reset();
        document.getElementById('edit-id').value = '';
        document.querySelector('.modal-content p').textContent = 'Add Gallery Item';
    }

    // Call this function when the "Add" button is clicked
    addBtn.addEventListener('click', function () {
        resetForm();
        toggleModal();
    });

    function updateGalleryItem(id, formData) {
        fetch(`gallery/update/${id}`, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="X-CSRF-TOKEN"]').getAttribute('content')
            }
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    console.log('Success:', data.message);
                    toggleModal();
                    location.reload();
                } else {
                    console.error('Error:', data.message);
                    alert('Failed to update item: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An unexpected error occurred while updating the item.');
            });
    }

    function saveGalleryOrder() {
        const items = Array.from(document.querySelectorAll('#sortable-list li')).map((li, index) => ({
            id: li.dataset.id,
            order: index
        }));

        fetch('gallery/save-order', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="X-CSRF-TOKEN"]').getAttribute('content')
            },
            body: JSON.stringify(items)
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    console.log('Success:', data.message);
                    alert('Gallery order saved successfully');
                } else {
                    console.error('Error:', data.message);
                    alert('Failed to save gallery order: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An unexpected error occurred while saving the gallery order.');
            });
    

    function setHomeGallery(ids) {
        fetch('/gallery/setHome', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="X-CSRF-TOKEN"]').getAttribute('content')
            },
            body: JSON.stringify({ ids: ids })
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(data.message);
                    location.reload();
                } else {
                    alert(data.message || 'Failed to set items as Home Gallery');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while setting the Home Gallery.');
            });
    }



    sortableList.addEventListener('click', function (e) {
        if (e.target.classList.contains('edit-btn')) {
            const listItem = e.target.closest('li');
            const itemId = listItem.dataset.id;
            editGalleryItem(itemId);
        } else if (e.target.classList.contains('delete-btn')) {
            const listItem = e.target.closest('li');
            const itemId = listItem.dataset.id;
            deleteGalleryItem(itemId);
        }
    });

    // Add event listener for the save button
    document.getElementById('save-btn').addEventListener('click', saveGalleryOrder);

    // Add this to your existing JavaScript

    document.getElementById('delete-selected-btn').addEventListener('click', function () {
        const selectedItems = document.querySelectorAll('.select-item:checked');
        if (selectedItems.length === 0) {
            alert('Please select items to delete');
            return;
        }

        if (confirm(`Are you sure you want to delete ${selectedItems.length} item(s)?`)) {
            const itemIds = Array.from(selectedItems).map(checkbox => checkbox.closest('li').dataset.id);

            fetch('gallery/delete-multiple', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="X-CSRF-TOKEN"]').getAttribute('content')
                },
                body: JSON.stringify({ ids: itemIds })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        console.log('Success:', data.message);
                        // Remove the deleted items from the DOM
                        selectedItems.forEach(checkbox => checkbox.closest('li').remove());
                    } else {
                        console.error('Error:', data.message);
                        alert('Failed to delete items: ' + data.message);
                    }
                })
                .catch((error) => {
                    console.error('Error:', error);
                    alert('An unexpected error occurred while deleting the items.');
                });
        }
    });
</script>

</html>

<?= $this->endSection() ?>