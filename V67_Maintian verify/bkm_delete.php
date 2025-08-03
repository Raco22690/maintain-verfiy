<?php
header('Content-Type: application/json; charset=utf-8');

$dbHost = 'localhost';
$dbUser = 'root';
$dbPass = 'A12345678';
$dbName = 'mydatabase';

$conn = new mysqli($dbHost, $dbUser, $dbPass, $dbName);
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'error' => '資料庫連線失敗: ' . $conn->connect_error]);
    exit;
}

$id = isset($_POST['ID']) ? intval($_POST['ID']) : 0;
if (!$id) {
    echo json_encode(['success' => false, 'error' => '缺少ID']);
    exit;
}

// 先獲取附件路徑
$sql = "SELECT Attch FROM BKM_table WHERE ID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

// 刪除資料
$sql = "DELETE FROM BKM_table WHERE ID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $id);
$ok = $stmt->execute();

if ($ok) {
    // 如果刪除成功且存在附件，則刪除附件文件
    if ($row && $row['Attch'] && file_exists($row['Attch'])) {
        unlink($row['Attch']);
    }
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => $stmt->error]);
}
$stmt->close();
$conn->close(); 