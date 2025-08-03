<?php
header('Content-Type: application/json');
require_once 'db_connect.php'; // Include the database connection

$json_data = file_get_contents('php://input');
$data = json_decode($json_data, true);

if (!$data) {
    echo json_encode(['success' => false, 'message' => 'Invalid data provided.']);
    exit;
}

// Begin transaction
$conn->begin_transaction();

try {
    $is_edit = !empty($data['id']);
    
    // Main data for verify_main table
    $main_data_map = [
        'part6' => $data['part6'] ?? null,
        'device_name' => $data['device_name'] ?? null,
        'pcr_owner' => $data['pcr_owner'] ?? null,
        'otc_owner' => $data['otc_owner'] ?? null,
        'rd_owner' => $data['rd_owner'] ?? null,
        'corr_wafer' => $data['corr_wafer'] ?? null,
        'clean_pad_type' => $data['clean_pad_type'] ?? null,
        'verify_sort' => $data['verify_sort'] ?? null,
        'verify_method' => $data['verify_method'] ?? null,
        'rule_verify_pass' => $data['rule_verify_pass'] ?? null,
        'rule_contact_window' => $data['rule_contact_window'] ?? null,
        'rule_dib_check' => $data['rule_dib_check'] ?? null,
        'general_remark' => $data['general_remark'] ?? null,
    ];

    if ($is_edit) {
        // --- Edit Mode ---
        $verify_id = $data['id'];
        $stmt = $conn->prepare("UPDATE verify_main SET part6=?, device_name=?, pcr_owner=?, otc_owner=?, rd_owner=?, corr_wafer=?, clean_pad_type=?, verify_sort=?, verify_method=?, rule_verify_pass=?, rule_contact_window=?, rule_dib_check=?, general_remark=? WHERE id=?");
        $stmt->bind_param("sssssssssssssi", 
            $main_data_map['part6'], $main_data_map['device_name'], $main_data_map['pcr_owner'], 
            $main_data_map['otc_owner'], $main_data_map['rd_owner'], $main_data_map['corr_wafer'],
            $main_data_map['clean_pad_type'], $main_data_map['verify_sort'], $main_data_map['verify_method'],
            $main_data_map['rule_verify_pass'], $main_data_map['rule_contact_window'], $main_data_map['rule_dib_check'],
            $main_data_map['general_remark'], $verify_id);
        $stmt->execute();
        
        // Delete old details to re-insert
        $stmt_delete = $conn->prepare("DELETE FROM verify_details WHERE verify_id = ?");
        $stmt_delete->bind_param("i", $verify_id);
        $stmt_delete->execute();
    } else {
        // --- Insert Mode ---
        $stmt = $conn->prepare("INSERT INTO verify_main (part6, device_name, pcr_owner, otc_owner, rd_owner, corr_wafer, clean_pad_type, verify_sort, verify_method, rule_verify_pass, rule_contact_window, rule_dib_check, general_remark) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssssssssss",
            $main_data_map['part6'], $main_data_map['device_name'], $main_data_map['pcr_owner'], 
            $main_data_map['otc_owner'], $main_data_map['rd_owner'], $main_data_map['corr_wafer'],
            $main_data_map['clean_pad_type'], $main_data_map['verify_sort'], $main_data_map['verify_method'],
            $main_data_map['rule_verify_pass'], $main_data_map['rule_contact_window'], $main_data_map['rule_dib_check'],
            $main_data_map['general_remark']);
        $stmt->execute();
        $verify_id = $conn->insert_id;
    }

    // Handle verify_details (up to 5)
    if (isset($data['verify_data']) && is_array($data['verify_data'])) {
        $details_stmt = $conn->prepare("INSERT INTO verify_details (verify_id, type_name, test_program, test_od, prober_file, clean_od) VALUES (?, ?, ?, ?, ?, ?)");
        
        $item_count = 0;
        foreach ($data['verify_data'] as $detail) {
            if ($item_count >= 5) break; // Enforce limit
            
            $details_stmt->bind_param("isssss", 
                $verify_id,
                $detail['type_name'],
                $detail['test_program'],
                $detail['test_od'],
                $detail['prober_file'],
                $detail['clean_od']
            );
            $details_stmt->execute();
            $item_count++;
        }
    }

    // Commit transaction
    $conn->commit();
    
    echo json_encode(['success' => true, 'message' => 'Data saved successfully.', 'id' => $verify_id]);

} catch (Exception $e) {
    // Rollback transaction on error
    $conn->rollback();
    echo json_encode(['success' => false, 'message' => 'An error occurred: ' . $e->getMessage()]);
}

// Close connections
$stmt->close();
if (isset($stmt_delete)) $stmt_delete->close();
if (isset($details_stmt)) $details_stmt->close();
$conn->close();
?>