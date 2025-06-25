<?php
// Ambil data kategori untuk dropdown
require_once 'config/database.php';
$kategori_stmt = $pdo->query("SELECT id, nama_kategori FROM kategori ORDER BY nama_kategori ASC");
$kategori_list = $kategori_stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="flex justify-between items-center mb-6">
    <h1 class="text-3xl font-bold">Tambah Kamar Baru</h1>
    <a href="index.php?page=kamar" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
        <i class="fas fa-arrow-left mr-2"></i> Kembali
    </a>
</div>

<div class="bg-white p-8 rounded-lg shadow-md">
    <form action="controllers/kamar_controller.php?action=store" method="POST" enctype="multipart/form-data">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="mb-4">
                <label for="nama_kamar" class="block text-gray-700 text-sm font-bold mb-2">Nama Kamar <span class="text-red-500">*</span></label>
                <input type="text" id="nama_kamar" name="nama_kamar" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700" required>
            </div>

            <div class="mb-4">
                <label for="id_kategori" class="block text-gray-700 text-sm font-bold mb-2">Kategori <span class="text-red-500">*</span></label>
                <select id="id_kategori" name="id_kategori" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700" required>
                    <option value="">-- Pilih Kategori --</option>
                    <?php foreach ($kategori_list as $kat): ?>
                        <option value="<?php echo $kat['id']; ?>"><?php echo htmlspecialchars($kat['nama_kategori']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-4">
                <label for="harga_per_malam" class="block text-gray-700 text-sm font-bold mb-2">Harga per Malam <span class="text-red-500">*</span></label>
                <input type="number" id="harga_per_malam" name="harga_per_malam" min="0" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700" required>
            </div>

            <div class="mb-4">
                <label for="stok" class="block text-gray-700 text-sm font-bold mb-2">Stok Kamar <span class="text-red-500">*</span></label>
                <input type="number" id="stok" name="stok" min="0" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700" required>
            </div>
        </div>

        <div class="mb-4">
            <label for="deskripsi" class="block text-gray-700 text-sm font-bold mb-2">Deskripsi</label>
            <textarea id="deskripsi" name="deskripsi" rows="4" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700"></textarea>
        </div>
        
        <div class="mb-6">
            <label for="gambar" class="block text-gray-700 text-sm font-bold mb-2">Gambar Kamar</label>
            <input type="file" id="gambar" name="gambar" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
            <p class="mt-1 text-sm text-gray-500">Format: JPG, PNG, JPEG. Ukuran maks: 2MB.</p>
        </div>

        <div class="flex items-center justify-end">
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                <i class="fas fa-save mr-2"></i> Simpan Kamar
            </button>
        </div>
    </form>
</div>