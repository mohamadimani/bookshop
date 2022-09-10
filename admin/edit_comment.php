<?php include_once 'header.php';
if (!isset($_SESSION['admin'])) {
    header("Location:index.php");
}
if (isset($_GET['edit']) and !empty($_GET['edit'])) {
    $comment = $functions->get_comments($_GET['edit']);
} else {
    header("Location:list_comments.php");
}
if (isset($_POST['edit_comment'])) {
    $functions->edit_comment($_POST, $_GET['edit']);
}


?>
    <div class="boxfather">
        <?php include_once 'sidebar.php' ?>
        <div class="leftbox" style="margin-top: 15px">
            <div class="container-fluid text-center">
                <div class="row">
                    <div class="col-10 mx-auto">
                        <div class="alert alert-secondary">ویرایش نظرات</div>
                        <form method="post" enctype="multipart/form-data">

                            <?php if (isset($_SESSION['error'])) { ?>
                                <h4 class="alert alert-<?= $_SESSION['error'][0] ?>">
                                    <span> <?= $_SESSION['error'][1] ?></span></h4>
                                <?php
//                                unset($_SESSION['error']);
                            } ?>

                            <div class="form-group">
                                <input value="<?= $comment['name'] ?>" type="text" class="form-control"
                                       placeholder="نام  " name="name">
                            </div>
                            <div class="form-group">
                                <input value="<?= $comment['mobile'] ?>" type="text" class="form-control"
                                       placeholder="موبایل  " name="mobile">
                            </div>

                            <div class="form-group">
                                <textarea type="text" class="form-control" placeholder="نظر  "
                                          name="comment"><?= $comment['comment'] ?></textarea>
                            </div>

                            <button type="submit" name="edit_comment" class="btn btn-success btn-block mt-3"> ویرایش
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php include_once 'footer.php' ?>