<?php
include 'config.php'; // Include your database configuration file

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $workGroupId = isset($_POST['work_group_id']) ? $_POST['work_group_id'] : null;
    $workGroupName = $_POST['work_group_name'];

    if ($workGroupId) {
        // Update existing work group
        $stmt = $conn->prepare("UPDATE work_groups SET name = ? WHERE id = ?");
        $stmt->bind_param("si", $workGroupName, $workGroupId);
    } else {
        // Insert new work group
        $stmt = $conn->prepare("INSERT INTO work_groups (name) VALUES (?)");
        $stmt->bind_param("s", $workGroupName);
    }

    if ($stmt->execute()) {
        echo "Work group saved successfully.";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request method.";
}

// Redirect back to the form or another page
header("Location: add_edit_work_group.php");
exit;
?>
