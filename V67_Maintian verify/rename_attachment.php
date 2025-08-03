<?php
header('Content-Type: application/json');

// 設置上傳目錄
$uploadDir = 'attachments/';

// 檢查必要參數
if (!isset($_POST['old_filename']) || !isset($_POST['new_id'])) {
    echo json_encode([
        'success' => false,
        'message' => '缺少必要參數'
    ]);
    exit;
}

$oldFilename = $_POST['old_filename'];
$newId = str_pad($_POST['new_id'], 6, '0', STR_PAD_LEFT); // 將 ID 轉換為 6 位數格式

// 獲取檔案副檔名
$extension = pathinfo($oldFilename, PATHINFO_EXTENSION);
$newFilename = $newId . '.' . $extension;

$oldPath = $uploadDir . $oldFilename;
$newPath = $uploadDir . $newFilename;

// 檢查舊檔案是否存在
if (!file_exists($oldPath)) {
    echo json_encode([
        'success' => false,
        'message' => '原始檔案不存在'
    ]);
    exit;
}

// 如果新檔案已存在，先刪除
if (file_exists($newPath)) {
    unlink($newPath);
}

// 重新命名檔案
if (rename($oldPath, $newPath)) {
    echo json_encode([
        'success' => true,
        'url' => $newPath,
        'message' => '檔案重新命名成功'
    ]);
} else {
    echo json_encode([
        'success' => false,
        'message' => '檔案重新命名失敗'
    ]);
}
?> 