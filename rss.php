<?php
header("Content-Type: application/rss+xml; charset=ISO-8859-1");

include 'db.php';

$rssfeed = '<?xml version="1.0" encoding="ISO-8859-1"?>';
$rssfeed .= '<rss version="2.0">';
$rssfeed .= '<channel>';
$rssfeed .= '<title>Your News Website</title>';
$rssfeed .= '<link>http://www.yourwebsite.com</link>';
$rssfeed .= '<description>This is an RSS feed for Your News Website</description>';

$sql = "SELECT * FROM news ORDER BY date DESC";
$result = $conn->query($sql);

while ($row = $result->fetch_assoc()) {
    $rssfeed .= '<item>';
    $rssfeed .= '<title>' . htmlspecialchars($row['title']) . '</title>';
    $rssfeed .= '<description>' . htmlspecialchars($row['content']) . '</description>';
    $rssfeed .= '<link>http://www.yourwebsite.com/news/' . $row['id'] . '</link>';
    $rssfeed .= '<pubDate>' . date("D, d M Y H:i:s O", strtotime($row['date'])) . '</pubDate>';
    $rssfeed .= '</item>';
}

$rssfeed .= '</channel>';
$rssfeed .= '</rss>';

echo $rssfeed;
?>
