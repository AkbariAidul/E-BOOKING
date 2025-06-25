<?php
require_once 'config/database.php';

// Logika Search
$search = isset($_GET['search']) ? $_GET['search'] : '';
$whereClause = '';
if (!empty($search)) {
    $whereClause = "WHERE nama_kategori LIKE :search";
}

// Logika Pagination
$limit = 5; // Jumlah item per halaman
$page = isset($_GET['p']) ? (int)$_GET['p'] : 1;
$start = ($page > 1) ? ($page * $limit) - $limit : 0;

// Query untuk mengambil total data
$stmt_total = $pdo->prepare("SELECT COUNT(*) FROM kategori $whereClause");
if (!empty($search)) $stmt_total->bindValue(':search', '%' . $search . '%');
$stmt_total->execute();
$total_data = $stmt_total->fetchColumn();
$total_pages = ceil($total_data / $limit);

// Query untuk mengambil data dengan limit
$stmt = $pdo->prepare("SELECT * FROM kategori $whereClause ORDER BY id DESC LIMIT :start, :limit");
if (!empty($search)) $stmt->bindValue(':search', '%' . $search . '%');
$stmt->bindValue(':start', $start, PDO::PARAM_INT);
$stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
$stmt->execute();
$kategori = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="flex justify-between items-center mb-6">
    <h1 class="text-3xl font-bold text-gray-700">Manajemen Kategori</h1>
    <a href="index.php?page=kategori-create" class="bg-sky-500 hover:bg-sky-600 text-white font-bold py-2 px-4 rounded-lg flex items-center transition-colors">
        <i class="fas fa-plus mr-2"></i>Tambah Kategori
    </a>
</div>

<div class="bg-white shadow-lg rounded-xl border border-gray-200">
    <div class="p-4">
        <form method="GET">
            <input type="hidden" name="page" value="kategori">
            <div class="relative">
                <input type="text" name="search" class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-sky-300 focus:border-sky-500" placeholder="Cari nama kategori..." value="<?php echo htmlspecialchars($search); ?>">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-search text-gray-400"></i>
                </div>
            </div>
        </form>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Nama Kategori</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Deskripsi</th>
                    <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php if (count($kategori) > 0): ?>
                    <?php foreach ($kategori as $kat): ?>
                        <tr class="hover:bg-sky-50 transition-colors duration-200">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-800"><?php echo htmlspecialchars($kat['nama_kategori']); ?></td>
                            <td class="px-6 py-4 text-sm text-gray-600 max-w-sm truncate"><?php echo htmlspecialchars($kat['deskripsi'] ?: '-'); ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-center">
                                <a href="index.php?page=kategori-edit&id=<?php echo $kat['id']; ?>" class="text-sky-600 hover:text-sky-800 p-2 hover:bg-sky-100 rounded-full transition-colors" title="Edit">
                                    <i class="fas fa-edit fa-lg"></i>
                                </a>
                                <a href="#" onclick="confirmDelete(<?php echo $kat['id']; ?>)" class="text-red-500 hover:text-red-700 p-2 hover:bg-red-100 rounded-full transition-colors ml-2" title="Hapus">
                                    <i class="fas fa-trash fa-lg"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="3" class="text-center py-12">
                           <div class="flex flex-col items-center text-gray-400">
                               <i class="fa-solid fa-tags text-4xl mb-3"></i>
                               <p class="font-medium">Tidak ada data kategori ditemukan.</p>
                           </div>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <?php if ($total_pages > 1): ?>
    <div class="p-4 border-t border-gray-200">
        <nav class="flex justify-center">
            <ul class="flex items-center -space-x-px">
                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <li>
                    <a href="?page=kategori&p=<?php echo $i; ?>&search=<?php echo htmlspecialchars($search); ?>" 
                       class="py-2 px-3 leading-tight transition-colors duration-200 
                              <?php if ($i == $page): ?>
                                  bg-sky-500 text-white border border-sky-500 z-10
                              <?php else: ?>
                                  bg-white text-gray-500 border border-gray-300 hover:bg-sky-100 hover:text-sky-700
                              <?php endif; ?>
                              <?php if ($i == 1) echo 'rounded-l-lg'; ?>
                              <?php if ($i == $total_pages) echo 'rounded-r-lg'; ?>
                       ">
                        <?php echo $i; ?>
                    </a>
                </li>
                <?php endfor; ?>
            </ul>
        </nav>
    </div>
    <?php endif; ?>
</div>

<script>
function confirmDelete(id) {
    Swal.fire({
        title: 'Anda yakin?',
        text: "Kategori yang dihapus tidak dapat dikembalikan!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal',
        customClass: {
            popup: 'rounded-xl'
        }
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = 'controllers/kategori_controller.php?action=delete&id=' + id;
        }
    })
}
</script>