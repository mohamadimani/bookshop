<?php include_once("header.php");

if (isset($_GET["deleting"]) and !empty(trim($_GET["deleting"]))) {
    $cat = $functions->delete_basket($_GET["deleting"]);
}

$basket_products = $functions->get_basket();
?>
    <!-------------- start Table ------------->
    <div class="container">
        <?php if (isset($_GET['delete'])) { ?>
            <h4 class="alert alert-warning">
                <span>  حذف شود ؟ </span>
                <a href="?deleting=<?= $_GET['delete'] ?>" class="btn-danger  "> بله</a>
                <a href="basket.php" class="btn-info"> خیر</a>
            </h4>
            <?php
        } ?>
        <table>
            <thead>
            <tr>
                <th> ردیف</th>
                <th> نام محصول</th>
                <th> تعداد</th>
                <th> قیمت محصول</th>
                <th> قیمت کل</th>
                <th> حذف از سبد</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $all_price = 0;
            if (count($basket_products) > 0) {
                foreach ($basket_products as $key => $product) {
                    $all_price = $all_price + ($product['price'] * $product['pro_count']);

                    ?>
                    <tr>
                        <td><?= $key + 1 ?></td>
                        <td><?= $product['product_name'] ?></td>
                        <td><?= $product['pro_count'] ?></td>
                        <td><?= $product['price'] ?></td>
                        <td><?= $product['price'] * $product['pro_count'] ?></td>
                        <td><a href="?delete=<?= $product['id'] ?>" class="btn-danger"> حذف </a></td>
                    </tr>
                <?php } ?>
                <tr>
                    <td>مجموع سبد خرید :</td>
                    <td> <?= $all_price ?></td>
                    <td></td>
                    <td></td>
                    <td><a href="get_address.php" class="btn-info">نهایی کردن خرید</a></td>
                </tr>
            <?php }else{ ?>
                <tr>


                    <td></td>
                    <td style="color: red">هیچ محصولی وجود ندارد!</td>
                    <td></td>

                </tr>
                <?php }?>
            </tbody>
        </table>
    </div>
    <!-------------- end Table ------------->
<?php include_once("footer.php") ?>