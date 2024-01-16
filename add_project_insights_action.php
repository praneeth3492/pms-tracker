<?php
session_start();
require_once "config.php"; // Include your database configuration file
error_reporting(0); 

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize input data for project_insights fields
    $website_speed = isset($_POST['website_speed']) ? intval($_POST['website_speed']) : 0;
    $website_score = isset($_POST['website_score']) ? intval($_POST['website_score']) : 0;
    $appointment_system = isset($_POST['appointment_system']) ? $conn->real_escape_string($_POST['appointment_system']) : 'N';
    $website_backlinks = isset($_POST['website_backlinks']) ? intval($_POST['website_backlinks']) : 0;
    $online_citations = isset($_POST['online_citations']) ? intval($_POST['online_citations']) : 0;
    $medical_blogs = isset($_POST['medical_blogs']) ? intval($_POST['medical_blogs']) : 0;
    $case_studies = isset($_POST['case_studies']) ? intval($_POST['case_studies']) : 0;
    $promotional_videos = isset($_POST['promotional_videos']) ? intval($_POST['promotional_videos']) : 0;
    $gbp_rank = isset($_POST['gbp_rank']) ? intval($_POST['gbp_rank']) : 0;
    $google_reviews = isset($_POST['google_reviews']) ? intval($_POST['google_reviews']) : 0;
    $reviews_rating = isset($_POST['reviews_rating']) ? intval($_POST['reviews_rating']) : 0;
    $search_views = isset($_POST['search_views']) ? intval($_POST['search_views']) : 0;
    $profile_clicks = isset($_POST['profile_clicks']) ? intval($_POST['profile_clicks']) : 0;
    $driving_directions = isset($_POST['driving_directions']) ? intval($_POST['driving_directions']) : 0;
    $phone_calls = isset($_POST['phone_calls']) ? intval($_POST['phone_calls']) : 0;
    $fb_followers = isset($_POST['fb_followers']) ? intval($_POST['fb_followers']) : 0;
    $instagram_followers = isset($_POST['instagram_followers']) ? intval($_POST['instagram_followers']) : 0;
    $youtube_videos_ranking = isset($_POST['youtube_videos_ranking']) ? intval($_POST['youtube_videos_ranking']) : 0;
    $t10_keywords_rankings = isset($_POST['t10_keywords_rankings']) ? intval($_POST['t10_keywords_rankings']) : 0;

    $client_id = intval($_POST['client_id']); // Assuming client_id is the identifier

    // Check if a record with the same client_id already exists in project_insights
    $check_sql = "SELECT client_id FROM project_insights WHERE client_id = ?";
    if ($check_stmt = $conn->prepare($check_sql)) {
        $check_stmt->bind_param("i", $client_id);
        $check_stmt->execute();
        $check_result = $check_stmt->get_result();
        $check_stmt->close();

        if ($check_result->num_rows > 0) {
            // Record exists, perform an update
            $update_sql = "UPDATE project_insights SET website_speed=?, website_score=?, appointment_system=?, website_backlinks=?, online_citations=?, medical_blogs=?, case_studies=?, promotional_videos=?, gbp_rank=?, google_reviews=?, reviews_rating=?, search_views=?, profile_clicks=?, driving_directions=?, phone_calls=?, fb_followers=?, instagram_followers=?, youtube_videos_ranking=?, t10_keywords_rankings=? WHERE client_id=?";
        } else {
            // Record does not exist, perform an insert
            $update_sql = "INSERT INTO project_insights (website_speed, website_score, appointment_system, website_backlinks, online_citations, medical_blogs, case_studies, promotional_videos, gbp_rank, google_reviews, reviews_rating, search_views, profile_clicks, driving_directions, phone_calls, fb_followers, instagram_followers, youtube_videos_ranking, t10_keywords_rankings, client_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        }

        if ($stmt = $conn->prepare($update_sql)) {
            $stmt->bind_param("iisiiiiiiiiiiiiiiiii", $website_speed, $website_score, $appointment_system, $website_backlinks, $online_citations, $medical_blogs, $case_studies, $promotional_videos, $gbp_rank, $google_reviews, $reviews_rating, $search_views, $profile_clicks, $driving_directions, $phone_calls, $fb_followers, $instagram_followers, $youtube_videos_ranking, $t10_keywords_rankings, $client_id);
            if ($stmt->execute()) {
                echo "Project insights details processed successfully.";
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
