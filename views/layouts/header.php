<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$currentPage = isset($_GET['page']) ? $_GET['page'] : 'dashboard';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Luminary Stays</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"/>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.14/index.global.min.js'></script>

    <style>
        body { font-family: 'Poppins', sans-serif; }
        ::-webkit-scrollbar { width: 8px; height: 8px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; }
        ::-webkit-scrollbar-thumb { background: #bae6fd; }
        ::-webkit-scrollbar-thumb:hover { background: #7dd3fc; }
        /* Style untuk FullCalendar agar serasi */
        :root {
            --fc-border-color: #e5e7eb;
            --fc-today-bg-color: rgba(14, 165, 233, 0.1); /* sky-500/10 */
            --fc-button-bg-color: #0ea5e9; /* sky-500 */
            --fc-button-text-color: #ffffff;
            --fc-button-border-color: #0ea5e9;
            --fc-button-hover-bg-color: #0284c7; /* sky-600 */
            --fc-button-hover-border-color: #0284c7;
            --fc-button-active-bg-color: #0369a1; /* sky-700 */
            --fc-button-active-border-color: #0369a1;
        }
    </style>
</head>
<body class="bg-gray-100">

    <div class="flex h-screen">
        <aside class="w-64 flex-shrink-0 bg-sky-200 text-sky-900 flex flex-col">
            <div class="h-28 flex flex-col items-center justify-center px-4 bg-sky-300">
                <i class="fa-solid fa-hotel text-4xl text-white mb-2"></i>
                <span class="text-lg font-bold text-white">Luminary Stays</span>
            </div>
            <nav class="flex-grow px-4 py-6 space-y-2">
                <?php
                function sidebar_link($page, $icon, $text, $currentPage) {
                    $is_active = ($currentPage == $page || (strpos($currentPage, $page) === 0 && $page !== 'dashboard'));
                    $activeClass = $is_active ? 'bg-white text-sky-700 font-semibold shadow-sm' : 'hover:bg-white/60 hover:text-sky-700';
                    echo "<a href='index.php?page={$page}' class='flex items-center px-4 py-2.5 rounded-lg transition-all duration-200 {$activeClass}'>
                           <i class='fa-solid {$icon} w-6 text-center text-lg'></i>
                           <span class='ml-3'>{$text}</span>
                          </a>";
                }

                sidebar_link('dashboard', 'fa-tachometer-alt', 'Dashboard', $currentPage);
                // [BARU] Menu Kalender ditambahkan
                sidebar_link('kalender', 'fa-calendar-days', 'Kalender', $currentPage);
                sidebar_link('reservasi', 'fa-calendar-check', 'Reservasi', $currentPage);
                sidebar_link('kamar', 'fa-bed', 'Manajemen Kamar', $currentPage);
                sidebar_link('kategori', 'fa-tags', 'Kategori Kamar', $currentPage);
                ?>
            </nav>
            <div class="px-4 py-4 mt-auto border-t border-sky-300">
                <a href="logout.php" class="flex items-center px-4 py-2.5 rounded-lg transition-colors duration-200 text-slate-600 hover:bg-red-400 hover:text-white">
                    <i class="fa-solid fa-right-from-bracket w-6 text-center text-lg"></i>
                    <span class="ml-3">Logout</span>
                </a>
            </div>
        </aside>

        <main class="flex-1 overflow-y-auto p-6 md:p-8">