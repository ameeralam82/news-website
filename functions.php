<?php
include 'db.php';

function addNotification($userId, $message) {
    global $conn;
    $stmt = $conn->prepare("INSERT INTO notifications (user_id, message) VALUES (?, ?)");
    $stmt->bind_param("is", $userId, $message);
    $stmt->execute();
}

function getAllUserIds() {
    global $conn;
    $userIds = [];
    $result = $conn->query("SELECT id FROM users");
    while ($row = $result->fetch_assoc()) {
        $userIds[] = $row['id'];
    }
    return $userIds;
}
?>
