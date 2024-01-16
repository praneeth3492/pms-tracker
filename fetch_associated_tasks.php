<?php
require_once "config.php"; // Ensure this points to your database configuration file

$sql = "SELECT c.client_name, m.manager_name, cm.tasks_id1, cm.tasks_id2, cm.tasks_id3, cm.tasks_id4, cm.tasks_id5, cm.tasks_id6, cm.tasks_id7, cm.tasks_id8 
        FROM client_manager cm
        JOIN clients c ON cm.client_id = c.client_id
        JOIN managers m ON cm.manager_id = m.manager_id";

$result = $conn->query($sql);

$output = "";

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $assignedTasks = [];
        for ($i = 1; $i <= 8; $i++) {
            if (!empty($row["tasks_id$i"])) {
                $assignedTasks[] = $row["tasks_id$i"];
            }
        }
        $output .= "<tr>";
        $output .= "<td>" . htmlspecialchars($row['client_name']) . "</td>";
        $output .= "<td>" . htmlspecialchars($row['manager_name']) . "</td>";
        $output .= "<td>" . htmlspecialchars(implode(", ", $assignedTasks)) . "</td>";
        $output .= "</tr>";
    }
} else {
    $output .= "<tr><td colspan='3'>No data found</td></tr>";
}

echo $output;

$conn->close();
?>
