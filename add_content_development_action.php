<?php
session_start();
require_once "config.php"; // Include your database configuration file
// error_reporting(0);

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize input data for content_development fields
    $t10_keywords = isset($_POST['t10_keywords']) ? $conn->real_escape_string($_POST['t10_keywords']) : '';
    $website_content = isset($_POST['website_content']) ? $conn->real_escape_string($_POST['website_content']) : '';
    $medical_blogs = isset($_POST['medical_blogs']) ? $conn->real_escape_string($_POST['medical_blogs']) : '';
    $reviews_content = isset($_POST['reviews_content']) ? $conn->real_escape_string($_POST['reviews_content']) : '';
    $review_replies = isset($_POST['review_replies']) ? $conn->real_escape_string($_POST['review_replies']) : '';
    $sm_master_file = isset($_POST['sm_master_file']) ? $conn->real_escape_string($_POST['sm_master_file']) : '';
    $sm_oneliners = isset($_POST['sm_oneliners']) ? $conn->real_escape_string($_POST['sm_oneliners']) : '';
    $supporting_text = isset($_POST['supporting_text']) ? $conn->real_escape_string($_POST['supporting_text']) : '';
    $hashtags = isset($_POST['hashtags']) ? $conn->real_escape_string($_POST['hashtags']) : '';
    $gmb_descriptions = isset($_POST['gmb_descriptions']) ? $conn->real_escape_string($_POST['gmb_descriptions']) : '';
    $gmb_qa = isset($_POST['gmb_qa']) ? $conn->real_escape_string($_POST['gmb_qa']) : '';
    $fb_page_descriptions = isset($_POST['fb_page_descriptions']) ? $conn->real_escape_string($_POST['fb_page_descriptions']) : '';
    $video_scripts = isset($_POST['video_scripts']) ? $conn->real_escape_string($_POST['video_scripts']) : '';

    $client_id = intval($_POST['client_id']); // Assuming client_id is the identifier

    // Check if a record with the same client_id already exists in content_development
    $check_sql = "SELECT client_id FROM content_development WHERE client_id = ?";
    if ($check_stmt = $conn->prepare($check_sql)) {
        $check_stmt->bind_param("i", $client_id);
        $check_stmt->execute();
        $check_result = $check_stmt->get_result();
        $check_stmt->close();

        if ($check_result->num_rows > 0) {
            // Record exists, perform an update
            $update_sql = "UPDATE content_development SET t10_keywords=?, website_content=?, medical_blogs=?, reviews_content=?, review_replies=?, sm_master_file=?, sm_oneliners=?, supporting_text=?, hashtags=?, gmb_descriptions=?, gmb_qa=?, fb_page_descriptions=?, video_scripts=? WHERE client_id=?";
        } else {
            // Record does not exist, perform an insert
            $update_sql = "INSERT INTO content_development (t10_keywords, website_content, medical_blogs, reviews_content, review_replies, sm_master_file, sm_oneliners, supporting_text, hashtags, gmb_descriptions, gmb_qa, fb_page_descriptions, video_scripts, client_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        }

        if ($stmt = $conn->prepare($update_sql)) {
            $stmt->bind_param("sssssssssssssi", $t10_keywords, $website_content, $medical_blogs, $reviews_content, $review_replies, $sm_master_file, $sm_oneliners, $supporting_text, $hashtags, $gmb_descriptions, $gmb_qa, $fb_page_descriptions, $video_scripts, $client_id);
            if ($stmt->execute()) {
                echo "Content development details processed successfully.";
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
