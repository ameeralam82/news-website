<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];

    $conn = new mysqli('localhost', 'root', '', 'user_management');

    if ($conn->connect_error) {
        die('Connection failed: ' . $conn->connect_error);
    }

    $stmt = $conn->prepare('SELECT username, password FROM users WHERE email = ?');
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $stmt->bind_result($username, $hashed_password);

    if ($stmt->fetch()) {
        $password = password_hash($hashed_password, PASSWORD_BCRYPT);

        // Send email
        $to = $email;
        $subject = 'Your username and password';
        $message = "Username: $username\nPassword: $password";
        $headers = 'From: noreply@example.com' . "\r\n" .
                   'Reply-To: noreply@example.com' . "\r\n" .
                   'X-Mailer: PHP/' . phpversion();

        if (mail($to, $subject, $message, $headers)) {
            echo 'An email has been sent with your username and password';
        } else {
            echo 'Failed to send email';
        }
    } else {
        echo 'No account found with that email';
    }

    $stmt->close();
    $conn->close();
}
?>
