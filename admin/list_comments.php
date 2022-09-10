<?php include_once 'header.php';
if (!isset($_SESSION['admin'])) {
    header("Location:index.php");
}

$comments = $functions->get_comments();

if (isset($_GET["deleting"]) and !empty(trim($_GET["deleting"]))) {
    $cat = $functions->delete_comments($_GET["deleting"]);
}

?>

    <style>
        .page_ination {
            position: relative;
            padding: 1px 5px;
            margin: 0 3px;
            background-color: #6178ff;
            display: inline-block;
            color: white;
            border-radius: 3px;
            cursor: pointer;
        }

    </style>
    <div class="boxfather">
        <?php include_once 'sidebar.php' ?>
        <div class="leftbox" style="margin-top: 15px">
            <div class="container-fluid text-center">
                <div class="row">
                    <div class="col-12">
                        <div class="alert alert-secondary">لیست محصولات سایت</div>

                        <table class="table table-dark table-hover small">
                            <?php if (isset($_SESSION['error'])) { ?>
                                <h4 class="alert alert-<?= $_SESSION['error'][0] ?>">
                                    <span> <?= $_SESSION['error'][1] ?></span></h4>
                                <?php
                                unset($_SESSION['error']);
                            } ?>

                            <?php if (isset($_GET['delete'])) { ?>
                                <h4 class="alert alert-warning">
                                    <span>  حذف شود ؟ </span>
                                    <a href="?deleting=<?= $_GET['delete'] ?>" class="btn btn-info m-2"> بله</a>
                                    <a href="list_comments.php" class="btn btn-info m-2"> خیر</a>
                                </h4>
                                <?php
                            } ?>

                            <thead>
                            <tr>
                                <th>ردیف</th>
                                <th> نام</th>
                                <th> موبایل</th>
                                <th>نظر</th>
                                <th>محصول</th>
                                <th>تاریخ</th>
                                <th>ویرایش</th>
                                <th>حذف</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            if (is_array($comments)) {
                                foreach ($comments as $key => $comment) {
                                    ?>
                                    <tr>
                                        <td><?= $key + 1 ?></td>
                                        <td><?= $comment['name'] ?></td>
                                        <td><?= $comment['mobile'] ?></td>
                                        <td><?= $comment['comment'] ?></td>
                                        <td><?= $comment['product_name'] ?></td>
                                        <td><?= date('Y/m/d', $comment['insert_date']) ?></td>
                                        <td><a href="add_replay.php?replay=<?= $comment['id'] ?>"
                                               class="btn btn-info p-1"> پاسخ </a></td>
                                        <td><a href="edit_comment.php?edit=<?= $comment['id'] ?>"
                                               class="btn btn-warning p-1"> ویرایش </a></td>
                                        <td><a href="list_comments.php?delete=<?= $comment['id'] ?>"
                                               class="btn btn-danger p-1"> حذف </a></td>
                                    </tr>
                                <?php }
                            } ?>

                            </tbody>
                        </table>


                    </div>
                </div>
            </div>
        </div>
    </div>
<?php include_once 'footer.php' ?>