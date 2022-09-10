<?php include_once("header.php");

//error_reporting(0);
$functions->check_login();


if (isset($_POST['login_btn'])) {
    $functions->get_login($_POST);
}

?>

    <!------------ start login form ------------>
    <div class="login">
        <div class="login-top">
            <span> فرم  ورود به  سایت </span>
        </div>
        <div class="login-bot">
            <form method="post"  >
                <?php if (isset($_SESSION['error'])) { ?>
                    <h4 class="alert alert-<?= $_SESSION['error'][0] ?>"><span> <?= $_SESSION['error'][1] ?></span></h4>
                    <?php unset($_SESSION['error']);
                } ?>

                <input required name="username" type="text" placeholder="نام کاربری خود را وارد کنید"><br>
                <input required name="password" type="password" placeholder="رمز عبور خود را وارد کنید">
                <input name="rememberme" type="checkbox" class="check" id="check"><label for="check"> مرا به خاطر بسپار
                    ! </label>
                <button type="submit" name="login_btn"> ورود به سایت</button>
                <a href="register.php" class="btn btn-registerd"> ثبت نام </a>
            </form>
        </div>
    </div>
    <!------------ end login form ------------>

<?php include_once("footer.php") ?>