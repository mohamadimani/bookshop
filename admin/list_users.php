<?php include_once 'header.php';
if (!isset($_SESSION['admin'])) {
    header("Location:admin_login.php");
}

$userid = "";
if (isset($_GET['edit']) and !empty($_GET['edit'])) {
    $userid = $_GET['edit'];
}
$users = $functions->get_users($userid);

if (isset($_GET["deleting"]) and !empty(trim($_GET["deleting"]))) {
    $cat = $functions->delete_user($_GET["deleting"]);
}
if (isset($_POST["add-user"])) {
    $cat = $functions->add_user($_POST);
}

if (isset($_POST["edit-user"])) {
    $cat = $functions->edit_user($_POST, $_GET['edit']);
}

?>
    <div class="boxfather">
        <?php include "sidebar.php" ?>
        <div class="leftbox" style="margin-top: 15px">
            <div class="container-fluid text-center">
                <div class="row">
                    <div class="col-12">
                        <?php if (!isset($_GET['edit'])) { ?>
                            <div class="alert alert-secondary">افزودن کاربر</div>

                            <?php if (isset($_SESSION['error'])) { ?>
                                <h4 class="alert alert-<?= $_SESSION['error'][0] ?>">
                                    <span> <?= $_SESSION['error'][1] ?></span></h4>
                                <?php unset($_SESSION['error']);
                            } ?>

                            <?php if (isset($_GET['delete'])) { ?>
                                <h4 class="alert alert-warning">
                                    <span>  حذف شود ؟ </span>
                                    <a href="?deleting=<?= $_GET['delete'] ?>" class="btn btn-info m-2"> بله</a>
                                    <a href="list_users.php" class="btn btn-info m-2"> خیر</a>
                                </h4>
                                <?php
                            } ?>

                            <form method="post">
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="نام  " name="name"
                                           required>
                                    <input type="text" class="form-control" placeholder="نام خانوادگی  " name="family"
                                           required>
                                    <input type="text" class="form-control" placeholder="نام کاربری    " name="username"
                                           required>
                                    <input type="email" class="form-control" placeholder="   ایمیل  " name="email"
                                           required>
                                    <input type="text" class="form-control" placeholder=" رمز عبور  " name="password"
                                           required>
                                </div>
                                <button type="submit" name="add-user" class="btn btn-success btn-block mt-3"> افزودن
                                </button>
                            </form>
                            <br>
                            <table class="table table-dark table-hover small">
                                <thead>
                                <tr>
                                    <th>ردیف</th>
                                    <th>نام</th>
                                    <th>نام کاربری</th>
                                    <th>نام ایمیل</th>
                                    <th>ویرایش</th>
                                    <th>حذف</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                if (is_array($users)) {
                                    foreach ($users as $key => $value) {
                                        ?>
                                        <tr>
                                            <td><?= $key + 1 ?></td>
                                            <td><?= $value['name'] . ' ' . $value['family'] ?> </td>
                                            <td><?= $value['username'] ?> </td>
                                            <td><?= $value['email'] ?> </td>
                                            <td><a href="list_users.php?edit=<?= $value['id'] ?>"
                                                   class="btn btn-warning p-1"> ویرایش </a></td>
                                            <td><a href="list_users.php?delete=<?= $value['id'] ?>"
                                                   class="btn btn-danger p-1"> حذف </a></td>
                                        </tr>
                                    <?php }
                                } else { ?>
                                    <td><a class="btn btn-danger p-1"> هیچ موردی یافت نشد </a></td>
                                <?php } ?>
                                </tbody>
                            </table>
                        <?php } else {
                            if (is_array($users)) {
                                ?>

                                <div class="alert alert-secondary">ویرایش کاربر</div>

                                <form method="post">
                                    <div class="form-group">
                                        <input type="text" value="<?= $users['name'] ?>" class="form-control"
                                               placeholder="نام  " name="name"
                                               required>
                                        <input type="text" value="<?= $users['family'] ?>" class="form-control"
                                               placeholder="نام خانوادگی  " name="family"
                                               required>
                                        <input type="text" value="<?= $users['username'] ?>" class="form-control"
                                               placeholder="نام کاربری    " name="username"
                                               required>
                                        <input type="email" value="<?= $users['email'] ?>" class="form-control"
                                               placeholder="   ایمیل  " name="email"
                                               required>
                                        <input type="text" value="<?= $users['password'] ?>" class="form-control"
                                               placeholder=" رمز عبور  " name="password"
                                               required>
                                    </div>
                                    <button type="submit" name="edit-user" class="btn btn-success btn-block mt-3">
                                        ویرایش
                                    </button>
                                </form>

                            <?php }
                        } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php include_once 'footer.php' ?>