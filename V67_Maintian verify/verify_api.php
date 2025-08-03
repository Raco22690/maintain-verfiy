<?php
header('Content-Type: application/json');

// --- 1. 資料庫連線設定 ---
$dbHost = 'localhost';
$dbUser = 'root';
$dbPass = 'A12345678';
$dbName = 'mydatabase';

$link = @mysqli_connect($dbHost, $dbUser, $dbPass, $dbName);
if (!$link) {
    echo json_encode(['success' => false, 'message' => '資料庫連線錯誤: ' . mysqli_connect_error()]);
    exit();
}
mysqli_set_charset($link, "utf8mb4");

// --- 2. 獲取請求資料 ---
$action = $_GET['action'] ?? '';
$input = json_decode(file_get_contents('php://input'), true);

// --- 3. 根據 action 執行對應操作 ---
switch ($action) {
    case 'save':
        saveVerifyData($link, $input);
        break;
    case 'getAll':
        getAllVerifyData($link);
        break;
    case 'getByPart6':
        getVerifyDataByPart6($link, $_GET['part6'] ?? '');
        break;
    case 'delete':
        deleteVerifyData($link, $input['id'] ?? '');
        break;
    default:
        echo json_encode(['success' => false, 'message' => '無效的操作']);
        break;
}

// --- 4. 功能函式 ---

