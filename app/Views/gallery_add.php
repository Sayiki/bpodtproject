<?= $this->extend('layout') ?>

<?= $this->section('content') ?>

<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-6">Add Gallery Item</h1>
    <div class="bg-white rounded-lg shadow-md p-6">
        <form action="<?= site_url('gallery/create') ?>" method="post" enctype="multipart/form-data">
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="title">
                    Title
                </label>
                <input
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    id="title" name="title" type="text" placeholder="Enter title" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="image">
                    Image
                </label>
                <input
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    id="image" name="image" type="file" accept="image/*" required>
            </div>
            <div class="flex justify-end pt-2">
                <button class="px-4 bg-indigo-500 p-3 rounded-lg text-white hover:bg-indigo-400" type="submit">Save</button>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>