<?php
session_start();
require_once "config.php"; // Adjust with your actual config file
ini_set('display_errors', 1);
error_reporting(E_ALL);


// Fetch work groups from the database
$workGroups = [];
$sql = "SELECT * FROM work_groups";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $workGroups[] = $row;
    }
} else {
    echo "No work groups found.";
}
if (isset($_POST['work_group_id']) && !empty($_POST['work_group_id'])) {
    $work_group_id = $_POST['work_group_id'];
} else {
    // Handle the case where work_group_id is not set or empty
    echo "Error: work_group_id is required.";
    exit;
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Extract and sanitize input data
    $taskName = $conn->real_escape_string($_POST['task_name']);
    $workGroupId = $conn->real_escape_string($_POST['work_group_id']);
    $description = $conn->real_escape_string($_POST['description']);
    $dueDate = $conn->real_escape_string($_POST['due_date']);
    $status = $conn->real_escape_string($_POST['status']);

    // Insert data into database
    try {
        // Your insert query
        $stmt = $conn->prepare("INSERT INTO tasks (task_name, work_group_id, description, due_date, status) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sisss", $task_name, $work_group_id, $description, $due_date, $status);
        
        // Check for successful execution
        if (!$stmt->execute()) {
            echo "Error: " . $stmt->error;
        }
    } catch (mysqli_sql_exception $e) {
        echo "Error: " . $e->getMessage();
        // Handle error, e.g., by logging it or displaying a user-friendly message
    }
}    
echo "<pre>";
print_r($_POST);
echo "</pre>";
$conn->close();


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Task</title>
    <!-- Include your CSS files here -->
</head>
<body>
    <h2>Add Task</h2>
    <form action="add_task.php" method="post">
        <label for="task_name">Task Name:</label>
        <input type="text" name="task_name" id="task_name" required><br>

        <label for="work_group_id">Work Group:</label>
        <select name="work_group_id" id="work_group_id" required>
            <?php foreach($workGroups as $group): ?>
                <option value="<?php echo htmlspecialchars($group['work_group_id']); ?>">
                    <?php echo htmlspecialchars($group['name']); ?>
                </option>
            <?php endforeach; ?>
        </select><br>

        <label for="description">Description:</label>
        <textarea name="description" id="description" required></textarea><br>

        <label for="due_date">Due Date:</label>
        <input type="date" name="due_date" id="due_date" required><br>

        <label for="status">Status:</label>
        <select name="status" id="status" required>
            <option value="Pending">Pending</option>
            <option value="In Progress">In Progress</option>
            <option value="Completed">Completed</option>
        </select><br>

        <input type="submit" value="Add Task">
    </form>
</body>
</html>
