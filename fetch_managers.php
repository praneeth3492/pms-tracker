<?php
// fetch_managers.php
require_once "config.php";

$sql = "SELECT manager_id, manager_name FROM managers";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["manager_id"] . "</td>";
        echo "<td>" . $row["manager_name"] . "</td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='2'>No managers found</td></tr>";
}

$conn->close();
?>
