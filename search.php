<?php
include_once("header.php");
$products = [];
if (isset($_POST['search']) and !empty($_POST['search'])) {
    $products = $functions->get_products_search($_POST['search']);
}

$pro_count = $functions->get_products_count();

?>

    <!------------ start body ------------>
    <div class="onvan"><p> جدیدترین محصولات </p></div>
    <div class="section">

        <style>
            .discount:after {
                content: " ";
                width: 95%;
                height: 1px;
                position: absolute;
                top: 15px;
                right: 0;
                transform: rotate(-15deg);
                display: block;
                background-color: #ff0003;
            }

            .discount {
                position: relative;
                padding: 3px;
                margin: 0 3px;
                background-color: #cffdff;
                display: inline-block;
            }

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

        <!------------ start box ------------>
        <?php if (is_array($products) and !empty($products)) {
            foreach ($products as $key => $product) { ?>
                <div class="div div1">
                    <a href="product_info.php?pro_id=<?= $product['id'] ?>">
                        <div class="image-box">
                            <img src="files/image/products/<?= $product['id'] . '/' . $product['product_img'] ?>"
                                 alt="">
                        </div>
                        <div class="text-box">
                            <p> <?= $product['product_name'] ?></p>
                        </div>
                        <div class="price-box">
                            <p><span><?= number_format($product['price']) ?></span> تومان
                                <span class="discount"><?= number_format($product['discount']) ?></span>
                            </p>
                        </div>
                    </a>
                </div>
            <?php }
        } else { ?>
            <p>محصولی یافت نشد!</p>
        <?php } ?>
        <!------------ end box ------------>

    </div>
    <!------------ end body ------------>
<?php include_once("footer.php") ?>