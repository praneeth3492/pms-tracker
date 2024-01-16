<?php
session_start();
require_once "config.php";

// Check if the user is logged in
if (!isset($_SESSION["manager_id"])) {
    header("Location: login.php");
    exit;
}

// Get the submitted data
$client_id = $_POST['client_id'];
$month_id = $_POST['month_id'];
$year_id = $_POST['year_id'];
$search_views = $_POST['search_views']; 
$calls = $_POST['calls'];
$directions = $_POST['directions'];
$google_reviews = $_POST['google_reviews'];
$average_ratings = $_POST['average_ratings'];
$review_responses = $_POST['review_responses'];

// New fields
$clicks = $_POST['clicks'];
$gbp_ranking = $_POST['gbp_ranking'];
$fb_followers = $_POST['fb_followers'];
$fb_engagement = $_POST['fb_engagement'];
$promotional_videos = $_POST['promotional_videos'];
$social_media_creatives = $_POST['social_media_creatives'];
$website_pagespeed = $_POST['website_pagespeed'];
$backlinks = $_POST['backlinks'];
$website_security = $_POST['website_security'];

$medical_blogs = $_POST['medical_blogs'];
$case_studies = $_POST['case_studies'];
$website_performance = $_POST['website_performance'];
$website_accessibility = $_POST['website_accessibility'];
$website_best_practices = $_POST['website_best_practices'];
$website_seo = $_POST['website_seo'];

$citations = $_POST['citations'];
$instagram_engagement = $_POST['instagram_engagement'];
$instagram_followers = $_POST['instagram_followers'];

$keyword_text1 = $_POST['keyword_text1'];
$keyword_ranking1 = $_POST['keyword_ranking1'];
$keyword_text2 = $_POST['keyword_text2'];
$keyword_ranking2 = $_POST['keyword_ranking2'];
$keyword_text3 = $_POST['keyword_text3'];
$keyword_ranking3 = $_POST['keyword_ranking3'];
$keyword_text4 = $_POST['keyword_text4'];
$keyword_ranking4 = $_POST['keyword_ranking4'];
$keyword_text5 = $_POST['keyword_text5'];
$keyword_ranking5 = $_POST['keyword_ranking5'];
$keyword_text6 = $_POST['keyword_text6'];
$keyword_ranking6 = $_POST['keyword_ranking6'];
$keyword_text7 = $_POST['keyword_text7'];
$keyword_ranking7 = $_POST['keyword_ranking7'];
$keyword_text8 = $_POST['keyword_text8'];
$keyword_ranking8 = $_POST['keyword_ranking8'];


