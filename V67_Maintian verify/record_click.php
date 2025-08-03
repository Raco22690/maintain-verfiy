<?php
header('Content-Type: application/json; charset=utf-8');

// 資料庫連線參數
$dbHost = 'localhost';
$dbUser = 'root';
$dbPass = 'A12345678';
$dbName = 'mydatabase';

// 建立連線
$conn = new mysqli($dbHost, $dbUser, $dbPass, $dbName);
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'error' => '資料庫連線失敗: ' . $conn->connect_error]);
    exit;
}

// 設定連線編碼
$conn->set_charset("utf8");

// 獲取BKM ID
$bkm_id = isset($_POST['id']) ? intval($_POST['id']) : 0;
if (!$bkm_id) {
    echo json_encode(['success' => false, 'error' => '缺少BKM ID']);
    exit;
}

// 獲取客戶端IP地址
$ip_address = $_SERVER['REMOTE_ADDR'];

// 檢查是否在1分鐘內有相同IP的點擊記錄
$check_sql = "SELECT COUNT(*) as count FROM click_counts 
              WHERE bkm_id = ? AND ip_address = ? 
              AND last_click > DATE_SUB(NOW(), INTERVAL 1 MINUTE)";
$check_stmt = $conn->prepare($check_sql);
$check_stmt->bind_param('is', $bkm_id, $ip_address);
$check_stmt->execute();
$result = $check_stmt->get_result();
$row = $result->fetch_assoc();

if ($row['count'] > 0) {
    echo json_encode(['success' => false, 'error' => '請等待1分鐘後再點擊']);
    $check_stmt->close();
    $conn->close();
    exit;
}

// 更新點擊計數
$sql = "INSERT INTO click_counts (bkm_id, count, ip_address) VALUES (?, 1, ?) 
        ON DUPLICATE KEY UPDATE count = count + 1, ip_address = ?, last_click = NOW()";
$stmt = $conn->prepare($sql);
$stmt->bind_param('iss', $bkm_id, $ip_address, $ip_address);
$ok = $stmt->execute();

if ($ok) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => $stmt->error]);
}

$stmt->close();
$conn->close();
?> 