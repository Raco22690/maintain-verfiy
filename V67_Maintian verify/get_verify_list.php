<?php
header('Content-Type: application/json');
require_once 'db_connect.php'; // Include the database connection

try {
    // Fetch main records, ordering by the most recently updated
    $sql_main = "SELECT * FROM verify_main ORDER BY last_updated DESC";
    $result_main = $conn->query($sql_main);

    $all_data = [];
    if ($result_main->num_rows > 0) {
        while ($row_main = $result_main->fetch_assoc()) {
            $verify_id = $row_main['id'];
            
            // Fetch related details for each main record
            $sql_details = "SELECT * FROM verify_details WHERE verify_id = ?";
            $stmt_details = $conn->prepare($sql_details);
            $stmt_details->bind_param("i", $verify_id);
            $stmt_details->execute();
            $result_details = $stmt_details->get_result();
            
            $details = [];
            if ($result_details->num_rows > 0) {
                while ($row_detail = $result_details->fetch_assoc()) {
                    $details[] = $row_detail;
                }
            }
            
            // Add the details array to the main record's data
            $row_main['verify_data'] = $details;
            $all_data[] = $row_main;
            
            $stmt_details->close();
        }
    }

    echo json_encode(['success' => true, 'data' => $all_data]);

} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'An error occurred: ' . $e->getMessage()]);
}

// Close the main connection
$conn->close();
?>