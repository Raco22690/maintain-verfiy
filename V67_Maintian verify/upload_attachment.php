<?php
header('Content-Type: application/json; charset=utf-8');

// 設置上傳目錄（使用絕對路徑）
$uploadDir = __DIR__ . '/attachments/';

// 如果目錄不存在則創建
if (!file_exists($uploadDir)) {
    if (!mkdir($uploadDir, 0777, true)) {
        echo json_encode([
            'success' => false,
            'error' => '無法創建上傳目錄'
        ]);
        exit;
    }
}

// 檢查目錄權限
if (!is_writable($uploadDir)) {
    echo json_encode([
        'success' => false,
        'error' => '上傳目錄沒有寫入權限'
    ]);
    exit;
}

// 檢查是否有文件上傳
if (!isset($_FILES['attachment'])) {
    echo json_encode([
        'success' => false,
        'error' => '未收到文件'
    ]);
    exit;
}

$file = $_FILES['attachment'];

// 檢查上傳錯誤
if ($file['error'] !== UPLOAD_ERR_OK) {
    $errorMessage = match($file['error']) {
        UPLOAD_ERR_INI_SIZE => '文件大小超過 PHP 限制',
        UPLOAD_ERR_FORM_SIZE => '文件大小超過表單限制',
        UPLOAD_ERR_PARTIAL => '文件只上傳了一部分',
        UPLOAD_ERR_NO_FILE => '沒有文件被上傳',
        UPLOAD_ERR_NO_TMP_DIR => '找不到臨時文件夾',
        UPLOAD_ERR_CANT_WRITE => '文件寫入失敗',
        UPLOAD_ERR_EXTENSION => '文件上傳被擴展程序停止',
        default => '未知上傳錯誤'
    };
    echo json_encode([
        'success' => false,
        'error' => $errorMessage
    ]);
    exit;
}

// 檢查文件大小（限制為 5MB）
$maxFileSize = 5 * 1024 * 1024; // 5MB
if ($file['size'] > $maxFileSize) {
    echo json_encode([
        'success' => false,
        'error' => '文件大小不能超過 5MB'
    ]);
    exit;
}

// 檢查文件類型
$allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/bmp', 'image/webp', 'application/pdf'];
$finfo = finfo_open(FILEINFO_MIME_TYPE);
$mimeType = finfo_file($finfo, $file['tmp_name']);
finfo_close($finfo);

if (!in_array($mimeType, $allowedTypes)) {
    echo json_encode([
        'success' => false,
        'error' => '只允許上傳 JPG、PNG、GIF、BMP、WEBP 或 PDF 格式的文件'
    ]);
    exit;
}

try {
    // 生成唯一文件名
    $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $dataId = isset($_POST['data_id']) ? $_POST['data_id'] : 'temp_' . uniqid();
    $filename = $dataId . '.' . $extension;
    $targetPath = $uploadDir . $filename;

    // 如果檔案已存在，先刪除舊檔案
    if (file_exists($targetPath)) {
        if (!unlink($targetPath)) {
            throw new Exception('無法刪除已存在的檔案');
        }
    }

    // 移動上傳的文件
    if (!move_uploaded_file($file['tmp_name'], $targetPath)) {
        throw new Exception('文件移動失敗');
    }

    // 設置檔案權限
    chmod($targetPath, 0644);

    // 返回相對路徑
    $relativePath = 'attachments/' . $filename;
    
    echo json_encode([
        'success' => true,
        'url' => $relativePath,
        'filename' => $filename,
        'message' => '文件上傳成功'
    ]);

} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}
?> 