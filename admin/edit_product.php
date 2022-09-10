<?php include_once 'header.php';
if (!isset($_SESSION['admin'])) {
    header("Location:index.php");
}
if (isset($_GET['edit']) and !empty($_GET['edit'])) {
    $products = $functions->get_products($_GET['edit']);
} else {
    header("Location:list_products.php");
}

$category = $functions->get_product_category();

if (isset($_POST['edit_pro'])) {
    $functions->edit_product($_POST, $_FILES, $_GET['edit']);
}

?>
    <div class="boxfather">
        <?php include_once 'sidebar.php' ?>
        <div class="leftbox" style="margin-top: 15px">
            <div class="container-fluid text-center">
                <div class="row">
                    <div class="col-10 mx-auto">
                        <div class="alert alert-secondary">ویرایش محصول</div>
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
                                        $select = "";
                                        if ($cat['id'] == $products['category_id']) {
                                            $select = "selected";
                                        }
                                        ?>
                                        <option value="<?= $cat['id'] ?>" <?= $select ?>
                                                class="active"><?= $cat['cat_name'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <input value="<?= $products['product_name'] ?>" type="text" class="form-control"
                                       placeholder="عنوان محصول" name="product_name">
                            </div>
                            <div class="form-group">
                                <input value="<?= $products['seller'] ?>" type="text" class="form-control"
                                       placeholder="فروشنده محصول" name="seller">
                            </div>
                            <div class="form-group">
                                <input value="<?= $products['waranty'] ?>" type="text" class="form-control"
                                       placeholder="گارانتی" name="waranty">
                            </div>
                            <div class="form-group">
                                <input value="<?= $products['brand'] ?>" type="text" class="form-control"
                                       placeholder="برند" name="brand">
                            </div>
                            <div class="form-group">
                                <input value="<?= $products['price'] ?>" type="text" class="form-control"
                                       placeholder="قیمت فروش" name="price">
                            </div>
                            <div class="form-group">
                                <input value="<?= $products['discount'] ?>" type="text" class="form-control"
                                       placeholder="قیمت اصلی" name="discount">
                            </div>
                            <div class="form-group">
                                <textarea type="text" class="form-control" placeholder="توضیحات محصول"
                                          name="introduction"><?= $products['introduction'] ?></textarea>
                            </div>
                            <div class="form-group">
                                <input value="<?= $products['tags'] ?>" type="text" class="form-control"
                                       placeholder="تگ محصول" name="tags">
                            </div>
                            <div class="form-group">
                                <img src="../files/image/products/<?= $products['id'] . '/' . $products['product_img'] ?>"
                                     width="90" height="80"
                                     class="rounded">
                                <input type="file" class="form-control" name="product_img">
                            </div>
                            <button type="submit" name="edit_pro" class="btn btn-success btn-block mt-3"> ویرایش
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php include_once 'footer.php' ?>