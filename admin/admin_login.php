<?php include_once("header.php");
include_once("../core/model.php");

if (isset($_SESSION['admin']) and !empty(trim($_SESSION['admin']))) {
    header("location:index.php");
}

if (isset($_POST['login_btn'])) {
    $username = $functions->filter($_POST["username"]);
    $password = $functions->filter($_POST["password"]);

    $result = $functions->Do_Select("select * from `user` where username=?  ", [$username], 1);
    if ($result) {
        if ($functions->password_verify($password, $result['password'])) {

            $_SESSION['admin'] = base64_encode($result["id"]);
            $_SESSION['admin_info'] = $result;
            header("location:index.php");
        } else {
            $_SESSION["error"][0] = "danger";
            $_SESSION["error"][1] = "نام کاربری یا رمز عبور اشتباه است!";
        }
    } else {
        $_SESSION["error"][0] = "danger";
        $_SESSION["error"][1] = "هیچ کاربری یافت نشد!";
    }
}

?>


    <div class="boxfader">
        <div class="ADDmininputLOG">
            <h3 style="text-align: center">فرم ورود مدیریت</h3><br>
            <form method="post">

                <?php if (isset($_SESSION['error'])) { ?>
                    <h4 class="alert alert-<?= $_SESSION['error'][0] ?>"><span> <?= $_SESSION['error'][1] ?></span></h4>
                    <?php unset($_SESSION['error']);
                } ?>

                <input type="text" placeholder="نام کاربری" name="username"><br>
                <input type="password" placeholder="پسورد" name="password"><br>
                <button type="submit" name="login_btn">ورود به داشبورد</button>
            </form>
        </div>
    </div>


<?php //include_once("footer.php") ?>