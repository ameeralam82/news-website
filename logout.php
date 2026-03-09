<?php
session_start();
session_unset();
session_destroy();
header("Location: ./index.php");
exit();
echo "Logout successful!";
?>
<?php
// session_start();
// if (!isset($_SESSION['user_id'])) {
//     header("Location: ../login.php");
//     exit();
// }
?>
