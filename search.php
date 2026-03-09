<?php
include 'header.php';
include 'db.php';

if (isset($_GET['query'])) {
    $query = htmlspecialchars($_GET['query']);
    $stmt = $conn->prepare("SELECT * FROM news WHERE title LIKE ? OR content LIKE ?");
    $searchTerm = "%" . $query . "%";
    $stmt->bind_param("ss", $searchTerm, $searchTerm);
    $stmt->execute();
    $result = $stmt->get_result();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Search Results</title>
    <style>
    .anchorbtn{
    display: inline-block;
    background-color: #007bff;
    color: #fff;
    padding: 10px 20px;
    border-radius: 5px;
    text-decoration: none;
    margin-top: 80px;
    margin-left: 100px;
    text-align: center;
    
}</style>
</head>
<body>
    <h1>Search Results for "<?php echo $query; ?>"</h1>

    <?php
    if (isset($result) && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<div class='news-article'>";
            echo "<h2><a href='news.php?id=" . $row['id'] . "'>" . htmlspecialchars($row['title']) . "</a></h2>";
            echo "<p>" . htmlspecialchars(substr($row['content'], 0, 100)) . "...</p>";
            echo "</div>";
        }
    } else {
        echo "<p>No results found</p>";
        echo "<img src='https://media3.giphy.com/media/v1.Y2lkPTc5MGI3NjExZmJjbG9nMWxuMXA0MTd4cmIzMHQxYXo5YzRndzE3c2gzOGZubTl4dCZlcD12MV9pbnRlcm5hbF9naWZfYnlfaWQmY3Q9Zw/OKvgO8uBDWi3Uu6ht3/giphy.gif' width='300'>";
        echo "<br><a class='anchorbtn' href='index.php'>Go Back !!!</a>";
    }
    include 'footer.php';
    ?>
</body>
</html>

