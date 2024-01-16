<?php
require_once "config.php"; // Database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $task_id = $_POST['task_id'];
    $status = $_POST['status'];

    $sql = "UPDATE tasks SET status = ? WHERE task_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $status, $task_id);
    $stmt->execute();

    // Redirect back to the dashboard or display a success message
    header("Location: test.php"); // Redirect back to the dashboard
    exit;
}
?>
