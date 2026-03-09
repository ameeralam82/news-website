<?php include './header.php'; ?>

<?php
include '../session_check.php';
include '../db.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($id, $hashed_password);
    $stmt->fetch();

    if ($stmt->num_rows > 0 && password_verify($password, $hashed_password)) {
        $_SESSION['user_id'] = $id;
        $_SESSION['username'] = $username;
        header("Location: ./admin/dashboard.php");




    } else {
        echo "Invalid username or password";
    }

    $stmt->close();
}


?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../styles.css"> <!-- Assuming you have a CSS file for styling -->
    <style>
        body{padding-top: 37vh;}
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
    
}
#news-table {
    width: 90%;
    margin: 20px auto;
    border-collapse: collapse;
    text-align: center;
}
#news-table th, #news-table td {
    border: 1px solid #ddd;
    padding: 8px;
}
#news-table th {
    background-color: #f2f2f2;
    color: #333;
}
    </style>
</head>
<body>
    <h1>Admin Dashboard</h1>
    <a href="add_news.php" class="btn">Add News</a>
    <a href="../logout.php" class="btn">Log Out</a>
    <a href="./admin/change_logo.php" class="btn">Chnage Logo</a>

    <h2>Manage News Articles</h2>
<?php
// include './db.php';
    $stmt = $conn->prepare("SELECT news.*, categories.category_name 
FROM news
LEFT JOIN categories ON news.category_id = categories.id
ORDER BY news.created_at DESC
");
    $stmt->execute();
    $result = $stmt->get_result();


    if ($result->num_rows > 0) {
        echo "<table id='news-table'>";
        echo "<tr><th>Title</th><th>Actions</th><th>Category</th><th>Created At</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row['title']) . "</td>";
            echo "<td>";
            echo "<a href='../news.php?id=" . $row['id'] . "' target='_blank'>View</a> | ";
            echo "<a href='add_news.php?id=" . $row['id'] . "'>Edit</a> | ";
            echo "<a href='delete_news.php?id=" . $row['id'] . "' onclick='return confirm(\"Are you sure you want to delete this article?\")'>Delete</a>";
            echo "</td>";
            echo "<td>" . htmlspecialchars($row['category_name']) . "</td>";
            echo "<td>" . htmlspecialchars($row['created_at']) . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p>No news articles available.</p>";
    }
    ?>
    <a href="../index.php" class="btn anchorbtn">Back to Dashboard</a>
    
</body>
</html>
    <?php include './footer.php'; ?>