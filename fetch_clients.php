
<?php
// fetch_clients.php
require_once "config.php";

$sql = "SELECT client_id, client_name FROM clients";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["client_id"] . "</td>";
        echo "<td>" . $row["client_name"] . "</td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='2'>No client found</td></tr>";
}

$conn->close();
?>