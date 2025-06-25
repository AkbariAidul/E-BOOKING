<?php
require_once 'config/database.php';
$search = isset($_GET['search']) ? $_GET['search'] : '';
$whereClause = !empty($search) ? "WHERE r.nama_pemesan LIKE :search OR k.nama_kamar LIKE :search" : '';
$stmt = $pdo->prepare("SELECT r.*, k.nama_kamar FROM reservasi r JOIN kamar k ON r.id_kamar = k.id $whereClause ORDER BY r.created_at DESC");
if (!empty($search)) $stmt->bindValue(':search', '%' . $search . '%');
$stmt->execute();
$reservasi_list = $stmt->fetchAll(PDO::FETCH_ASSOC);
$statuses = ['Pending', 'Confirmed', 'Completed', 'Cancelled'];
?>

<div class="flex justify-between items-center mb-6">
    <h1 class="text-3xl font-bold text-gray-700">Manajemen Reservasi</h1>
    <a href="index.php?page=reservasi-create" class="bg-sky-500 hover:bg-sky-600 text-white font-bold py-2 px-4 rounded-lg flex items-center transition-colors">
        <i class="fas fa-plus mr-2"></i> Tambah Reservasi
    </a>
</div>

<div class="bg-white shadow-lg rounded-xl border border-gray-200">
    <div class="p-4">
        <form method="GET">
            <input type="hidden" name="page" value="reservasi">
            <div class="relative">
                <input type="text" name="search" class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-sky-300 focus:border-sky-500" placeholder="Cari nama pemesan atau kamar..." value="<?php echo htmlspecialchars($search); ?>">
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
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Pemesan</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Kamar</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Periode Menginap</th>
                    <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php if (count($reservasi_list) > 0): ?>
                    <?php foreach ($reservasi_list as $reservasi): ?>
                        <tr class="hover:bg-sky-50 transition-colors duration-200">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900"><?php echo htmlspecialchars($reservasi['nama_pemesan']); ?></div>
                                <div class="text-sm text-gray-500"><?php echo htmlspecialchars($reservasi['email_pemesan']); ?></div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600"><?php echo htmlspecialchars($reservasi['nama_kamar']); ?></td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900"><?php echo date('d M Y', strtotime($reservasi['tgl_checkin'])); ?> - <?php echo date('d M Y', strtotime($reservasi['tgl_checkout'])); ?></div>
                                <div class="text-sm text-gray-500"><?php echo $reservasi['jumlah_malam']; ?> Malam</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <div class="relative inline-block">
                                    <?php 
                                    $status = $reservasi['status'];
                                    $badge_color = 'bg-gray-100 text-gray-800';
                                    if ($status == 'Confirmed') $badge_color = 'bg-teal-100 text-teal-800';
                                    if ($status == 'Pending') $badge_color = 'bg-amber-100 text-amber-800';
                                    if ($status == 'Cancelled') $badge_color = 'bg-red-100 text-red-800';
                                    if ($status == 'Completed') $badge_color = 'bg-sky-100 text-sky-800';
                                    ?>
                                    <button data-dropdown-toggle="dropdown-<?php echo $reservasi['id']; ?>" class="dropdown-toggle px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full <?php echo $badge_color; ?> hover:opacity-80 transition-opacity">
                                        <?php echo htmlspecialchars($status); ?>
                                        <i class="fas fa-caret-down ml-2"></i>
                                    </button>
                                    <div id="dropdown-<?php echo $reservasi['id']; ?>" class="status-dropdown-menu hidden fixed w-48 bg-white rounded-md shadow-lg z-50 border">
                                        <div class="py-1">
                                            <?php foreach($statuses as $s): ?>
                                                <a href="controllers/reservasi_controller.php?action=update_status&id=<?php echo $reservasi['id']; ?>&status=<?php echo $s; ?>" class="block px-4 py-2 text-sm text-left <?php echo ($s == $status) ? 'bg-sky-100 text-sky-800' : 'text-gray-700 hover:bg-gray-100'; ?>">
                                                    <?php echo $s; ?>
                                                </a>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-center font-medium">
                                <button onclick="openDetailModal(<?php echo $reservasi['id']; ?>)" class="text-gray-500 hover:text-sky-600 p-2 hover:bg-sky-100 rounded-full transition-colors" title="Lihat Detail">
                                    <i class="fas fa-eye fa-lg"></i>
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="5" class="text-center py-12"><div class="flex flex-col items-center text-gray-400"><i class="fa-solid fa-calendar-xmark text-4xl mb-3"></i><p class="font-medium">Tidak ada data reservasi ditemukan.</p></div></td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<div id="detail-modal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-2xl w-full max-w-2xl transform transition-all max-h-full overflow-y-auto">
        <div class="p-6">
            <div class="flex justify-between items-center border-b pb-3 mb-4">
                <h3 class="text-2xl font-bold text-gray-800">Detail Reservasi</h3>
                <button onclick="closeDetailModal()" class="text-gray-400 hover:text-gray-800 text-3xl leading-none">&times;</button>
            </div>
            <div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-4">
                    <div><strong class="text-gray-600 block text-sm">ID Reservasi:</strong> <span id="detail-id" class="text-base text-gray-900"></span></div>
                    <div><strong class="text-gray-600 block text-sm">Tanggal Pesan:</strong> <span id="detail-created_at" class="text-base text-gray-900"></span></div>
                    <div><strong class="text-gray-600 block text-sm">Nama Pemesan:</strong> <span id="detail-nama_pemesan" class="text-base text-gray-900"></span></div>
                    <div><strong class="text-gray-600 block text-sm">Kamar Dipesan:</strong> <span id="detail-nama_kamar" class="text-base text-gray-900"></span></div>
                    <div><strong class="text-gray-600 block text-sm">Email:</strong> <span id="detail-email_pemesan" class="text-base text-gray-900"></span></div>
                    <div><strong class="text-gray-600 block text-sm">Telepon:</strong> <span id="detail-telepon_pemesan" class="text-base text-gray-900"></span></div>
                    <div><strong class="text-gray-600 block text-sm">Check-in:</strong> <span id="detail-tgl_checkin" class="text-base text-gray-900"></span></div>
                    <div><strong class="text-gray-600 block text-sm">Check-out:</strong> <span id="detail-tgl_checkout" class="text-base text-gray-900"></span></div>
                    <div class="md:col-span-2 border-t pt-4 mt-2">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Total: <span id="detail-jumlah_kamar"></span> Kamar, <span id="detail-jumlah_malam"></span> Malam</span>
                            <span class="text-2xl font-bold text-sky-600" id="detail-total_harga"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Fungsi untuk menutup semua dropdown yang terbuka
