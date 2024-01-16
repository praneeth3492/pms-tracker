<?php
session_start();
require_once "config.php"; // Include your database configuration file

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize input data
    $project_name = $conn->real_escape_string($_POST['project_name']);
    $project_logo = $conn->real_escape_string($_POST['project_logo']);
    $project_type = $conn->real_escape_string($_POST['project_type']);
    $domain_names = $conn->real_escape_string($_POST['domain_names']);
    $mobile_no = $conn->real_escape_string($_POST['mobile_no']);
    $locations = $conn->real_escape_string($_POST['locations']);
    $whatsapp_no = $conn->real_escape_string($_POST['whatsapp_no']);
    $addresses = $conn->real_escape_string($_POST['addresses']);
    $extinct_photos = $conn->real_escape_string($_POST['extinct_photos']);
    $team_size = intval($_POST['team_size']);
    $equip_photos = $conn->real_escape_string($_POST['equip_photos']);
    $credentials = $conn->real_escape_string($_POST['credentials']);
    $list_of_services = $conn->real_escape_string($_POST['list_of_services']);
    $website = $conn->real_escape_string($_POST['website']);
    $gmb_accounts = isset($_POST['gmb_accounts']) ? 1 : 0;  
    $facebook_yn = isset($_POST['facebook_yn']) ? 1 : 0;
    $instagram_yn = isset($_POST['instagram_yn']) ? 1 : 0;
    $youtube_yn = isset($_POST['youtube_yn']) ? 1 : 0;
    $project_id = intval($_POST['project_id']);
    $client_id = intval($_POST['client_id']);

    $client_id = intval($_POST['client_id']);

    $validation_sql = "SELECT client_id FROM clients WHERE client_id = ?";
    $validation_stmt = $conn->prepare($validation_sql);
    $validation_stmt->bind_param("i", $client_id);
    $validation_stmt->execute();
    $validation_result = $validation_stmt->get_result();
    if ($validation_result->num_rows == 0) {
        echo "Error: client_id does not exist in the clients table.";
        $validation_stmt->close();
        $conn->close();
        exit;
    }
    $validation_stmt->close();
    
    // Check if a record with the same client_id already exists in project_details
    $check_sql = "SELECT client_id FROM project_details WHERE client_id = ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("i", $client_id);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();
    $check_stmt->close();
    
    if ($check_result->num_rows > 0) {
        // Record exists, perform an update
        $update_sql = "UPDATE project_details SET project_name=?, project_logo=?, project_type=?, domain_names=?, mobile_no=?, locations=?, whatsapp_no=?, addresses=?, extinct_photos=?, team_size=?, equip_photos=?, credentials=?, list_of_services=?, website=?, gmb_accounts=?, facebook_yn=?, instagram_yn=?, youtube_yn=?, project_id=? WHERE client_id=?";
        $stmt = $conn->prepare($update_sql);
        $stmt->bind_param("sssssssssisssssssiii", $project_name, $project_logo, $project_type, $domain_names, $mobile_no, $locations, $whatsapp_no, $addresses, $extinct_photos, $team_size, $equip_photos, $credentials, $list_of_services, $website, $gmb_accounts, $facebook_yn, $instagram_yn, $youtube_yn, $project_id, $client_id);
    } else {
        // Record does not exist, perform an insert
        $insert_sql = "INSERT INTO project_details (project_name, project_logo, project_type, domain_names, mobile_no, locations, whatsapp_no, addresses, extinct_photos, team_size, equip_photos, credentials, list_of_services, website, gmb_accounts, facebook_yn, instagram_yn, youtube_yn, project_id, client_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($insert_sql);
        $stmt->bind_param("sssssssssisssssssiii", $project_name, $project_logo, $project_type, $domain_names, $mobile_no, $locations, $whatsapp_no, $addresses, $extinct_photos, $team_size, $equip_photos, $credentials, $list_of_services, $website, $gmb_accounts, $facebook_yn, $instagram_yn, $youtube_yn, $project_id, $client_id);
    }
    
    // Execute and check for errors
    if ($stmt->execute()) {
        echo "Project details processed successfully.";
    } else {
        echo "Error: " . $stmt->error;
    }
    
    // Close statement and connection
    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request method.";
}
?>
