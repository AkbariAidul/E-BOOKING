<?php
// Pastikan ada ID yang dikirim
if (!isset($_GET['id'])) {
    echo '<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">ID Kategori tidak ditemukan.</div>';
    exit();
}

$id = $_GET['id'];
require_once 'config/database.php';

// Ambil data kategori berdasarkan ID
$stmt = $pdo->prepare("SELECT * FROM kategori WHERE id = ?");
$stmt->execute([$id]);
$kategori = $stmt->fetch(PDO::FETCH_ASSOC);

// Jika data tidak ditemukan
if (!$kategori) {
    echo '<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">Data kategori dengan ID ' . htmlspecialchars($id) . ' tidak ditemukan.</div>';
    exit();
}
?>

<div class="flex justify-between items-center mb-6">
    <h1 class="text-3xl font-bold">Edit Kategori</h1>
    <a href="index.php?page=kategori" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
        <i class="fas fa-arrow-left mr-2"></i> Kembali
    </a>
</div>

<div class="bg-white p-8 rounded-lg shadow-md">
    <form action="controllers/kategori_controller.php?action=update" method="POST">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($kategori['id']); ?>">

        <div class="mb-4">
            <label for="nama_kategori" class="block text-gray-700 text-sm font-bold mb-2">Nama Kategori <span class="text-red-500">*</span></label>
            <input type="text" id="nama_kategori" name="nama_kategori" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="<?php echo htmlspecialchars($kategori['nama_kategori']); ?>" required>
        </div>

        <div class="mb-6">
            <label for="deskripsi" class="block text-gray-700 text-sm font-bold mb-2">Deskripsi</label>
            <textarea id="deskripsi" name="deskripsi" rows="4" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"><?php echo htmlspecialchars($kategori['deskripsi']); ?></textarea>
        </div>

        <div class="flex items-center justify-end">
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                <i class="fas fa-sync-alt mr-2"></i> Perbarui
            </button>
        </div>
    </form>
</div>