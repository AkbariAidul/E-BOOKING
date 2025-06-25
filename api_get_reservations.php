<?php
header('Content-Type: application/json');
require_once 'config/database.php';

try {
    // Daftar warna yang akan kita gunakan untuk setiap kamar
    $colors = ['#3b82f6', '#10b981', '#ef4444', '#f97316', '#8b5cf6', '#d946ef', '#ec4899'];
    
    $stmt = $pdo->query("
        SELECT 
            r.id,
            r.nama_pemesan,
            r.tgl_checkin,
            r.tgl_checkout,
            k.id AS kamar_id,
            k.nama_kamar
        FROM 
            reservasi r
        JOIN 
            kamar k ON r.id_kamar = k.id
        WHERE
            r.status = 'Confirmed' OR r.status = 'Completed'
    ");
    
    $events = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        // Menentukan warna berdasarkan ID kamar
        $color = $colors[$row['kamar_id'] % count($colors)];

        $events[] = [
            'id'    => $row['id'],
            // Judul event kini berisi nama kamar dan nama pemesan
            'title' => $row['nama_kamar'] . ' - ' . $row['nama_pemesan'],
            'start' => $row['tgl_checkin'],
            'end'   => $row['tgl_checkout'],
            'color' => $color,
            'borderColor' => $color
        ];
    }

    echo json_encode($events);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}