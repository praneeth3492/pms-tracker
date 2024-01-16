<?php
// Include your database connection code here
// Example: require_once 'db_connect.php';

include 'config.php'; // Database connection
 
// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Define static workgroups and tasks
$workgroups = [
    "Project Delivery" => [
        "Dr Details",
        "SM Setup",
        "SM Access",
        "Project Insights",
        "Website Content",
        "SM Content",
        "Project QC",
        "Project Launch",
        "Client Sign Off",
    ],
    "Service Delivery" => [
        "Post Verification",
        "Google Rev Resp",
        "Promo Videos",
        "Case Studies",
        "Medical Blogs",
        "Calendars",
        "QC-Calendars",
        "QC-Blueprints",
        "Share Blueprints",
        "Schedule Posts",
        "Citations",
        "Google Reviews",
        "FB Followers",
        "Insta Followers",
        "Backlinks",
        "Keyword Ranks",
        "Progress Reports",
    ],
    "Client Support" => [
        "Design Changes",
        "Oneliner changes",
        "Supporting Text",
        "Website Changes",
        "U/L Case Studies",
        "U/L Blogs",
        "Special post",
        "Wrong post",
        "Research",
    ],
    "Graphic Designing" => [
        "Logo Design",
        "New Posts",
        "Rebranding",
        "FB Cover",
        "YT Channel Art",
        "eVisiting Card",
        "Promo Videos",
        "GIFs",
        "Carousals",
        "Lollipop Designs",
    ],
];

// Define SQL queries
$insertWorkgroupSQL = "INSERT INTO work_groups (name) VALUES (?)";
$insertTaskSQL = "INSERT INTO tasks (task_name, work_group_id) VALUES (?, ?)";

// Prepare and execute queries
foreach ($workgroups as $workgroupName => $tasks) {
    // Insert workgroup
    $stmt = $conn->prepare($insertWorkgroupSQL);
    $stmt->bind_param("s", $workgroupName);
    $stmt->execute();
    $workgroupId = $stmt->insert_id;

    // Insert tasks for the workgroup
    foreach ($tasks as $taskName) {
        $stmt = $conn->prepare($insertTaskSQL);
        $stmt->bind_param("si", $taskName, $workgroupId);
        $stmt->execute();
    }
}

// Close database connection
$conn->close();

echo "Static data inserted successfully.";
?>
