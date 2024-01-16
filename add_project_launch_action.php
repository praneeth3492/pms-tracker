<?php
session_start();
require_once "config.php"; // Include your database configuration file
error_reporting(0); 

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize input data for project_launch fields
    $client_check_list = isset($_POST['client_check_list']) ? $conn->real_escape_string($_POST['client_check_list']) : '';
    $website_launch_date = isset($_POST['website_launch_date']) ? $conn->real_escape_string($_POST['website_launch_date']) : '';
    $sm_posts_blueprint = isset($_POST['sm_posts_blueprint']) ? $conn->real_escape_string($_POST['sm_posts_blueprint']) : '';
    $sm_posts_scheduling = isset($_POST['sm_posts_scheduling']) ? $conn->real_escape_string($_POST['sm_posts_scheduling']) : '';
    $project_launch_date = isset($_POST['project_launch_date']) ? $conn->real_escape_string($_POST['project_launch_date']) : '';
    $welcome_kit = isset($_POST['welcome_kit']) ? $conn->real_escape_string($_POST['welcome_kit']) : '';
    $client_sign_off = isset($_POST['client_sign_off']) ? $conn->real_escape_string($_POST['client_sign_off']) : '';

    $client_id = intval($_POST['client_id']); // Assuming client_id is the identifier

    // Check if a record with the same client_id already exists in project_launch
    $check_sql = "SELECT client_id FROM project_launch WHERE client_id = ?";
    if ($check_stmt = $conn->prepare($check_sql)) {
        $check_stmt->bind_param("i", $client_id);
        $check_stmt->execute();
        $check_result = $check_stmt->get_result();
        $check_stmt->close();

        if ($check_result->num_rows > 0) {
            // Record exists, perform an update
            $update_sql = "UPDATE project_launch SET client_check_list=?, website_launch_date=?, sm_posts_blueprint=?, sm_posts_scheduling=?, project_launch_date=?, welcome_kit=?, client_sign_off=? WHERE client_id=?";
        } else {
            // Record does not exist, perform an insert
            $update_sql = "INSERT INTO project_launch (client_check_list, website_launch_date, sm_posts_blueprint, sm_posts_scheduling, project_launch_date, welcome_kit, client_sign_off, client_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        }

        if ($stmt = $conn->prepare($update_sql)) {
            $stmt->bind_param("sssssssi", $client_check_list, $website_launch_date, $sm_posts_blueprint, $sm_posts_scheduling, $project_launch_date, $welcome_kit, $client_sign_off, $client_id);
            if ($stmt->execute()) {
                echo "Project launch details processed successfully.";
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
