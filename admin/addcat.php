<?php include_once 'header.php';
if (!isset($_SESSION['admin'])) {
    header("Location:admin_login.php");
}
if (isset($_POST['add-btn'])) {
    $category = $functions->filter($_POST["cat_name"]);
    $parent = $functions->filter($_POST["cat_parent"]);

    if (!empty($category)) {
        if ($parent > 0) {
            $parent1 = $parent;
        } else {
            $parent1 = 0;
        }
        $result = $functions->Do_Query("insert into product_category (cat_name , parent) values (?,?)", [$category, $parent1]);
        if ($result) {
            $_SESSION['error'][0] = "success";
            $_SESSION['error'][1] = "با موفقیت ثبت شد";
        } else {
            $_SESSION['error'][0] = "danger";
            $_SESSION['error'][1] = "مشکل در ثبت، مجدد امتحان کنید!";
        }
    } else {
        $_SESSION['error'][0] = "danger";
        $_SESSION['error'][1] = "مقادیر را وارد کنید!";
    }
}

?>
    <div class="boxfather">
        <?php include_once 'sidebar.php' ?>
        <div class="leftbox" style="margin-top: 15px">
            <div class="container-fluid text-center">
                <div class="row">
                    <div class="col-10 mx-auto">
                        <div class="alert alert-secondary"> افزودن دسته بندی</div>
                        <?php if (isset($_SESSION['error'])) { ?>
                            <h4 class="alert alert-<?= $_SESSION['error'][0] ?>">
                                <span> <?= $_SESSION['error'][1] ?></span></h4>
                            <?php unset($_SESSION['error']);
                        } ?>
                        <form method="post">
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="نام دسته بندی" name="cat_name"
                                       required>
                            </div>
                            <select class="form-control" name="cat_parent" id="cat_parent">
                                <option value="0" class="active">دسته بندی اصلی</option>
                                <?php
                                $functions->get_product_category_option();
                                ?>
                            </select>
                            <button type="submit" name="add-btn" class="btn btn-success btn-block mt-3"> افزودن</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php include_once 'footer.php' ?>