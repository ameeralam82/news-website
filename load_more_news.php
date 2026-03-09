<?php
include 'db.php';

header('Content-Type: application/json');

$offset = isset($_POST['offset']) ? (int)$_POST['offset'] : 0;
$limit  = 5;

$sql = "SELECT * FROM news ORDER BY created_at DESC LIMIT ?, ?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    echo json_encode([
        'error' => 'SQL prepare failed',
        'mysql_error' => $conn->error
    ]);
    exit;
}

$stmt->bind_param("ii", $offset, $limit);
$stmt->execute();
$result = $stmt->get_result();

$news = [];

while ($row = $result->fetch_assoc()) {
    $news[] = $row;
}

echo json_encode([
    'news' => $news,
    'hasMore' => count($news) === $limit
]);
