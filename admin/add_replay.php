<?php include_once 'header.php';
if (!isset($_SESSION['admin'])) {
    header("Location:index.php");
}
if (isset($_GET['replay']) and !empty($_GET['replay'])) {
    $comment = $functions->get_comments($_GET['replay']);
} else {
    header("Location:add_replay.php");
}
if (isset($_POST['add_replay'])) {
    $functions->add_replay($_POST['replay'], $_GET['replay']);
}


?>
    <div class="boxfather">
        <?php include_once 'sidebar.php' ?>
        <div class="leftbox" style="margin-top: 15px">
            <div class="container-fluid text-center">
                <div class="row">
                    <div class="col-10 mx-auto">
                        <div class="alert alert-secondary">ثبت پاسخ</div>
                        <form method="post" enctype="multipart/form-data">

                            <?php if (isset($_SESSION['error'])) { ?>
                                <h4 class="alert alert-<?= $_SESSION['error'][0] ?>">
                                    <span> <?= $_SESSION['error'][1] ?></span></h4>
                                <?php
//                                unset($_SESSION['error']);
                            } ?>

                            <div class="form-group">
                                <input disabled value="<?= $comment['name'] ?>" type="text" class="form-control"
                                       placeholder="نام  " name="name">
                            </div>
                            <div class="form-group">
                                <input disabled value="<?= $comment['mobile'] ?>" type="text" class="form-control"
                                       placeholder="موبایل  " name="mobile">
                            </div>

                            <div class="form-group">
                                <textarea disabled type="text" class="form-control" placeholder="نظر  "
                                          name="comment"><?= $comment['comment'] ?></textarea>
                            </div>

                            <div class="form-group">
                                <textarea type="text" class="form-control" placeholder="پاسخ  "
                                          name="replay"><?= $comment['replay'] ?></textarea>
                            </div>

                            <button type="submit" name="add_replay" class="btn btn-success btn-block mt-3"> ثبت
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php include_once 'footer.php' ?>