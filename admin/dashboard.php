<?php
session_start();
if(!isset($_SESSION['username'])) {
    header("Location: ./login.html");
    // exit();
}
else {
    require './index.php';
    // exit();
    }
?>

