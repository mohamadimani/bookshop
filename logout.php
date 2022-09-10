<?php
session_start();
session_destroy();
setcookie("um0406", "", time() + 1);
setcookie("pm0406", "", time() + 1);
header("location:index.php");

?>

