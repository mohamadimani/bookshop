<?php include_once("header.php");

if (isset($_POST["add-address"])) {
    $cat = $functions->add_address($_POST["address"]);
}

?>
    <!-------------- start Table ------------->
    <div class="container">

                <?php if (isset($_SESSION['error'])) { ?>
                    <h4 class="alert alert-<?= $_SESSION['error'][0] ?>"><span> <?= $_SESSION['error'][1] ?></span>
                    </h4>
<!--                    --><?php //unset($_SESSION['error']);
                } ?>
        <div class="sendComment2">
            <div class="right">
                <form method="post" action="#">
                    <textarea placeholder="آدرس خود را بنویسید" cols="30" rows="3" size="none"
                              name="address"></textarea>
                    <button type="submit" name="add-address"> ثبت آدرس و پرداخت</button>
                </form>
            </div>

        </div>


    </div>
    <!-------------- end Table ------------->
<?php include_once("footer.php") ?>