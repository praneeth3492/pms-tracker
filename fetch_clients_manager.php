
<?php
// fetch_clients.php
require_once "config.php";

$sql = "SELECT clients.client_name, managers.manager_name 
        FROM client_manager
        JOIN clients ON client_manager.client_id = clients.client_id
        JOIN managers ON client_manager.manager_id = managers.manager_id";

$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['client_name'] . "</td>";
        echo "<td>" . $row['manager_name'] . "</td>";
        echo "</tr>";
    }
} else {
    echo '<tr><td colspan="2">No records found.</td></tr>';
}

$stmt->close();