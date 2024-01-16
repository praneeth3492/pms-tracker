<?php
session_start();
require_once "config.php";

header('Content-Type: application/json');

if (isset($_GET['client_id']) && is_numeric($_GET['client_id'])) {
    $client_id = intval($_GET['client_id']);

    // SQL query to fetch project details
    $sql = "SELECT * FROM project_launch WHERE client_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $client_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();
        echo json_encode($data);
    } else {
        echo json_encode(["error" => "No project_launch details found for client ID: " . $client_id]);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(["error" => "Invalid client ID"]);
}
?>
