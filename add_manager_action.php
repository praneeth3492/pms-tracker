<?php
// add_manager_action.php
require_once "config.php";

$managerName = $_POST['managerName'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

$sql = "INSERT INTO managers (manager_name, password) VALUES (?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $managerName, $password);

if ($stmt->execute()) {
    echo "Manager added successfully!";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
