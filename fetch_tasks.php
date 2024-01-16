<?php
// fetch_tasks.php
require_once "config.php";

$sql = "SELECT task_id, task_name FROM tasks"; // Adjust the query according to your tasks table structure
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["task_id"] . "</td>";
        echo "<td>" . $row["task_name"] . "</td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='2'>No tasks found</td></tr>";
}

$conn->close();
?>
