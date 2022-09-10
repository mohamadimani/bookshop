<?php include_once 'header.php';
if (!isset($_SESSION['admin'])) {
    header("Location:index.php");
}

if (isset($_GET['page']) and !empty($_GET['page'])) {
    $products = $functions->get_products("",$_GET['page']);
} else {
    $products = $functions->get_products("",1);
}


if (isset($_GET["deleting"]) and !empty(trim($_GET["deleting"]))) {
    $cat = $functions->delete_product($_GET["deleting"]);
}

$pro_count = $functions->get_products_count();

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
                                    <a href="list_products.php" class="btn btn-info m-2"> خیر</a>
                                </h4>
                                <?php
                            } ?>

                            <thead>
                            <tr>
                                <th>ردیف</th>
                                <th>دسته بندی</th>
                                <th>عنوان محصول</th>
                                <th>تاریخ</th>
                                <th>قیمت</th>
                                <th>عکس</th>
                                <th>ویرایش</th>
                                <th>حذف</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            if (is_array($products)) {
                                foreach ($products as $key => $product) {
                                    ?>
                                    <tr>
                                        <td><?= $key + 1 ?></td>
                                        <td><?= $product['cat_name'] ?></td>
                                        <td><?= $product['product_name'] ?></td>
                                        <td><?= date('Y/m/d', $product['insert_date']) ?></td>
                                        <td><?= number_format($product['price']) ?></td>
                                        <td>
                                            <img src="../files/image/products/<?= $product['id'] . '/' . $product['product_img'] ?>"
                                                 width="60" height="40"
                                                 class="rounded"></td>
                                        <td><a href="edit_product.php?edit=<?= $product['id'] ?>"
                                               class="btn btn-warning p-1"> ویرایش </a></td>
                                        <td><a href="list_products.php?delete=<?= $product['id'] ?>"
                                               class="btn btn-danger p-1"> حذف </a></td>
                                    </tr>
                                <?php }
                            } ?>

                            </tbody>
                        </table>
                        <br>
                        <?php
                        $page_count = ceil($pro_count / 12);
                        for ($i = 1; $i <= $page_count; $i++) { ?>
                            <a href="?page=<?= $i ?>"> <span class="page_ination"><?= $i ?></span></a>
                        <?php } ?>
                        <br>

                    </div>
                </div>
            </div>
        </div>
    </div>
<?php include_once 'footer.php' ?>