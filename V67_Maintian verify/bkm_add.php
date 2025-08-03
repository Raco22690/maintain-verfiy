<?php
header('Content-Type: application/json; charset=utf-8');

// 資料庫連線參數
$dbHost = 'localhost';
$dbUser = 'root';
$dbPass = 'A12345678';
$dbName = 'mydatabase';

try {
    $conn = new mysqli($dbHost, $dbUser, $dbPass, $dbName);
    if ($conn->connect_error) {
        throw new Exception('資料庫連線失敗: ' . $conn->connect_error);
    }

    // 設置字符集
    $conn->set_charset("utf8mb4");

    // 檢查並添加 Status 欄位
    $checkColumn = "SHOW COLUMNS FROM BKM_table LIKE 'Status'";
    $result = $conn->query($checkColumn);
    if ($result->num_rows == 0) {
        $addColumn = "ALTER TABLE BKM_table ADD COLUMN Status VARCHAR(50) DEFAULT 'BKM needed'";
        if (!$conn->query($addColumn)) {
            throw new Exception('添加 Status 欄位失敗: ' . $conn->error);
        }
    }

    // 檢查必要欄位
    if (empty($_POST['Device'])) {
        throw new Exception('Device 欄位不能為空');
    }

    // 獲取最大 ID
    $sql = "SELECT MAX(ID) as max_id FROM BKM_table";
    $result = $conn->query($sql);
    if (!$result) {
        throw new Exception('查詢最大 ID 失敗: ' . $conn->error);
    }
    $row = $result->fetch_assoc();
    $newId = ($row['max_id'] ?? 0) + 1;
    $formattedId = str_pad($newId, 6, '0', STR_PAD_LEFT);

    // 處理附件路徑
    $attch = $_POST['Attch'] ?? '';
    if (!empty($attch)) {
        // 如果是臨時文件，重命名為正式文件
        if (strpos($attch, 'temp_') === 0) {
            $oldPath = __DIR__ . '/attachments/' . $attch;
            $newPath = __DIR__ . '/attachments/' . $formattedId . '.' . pathinfo($attch, PATHINFO_EXTENSION);
            if (file_exists($oldPath)) {
                if (!rename($oldPath, $newPath)) {
                    throw new Exception('重命名附件失敗');
                }
                $attch = $formattedId . '.' . pathinfo($attch, PATHINFO_EXTENSION);
            }
        }
    }

    // 準備 SQL 語句
    $sql = "INSERT INTO BKM_table (ID, Device, SWBin_Issue, Sort, Description, Attch, Status, Site, Updater, Last_update) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        throw new Exception('SQL 準備失敗: ' . $conn->error);
    }

    // 設定參數
    $device = $_POST['Device'] ?? '';
    $swbin = $_POST['SWBin_Issue'] ?? '';
    $sort = $_POST['Sort'] ?? '';
    $desc = $_POST['Description'] ?? '';
    $status = $_POST['Status'] ?? 'BKM needed';
    $site = $_POST['Site'] ?? '';
    $updater = $_POST['Updater'] ?? '';
    $last_update = $_POST['Last_update'] ?? '';

    $stmt->bind_param('ssssssssss', 
        $formattedId, $device, $swbin, $sort, $desc, 
        $attch, $status, $site, $updater, $last_update
    );

    if (!$stmt->execute()) {
        throw new Exception('新增失敗: ' . $stmt->error);
    }

    echo json_encode([
        'success' => true,
        'id' => $formattedId,
        'message' => '新增成功'
    ]);

} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
} finally {
    if (isset($stmt)) {
        $stmt->close();
    }
    if (isset($conn)) {
        $conn->close();
    }
}
?> 