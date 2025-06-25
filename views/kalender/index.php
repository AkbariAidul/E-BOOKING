<div class="flex justify-between items-center mb-6">
    <h1 class="text-3xl font-bold text-gray-700">Kalender Ketersediaan Kamar</h1>
</div>

<div class="bg-white shadow-lg rounded-xl p-6 border border-gray-200">
    <div id='calendar'></div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');

    var calendar = new FullCalendar.Calendar(calendarEl, {
        // [PERBAIKAN] Menggunakan tampilan bulanan standar yang gratis
        initialView: 'dayGridMonth', 
        
        locale: 'id',
        
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek' // Opsi tampilan gratis
        },
        
        height: 'auto',
        
        // Mengambil data dari API yang sudah kita perbarui
        events: 'api_get_reservations.php',
        
        // Menampilkan judul event sebagai tooltip saat di-hover
        eventMouseEnter: function(info) {
            info.el.setAttribute('title', info.event.title);
        }
    });

    calendar.render();
});
</script>