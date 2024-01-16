<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assign Work Groups to Manager</title>
</head>
<body>
    <?php
    include 'config.php'; // Database connection

    // Fetch all managers
    $managers = $conn->query("SELECT manager_id, manager_name FROM managers");

    // Fetch all work groups
    $workGroups = $conn->query("SELECT id, name FROM work_groups");
    ?>

    <form action="assign_work_group.php" method="post">
        <label for="manager">Select Manager:</label>
        <select name="manager_id" id="manager" required>
            <?php while ($manager = $managers->fetch_assoc()): ?>
                <option value="<?php echo $manager['manager_id']; ?>"><?php echo htmlspecialchars($manager['manager_name']); ?></option>
            <?php endwhile; ?>
        </select>

        <fieldset>
            <legend>Select Work Groups:</legend>
            <?php while ($workGroup = $workGroups->fetch_assoc()): ?>
                <div>
                    <input type="checkbox" id="work_group_<?php echo $workGroup['id']; ?>" name="work_group_ids[]" value="<?php echo $workGroup['id']; ?>">
                    <label for="work_group_<?php echo $workGroup['id']; ?>"><?php echo htmlspecialchars($workGroup['name']); ?></label>
                </div>
            <?php endwhile; ?>
        </fieldset>

        <button type="submit">Assign Work Groups</button>
    </form>
</body>
</html>
