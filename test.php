<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manager Dashboard</title>
</head>
<body>
    <h1>Manager Dashboard</h1>

    <?php
    include 'config.php'; // Database connection

    // Fetch and display assigned workgroups
    $managerId = 129; // Replace with the actual manager ID

    // Fetch assigned workgroups from the database
    $workgroupQuery = "SELECT w.name FROM work_groups w
                       INNER JOIN manager_workgroup mw ON w.id = mw.work_group_id
                       WHERE mw.manager_id = $managerId";

    $workgroupResult = mysqli_query($conn, $workgroupQuery);

    if ($workgroupResult) {
        while ($workgroup = mysqli_fetch_assoc($workgroupResult)) {
            echo '<h2>' . $workgroup['name'] . '</h2>';

            // Fetch and display tasks for the workgroup
            $workGroupName = $workgroup['name'];
            $tasksQuery = "SELECT * FROM tasks WHERE work_group_id = (
                SELECT id FROM work_groups WHERE name = ?
            )";

            // Prepare and execute the tasks query
            $tasksStatement = mysqli_prepare($conn, $tasksQuery);
            mysqli_stmt_bind_param($tasksStatement, "s", $workGroupName);
            mysqli_stmt_execute($tasksStatement);

            $tasksResult = mysqli_stmt_get_result($tasksStatement);

            if ($tasksResult) {
                echo '<table>';
                echo '<tr><th>Task Name</th><th>Description</th><th>Due Date</th><th>Status</th><th>Remarks</th></tr>';
                while ($task = mysqli_fetch_assoc($tasksResult)) {
                    echo '<tr>';
                    echo '<td>' . $task['task_name'] . '</td>';
                    echo '<td><input type="text" name="description" value="' . $task['description'] . '"></td>';
                    echo '<td>' . $task['due_date'] . '</td>';
                    echo '<td>
                        <select name="status">
                            <option value="Pending" ' . ($task['status'] == 'Pending' ? 'selected' : '') . '>Pending</option>
                            <option value="Completed" ' . ($task['status'] == 'Completed' ? 'selected' : '') . '>Completed</option>
                        </select>
                    </td>';
                    echo '<td><input type="text" name="remarks" value="' . $task['remarks'] . '"></td>';
                    echo '</tr>';
                }
                echo '</table>';
            } else {
                echo '<p>No tasks assigned.</p>';
            }
        }
    } else {
        echo '<p>No workgroups assigned.</p>';
    }
    ?>
</body>
</html>
