<?php
// Ambil data kamar yang stoknya lebih dari 0 untuk dropdown
require_once 'config/database.php';
$kamar_stmt = $pdo->query("SELECT id, nama_kamar, harga_per_malam, stok FROM kamar WHERE stok > 0 ORDER BY nama_kamar ASC");
$kamar_list = $kamar_stmt->fetchAll(PDO::FETCH_ASSOC);

// Buat array javascript untuk kalkulasi harga
$kamar_data_js = json_encode(array_column($kamar_list, null, 'id'));
?>

<div class="flex justify-between items-center mb-6">
    <h1 class="text-3xl font-bold text-gray-700">Buat Reservasi Baru</h1>
    <a href="index.php?page=reservasi" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded-lg flex items-center transition-colors">
        <i class="fas fa-arrow-left mr-2"></i> Kembali
    </a>
</div>

<?php if (isset($_SESSION['error_message'])): ?>
<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg relative mb-5" role="alert">
    <strong class="font-bold">Terjadi Kesalahan!</strong>
    <span class="block sm:inline"><?php echo $_SESSION['error_message']; ?></span>
</div>
<?php unset($_SESSION['error_message']); ?>
<?php endif; ?>

<div class="bg-white p-8 rounded-xl shadow-lg border border-gray-200">
    <form action="controllers/reservasi_controller.php?action=store" method="POST" id="form-reservasi">
        <h2 class="text-xl font-semibold text-gray-800 border-b pb-3 mb-6">Informasi Pemesan</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <label for="nama_pemesan" class="block text-sm font-medium text-gray-700 mb-1">Nama Pemesan <span class="text-red-500">*</span></label>
                <input type="text" id="nama_pemesan" name="nama_pemesan" class="w-full px-3 py-2 border border-gray-300 rounded-lg" required>
            </div>
            <div>
                <label for="email_pemesan" class="block text-sm font-medium text-gray-700 mb-1">Email <span class="text-red-500">*</span></label>
                <input type="email" id="email_pemesan" name="email_pemesan" class="w-full px-3 py-2 border border-gray-300 rounded-lg" required>
            </div>
            <div>
                <label for="telepon_pemesan" class="block text-sm font-medium text-gray-700 mb-1">No. Telepon <span class="text-red-500">*</span></label>
                <input type="tel" id="telepon_pemesan" name="telepon_pemesan" class="w-full px-3 py-2 border border-gray-300 rounded-lg" required>
            </div>
        </div>

        <h2 class="text-xl font-semibold text-gray-800 border-b pb-3 mb-6">Detail Reservasi</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="id_kamar" class="block text-sm font-medium text-gray-700 mb-1">Pilih Kamar <span class="text-red-500">*</span></label>
                <select id="id_kamar" name="id_kamar" class="w-full px-3 py-2 border border-gray-300 rounded-lg" required>
                    <option value="">-- Pilih Kamar --</option>
                    <?php foreach ($kamar_list as $kamar): ?>
                        <option value="<?php echo $kamar['id']; ?>" data-stok="<?php echo $kamar['stok']; ?>"><?php echo htmlspecialchars($kamar['nama_kamar']); ?> (Stok: <?php echo $kamar['stok']; ?>)</option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <label for="jumlah_kamar" class="block text-sm font-medium text-gray-700 mb-1">Jumlah Kamar Dipesan <span class="text-red-500">*</span></label>
                <input type="number" id="jumlah_kamar" name="jumlah_kamar" min="1" value="1" class="w-full px-3 py-2 border border-gray-300 rounded-lg" required>
            </div>
            <div>
                <label for="tgl_checkin" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Check-in <span class="text-red-500">*</span></label>
                <input type="date" id="tgl_checkin" name="tgl_checkin" class="w-full px-3 py-2 border border-gray-300 rounded-lg" required>
            </div>
            <div>
                <label for="tgl_checkout" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Check-out <span class="text-red-500">*</span></label>
                <input type="date" id="tgl_checkout" name="tgl_checkout" class="w-full px-3 py-2 border border-gray-300 rounded-lg" required>
            </div>
        </div>
        
        <div class="mt-8 p-6 bg-sky-50 rounded-lg border border-sky-200">
            <h3 class="text-lg font-semibold text-sky-800 mb-2">Rincian Biaya</h3>
            <div class="space-y-2">
                <div class="flex justify-between">
                    <span class="text-gray-600">Harga per malam:</span>
                    <span id="harga-per-malam" class="font-semibold text-gray-800">Rp 0</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Jumlah malam:</span>
                    <span id="jumlah-malam" class="font-semibold text-gray-800">0 Malam</span>
                </div>
                 <div class="flex justify-between">
                    <span class="text-gray-600">Jumlah kamar:</span>
                    <span id="display-jumlah-kamar" class="font-semibold text-gray-800">1 Kamar</span>
                </div>
                <hr class="my-2">
                <div class="flex justify-between text-xl">
                    <span class="font-bold text-sky-900">Total Biaya:</span>
                    <span id="total-harga" class="font-bold text-sky-900">Rp 0</span>
                </div>
            </div>
        </div>

        <div class="flex items-center justify-end mt-8">
            <button type="submit" class="bg-sky-500 hover:bg-sky-600 text-white font-bold py-3 px-6 rounded-lg transition-colors">
                <i class="fas fa-save mr-2"></i> Simpan Reservasi
            </button>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const kamarData = <?php echo $kamar_data_js; ?>;
    const idKamarEl = document.getElementById('id_kamar');
    const tglCheckinEl = document.getElementById('tgl_checkin');
    const tglCheckoutEl = document.getElementById('tgl_checkout');
    const jumlahKamarEl = document.getElementById('jumlah_kamar');
    
    const today = new Date().toISOString().split('T')[0];
    tglCheckinEl.setAttribute('min', today);

    function setMinCheckoutDate() {
        if (!tglCheckinEl.value) return;
        let checkinDate = new Date(tglCheckinEl.value);
        checkinDate.setDate(checkinDate.getDate() + 1);
        let minCheckoutDate = checkinDate.toISOString().split('T')[0];
        tglCheckoutEl.setAttribute('min', minCheckoutDate);
        if (tglCheckoutEl.value < minCheckoutDate) {
            tglCheckoutEl.value = minCheckoutDate;
        }
    }

    function checkStok() {
        const selectedOption = idKamarEl.options[idKamarEl.selectedIndex];
        if (!selectedOption || !selectedOption.dataset.stok) return;
        const maxStok = parseInt(selectedOption.dataset.stok, 10);
        jumlahKamarEl.setAttribute('max', maxStok);
        if (parseInt(jumlahKamarEl.value, 10) > maxStok) {
            jumlahKamarEl.value = maxStok;
        }
    }

    function calculateTotal() {
        const idKamar = idKamarEl.value;
        const tglCheckin = new Date(tglCheckinEl.value);
        const tglCheckout = new Date(tglCheckoutEl.value);
        const jumlahKamar = parseInt(jumlahKamarEl.value, 10) || 1;

        if (!idKamar || isNaN(tglCheckin) || isNaN(tglCheckout) || tglCheckout <= tglCheckin) {
            resetPricing();
            return;
        }

        const selectedKamar = kamarData[idKamar];
        const hargaPerMalam = parseFloat(selectedKamar.harga_per_malam);
        const diffTime = Math.abs(tglCheckout - tglCheckin);
        const jumlahMalam = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
        const totalHarga = hargaPerMalam * jumlahMalam * jumlahKamar;

        document.getElementById('harga-per-malam').textContent = formatRupiah(hargaPerMalam);
        document.getElementById('jumlah-malam').textContent = jumlahMalam + ' Malam';
        document.getElementById('display-jumlah-kamar').textContent = jumlahKamar + ' Kamar';
        document.getElementById('total-harga').textContent = formatRupiah(totalHarga);
    }

    function resetPricing() {
        document.getElementById('harga-per-malam').textContent = 'Rp 0';
        document.getElementById('jumlah-malam').textContent = '0 Malam';
        document.getElementById('display-jumlah-kamar').textContent = '1 Kamar';
        document.getElementById('total-harga').textContent = 'Rp 0';
    }

    function formatRupiah(angka) {
        return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(angka);
    }
    
    tglCheckinEl.addEventListener('change', () => {
        setMinCheckoutDate();
        calculateTotal();
    });
    idKamarEl.addEventListener('change', () => {
        checkStok();
        calculateTotal();
    });
    tglCheckoutEl.addEventListener('change', calculateTotal);
    jumlahKamarEl.addEventListener('input', () => {
        checkStok();
        calculateTotal();
    });

    setMinCheckoutDate();
    checkStok();
});
</script>