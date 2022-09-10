<?php include_once 'header.php';
if (!isset($_SESSION['admin'])) {
    header('location:admin_login.php');
}
include_once 'sidebar.php'; ?>


<?php include_once 'footer.php' ?>