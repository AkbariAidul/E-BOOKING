<?php
require_once 'controllers/dashboard_controller.php';

// Fungsi stat_card dimodifikasi agar senada dengan tema baby blue
function stat_card($icon, $color, $title, $value) {
    // Penggunaan warna yang lebih lembut dan konsisten dengan tema sidebar
    $icon_color = "text-{$color}-600";
    $bg_color = "bg-{$color}-200";

    echo "
    <div class='bg-white p-5 rounded-xl shadow-lg flex items-center space-x-4 transition-all duration-300 hover:shadow-sky-200 hover:-translate-y-1 border border-gray-200'>
        <div class='flex-shrink-0 w-16 h-16 flex items-center justify-center rounded-full {$bg_color}'>
            <i class='fa-solid {$icon} text-3xl {$icon_color}'></i>
        </div>
        <div>
            <p class='text-sm font-medium text-gray-500'>{$title}</p>
            <p class='text-2xl font-bold text-gray-800'>{$value}</p>
        </div>
    </div>
    ";
}
?>

<h1 class="text-3xl font-bold text-gray-700 mb-6">Dashboard</h1>

<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">
    <?php 
    // Warna diubah menjadi palet yang lebih cocok dengan tema baby blue
    stat_card('fa-bed', 'sky', 'Total Kamar', $total_kamar);
    stat_card('fa-tags', 'cyan', 'Total Kategori', $total_kategori);
    stat_card('fa-check-to-slot', 'teal', 'Reservasi Sukses', $total_reservasi_sukses);
    stat_card('fa-sack-dollar', 'blue', 'Total Pendapatan', 'Rp ' . number_format($total_pendapatan, 0, ',', '.'));
    ?>
</div>

<div class="mt-10 bg-white shadow-lg rounded-xl overflow-hidden border border-gray-200">
    <div class="p-5 border-b border-gray-200">
        <h2 class="text-lg font-semibold text-gray-700">Reservasi Terbaru</h2>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Nama Pemesan</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Kamar</th>
                    <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Check-in</th>
                    <th class="px-6 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">Total Harga</th>
                    <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php if (!empty($reservasi_terbaru)): ?>
                    <?php foreach ($reservasi_terbaru as $reservasi): ?>
                        <tr class="hover:bg-sky-50 transition-colors duration-200">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800"><?php echo htmlspecialchars($reservasi['nama_pemesan']); ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600"><?php echo htmlspecialchars($reservasi['nama_kamar']); ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 text-center"><?php echo date('d M Y', strtotime($reservasi['tgl_checkin'])); ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 text-right font-medium">Rp <?php echo number_format($reservasi['total_harga'], 0, ',', '.'); ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <?php 
                                $status = $reservasi['status'];
                                $badge_color = 'bg-gray-100 text-gray-800'; // Default
                                if ($status == 'Confirmed') $badge_color = 'bg-teal-100 text-teal-800';
                                if ($status == 'Pending') $badge_color = 'bg-amber-100 text-amber-800';
                                if ($status == 'Cancelled') $badge_color = 'bg-red-100 text-red-800';
                                if ($status == 'Completed') $badge_color = 'bg-sky-100 text-sky-800';
                                ?>
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full <?php echo $badge_color; ?>">
                                    <?php echo htmlspecialchars($status); ?>
                                </span>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center py-12">
                           <div class="flex flex-col items-center text-gray-400">
                               <i class="fa-solid fa-moon-cloud text-4xl mb-3"></i>
                               <p class="font-medium">Belum ada data reservasi.</p>
                               <p class="text-xs">Data reservasi terbaru akan muncul di sini.</p>
                           </div>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>