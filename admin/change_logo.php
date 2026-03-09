<!-- admin_panel.php (Or wherever your admin panel is) -->
<?php
session_start();
include 'db.php';

// Check if the admin is logged in
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit();
}

// Handle the logo upload
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['logo'])) {
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["logo"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if image file is an actual image
    $check = getimagesize($_FILES["logo"]["tmp_name"]);
    if ($check !== false) {
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["logo"]["size"] > 500000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    } else {
        // if everything is ok, try to upload the file
        if (move_uploaded_file($_FILES["logo"]["tmp_name"], $target_file)) {
            // Update logo path in the database
            $stmt = $conn->prepare("UPDATE settings SET logo_path = ? WHERE id = 1");
            $stmt->bind_param("s", $target_file);
            $stmt->execute();
            echo "The file " . htmlspecialchars(basename($_FILES["logo"]["name"])) . " has been uploaded.";
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}

// Get the current logo path
$logoPathQuery = $conn->query("SELECT logo_path FROM settings WHERE id = 1");
$logoPath = $logoPathQuery->fetch_assoc()['logo_path'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel</title>
</head>
<body>

<h2>Change Logo</h2>
<form action="admin_panel.php" method="post" enctype="multipart/form-data">
    <label for="logo">Select new logo:</label>
    <input type="file" name="logo" id="logo">
    <input type="submit" value="Upload Logo" name="submit">
</form>

</body>
</html>
