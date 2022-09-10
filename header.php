<?php
include_once("core/model.php");
session_start();
$meno = $functions->get_meno();
//$meno = [];

?>
<!DOCTYPE html>
<html dir="rtl" lang="fa">
<head>
    <title> عنوان صفحه </title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <link rel="stylesheet" href="files/css/style.css">
</head>
<body>
<!------------ start header ------------>

<style>

    ul.sub_mano li:hover {
        background-color: #6178ff !important;
    }

    ul.sub_mano li {
        display: block;
        text-align: right;
        padding: 0 15px;
        border-bottom: 1px solid #828282;
        height: 35px;
        line-height: 35px;
    }

    ul.sub_mano li a:hover {
        color: white;
    }

    ul.sub_mano li a {
        color: white;
        padding: 2px 5px;
    }

    ul.sub_mano {
        list-style: none;
        padding: 0;
        margin: 0;
        display: none;
        position: absolute;
        top: 50px;
        right: 10px;
        background-color: #3c64f5;
        z-index: 99999999;
    }

    nav > ul li.sup_meno {
        position: relative;
    }

    nav > ul li.sup_meno:hover ul.sub_mano {
        display: block;
    }

</style>

<header>
    <nav>
        <ul>
            <li><a href="index.php">خانه</a></li>
            <li><a href="admin/admin_login.php">پنل مدیریت</a></li>
            <?php

            if (is_array($meno)) {
                foreach ($meno as $row) {
                    $sub_meno = "";
                    $sub_meno = $functions->get_meno($row['id']);
                    ?>
                    <li class="sup_meno"><a href="products.php?cat_id=<?= $row['id'] ?>"><?= $row['cat_name'] ?></a>
                        <?php if (is_array($sub_meno)) { ?>
                            <ul class="sub_mano">
                                <?php foreach ($sub_meno as $sub_row) { ?>
                                    <li>
                                        <a href="products.php?cat_id=<?= $sub_row['id'] ?>"><?= $sub_row['cat_name'] ?></a>
                                    </li>
                                <?php } ?>
                            </ul>
                        <?php } ?>
                    </li>
                <?php }
            } ?>

            <?php if (isset($_SESSION['user']) and !empty(trim($_SESSION['user']))) { ?>
                <li><a href="panel.php">پنل کاربری</a></li>
                <li><a href="logout.php">خروج</a></li>
            <?php } else { ?>
                <li><a href="login.php">ورود</a></li>
                <li><a href="register.php">عضویت</a></li>
            <?php } ?>
            <li><a href="basket.php"
                   style="background-color: #12a1ee;padding: 5px 15px;border-radius: 3px;color: #ffffff;font-size: 12px">
                    سبد خرید <span></span> </a>
            </li>
            <li>
                <div class="search">
                    <form action="search.php" method="post">
                        <input type="text" class="searchTerm" placeholder="دنبال چی میگردی؟" name="search">
                        <button type="submit" class="searchButton" name="search_btn">
                            جستجو
                        </button>

                    </form>
                </div>
            </li>
        </ul>
    </nav>
</header>
