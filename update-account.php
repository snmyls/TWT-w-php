<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: user-login.html");
    exit();
}

$username = $_SESSION['username'];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['updateBtn'])) {
    $newUsername = $_POST['new_username'];
    $newPassword = $_POST['new_password'];

    $conn = new mysqli("localhost", "root", "", "techwise_db");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("UPDATE users SET username = ?, password = ? WHERE username = ?");
    $stmt->bind_param("sss", $newUsername, $newPassword, $username);

    if ($stmt->execute()) {
        $_SESSION['username'] = $newUsername;
        $_SESSION['update_status'] = "Account details updated successfully.";
    } else {
        $_SESSION['update_status'] = "Error updating account details: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
    header("Location: User-acc.php");
    exit();
}
?>
