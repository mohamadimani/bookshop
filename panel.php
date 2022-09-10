<?php include 'header.php' ?>

<?php if (isset($_SESSION['error']) and !empty( $_SESSION['error'])){?>
<h2>
    <a style="text-align: center;display: block;width: 100%;color: green"> با موفقیت پرداخت انجام شد </a>
</h2>
<?php
unset($_SESSION['error']);}?>
<br>
<h5 style="text-align: center">
    <a href="index.php" class="btn-info" >بازگشت به فروشگاه</a>
</h5>
<br>
<br>
<?php include 'footer.php' ?>
