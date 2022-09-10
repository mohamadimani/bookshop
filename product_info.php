<?php include_once("header.php");

if (isset($_GET['pro_id']) and !empty($_GET['pro_id'])) {

} else {
    header("location:index.php");
}
if (isset($_POST['add-comment'])) {
    $functions->add_comments($_POST, $_GET['pro_id']);
}

if (isset($_POST['add_basket'])) {
    $functions->add_basket($_GET['pro_id']);
}

$product = $functions->get_products_web($_GET['pro_id']);
$product_comments = $functions->get_products_comments($_GET['pro_id']);
$products = $functions->get_pro_cat_web($product['category_id']);
?>

    <style>
        .discount:after {
            content: " ";
            width: 100%;
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

        .tags {
            position: relative;
            padding: 1px 5px;
            margin: 0 3px;
            background-color: #6178ff;
            display: inline-block;
            color: white;
            border-radius: 3px;

        }
    </style>
<?php
if (isset($_SESSION['error']) and !empty($_SESSION['error'])) {
    ?>
    <h2>
        <a style="text-align: center;display: block;width: 100%;color: green"> با موفقیت ثبت شد </a>
    </h2>
    <?php
} ?>

    <div class="det-product">

        <p><?= $product['product_name'] ?></p>


    </div>


    <div class="pic-box">

        <div class="pic-product">
            <img src="files/image/products/<?= $product['id'] . '/' . $product['product_img'] ?>"
                 alt="">
        </div>
        <div class="desc-product">
            <p> تاریخ ثبت محصول : <span><?= $product['insert_date'] ?></span></p>
            <p> فروشنده این محصول : <span><?= $product['seller'] ?></span></p>
            <p> گارانتی : <span><?= $product['waranty'] ?></span></p>
            <p> دسته بندی محصول : <span><?= $product['cat_name'] ?></span></p>
            <p> برند : <span><?= $product['brand'] ?></span></p>
            <span> قیمت نهایی محصول <span><?= number_format($product['price']) ?></span> تومان
                <span class="discount"><?= number_format($product['discount']) ?></span> </span>
            <form action="#" method="post">
                <button name="add_basket"> افزودن محصول به سبد خرید</button>
            </form>
        </div>
    </div>
    <div class="descrip-pro">

        <h4 style="color: #6b6b6b"> بررسی تخصصی محصول </h4>
        <p>
            <?= $product['introduction'] ?>
            <br>
            <br>
            <?php $tags = explode('،', $product['tags']);
            foreach ($tags as $tag) {
                if (!empty(trim($tag))) {
                    ?>
                    <span class="tags"><?= $tag ?></span>
                <?php }
            } ?>
        </p>
    </div>
    <div class="tabligh"></div>
    <div class="onvan1"><h4>کالای مشابه</h4></div>
    <div class="dop-pro">

        <!------------ start box ------------>
        <?php if (is_array($products)) {
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
        } ?>
        <!------------ end box ------------>

    </div>
    <!------------ end box ------------>
<?php if (isset($_SESSION['error'])) { ?>
    <div class="onvan1">
        <h4 class="alert alert-<?= $_SESSION['error'][0] ?>"><span> <?= $_SESSION['error'][1] ?></span></h4>
    </div>
    <?php
    unset($_SESSION['error']);
} ?>
    <div class="onvan1"><h4>نظرات کاربران در مورد این محصول</h4></div>
    <div class="sendComment">
        <div class="right">
            <form method="post">
                <input type="text" placeholder="نام خود را وارد کنید" name="name"><br>
                <input type="number" placeholder="موبایل خود را وارد کنید" name="mobile" style="margin-top: 10px"><br>
                <textarea placeholder="نظر خود را بنویسید" cols="10" rows="3" size="none" name="comment"></textarea>
                <button type="submit" name="add-comment"> ثبت نظر</button>
            </form>
        </div>
        <div class="left">
            <li>کامنت های حاوی توهین نمایش داده نخواهد شد</li>
            <li>از ارسال کامنت بصورت فینگلیش خودداری فرمایید</li>
            <li>لطفا نظر خود در مورد محصول خریداری شده را بصورت کامل و واضح بیان کنید</li>
            <li>در صورت وجود مشکل در بخش ثبت یا پرداخت مبالغ محصول از قسمت تماس با ما بصورت مستقیم تماس حاصل فرمایید
            </li>
            <li>نظرات بعد از تایید مدیریت نمایش داده خواهد شد،شکیبا باشید</li>
        </div>
    </div>


<?php if (isset($product_comments) and !empty($product_comments)) {
    foreach ($product_comments as $commet) { ?>
        <div class="comment">
            <span style="color: #ffffff;font-size: 13px;margin: 20px"> <?= $commet["name"] ?> </span>
            <span style="color: #ffffff;font-size: 12px;margin: 20px"> در تاریخ :   <?= $commet['insert_date'] ?></span>
            <div class="box">
                <span> <?= $commet['comment'] ?> </span>
            </div>

            <div class="boxcom">
                <span> <?= $commet['replay'] ?> </span>
            </div>
            <span style="float: left;display: block;width: 100%;height: 10px"></span>
        </div>
    <?php }
} else { ?>
    <p style="text-align: center;font-weight: bold">نظری وجود ندارد!</p>
<?php } ?>
    <!------------ end box ------------>


<?php include_once("footer.php") ?>