function saveVerifyData($link, $data) {
    if (empty($data)) {
        echo json_encode(['success' => false, 'message' => '沒有接收到資料']);
        return;
    }

    mysqli_begin_transaction($link);

    try {
        // 準備 main data
        $id = mysqli_real_escape_string($link, $data['id']);
        $part6 = mysqli_real_escape_string($link, $data['part6'] ?? '');
        $device_name = mysqli_real_escape_string($link, $data['device_name'] ?? '');
        $pcr_owner = mysqli_real_escape_string($link, $data['pcr_owner'] ?? '');
        $otc_owner = mysqli_real_escape_string($link, $data['otc_owner'] ?? '');
        $rd_owner = mysqli_real_escape_string($link, $data['rd_owner'] ?? '');
        $corr_wafer = mysqli_real_escape_string($link, $data['corr_wafer'] ?? '');
        $clean_pad_type = mysqli_real_escape_string($link, $data['clean_pad_type'] ?? '');
        $verify_sort = mysqli_real_escape_string($link, $data['verify_sort'] ?? '');
        $verify_method = mysqli_real_escape_string($link, $data['verify_method'] ?? '');
        $rule_verify_pass = mysqli_real_escape_string($link, $data['rule_verify_pass'] ?? '');
        $rule_contact_window = mysqli_real_escape_string($link, $data['rule_contact_window'] ?? '');
        $rule_dib_check = mysqli_real_escape_string($link, $data['rule_dib_check'] ?? '');
        $general_remark = mysqli_real_escape_string($link, $data['general_remark'] ?? '');
        $created_at = mysqli_real_escape_string($link, $data['created_at']);
        $updated_at = mysqli_real_escape_string($link, $data['updated_at']);

        // 使用 ON DUPLICATE KEY UPDATE 處理新增或更新
        $mainSql = "INSERT INTO verify_main (id, part6, device_name, pcr_owner, otc_owner, rd_owner, corr_wafer, clean_pad_type, verify_sort, verify_method, rule_verify_pass, rule_contact_window, rule_dib_check, general_remark, created_at, updated_at) 
                    VALUES ('$id', '$part6', '$device_name', '$pcr_owner', '$otc_owner', '$rd_owner', '$corr_wafer', '$clean_pad_type', '$verify_sort', '$verify_method', '$rule_verify_pass', '$rule_contact_window', '$rule_dib_check', '$general_remark', '$created_at', '$updated_at')
                    ON DUPLICATE KEY UPDATE 
                        part6 = VALUES(part6), device_name = VALUES(device_name), pcr_owner = VALUES(pcr_owner), otc_owner = VALUES(otc_owner), rd_owner = VALUES(rd_owner), corr_wafer = VALUES(corr_wafer), 
                        clean_pad_type = VALUES(clean_pad_type), verify_sort = VALUES(verify_sort), verify_method = VALUES(verify_method), rule_verify_pass = VALUES(rule_verify_pass), 
                        rule_contact_window = VALUES(rule_contact_window), rule_dib_check = VALUES(rule_dib_check), general_remark = VALUES(general_remark), updated_at = VALUES(updated_at)";
        
        if (!mysqli_query($link, $mainSql)) {
            throw new Exception("主資料儲存失敗: " . mysqli_error($link));
        }

        // 先刪除舊的 verify_items
        $deleteItemsSql = "DELETE FROM verify_items WHERE verify_main_id = '$id'";
        if (!mysqli_query($link, $deleteItemsSql)) {
            throw new Exception("清除舊項目失敗: " . mysqli_error($link));
        }

        // 插入新的 verify_items
        if (!empty($data['verify_data']) && is_array($data['verify_data'])) {
            $itemsSql = "INSERT INTO verify_items (verify_main_id, verify_type, test_program, prober_file, test_od, clean_od) VALUES ";
            $values = [];
            foreach ($data['verify_data'] as $item) {
                $verify_type = mysqli_real_escape_string($link, $item['verify_type'] ?? '');
                $test_program = mysqli_real_escape_string($link, $item['test_program'] ?? '');
                $prober_file = mysqli_real_escape_string($link, $item['prober_file'] ?? '');
                $test_od = mysqli_real_escape_string($link, $item['test_od'] ?? '');
                $clean_od = mysqli_real_escape_string($link, $item['clean_od'] ?? '');
                $values[] = "('$id', '$verify_type', '$test_program', '$prober_file', '$test_od', '$clean_od')";
            }
            if (!empty($values)) {
                $itemsSql .= implode(", ", $values);
                if (!mysqli_query($link, $itemsSql)) {
                    throw new Exception("項目資料儲存失敗: " . mysqli_error($link));
                }
            }
        }

        mysqli_commit($link);
        echo json_encode(['success' => true, 'message' => '資料儲存成功']);

    } catch (Exception $e) {
        mysqli_rollback($link);
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
}

function getAllVerifyData($link) {
    $mainSql = "SELECT * FROM verify_main ORDER BY updated_at DESC";
    $mainResult = mysqli_query($link, $mainSql);
    $data = [];
    while ($row = mysqli_fetch_assoc($mainResult)) {
        $itemsSql = "SELECT * FROM verify_items WHERE verify_main_id = '{$row['id']}'";
        $itemsResult = mysqli_query($link, $itemsSql);
        $items = [];
        while ($itemRow = mysqli_fetch_assoc($itemsResult)) {
            $items[] = $itemRow;
        }
        $row['verify_data'] = $items;
        $data[] = $row;
    }
    echo json_encode(['success' => true, 'data' => $data]);
}

function getVerifyDataByPart6($link, $part6) {
    if (empty($part6)) {
        echo json_encode(['success' => false, 'message' => '缺少 part6 參數']);
        return;
    }
    $part6 = mysqli_real_escape_string($link, $part6);
    $mainSql = "SELECT * FROM verify_main WHERE part6 = '$part6' LIMIT 1";
    $mainResult = mysqli_query($link, $mainSql);
    
    if ($row = mysqli_fetch_assoc($mainResult)) {
        $itemsSql = "SELECT * FROM verify_items WHERE verify_main_id = '{$row['id']}'";
        $itemsResult = mysqli_query($link, $itemsSql);
        $items = [];
        while ($itemRow = mysqli_fetch_assoc($itemsResult)) {
            $items[] = $itemRow;
        }
        $row['verify_data'] = $items;
        echo json_encode(['success' => true, 'data' => $row]);
    } else {
        echo json_encode(['success' => false, 'message' => '找不到資料']);
    }
}

function deleteVerifyData($link, $id) {
    if (empty($id)) {
        echo json_encode(['success' => false, 'message' => '缺少 ID']);
        return;
    }
    $id = mysqli_real_escape_string($link, $id);
    // Because of CASCADE delete, we only need to delete from the main table.
    $sql = "DELETE FROM verify_main WHERE id = '$id'";
    if (mysqli_query($link, $sql)) {
        echo json_encode(['success' => true, 'message' => '資料刪除成功']);
    } else {
        echo json_encode(['success' => false, 'message' => '資料刪除失敗: ' . mysqli_error($link)]);
    }
}

mysqli_close($link);
?>
