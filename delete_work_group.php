<?php
include 'config.php'; // Database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $workGroupId = $_POST['work_group_id'];

    // Delete from database
    $stmt = $conn->prepare("DELETE FROM work_groups WHERE id = ?");
    $stmt->bind_param("i", $workGroupId);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "Work group deleted successfully.";
    } else {
        echo "Error deleting work group.";
    }

    $stmt->close();
    $conn->close();
}
?>
