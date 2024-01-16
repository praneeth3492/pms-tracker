<?php
session_start();
require_once "config.php"; // Include your database configuration file
error_reporting(0); 

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize input data for website fields
    $domain_name = isset($_POST['domain_name']) ? $conn->real_escape_string($_POST['domain_name']) : '';
    $created_got_access = isset($_POST['created_got_access']) ? $conn->real_escape_string($_POST['created_got_access']) : '';
    $wireframe = isset($_POST['wireframe']) ? $conn->real_escape_string($_POST['wireframe']) : '';
    $website_design = isset($_POST['website_design']) ? $conn->real_escape_string($_POST['website_design']) : '';
    $aptmt_system = isset($_POST['aptmt_system']) ? $conn->real_escape_string($_POST['aptmt_system']) : '';
    $reviews_widget = isset($_POST['reviews_widget']) ? $conn->real_escape_string($_POST['reviews_widget']) : '';
    $medical_seo = isset($_POST['medical_seo']) ? $conn->real_escape_string($_POST['medical_seo']) : '';
    $technical_seo = isset($_POST['technical_seo']) ? $conn->real_escape_string($_POST['technical_seo']) : '';
    $beta_website = isset($_POST['beta_website']) ? $conn->real_escape_string($_POST['beta_website']) : '';
    $website_testing = isset($_POST['website_testing']) ? $conn->real_escape_string($_POST['website_testing']) : '';
    $page_load_speed = isset($_POST['page_load_speed']) ? $conn->real_escape_string($_POST['page_load_speed']) : '';
    $website_score = isset($_POST['website_score']) ? $conn->real_escape_string($_POST['website_score']) : '';
    

    $client_id = intval($_POST['client_id']); // Assuming client_id is the identifier

    // Check if a record with the same client_id already exists in website
    $check_sql = "SELECT client_id FROM website WHERE client_id = ?";
    if ($check_stmt = $conn->prepare($check_sql)) {
        $check_stmt->bind_param("i", $client_id);
        $check_stmt->execute();
        $check_result = $check_stmt->get_result();
        $check_stmt->close();

        if ($check_result->num_rows > 0) {
            // Record exists, perform an update
            $update_sql = "UPDATE website SET domain_name=?, created_got_access=?, wireframe=?, website_design=?, aptmt_system=?, reviews_widget=?, medical_seo=?, technical_seo=?, beta_website=?, website_testing=?, page_load_speed=?, website_score=? WHERE client_id=?";
        } else {
            // Record does not exist, perform an insert
            $update_sql = "INSERT INTO website (domain_name, created_got_access, wireframe, website_design, aptmt_system, reviews_widget, medical_seo, technical_seo, beta_website, website_testing, page_load_speed, website_score, client_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        }

        if ($stmt = $conn->prepare($update_sql)) {
            $stmt->bind_param("ssssssssssssi", $domain_name, $created_got_access, $wireframe, $website_design, $aptmt_system, $reviews_widget, $medical_seo, $technical_seo, $beta_website, $website_testing, $page_load_speed, $website_score, $client_id);
            if ($stmt->execute()) {
                echo "Website details processed successfully.";
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
