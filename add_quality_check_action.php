<?php
session_start();
require_once "config.php"; // Include your database configuration file
error_reporting(0);

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize input data for quality_check fields
    $examiner_name = isset($_POST['examiner_name']) ? $conn->real_escape_string($_POST['examiner_name']) : '';
    $t10_keywords = isset($_POST['t10_keywords']) ? $conn->real_escape_string($_POST['t10_keywords']) : '';
    $website_content = isset($_POST['website_content']) ? $conn->real_escape_string($_POST['website_content']) : '';
    $dr_details = isset($_POST['dr_details']) ? $conn->real_escape_string($_POST['dr_details']) : '';
    $contacts = isset($_POST['contacts']) ? $conn->real_escape_string($_POST['contacts']) : '';
    $sm_master_file = isset($_POST['sm_master_file']) ? $conn->real_escape_string($_POST['sm_master_file']) : '';
    $one_liners = isset($_POST['one_liners']) ? $conn->real_escape_string($_POST['one_liners']) : '';
    $supporting_text = isset($_POST['supporting_text']) ? $conn->real_escape_string($_POST['supporting_text']) : '';
    $gmb = isset($_POST['gmb']) ? $conn->real_escape_string($_POST['gmb']) : '';
    $fb_page = isset($_POST['fb_page']) ? $conn->real_escape_string($_POST['fb_page']) : '';
    $instagram = isset($_POST['instagram']) ? $conn->real_escape_string($_POST['instagram']) : '';
    $youtube = isset($_POST['youtube']) ? $conn->real_escape_string($_POST['youtube']) : '';
    $publer = isset($_POST['publer']) ? $conn->real_escape_string($_POST['publer']) : '';
    $oviond = isset($_POST['oviond']) ? $conn->real_escape_string($_POST['oviond']) : '';
    $special_instructions = isset($_POST['special_instructions']) ? $conn->real_escape_string($_POST['special_instructions']) : '';

    $client_id = intval($_POST['client_id']); // Assuming client_id is the identifier

    // Check if a record with the same client_id already exists in quality_check
    $check_sql = "SELECT client_id FROM quality_check WHERE client_id = ?";
    if ($check_stmt = $conn->prepare($check_sql)) {
        $check_stmt->bind_param("i", $client_id);
        $check_stmt->execute();
        $check_result = $check_stmt->get_result();
        $check_stmt->close();

        if ($check_result->num_rows > 0) {
            // Record exists, perform an update
            $update_sql = "UPDATE quality_check SET examiner_name=?, t10_keywords=?, website_content=?, dr_details=?, contacts=?, sm_master_file=?, one_liners=?, supporting_text=?, gmb=?, fb_page=?, instagram=?, youtube=?, publer=?, oviond=?, special_instructions=? WHERE client_id=?";
        } else {
            // Record does not exist, perform an insert
            $update_sql = "INSERT INTO quality_check (examiner_name, t10_keywords, website_content, dr_details, contacts, sm_master_file, one_liners, supporting_text, gmb, fb_page, instagram, youtube, publer, oviond, special_instructions, client_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        }

        if ($stmt = $conn->prepare($update_sql)) {
            $stmt->bind_param("sssssssssssssssi", $examiner_name, $t10_keywords, $website_content, $dr_details, $contacts, $sm_master_file, $one_liners, $supporting_text, $gmb, $fb_page, $instagram, $youtube, $publer, $oviond, $special_instructions, $client_id);
            if ($stmt->execute()) {
                echo "Quality check details processed successfully.";
            } else {
                echo "Error: " . $stmt->error;
            }
            $stmt->close();
        } else {
            echo "Error preparing statement: " . $conn->error;
        }
    } else {
        echo "Error preparing statement: " . $conn->error;
    }
    $conn->close();
} else {
    echo "Invalid request method.";
}
?>
