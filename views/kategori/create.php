<div class="flex justify-between items-center mb-6">
    <h1 class="text-3xl font-bold">Tambah Kategori Baru</h1>
    <a href="index.php?page=kategori" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
        <i class="fas fa-arrow-left mr-2"></i> Kembali
    </a>
</div>

<div class="bg-white p-8 rounded-lg shadow-md">
    <form action="controllers/kategori_controller.php?action=store" method="POST">
        <div class="mb-4">
            <label for="nama_kategori" class="block text-gray-700 text-sm font-bold mb-2">Nama Kategori <span class="text-red-500">*</span></label>
            <input type="text" id="nama_kategori" name="nama_kategori" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
        </div>

        <div class="mb-6">
            <label for="deskripsi" class="block text-gray-700 text-sm font-bold mb-2">Deskripsi</label>
            <textarea id="deskripsi" name="deskripsi" rows="4" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
        </div>

        <div class="flex items-center justify-end">
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                <i class="fas fa-save mr-2"></i> Simpan
            </button>
        </div>
    </form>
</div>