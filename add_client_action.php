<?php
// add_client_action.php
require_once "config.php";

$clientName = $_POST['clientName'];
$clientCreationDate = $_POST['clientCreationDate'];
error_log("Received date: " . $clientCreationDate); // Debugging line; // Receive the client creation date from the form

// Convert date to datetime format
$clientCreationDateTime = date('Y-m-d H:i:s', strtotime($clientCreationDate));


$sql = "INSERT INTO clients (client_name, client_creation_date) VALUES (?, ?)"; // Modify the SQL query to include client_creation_date
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $clientName, $clientCreationDateTime); // Bind both clientName and clientCreationDateTime

if ($stmt->execute()) {
    echo "Client added successfully!";
} else {
    echo "Error: " . $stmt->error;
}
if (isset($_POST['clientCreationDate'])) {
    $clientCreationDate = $_POST['clientCreationDate'];
    // Convert and use $clientCreationDate as needed
} else {
    echo "Client creation date is not set.";
    exit;
}

$stmt->close();
$conn->close();
?>
