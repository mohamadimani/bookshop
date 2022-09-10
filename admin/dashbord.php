<?php include_once 'header.php';
if (!isset($_SESSION['name'])){
    header("Location:admin_login.php");
}
?>
    <div class="boxfather">
        <?php include_once 'sidebar.php' ?>
        <div class="leftbox">
        </div>
    </div>
<?php include_once 'footer.php' ?>