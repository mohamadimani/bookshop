<div class="rightbox shadow">
    <?php if (isset($_SESSION['admin'])) { ?>
        <li><a href=""
               class="btn btn-info shadow d-block"><?= $_SESSION['admin_info']['name'] . " " . $_SESSION['admin_info']['family'] ?></a>
        </li>
    <?php } ?>
    <p>دسته بندی</p>
    <li><a href="addcat.php" class="btn btn-dark text-light shadow d-block" style="color: #ffffff">افزودن دسته بندی</a>
    </li>
    <li><a href="listcat.php" class="btn btn-dark text-light shadow d-block" style="color: #ffffff">لیست دسته بندی</a>
    </li>
    <p>مدیریت اسلایدر</p>
    <li><a href="listslide.php" class="btn btn-dark text-light shadow d-block" style="color: #ffffff">لیست تصاویر</a>
    </li>
    <p>مدیریت کاربران</p>
    <li><a href="list_users.php" class="btn btn-dark text-light shadow d-block" style="color: #ffffff">لیست کاربران</a>
    </li>
    <p>مدیریت محصولات</p>
    <li><a href="add_product.php" class="btn btn-dark text-light shadow d-block" style="color: #ffffff">افزودن محصول</a></li>
    <li><a href="list_products.php" class="btn btn-dark text-light shadow d-block" style="color: #ffffff">لیست محصولات</a></li>
    <p>نظرات کاربران</p>
    <li><a href="list_comments.php" class="btn btn-dark text-light shadow d-block" style="color: #ffffff">لیست نظرات</a>
    </li>
    <!-- <li><a href="showadmininfo.php" class="btn btn-dark text-light shadow d-block" style="color: #ffffff">مدیریت</a> -->
    <!-- </li> -->
    <li><a href="admin_logout.php" class="btn btn-danger shadow d-block">خروج از داشبورد</a></li>
    <li><a href="../" class="btn btn-danger shadow d-block">نمایش سایت</a></li>
</div>
