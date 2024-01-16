<!-- assign_client.php -->
<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
if (!isset($_SESSION['manager_id']) || !isset($_SESSION['manager_name'])) {
    header("Location: login.php");
    exit;
}
require_once "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $client_id = $_POST['client_id'];
    $manager_id = $_POST['manager_id'];
    $tasks = $_POST['tasks']; // This is an array of selected tasks

    // Initialize all task_ids to NULL
    $task_ids = array_fill(0, 8, NULL);

    // Assuming the tasks array contains task names, map them to their respective IDs
    foreach ($tasks as $index => $taskName) {
        // Manually map task names to task_ids
        if (str_contains($taskName, 'access_optimise')) {
            $task_ids[0] = 'access_optimise';
        }
        if (str_contains($taskName, 'content_development')) {
            $task_ids[1] = 'content_development';
        }
        if (str_contains($taskName, 'drs_details')) {
            $task_ids[2] = 'drs_details';
        }
        if (str_contains($taskName, 'project_details')) {
            $task_ids[3] = 'project_details';
        }
        if (str_contains($taskName, 'project_insights')) {
            $task_ids[4] = 'project_insights';
        }
        if (str_contains($taskName, 'project_launch')) {
            $task_ids[5] = 'project_launch';
        }
        if (str_contains($taskName, 'quality_check')) {
            $task_ids[6] = 'quality_check';
        }
        if (str_contains($taskName, 'website')) {
            $task_ids[7] = 'website';
        }
        // Add more if statements for other tasks as needed
    }
    

    $sql = "UPDATE client_manager SET tasks_id1 = ?, tasks_id2 = ?, tasks_id3 = ?, tasks_id4 = ?, tasks_id5 = ?, tasks_id6 = ?, tasks_id7 = ?, tasks_id8 = ? WHERE client_id = ? AND manager_id = ?";
    $stmt = $conn->prepare($sql);

    // Assuming $client_id and $manager_id are integers, and task_ids are strings
    $stmt->bind_param("ssssssssii", $task_ids[0], $task_ids[1], $task_ids[2], $task_ids[3], $task_ids[4], $task_ids[5], $task_ids[6], $task_ids[7], $client_id, $manager_id);

    $stmt->execute();

    // Check for errors
    if ($stmt->error) {
        // Handle error
        echo "Error: " . $stmt->error;
    } else {
        echo "Client assigned to manager successfully!";
    }

    // Close the statement
    $stmt->close(); // Remove the duplicate $stmt->close() here
}

header('Location:' . $_SERVER['HTTP_REFERER']);
exit;

?>
