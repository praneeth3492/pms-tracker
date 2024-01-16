<?php
session_start();
require_once "config.php"; // Include your database configuration file
error_reporting(0); 
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize input data
    $gbp = isset($_POST['gbp']) ? intval($_POST['gbp']) : 0;
    $existing = isset($_POST['existing']) ? intval($_POST['existing']) : 0;
    $new = isset($_POST['new']) ? intval($_POST['new']) : 0;
    $connected_email = isset($_POST['connected_email']) ? $conn->real_escape_string($_POST['connected_email']) : '';
    $optimisation_gmb = isset($_POST['optimisation_gmb']) ? $conn->real_escape_string($_POST['optimisation_gmb']) : 'N';
    $gmb_links = isset($_POST['gmb_links']) ? $conn->real_escape_string($_POST['gmb_links']) : '';
    $fb_page = isset($_POST['fb_page']) ? $conn->real_escape_string($_POST['fb_page']) : '';
    $optimisation_fb = isset($_POST['optimisation_fb']) ? $conn->real_escape_string($_POST['optimisation_fb']) : 'N';
    $fb_page_link = isset($_POST['fb_page_link']) ? $conn->real_escape_string($_POST['fb_page_link']) : '';
    $instagram = isset($_POST['instagram']) ? $conn->real_escape_string($_POST['instagram']) : '';
    $optimisation_instagram = isset($_POST['optimisation_instagram']) ? $conn->real_escape_string($_POST['optimisation_instagram']) : 'N';
    $instagram_link = isset($_POST['instagram_link']) ? $conn->real_escape_string($_POST['instagram_link']) : '';
    $fb_instagram_connection = isset($_POST['fb_instagram_connection']) ? $conn->real_escape_string($_POST['fb_instagram_connection']) : '';
    $youtube_channel = isset($_POST['youtube_channel']) ? $conn->real_escape_string($_POST['youtube_channel']) : '';
    $optimisation_youtube = isset($_POST['optimisation_youtube']) ? $conn->real_escape_string($_POST['optimisation_youtube']) : 'N';
    $youtube_channel_link = isset($_POST['youtube_channel_link']) ? $conn->real_escape_string($_POST['youtube_channel_link']) : '';
    $publer = isset($_POST['publer']) ? $conn->real_escape_string($_POST['publer']) : '';
    $oviond = isset($_POST['oviond']) ? $conn->real_escape_string($_POST['oviond']) : '';

    
    $client_id = intval($_POST['client_id']);
    // Assuming you have a unique identifier for each record, like 'id'
    $check_sql = "SELECT client_id FROM access_optimise WHERE client_id = ?";
    if ($check_stmt = $conn->prepare($check_sql)) {
        $check_stmt->bind_param("i", $client_id);
        $check_stmt->execute();
        $check_result = $check_stmt->get_result();
        $check_stmt->close();

        if ($check_result->num_rows > 0) {
            // Record exists, perform an update
            $update_sql = "UPDATE access_optimise SET gbp=?, existing=?, new=?, connected_email=?, optimisation_gmb=?, gmb_links=?, fb_page=?, optimisation_fb=?, fb_page_link=?, instagram=?, optimisation_instagram=?, instagram_link=?, fb_instagram_connection=?, youtube_channel=?, optimisation_youtube=?, youtube_channel_link=?, publer=?, oviond=? WHERE client_id=?";
        } else {
            // Record does not exist, perform an insert
            $update_sql = "INSERT INTO access_optimise (gbp, existing, new, connected_email, optimisation_gmb, gmb_links, fb_page, optimisation_fb, fb_page_link, instagram, optimisation_instagram, instagram_link, fb_instagram_connection, youtube_channel, optimisation_youtube, youtube_channel_link, publer, oviond, client_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        }

        if ($stmt = $conn->prepare($update_sql)) {
            $stmt->bind_param("iiisssssssssssssssi", $gbp, $existing, $new, $connected_email, $optimisation_gmb, $gmb_links, $fb_page, $optimisation_fb, $fb_page_link, $instagram, $optimisation_instagram, $instagram_link, $fb_instagram_connection, $youtube_channel, $optimisation_youtube, $youtube_channel_link, $publer, $oviond, $client_id);
            if ($stmt->execute()) {
                echo "Access optimise details processed successfully.";
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