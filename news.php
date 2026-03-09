<?php
include 'db.php';

if (!isset($_GET['id']) || $_GET['id'] === '') {
    die('News ID not specified.');
}

$id = (int) $_GET['id'];

$stmt = $conn->prepare("SELECT * FROM news WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$news = $result->fetch_assoc();


if ($result->num_rows === 0) {
    die('News article not found.');
}
?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title><?php echo htmlspecialchars($news['title']); ?></title>
        <style>
            /* body{
                background-color: red;} */
                .news-container{
                    max-width: 70vw;
                    margin: 0 auto;
                    padding: 20px;
                    background-color: white;
                    text-align: left;
                }
                .news-container p{
                    border : 1px solid black;
                    padding: 20px;
                    border-top: 1px solid red;
                }
                .newsimg{
                    width: 100%;
                    height: 500px;
                    margin-bottom: 20px;
                    overflow-y: hidden;
                    border-radius: 20px;
                }
                .news-container img{
                    width: 100%;
                    height: auto;
                    margin-bottom: 20px;
                }
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
        </style>
    </head>
    <body>
        <?php include 'header.php';?>
                <div class="news-container">
        <h1><?php echo htmlspecialchars($news['title']); ?></h1>
        <?php if ($news['image']): ?>
            <div class="newsimg">
            <img  src="<?php echo htmlspecialchars($news['image']); ?>" alt="News Image" ></div>
            <?php endif; ?>
            <p><strong>Posted on:</strong> <?php echo htmlspecialchars($news['created_at'])?></p>
            <p><?php echo nl2br(htmlspecialchars($news['content'])); ?></p>
            </div>
            <a class="anchorbtn" href="index.php">Back to News List</a>
            <?php include 'footer.php';?>
</body>
</html>