<?php
session_start();
$connection = mysqli_connect('localhost', 'root', '', 'pms2');
if (!$connection) {
    die("Database connection failed: " . mysqli_connect_error());
}

$clientId = $_POST['client_id'] ?? $_SESSION['client_id'];
$month = $_POST['month'];
$year = $_POST['year'];

$query = "SELECT * FROM client_performance WHERE client_id = ? AND month_id = ? AND year_id = ?";
$stmt = $connection->prepare($query);
$stmt->bind_param("iii", $clientId, $month, $year);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $data = $result->fetch_assoc();
    echo json_encode($data);
} else {
    echo json_encode(['error' => 'No data available.']);
}

$stmt->close();
mysqli_close($connection);
?>
