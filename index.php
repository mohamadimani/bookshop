<?php
include_once("header.php");
if (isset($_GET['page']) and !empty($_GET['page'])) {
    $products = $functions->get_products_web("",$_GET['page']);
} else {
    $products = $functions->get_products_web("",1);
}
$slider_images = $functions->get_slider_web();
$pro_count = $functions->get_products_count();

?>
    <!------------ start slider ------------>

    <div class="slideshow-container">
        <?php if (is_array($slider_images)) {
            foreach ($slider_images as $image) {
                ?>
                <div class="mySlides fade">
                    <img src="files/image/slider/<?= $image['img_name'] ?>" style="width:100%">
                </div>
            <?php }
        } ?>


        <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
        <a class="next" onclick="plusSlides(1)">&#10095;</a>
    </div>
    <!------------ end slider ------------>

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
        <br>
        <?php
        $page_count = ceil($pro_count / 12);
        for ($i = 1; $i <= $page_count; $i++) { ?>
            <a href="?page=<?= $i ?>"> <span class="page_ination"><?= $i ?></span></a>
        <?php } ?>
    </div>
    <!------------ end body ------------>
<?php include_once("footer.php") ?>