<?php include_once 'header.php';
if (!isset($_SESSION['admin'])) {
    header("Location:index.php");
}

$category = $functions->get_product_category();

if (isset($_POST['add_pro'])) {
    $functions->add_product($_POST,$_FILES);
}

?>
    <div class="boxfather">
        <?php include_once 'sidebar.php' ?>
        <div class="leftbox" style="margin-top: 15px">
            <div class="container-fluid text-center">
                <div class="row">
                    <div class="col-10 mx-auto">
                        <div class="alert alert-secondary">افزودن محصول</div>
                        <form method="post" enctype="multipart/form-data">

                            <?php if (isset($_SESSION['error'])) { ?>
                                <h4 class="alert alert-<?= $_SESSION['error'][0] ?>">
                                    <span> <?= $_SESSION['error'][1] ?></span></h4>
                                <?php
//                                unset($_SESSION['error']);
                            } ?>


                            <div class="form-group">
                                <label for="cat">دسته بندی : </label>
                                <select id="cat" class="form-control" name="category">
                                    <?php
                                    foreach ($category as $cat) {
                                        ?>
                                        <option value="<?= $cat['id'] ?>"
                                                class="active"><?= $cat['cat_name'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="عنوان محصول" name="product_name">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="فروشنده محصول" name="seller">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="گارانتی" name="waranty">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="برند" name="brand">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="قیمت فروش" name="price">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="قیمت اصلی" name="discount">
                            </div>
                            <div class="form-group">
                                <textarea type="text" class="form-control" placeholder="توضیحات محصول"
                                          name="introduction"></textarea>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="تگ محصول" name="tags">
                            </div>
                            <div class="form-group">
                                <input type="file" class="form-control" name="product_img">
                            </div>
                            <button type="submit" name="add_pro" class="btn btn-success btn-block mt-3"> افزودن</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php include_once 'footer.php' ?>