function closeAllDropdowns() {
    document.querySelectorAll('.status-dropdown-menu').forEach(menu => {
        menu.classList.add('hidden');
    });
}

document.querySelectorAll('.dropdown-toggle').forEach(button => {
    button.addEventListener('click', function (event) {
        event.stopPropagation();
        const dropdownId = this.getAttribute('data-dropdown-toggle');
        const dropdownMenu = document.getElementById(dropdownId);
        
        // Cek apakah dropdown yang diklik ini sudah terbuka
        const isCurrentlyOpen = !dropdownMenu.classList.contains('hidden');

        // Tutup semua dropdown dulu
        closeAllDropdowns();
        
        // Jika belum terbuka, buka yang ini
        if (!isCurrentlyOpen) {
            // Dapatkan posisi tombol pemicu
            const rect = this.getBoundingClientRect();
            
            // Atur posisi dropdown agar muncul di bawah tombol
            dropdownMenu.style.top = `${rect.bottom + window.scrollY + 5}px`;
            dropdownMenu.style.left = `${rect.left + (rect.width / 2) - (dropdownMenu.offsetWidth / 2)}px`;

            // Tampilkan dropdown
            dropdownMenu.classList.remove('hidden');
        }
    });
});

// Tutup semua dropdown jika klik di luar area dropdown
window.addEventListener('click', function (event) {
    if (!event.target.closest('.dropdown-toggle')) {
        closeAllDropdowns();
    }
});

// --- Kode Modal (tidak berubah) ---
const modal = document.getElementById('detail-modal');
function openDetailModal(id) {
    fetch(`controllers/reservasi_controller.php?action=get_detail&id=${id}`)
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                alert(data.error); return;
            }
            const options = { year: 'numeric', month: 'long', day: 'numeric' };
            const checkin = new Date(data.tgl_checkin).toLocaleDateString('id-ID', options);
            const checkout = new Date(data.tgl_checkout).toLocaleDateString('id-ID', options);
            const created = new Date(data.created_at).toLocaleString('id-ID', {...options, hour: '2-digit', minute:'2-digit'});
            const totalHarga = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(data.total_harga);

            document.getElementById('detail-id').textContent = data.id;
            document.getElementById('detail-created_at').textContent = created;
            document.getElementById('detail-nama_pemesan').textContent = data.nama_pemesan;
            document.getElementById('detail-nama_kamar').textContent = data.nama_kamar;
            document.getElementById('detail-email_pemesan').textContent = data.email_pemesan;
            document.getElementById('detail-telepon_pemesan').textContent = data.telepon_pemesan;
            document.getElementById('detail-tgl_checkin').textContent = checkin;
            document.getElementById('detail-tgl_checkout').textContent = checkout;
            document.getElementById('detail-jumlah_kamar').textContent = data.jumlah_kamar;
            document.getElementById('detail-jumlah_malam').textContent = data.jumlah_malam;
            document.getElementById('detail-total_harga').textContent = totalHarga;
            
            modal.classList.remove('hidden');
        });
}
function closeDetailModal() {
    modal.classList.add('hidden');
}
</script>