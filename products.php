<?php
include_once("header.php");
if (isset($_GET['cat_id']) and !empty($_GET['cat_id'])) {
    $products = $functions->get_pro_cat_web($_GET['cat_id']);
} else {
    header('location:index.php');
}


?>

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
    </style>

    <!------------ start body ------------>
    <div class="onvan"><p> محصولات </p></div>
    <div class="section">

        <!------------ start box ------------>
        <?php if (is_array($products) and !empty($products)) {
            foreach ($products as $key => $product) { ?>
                <a href="product_info.php?pro_id=<?= $product['id'] ?>">
                    <div class="div div1">
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
                    </div>
                </a>
            <?php }
        } else { ?>
            <p>محصولی یافت نشد!</p>
        <?php } ?>
        <!------------ end box ------------>


    </div>
    <!------------ end body ------------>
<?php include_once("footer.php") ?>