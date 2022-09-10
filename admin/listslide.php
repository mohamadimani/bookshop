<?php include_once 'header.php';
if (!isset($_SESSION['admin'])) {
    header("Location:admin_login.php");
}

$slides = $functions->get_slider_images();

if (isset($_GET["deleting"]) and !empty(trim($_GET["deleting"]))) {
    $cat = $functions->delete_slider($_GET["deleting"]);
}
if (isset($_POST["add-img"])) {
    $cat = $functions->upload_slider($_FILES['image']);
}

?>
    <div class="boxfather">
        <?php include "sidebar.php" ?>
        <div class="leftbox" style="margin-top: 15px">
            <div class="container-fluid text-center">
                <div class="row">
                    <div class="col-12">
                        <div class="alert alert-secondary">افزودن تصاویر اسلایدر</div>

                        <?php if (isset($_SESSION['error'])) { ?>
                            <h4 class="alert alert-<?= $_SESSION['error'][0] ?>">
                                <span> <?= $_SESSION['error'][1] ?></span></h4>
                            <?php unset($_SESSION['error']);
                        } ?>

                        <?php if (isset($_GET['delete'])) { ?>
                            <h4 class="alert alert-warning">
                                <span>  حذف شود ؟ </span>
                                <a href="?deleting=<?= $_GET['delete'] ?>" class="btn btn-info m-2"> بله</a>
                                <a href="listslide.php" class="btn btn-info m-2"> خیر</a>
                            </h4>
                            <?php
                        } ?>

                        <form method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <input type="file" class="form-control" placeholder="انتخاب فایل" name="image"
                                       required>
                            </div>
                            <button type="submit" name="add-img" class="btn btn-success btn-block mt-3"> افزودن</button>
                        </form>
                        <br>
                        <table class="table table-dark table-hover small">
                            <thead>
                            <tr>
                                <th>ردیف</th>
                                <th>تصویر</th>
                                <th>حذف</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            if (is_array($slides)) {
                                foreach ($slides as $key => $value) {
                                    ?>
                                    <tr>
                                        <td><?= $key + 1 ?></td>
                                        <td><img src="../files/image/slider/<?= $value['img_name'] ?>" width="80"
                                                 class="rounded shadow"></td>
                                        <td><a href="listslide.php?delete=<?= $value['id'] ?>"
                                               class="btn btn-danger p-1"> حذف </a></td>
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