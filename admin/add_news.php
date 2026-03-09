<?php
include '../db.php';

$title = $content = $image = "";
$category_id = "";
$status = "published";
$update = false;
$id = 0;

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $conn->prepare("SELECT * FROM news WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $title = $row['title'];
        $content = $row['content'];
        $image = $row['image'];
        $category_id = $row['category_id'];
        $status = $row['status'];
        $update = true;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $category_id = $_POST['category_id'];
    $status = $_POST['status'];
    $id = $_POST['id'];

    // keep old image if no new image uploaded
    if (!empty($_FILES['image']['name'])) {
        $image = "images/" . basename($_FILES["image"]["name"]);
        move_uploaded_file($_FILES["image"]["tmp_name"], "../" . $image);
    }

    if ($id != 0) {
        // Update existing news article
        if (!empty($_FILES['image']['name'])) {
            $stmt = $conn->prepare(
                "UPDATE news SET title = ?, content = ?, image = ?, category_id = ?, status = ? WHERE id = ?"
            );
            $stmt->bind_param("sssisi", $title, $content, $image, $category_id, $status, $id);
        } else {
            $stmt = $conn->prepare(
                "UPDATE news SET title = ?, content = ?, category_id = ?, status = ? WHERE id = ?"
            );
            $stmt->bind_param("ssisi", $title, $content, $category_id, $status, $id);
        }
    } else {
        // Insert new news article
        $stmt = $conn->prepare(
            "INSERT INTO news (title, content, image, category_id, status)
             VALUES (?, ?, ?, ?, ?)"
        );
        $stmt->bind_param("sssis", $title, $content, $image, $category_id, $status);
    }

    if ($stmt->execute()) {
        header("Location: index.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo $update ? "Edit" : "Add"; ?> News</title>
    <link rel="stylesheet" href="./addnews.css">
</head>
<body>
    <?php
include './header.php';
?>
<div class="addnewsdiv">
    <h1 class="page-title"><?php echo $update ? "Edit" : "Add"; ?> News</h1>
    <form action="add_news.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <label for="title">Title:</label>
        <input type="text" name="title" id="title" value="<?php echo htmlspecialchars($title); ?>" required>
        <br>
        <label for="content">Content:</label>
        <textarea name="content" id="content" required><?php echo htmlspecialchars($content); ?></textarea>
        <br>
        <label>Category</label>
        <select name="category_id" required>
            <option value="">Select Category</option>
            <option value="1" <?php if($category_id==1) echo 'selected'; ?>>Politics</option>
            <option value="2" <?php if($category_id==2) echo 'selected'; ?>>Sports</option>
            <option value="3" <?php if($category_id==3) echo 'selected'; ?>>Technology</option>
        </select>
        <br>
        <label>Status</label>
        <select name="status">
            <option value="published" <?php if($status=='published') echo 'selected'; ?>>Published</option>
            <option value="draft" <?php if($status=='draft') echo 'selected'; ?>>Draft</option>
        </select>
        <br>

        <br>
        <label for="image">Image:</label>
        <input type="file" name="image" id="image" <?php echo $update ? '' : 'required'; ?>>
        <br>
        <?php if ($update && $image): ?>
            <img src="../<?php echo $image; ?>" alt="Current Image" width="100">
            <br>
        <?php endif; ?>
        <button type="submit"><?php echo $update ? "Update" : "Add"; ?> News</button>
    </form>
</div>
<a class="anchorbtn" href="index.php" class="btn">Back to Dashboard</a>
    <?php
include './footer.php';
?>
</body>
</html>
