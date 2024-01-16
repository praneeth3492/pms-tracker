<?php
// login.php
session_start();
require_once "config.php";

if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['userType'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $userType = $_POST['userType'];
    
    if ($userType == 'admin' || $userType == 'manager') {
        $sql = ($userType == 'admin') ? "SELECT * FROM managers WHERE manager_name = ?" : "SELECT * FROM managers WHERE manager_name = ? AND manager_id != 1";
        
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();

            if (password_verify($password, $user['password'])) {
                $_SESSION['manager_id'] = $user['manager_id'];
                $_SESSION['manager_name'] = $user['manager_name'];
                $redirect = ($userType == 'admin') ? "dashboard.php" : "manager_dashboard2.php";
                header("Location: " . $redirect);
                exit();
            } else {
                echo "Invalid password!";
            }
        } else {
            echo "Invalid username!";
        }

        $stmt->close();
    } elseif ($userType == 'client') {
        $query = "SELECT client_id, client_name FROM clients WHERE client_name = ? AND password = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();
        $result = $stmt->get_result();

        if (mysqli_num_rows($result) === 1) {
            $row = mysqli_fetch_assoc($result);
            $_SESSION['client_id'] = $row['client_id'];
            $_SESSION['client_name'] = $row['client_name'];
            header('Location: view_performance.php');
            exit();
        } else {
            header('Location: login_form.php?error=1');
            exit();
        }

        $stmt->close();
    } else {
        echo "Invalid user type!";
    }

    $conn->close();
} else {
    echo "Form data is missing!";
}
?>
