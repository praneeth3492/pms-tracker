<?php
include 'config.php'; // Database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $workGroupId = $_POST['work_group_id'];
    $workGroupName = $_POST['work_group_name'];

    // Validation (add your validation logic here)

    // Update database
    $stmt = $conn->prepare("UPDATE work_groups SET name = ? WHERE id = ?");
    $stmt->bind_param("si", $workGroupName, $workGroupId);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "Work group updated successfully.";
    } else {
        echo "Error updating work group.";
    }

    $stmt->close();
    $conn->close();
}
?>
