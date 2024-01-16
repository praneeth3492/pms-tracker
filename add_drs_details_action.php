<?php
session_start();
require_once "config.php"; // Include your database configuration file
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize input data
    $dr_name = $conn->real_escape_string($_POST['dr_name']);
    $qualifications = $conn->real_escape_string($_POST['qualifications']);
    $specialisation = $conn->real_escape_string($_POST['specialisation']);
    $expertise = $conn->real_escape_string($_POST['expertise']);
    $experience = intval($_POST['experience']);
    $dr_photos = isset($_FILES['dr_photos']) ? $conn->real_escape_string($_FILES['dr_photos']['name']) : ''; // Adjust as needed for file handling
    $dr_resume = isset($_FILES['dr_resume']) ? $conn->real_escape_string($_FILES['dr_resume']['name']) : ''; // Adjust as needed for file handling    
    $insurance = $conn->real_escape_string($_POST['insurance']);
    $facilities = $conn->real_escape_string($_POST['facilities']);
    $diagnostics = $conn->real_escape_string($_POST['diagnostics']);
    $health_packages = $conn->real_escape_string($_POST['health_packages']);
    $multiple_gbp = $conn->real_escape_string($_POST['multiple_gbp']);
    $multiple_dr = $conn->real_escape_string($_POST['multiple_dr']);
    $project_start_date = $conn->real_escape_string($_POST['project_start_date']);
    $proposed_launch_date = $conn->real_escape_string($_POST['proposed_launch_date']);
    $client_id = intval($_POST['client_id']);

    $check_sql = "SELECT client_id FROM drs_details WHERE client_id = ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("i", $client_id);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();
    $check_stmt->close();
    
    if ($check_result->num_rows > 0) {
        // Record exists, perform an update
        $update_sql = "UPDATE drs_details SET dr_name=?, qualifications=?, specialisation=?, expertise=?, experience=?, dr_photos=?, dr_resume=?, insurance=?, facilities=?, diagnostics=?, health_packages=?, multiple_gbp=?, multiple_dr=?, project_start_date=?, proposed_launch_date=? WHERE client_id=?";
        $stmt = $conn->prepare($update_sql);
        $stmt->bind_param("ssssissssssssssi", $dr_name, $qualifications, $specialisation, $expertise, $experience, $dr_photos, $dr_resume, $insurance, $facilities, $diagnostics, $health_packages, $multiple_gbp, $multiple_dr, $project_start_date, $proposed_launch_date, $client_id);
    } else {
        // Record does not exist, perform an insert
        $insert_sql = "INSERT INTO drs_details (dr_name, qualifications, specialisation, expertise, experience, dr_photos, dr_resume, insurance, facilities, diagnostics, health_packages, multiple_gbp, multiple_dr, project_start_date, proposed_launch_date, client_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($insert_sql);
        $stmt->bind_param("ssssissssssssssi", $dr_name, $qualifications, $specialisation, $expertise, $experience, $dr_photos, $dr_resume, $insurance, $facilities, $diagnostics, $health_packages, $multiple_gbp, $multiple_dr, $project_start_date, $proposed_launch_date, $client_id);
    }
    
    // Execute and check for errors
    if ($stmt->execute()) {
        echo "Doctor details processed successfully.";
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