<!-- assign_client.php -->
<?php
session_start();
if (!isset($_SESSION['manager_id']) || !isset($_SESSION['manager_name'])) {
    header("Location: login.php");
    exit;
}
require_once "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['client_id']) && isset($_POST['manager_id'])) {
        $client_id = $_POST['client_id'];
        $manager_id = $_POST['manager_id'];

        $sql = "INSERT INTO client_manager (client_id, manager_id) VALUES (?, ?)";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $client_id, $manager_id);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            echo "Client assigned to manager successfully!";
        } else {
            echo "Error assigning client to manager: " . $stmt->error;
        }

        $stmt->close();
        $conn->close();
        
    } else {
        echo "Form data is missing!";
    }
} else {
    echo "Invalid request method!";
}

header('Location:' . $_SERVER['HTTP_REFERER']);
exit;
?>
?>
