<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Work Groups</title>
</head>
<body>
    <?php
    include 'config.php'; // Database connection
    $workGroupId = isset($_GET['id']) ? $_GET['id'] : null;
    $workGroupName = '';

    if ($workGroupId) {
        // Fetch existing work group details
        $stmt = $conn->prepare("SELECT name FROM work_groups WHERE id = ?");
        $stmt->bind_param("i", $workGroupId);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $workGroupName = $row['name'];
        }
        $stmt->close();
    }
    ?>

    <form action="save_work_group.php" method="post">
        <input type="hidden" name="work_group_id" value="<?php echo htmlspecialchars($workGroupId); ?>">
        <label for="work_group_name">Work Group Name:</label>
        <input type="text" name="work_group_name" id="work_group_name" value="<?php echo htmlspecialchars($workGroupName); ?>" required>
        <button type="submit">Save Work Group</button>
    </form>
</body>
</html>
