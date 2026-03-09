<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $old_password = $_POST['old_password'];
    $new_password = password_hash($_POST['new_password'], PASSWORD_BCRYPT);
    $user_id = $_SESSION['user_id'];

    $conn = new mysqli('localhost', 'root', '', 'news_website');

    if ($conn->connect_error) {
        die('Connection failed: ' . $conn->connect_error);
    }

    $stmt = $conn->prepare('SELECT password FROM users WHERE id = ?');
    $stmt->bind_param('i', $user_id);
    $stmt->execute();
    $stmt->bind_result($hashed_password);

    if ($stmt->fetch() && password_verify($old_password, $hashed_password)) {
        $stmt->close();

        $stmt = $conn->prepare('UPDATE users SET password = ? WHERE id = ?');
        $stmt->bind_param('si', $new_password, $user_id);

        if ($stmt->execute()) {
            echo 'Password changed successfully';
        } else {
            echo 'Error: ' . $stmt->error;
        }
    } else {
        echo 'Incorrect old password';
    }

    $stmt->close();
    $conn->close();
}
?>
