<?php
header('Content-Type: application/json; charset=utf-8');

// 資料庫連線參數
$dbHost = 'localhost';
$dbUser = 'root';
$dbPass = 'A12345678';
$dbName = 'mydatabase';

try {
    // 建立連線
    $conn = new mysqli($dbHost, $dbUser, $dbPass, $dbName);
    if ($conn->connect_error) {
        throw new Exception('資料庫連線失敗: ' . $conn->connect_error);
    }

    // 設定連線編碼
    $conn->set_charset("utf8mb4");

    // 檢查並添加 Status 欄位
    $checkColumn = "SHOW COLUMNS FROM BKM_table LIKE 'Status'";
    $result = $conn->query($checkColumn);
    if (!$result) {
        throw new Exception('查詢欄位失敗: ' . $conn->error);
    }

    if ($result->num_rows == 0) {
        $addColumn = "ALTER TABLE BKM_table ADD COLUMN Status VARCHAR(50) DEFAULT 'BKM needed'";
        if (!$conn->query($addColumn)) {
            throw new Exception('添加 Status 欄位失敗: ' . $conn->error);
        }
    }

    // 檢查並添加 Site 欄位
    $checkSiteColumn = "SHOW COLUMNS FROM BKM_table LIKE 'Site'";
    $resultSite = $conn->query($checkSiteColumn);
    if (!$resultSite) {
        throw new Exception('查詢欄位失敗: ' . $conn->error);
    }

    if ($resultSite->num_rows == 0) {
        $addSiteColumn = "ALTER TABLE BKM_table ADD COLUMN Site VARCHAR(50) DEFAULT ''";
        if (!$conn->query($addSiteColumn)) {
            throw new Exception('添加 Site 欄位失敗: ' . $conn->error);
        }
    }

    // 查詢所有資料
    $sql = "SELECT ID, Device, Site, Sort, SWBin_Issue, Description, Attch, Updater, Last_update, Status 
            FROM BKM_table 
            ORDER BY ID DESC";
    
    $result = $conn->query($sql);
    if (!$result) {
        throw new Exception('查詢資料失敗: ' . $conn->error);
    }

    $data = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            // 確保所有欄位都有值
            $row['Device'] = $row['Device'] ?? '';
            $row['Site'] = $row['Site'] ?? '';
            $row['Sort'] = $row['Sort'] ?? '';
            $row['SWBin_Issue'] = $row['SWBin_Issue'] ?? '';
            $row['Description'] = $row['Description'] ?? '';
            $row['Attch'] = $row['Attch'] ?? '';
            $row['Updater'] = $row['Updater'] ?? '';
            $row['Last_update'] = $row['Last_update'] ?? '';
            $row['Status'] = $row['Status'] ?? 'BKM needed';

            // 檢查附件是否存在
            if ($row['Attch']) {
                $filePath = __DIR__ . '/' . $row['Attch'];
                if (!file_exists($filePath)) {
                    $row['Attch'] = ''; // 如果檔案不存在，清空路徑
                }
            }

            $data[] = $row;
        }
    }

    echo json_encode([
        'success' => true,
        'data' => $data
    ], JSON_UNESCAPED_UNICODE);

} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
} finally {
    // 關閉資料庫連接
    if (isset($conn)) {
        $conn->close();
    }
}
?> 