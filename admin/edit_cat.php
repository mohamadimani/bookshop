<?php include_once 'header.php';

if (!isset($_SESSION['admin'])) {
    header("Location:admin_login.php");
}
if (isset($_GET['cat_id'])) {
    $cat_id = $functions->filter($_GET["cat_id"]);
    $cat_info = $functions->get_product_category($cat_id);
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
        $result = $functions->Do_Query("update   product_category set cat_name=? , parent=?  where id=?", [$category, $parent1, $cat_id]);
        if ($result) {
            $_SESSION['error'][0] = "success";
            $_SESSION['error'][1] = "با موفقیت ثبت شد";
            if (isset($_GET["parent"]) and !empty(trim($_GET["parent"]))) {
                header("location:listcat.php?parent=" . $parent1);
            } else {
                header("location:listcat.php");
            }
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
                        <form method="post">
                            <a href="listcat.php" class="btn btn-info m-2"> بازگشت</a>
                            <?php if (isset($_SESSION['error']) and !empty($_SESSION['error'][0])) { ?>
                                <h4 class="alert alert-<?= $_SESSION['error'][0] ?>">
                                    <span> <?= $_SESSION['error'][1] ?></span></h4>
                                <?php
//                                unset($_SESSION['error']);
                            } ?>
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="نام دسته بندی" name="cat_name"
                                       required value="<?= $cat_info['cat_name'] ?>">
                            </div>
                            <select class="form-control" name="cat_parent" id="cat_parent">
                                <option value="0">دسته بندی اصلی</option>
                                <?php
                                $cats = $functions->get_product_category();
                                if (is_array($cats)) {
                                    $select = "";
                                    foreach ($cats as $key => $row) {
                                        if ($row['id'] == $cat_info['parent']) {
                                            $select = "selected";
                                        } else {
                                            $select = "";
                                        }
                                        ?>
                                        <option <?= $select ?>
                                                value="<?= $row['id'] ?> "><?= $row['cat_name'] ?></option>
                                    <?php }
                                } ?>
                            </select>
                            <button type="submit" name="add-btn" class="btn btn-success btn-block mt-3"> ویرایش</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php include_once 'footer.php' ?>