<?php
header('Content-Type: application/json; charset=utf-8');

// 資料庫連線參數
$dbHost = 'localhost';
$dbUser = 'root';
$dbPass = 'A12345678';
$dbName = 'mydatabase';

try {
    // 檢查必要參數
    if (!isset($_POST['id']) || !isset($_POST['path'])) {
        throw new Exception('缺少必要參數');
    }

    $id = intval($_POST['id']);
    $path = $_POST['path'];

    // 驗證 ID
    if ($id <= 0) {
        throw new Exception('無效的 ID');
    }

    // 驗證路徑
    if (empty($path)) {
        throw new Exception('附件路徑不能為空');
    }

    // 連接資料庫
    $conn = new mysqli($dbHost, $dbUser, $dbPass, $dbName);
    if ($conn->connect_error) {
        throw new Exception('資料庫連線失敗: ' . $conn->connect_error);
    }

    // 設置字符集
    $conn->set_charset("utf8mb4");

    // 準備 SQL 語句
    $sql = "UPDATE BKM_table SET Attch = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        throw new Exception('SQL 準備失敗: ' . $conn->error);
    }

    $stmt->bind_param('si', $path, $id);

    if (!$stmt->execute()) {
        throw new Exception('更新失敗: ' . $stmt->error);
    }

    if ($stmt->affected_rows === 0) {
        throw new Exception('未找到要更新的記錄');
    }

    echo json_encode([
        'success' => true,
        'message' => '附件路徑更新成功'
    ]);

} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
} finally {
    // 關閉資料庫連接
    if (isset($stmt)) {
        $stmt->close();
    }
    if (isset($conn)) {
        $conn->close();
    }
}
?> 