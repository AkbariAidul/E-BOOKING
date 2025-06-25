<?php
// Validasi ID
if (!isset($_GET['id'])) {
    echo '<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">ID Kamar tidak ditemukan.</div>';
    exit();
}

$id = $_GET['id'];
require_once 'config/database.php';

// 1. Ambil data kamar berdasarkan ID
$stmt = $pdo->prepare("SELECT * FROM kamar WHERE id = ?");
$stmt->execute([$id]);
$kamar = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$kamar) {
    echo '<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">Data kamar tidak ditemukan.</div>';
    exit();
}

// 2. Ambil semua data kategori untuk dropdown
$kategori_stmt = $pdo->query("SELECT id, nama_kategori FROM kategori ORDER BY nama_kategori ASC");
$kategori_list = $kategori_stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="flex justify-between items-center mb-6">
    <h1 class="text-3xl font-bold">Edit Kamar</h1>
    <a href="index.php?page=kamar" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
        <i class="fas fa-arrow-left mr-2"></i> Kembali
    </a>
</div>

<div class="bg-white p-8 rounded-lg shadow-md">
    <form action="controllers/kamar_controller.php?action=update" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo $kamar['id']; ?>">
        <input type="hidden" name="gambar_lama" value="<?php echo htmlspecialchars($kamar['gambar']); ?>">

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="mb-4">
                <label for="nama_kamar" class="block text-gray-700 text-sm font-bold mb-2">Nama Kamar <span class="text-red-500">*</span></label>
                <input type="text" id="nama_kamar" name="nama_kamar" class="shadow appearance-none border rounded w-full py-2 px-3" value="<?php echo htmlspecialchars($kamar['nama_kamar']); ?>" required>
            </div>

            <div class="mb-4">
                <label for="id_kategori" class="block text-gray-700 text-sm font-bold mb-2">Kategori <span class="text-red-500">*</span></label>
                <select id="id_kategori" name="id_kategori" class="shadow appearance-none border rounded w-full py-2 px-3" required>
                    <option value="">-- Pilih Kategori --</option>
                    <?php foreach ($kategori_list as $kat): ?>
                        <option value="<?php echo $kat['id']; ?>" <?php echo ($kat['id'] == $kamar['id_kategori']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($kat['nama_kategori']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-4">
                <label for="harga_per_malam" class="block text-gray-700 text-sm font-bold mb-2">Harga per Malam <span class="text-red-500">*</span></label>
                <input type="number" id="harga_per_malam" name="harga_per_malam" min="0" class="shadow appearance-none border rounded w-full py-2 px-3" value="<?php echo htmlspecialchars($kamar['harga_per_malam']); ?>" required>
            </div>

            <div class="mb-4">
                <label for="stok" class="block text-gray-700 text-sm font-bold mb-2">Stok Kamar <span class="text-red-500">*</span></label>
                <input type="number" id="stok" name="stok" min="0" class="shadow appearance-none border rounded w-full py-2 px-3" value="<?php echo htmlspecialchars($kamar['stok']); ?>" required>
            </div>
        </div>

        <div class="mb-4">
            <label for="deskripsi" class="block text-gray-700 text-sm font-bold mb-2">Deskripsi</label>
            <textarea id="deskripsi" name="deskripsi" rows="4" class="shadow appearance-none border rounded w-full py-2 px-3"><?php echo htmlspecialchars($kamar['deskripsi']); ?></textarea>
        </div>
        
        <div class="mb-6">
            <label class="block text-gray-700 text-sm font-bold mb-2">Gambar Kamar</label>
            <div class="flex items-center space-x-6">
                <div class="shrink-0">
                    <img class="h-20 w-32 object-cover rounded" src="uploads/<?php echo htmlspecialchars($kamar['gambar']); ?>" alt="Gambar saat ini" />
                </div>
                <label class="block">
                    <span class="sr-only">Pilih gambar baru</span>
                    <input type="file" id="gambar" name="gambar" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"/>
                </label>
            </div>
            <p class="mt-1 text-sm text-gray-500">Kosongkan jika tidak ingin mengubah gambar.</p>
        </div>

        <div class="flex items-center justify-end">
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                <i class="fas fa-sync-alt mr-2"></i> Perbarui Kamar
            </button>
        </div>
    </form>
</div>