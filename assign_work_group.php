<?php
session_start();
require_once "config.php";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $managerId = $_POST['manager_id'];
    $workGroupIds = $_POST['work_group_ids']; // Array of work group IDs

    // Delete existing assignments
    $deleteStmt = $conn->prepare("DELETE FROM manager_workgroup WHERE manager_id = ?");
    $deleteStmt->bind_param("i", $managerId);
    $deleteStmt->execute();

    // Assign new work groups
    $insertStmt = $conn->prepare("INSERT INTO manager_workgroup (manager_id, work_group_id) VALUES (?, ?)");
    foreach ($workGroupIds as $workGroupId) {
        $insertStmt->bind_param("ii", $managerId, $workGroupId);
        $insertStmt->execute();
    }

    echo "Work groups assigned successfully.";

    $deleteStmt->close();
    $insertStmt->close();
    $conn->close();
}
?>
