<?php
include_once 'header.php';
include_once '../core/model.php';
if (!isset($_SESSION['admin'])) {
    header("Location:admin_login.php");
}


if (isset($_GET["inactive"]) and !empty(trim($_GET["inactive"]))) {
    $functions->cat_status("inactive", $_GET["inactive"]);
}
if (isset($_GET["active"]) and !empty(trim($_GET["active"]))) {
    $functions->cat_status("active", $_GET["active"]);
}


$btn_back = "";
if (isset($_GET["parent"]) and !empty(trim($_GET["parent"]))) {
    $cat = $functions->get_product_category_childs($_GET["parent"]);
    $btn_back = '<a href="listcat.php" class="btn btn-info m-2"> بازگشت</a>';
} else {
    $cat = $functions->get_product_category();
}

if (isset($_GET["deleting"]) and !empty(trim($_GET["deleting"]))) {
    $cat = $functions->delete_product_category($_GET["deleting"]);
    if ($cat) {
        $_SESSION['error'][0] = "success";
        $_SESSION['error'][1] = "حدف شد!";
    } else {
        $_SESSION['error'][0] = "danger";
        $_SESSION['error'][1] = "  مشکل در حذف!";
    }
    if (isset($_GET["parent"]) and !empty(trim($_GET["parent"]))) {
        header("location:listcat.php?parent=" . $_GET["parent"]);
    } else {
        header("location:listcat.php");
    }
}

?>
    <div class="boxfather">
        <?php include_once 'sidebar.php' ?>
        <div class="leftbox" style="margin-top: 15px">
            <div class="container-fluid text-center">
                <div class="row">
                    <div class="col-12">
                        <div class="alert alert-secondary">لیست دسته بندی ها</div>
                        <?= $btn_back ?>
                        <?php if (isset($_SESSION['error'])) { ?>
                            <h4 class="alert alert-<?= $_SESSION['error'][0] ?>">
                                <span> <?= $_SESSION['error'][1] ?></span></h4>
                            <?php
                            unset($_SESSION['error']);
                        } ?>

                        <?php if (isset($_GET['delete'])) { ?>
                            <h4 class="alert alert-warning">
                                <span> دسته بندی حذف شود ؟ </span>
                                <?php if (isset($_GET["parent"]) and !empty(trim($_GET["parent"]))) { ?>
                                    <a href="?parent=<?= $_GET['parent'] ?>&deleting=<?= $_GET['delete'] ?>"
                                       class="btn btn-info m-2"> بله</a>
                                    <a href="listcat.php?parent=<?= $_GET['parent'] ?>" class="btn btn-info m-2">
                                        خیر</a>
                                <?php } else { ?>
                                    <a href="?deleting=<?= $_GET['delete'] ?>" class="btn btn-info m-2"> بله</a>
                                    <a href="listcat.php" class="btn btn-info m-2"> خیر</a>
                                <?php } ?>
                            </h4>
                            <?php
                        } ?>
                        <table class="table table-dark table-hover small">

                            <thead>
                            <tr>
                                <th>ردیف</th>
                                <th>نام دسته بندی</th>
                                <th>زیر دسته ها</th>
                                <th>وضعیت</th>
                                <th>ویرایش</th>
                                <th>حذف</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            if (is_array($cat)) {
                                foreach ($cat as $key => $row) {
                                    ?>
                                    <tr>
                                        <td><?= $key + 1 ?></td>
                                        <td><?= $row["cat_name"] ?></td>
                                        <?php if ($row["parent"] == 0) { ?>
                                            <td><a href="?parent=<?= $row["id"] ?>" class="btn btn-info p-1 ">
                                                    <i class="glyphicon fa fa-eye"></i> </a></td>
                                        <?php } else { ?>
                                            <td><a class="btn btn-danger p-1 ">
                                                    <i class="glyphicon fa fa-eye-slash"></i> </a></td>
                                        <?php } ?>

                                        <?php if ($row["parent"] == 0) { ?>

                                            <?php if ($row["status"] == "ACTIVE") { ?>
                                                <td><a href="?inactive=<?= $row["id"] ?>" class="btn btn-success p-1">
                                                        فعال </a></td>
                                            <?php } else { ?>
                                                <td><a href="?active=<?= $row["id"] ?>" class="btn btn-warning p-1">
                                                        غیرفعال </a></td>
                                            <?php } ?>

                                            <td><a href="edit_cat.php?cat_id=<?= $row["id"] ?>"
                                                   class="btn btn-warning p-1"> ویرایش </a></td>
                                            <td><a href="?delete=<?= $row["id"] ?>" class="btn btn-danger p-1"> حذف </a>
                                            </td>

                                        <?php } else {
                                            if ($row["status"] == "ACTIVE") { ?>
                                                <td><a href="?parent=<?= $_GET["parent"] ?>&inactive=<?= $row["id"] ?>"
                                                       class="btn btn-success p-1">
                                                        فعال </a></td>
                                            <?php } else { ?>
                                                <td><a href="?parent=<?= $_GET["parent"] ?>&active=<?= $row["id"] ?>"
                                                       class="btn btn-warning p-1">
                                                        غیرفعال </a></td>
                                            <?php } ?>

                                            <td>
                                                <a href="edit_cat.php?parent=<?= $_GET["parent"] ?>&cat_id=<?= $row["id"] ?>"
                                                   class="btn btn-warning p-1"> ویرایش </a></td>
                                            <td><a href="?parent=<?= $_GET["parent"] ?>&delete=<?= $row["id"] ?>"
                                                   class="btn btn-danger p-1"> حذف </a></td>

                                        <?php } ?>


                                    </tr>
                                <?php }
                            } else { ?>
                                <td><a class="btn btn-danger p-1"> هیچ موردی یافت نشد </a></td>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php include_once 'footer.php' ?>