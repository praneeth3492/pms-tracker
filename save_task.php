<?php
session_start();
require_once "config.php"; // Adjust with your database connection file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $work_group_id = $_POST['work_group_id'];
    $activity_type = $_POST['activity_type'];
    $work_description = $_POST['work_description'];
    $remarks = $_POST['remarks'];
    $assigned_to = $_POST['assigned_to'];
    $due_date = $_POST['due_date'];
    $status = $_POST['status'];

    // Insert or update task
    if (isset($_POST['task_id']) && !empty($_POST['task_id'])) {
        // Update existing task
        $sql = "UPDATE tasks SET work_group_id=?, activity_type=?, work_description=?, remarks=?, assigned_to=?, due_date=?, status=? WHERE task_id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("isssissi", $work_group_id, $activity_type, $work_description, $remarks, $assigned_to, $due_date, $status, $_POST['task_id']);
    } else {
        // Insert new task
        $sql = "INSERT INTO tasks (work_group_id, activity_type, work_description, remarks, assigned_to, due_date, status) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("isssiss", $work_group_id, $activity_type, $work_description, $remarks, $assigned_to, $due_date, $status);
    }

    if ($stmt->execute()) {
        // Redirect or notify of success
        header("Location: manager_dashboard.php"); // Adjust the redirection as needed
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