// Check if a record with the given client_id exists
$sql = "SELECT * FROM client_performance WHERE client_id = ? and month_id = ? and year_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iii", $client_id, $month_id, $year_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Update the record
    $sql = "UPDATE client_performance SET 
        search_views = ?,
        calls = ?,
        directions = ?,
        google_reviews = ?,
        average_ratings = ?,
        review_responses = ?,
        clicks = ?,
        gbp_ranking = ?,
        fb_followers = ?,
        fb_engagement = ?,
        promotional_videos = ?,
        social_media_creatives = ?,
        website_pagespeed = ?,
        backlinks = ?,
        website_security = ?,
        medical_blogs = ?,
        case_studies = ?,
        website_performance = ?,
        website_accessibility = ?,
        website_best_practices = ?,
        website_seo = ?,
        citations = ?, 
    instagram_engagement = ?, 
    instagram_followers = ?,
    keyword_text1 = ?, keyword_ranking1 = ?, 
        keyword_text2 = ?, keyword_ranking2 = ?, keyword_text3 = ?, keyword_ranking3 = ?, 
        keyword_text4 = ?, keyword_ranking4 = ?, keyword_text5 = ?, keyword_ranking5 = ?, 
        keyword_text6 = ?, keyword_ranking6 = ?, keyword_text7 = ?, keyword_ranking7 = ?, 
        keyword_text8 = ?, keyword_ranking8 = ? WHERE client_id = ? and month_id = ? and year_id = ?"; 

    $stmt = $conn->prepare($sql);
    $stmt->bind_param(
        "iiiiiiiiiiiiiiiiiiiiiiiisisisisisisisisiiii", // Adjust the data types ('i' for integer, 'd' for double, 's' for string)
        $search_views,
        $calls,
        $directions,
        $google_reviews,
        $average_ratings, // Check if this should be 'd'
        $review_responses,
        $clicks,
        $gbp_ranking,
        $fb_followers,
        $fb_engagement,
        $promotional_videos,
        $social_media_creatives,
        $website_pagespeed,
        $backlinks,
        $website_security,
        $medical_blogs,
        $case_studies,
        $website_performance,
        $website_accessibility,
        $website_best_practices,
        $website_seo,
        $citations,
        $instagram_engagement,
        $instagram_followers,
        
        $keyword_text1, $keyword_ranking1, 
        $keyword_text2, $keyword_ranking2, 
        $keyword_text3, $keyword_ranking3, 
        $keyword_text4, $keyword_ranking4, 
        $keyword_text5, $keyword_ranking5, 
        $keyword_text6, $keyword_ranking6, 
        $keyword_text7, $keyword_ranking7, 
        $keyword_text8, $keyword_ranking8,
        $client_id,
        $month_id,
        $year_id
    ); echo "Executing Update Query: " . $sql . "<br>";
} else {
    // Insert a new record
    $sql = "INSERT INTO client_performance (
        client_id,
        month_id,
        year_id,
        search_views,
        calls,
        directions,
        google_reviews,
        average_ratings,
        review_responses,
        clicks,
        gbp_ranking,
        fb_followers,
        fb_engagement,
        promotional_videos,
        social_media_creatives,
        website_pagespeed,
        backlinks,
        website_security,
        medical_blogs,
        case_studies,
        website_performance,
        website_accessibility,
        website_best_practices,
        website_seo,
        citations,
    instagram_engagement,
    instagram_followers,
    keyword_text1, keyword_ranking1, 
        keyword_text2, keyword_ranking2, keyword_text3, keyword_ranking3, 
        keyword_text4, keyword_ranking4, keyword_text5, keyword_ranking5, 
        keyword_text6, keyword_ranking6, keyword_text7, keyword_ranking7, 
        keyword_text8, keyword_ranking8
) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?, ?, ?, ?, ?, ?, ?, ?,?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param(
        "iiiiiiiiiiiiiiiiiiiiiiiiiiisisisisisisisisi", // Adjust the data types as needed
        $client_id,
        $month_id,
        $year_id,
        $search_views,
        $calls,
        $directions,
        $google_reviews,
        $average_ratings,
        $review_responses,
        $clicks,
        $gbp_ranking,
        $fb_followers,
        $fb_engagement,
        $promotional_videos,
        $social_media_creatives,
        $website_pagespeed,
        $backlinks,
        $website_security,
        $medical_blogs,
        $case_studies,
        $website_performance,
        $website_accessibility,
        $website_best_practices,
        $website_seo,
        $citations,
        $instagram_engagement,
        $instagram_followers,
        $keyword_text1, $keyword_ranking1, 
        $keyword_text2, $keyword_ranking2, 
        $keyword_text3, $keyword_ranking3, 
        $keyword_text4, $keyword_ranking4, 
        $keyword_text5, $keyword_ranking5, 
        $keyword_text6, $keyword_ranking6, 
        $keyword_text7, $keyword_ranking7, 
        $keyword_text8, $keyword_ranking8
    );
}

$result = $stmt->execute();
if ($result === false) {
    echo "Error: " . $stmt->error;
} else {
    if ($stmt->affected_rows > 0) {
        header("Location: add_fields2.php?client_id=" . $client_id);
    } else {
        echo "No rows were updated. Check if the submitted data is different from the existing data.";
    }
}

$stmt->close();
$conn->close();
?>
