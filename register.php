<?php
include_once("header.php");
require_once 'core/captcha.php';
require_once 'files/phpmailer/class.phpmailer.php';

$secret = "6Lfz1okaAAAAAEdWjoVVa_oqEsd1JO8KkEUNK4Si"; # SECRET KEY #
$response = null; # RESPONSE #
$reCaptcha = new ReCaptcha($secret); #NEW OBJECT #

if (isset($_POST["btn"])) {
    $username = $functions->filter($_POST['username']);
    $password = $functions->filter($_POST['password']);
    $repassword = $functions->filter($_POST['repassword']);
    $name = $functions->filter($_POST['name']);
    $family = $functions->filter($_POST['family']);
    $email = $functions->filter($_POST['email']);
    if (!empty($username) and !empty($password) and !empty($repassword) and !empty($email) and !empty($name) and !empty($family)) {
        if ($password === $repassword) {
            if ($_POST['g-recaptcha-response']) {
                $response = $reCaptcha->verifyResponse(
                    $_SERVER['REMOTE_ADDR'],
                    $_POST['g-recaptcha-response']
                );
            }
            if ($response != null && $response->success) {
                $users = $functions->Do_Select("select id from users where username=? OR email=?", [$username, $email], 1);
                if (empty(trim($users['id']))) {
                    $data = [$username, $functions->password_hash($password), $name, $family, $email];
                    $result = $functions->Do_Query("insert into users(`username` ,`password` , `name` , family , email ) values (?,?,?,?,?)", $data);
//                    $result=true;
                    if ($result) {
                        $_SESSION["error"][0] = "success";
                        $_SESSION["error"][1] = "ثبت نام انجام شد، وارد شوید";

                        $mail = new PHPMailer();
                        $mail->IsSMTP();
                        $mail->Subject;
                        $mail->FromName;
                        $mail->Sender;
                        $mail->AddAddress($email);
                        $mail->MsgHTML("salam");
                         $mail->Send();

                        $username = "";
                        $password = "";
                        $repassword = "";
                        $name = "";
                        $family = "";
                        $email = "";

                    } else {
                        $_SESSION["error"][0] = "danger";
                        $_SESSION["error"][1] = "مشکل در ثبت نام،مجدد تلاش کند";
                    }
                } else {
                    $_SESSION["error"][0] = "danger";
                    $_SESSION["error"][1] = "این نام کاربری یا ایمیل موجود میباشد";
                }
            } else {
                $_SESSION["error"][0] = "danger";
                $_SESSION["error"][1] = "تایید کنید که ربات نیستید!";
            }
        } else {
            $_SESSION["error"][0] = "danger";
            $_SESSION["error"][1] = "پسورد و تکرار پسورد یکسان نیست!";
        }
    } else {
        $_SESSION["error"][0] = "danger";
        $_SESSION["error"][1] = "مقادیر را درست وارد کنید!";
    }
}
?>

<!------------ start login form ------------>
<div class="sighn">
    <div class="login-top">
        <span> فرم ثبت نام در سایت </span>
    </div>
    <div class="login-bot">
        <form method="post" action="">
            <?php if (isset($_SESSION['error'])) { ?>
                <h4 class="alert alert-<?= $_SESSION['error'][0] ?>"><span> <?= $_SESSION['error'][1] ?></span></h4>
                <?php unset($_SESSION['error']);
            } ?>
            <input value="<?= @$name ?>" type="text" required name="name" placeholder="نام خود را وارد کنید"><br>
            <input value="<?= @$family ?>" type="text" required name="family"
                   placeholder="نام خانوادگی خود را وارد کنید"><br>
            <input value="<?= @$username ?>" type="text" required name="username"
                   placeholder="نام کاربری خود را وارد کنید"><br>
            <input value="<?= @$email ?>" type="email" required name="email" placeholder="ایمیل خود را وارد کنید"><br>
            <input value="<?= @$password ?>" type="password" required name="password"
                   placeholder="رمز عبور خود را وارد کنید">
            <input value="<?= @$repassword ?>" type="password" required name="repassword"
                   placeholder="تکرار رمز عبور خود را وارد کنید">
            <div class="g-recaptcha" data-sitekey="6Lfz1okaAAAAACfsfl5jmWlP8blOOK9nnLSOslO_"></div>
            <button type="submit" name="btn"> ثبت نام در سایت</button>
            <a href="login.php" class="btn btn-registerd">ورود</a>
        </form>
    </div>
</div>
<!------------ end login form ------------>

<?php include_once("footer.php") ?>

















