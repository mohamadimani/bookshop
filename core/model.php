<?php

class model
{

    protected $connect;
    private $dbname;
    private $username;
    private $password;

    function __construct($dbname_in = "", $username_in = "", $password_in = "")
    {

        $this->dbname = $dbname_in;
        $this->username = $username_in;
        $this->password = $password_in;
        $uft = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES Utf8"];
        $this->connect = new PDO("mysql:host=localhost;dbname=" . $this->dbname, $this->username, $this->password, $uft);

    }

    //    model
    function Do_Query($query = "", $param = [])
    {
        $result = $this->connect->prepare($query);
        foreach ($param as $key => $row) {
            $result->bindValue($key + 1, $row);
        }
        return $result->execute();


    }

    function Do_Select($query = "", $param = [], $fetch = "")
    {
        $result = $this->connect->prepare($query);
        foreach ($param as $key => $row) {
            $result->bindValue($key + 1, $row);
        }
        $result->execute();
        if (empty($fetch)) {
            return $res = $result->fetchAll(2);
        } else {
            return $res = $result->fetch(2);
        }
    }

    function filter($data)
    {
        return trim(htmlspecialchars(stripcslashes($data)));
    }


}

class functions extends model
{

//    admin

    function check_login()
    {
        if (isset($_SESSION['user']) and !empty(trim($_SESSION['user']))) {
            header("location:index.php");
        } else if (isset($_COOKIE["um0406"]) and isset($_COOKIE["pm0406"])) {
            $username = $this->filter(base64_decode($_COOKIE["um0406"]));
            $password = $this->filter(base64_decode($_COOKIE["pm0406"]));

            $result = $this->Do_Select("select id , password from users where username=?  ", [$username], 1);
            if ($result) {
                if ($this->password_verify($password, $result['password'])) {
                    $_SESSION['user'] = $result["id"];
                    header("location:index.php");
                }
            }
        } else {
            $_SESSION['user'] = 406;
        }
    }

    function get_login($info = [])
    {
        $username = $this->filter($info["username"]);
        $password = $this->filter($info["password"]);

        $result = $this->Do_Select("select id , password from users where username=?  ", [$username], 1);
        if ($result) {
            if ($this->password_verify($password, $result['password'])) {

                if (isset($info['rememberme']) and !empty($info['rememberme'])) {
                    $rememberme = $this->filter($info["rememberme"]);
                    setcookie("um0406", base64_encode($username), time() + (7 * 86400));
                    setcookie("pm0406", base64_encode($password), time() + (7 * 86400));
                } else {
                    setcookie("um0406", "", time() + 1);
                    setcookie("pm0406", "", time() + 1);
                }

                $_SESSION['user'] = $result["id"];
                header("location:index.php");
            } else {
                $_SESSION["error"][0] = "danger";
                $_SESSION["error"][1] = "نام کاربری یا رمز عبور اشتباه است!";
            }
        } else {
            $_SESSION["error"][0] = "danger";
            $_SESSION["error"][1] = "هیچ کاربری یافت نشد!";
        }
    }

    function get_users($id = "")
    {
        $id = $this->filter($id);
        if (empty($id)) {
            $result = $this->Do_Select(" select * from users order by id desc ");
            if (is_array($result)) {
                return $result;
            } else {
                return [];
            }
        } else {
            $result = $this->Do_Select(" select * from users where id=? ", [$id], 1);
            if (is_array($result)) {
                return $result;
            } else {
                return [];
            }
        }
    }

    function delete_user($id = "")
    {
        $id = $this->filter($id);
        $result = $this->Do_Query("delete from users where id=?", [$id]);
        if ($result) {
            $_SESSION['error'][0] = "success";
            $_SESSION['error'][1] = "حدف شد!";
        } else {
            $_SESSION['error'][0] = "danger";
            $_SESSION['error'][1] = "  مشکل در حذف!";
        }
        header("location:list_users.php");
    }

    function add_user($info = [])
    {
        $name = $this->filter($info['name']);
        $family = $this->filter($info['family']);
        $username = $this->filter($info['username']);
        $email = $this->filter($info['email']);
        $password = $this->filter($info['password']);

        if (!empty($name) and !empty($family) and !empty($email) and !empty($password) and !empty($username)) {
            $data = [$name, $family, $username, $this->password_hash($password), $email];
            $result = $this->Do_Query("insert into  users (`name` , family , username , password , email) values (?,?,?,?,?)", $data);
            if ($result) {
                $_SESSION['error'][0] = "success";
                $_SESSION['error'][1] = "با موفقیت ثبت شد!";
            } else {
                $_SESSION['error'][0] = "danger";
                $_SESSION['error'][1] = "  مشکل در ثبت اطلاعات!";
            }
        } else {
            $_SESSION['error'][0] = "danger";
            $_SESSION['error'][1] = " اطلاعات را تکمیل کنید!";
        }
        header("location:list_users.php");
    }

    function add_product($info = [], $file = [])
    {
        $category = $this->filter($info['category']);
        $product_name = $this->filter($info['product_name']);
        $seller = $this->filter($info['seller']);
        $waranty = $this->filter($info['waranty']);
        $brand = $this->filter($info['brand']);
        $price = $this->filter($info['price']);
        $discount = $this->filter($info['discount']);
        $introduction = $this->filter($info['introduction']);
        $tags = $this->filter($info['tags']);
        $insert_date = time();

        if (!empty($category) and !empty($product_name) and !empty($seller) and !empty($waranty) and !empty($price) and
            !empty($brand) and !empty($discount) and !empty($introduction) and !empty($tags)) {
            $data = [$product_name, $seller, $price, $category, $introduction, $tags, $discount, $brand, $waranty, $insert_date];
            $result = $this->Do_Query("insert into  products (`product_name` , seller , price ,category_id, introduction,tags,discount,brand,waranty,insert_date) values (?,?,?,?,?,?,?,?,?,?)", $data);
            $product_id = $this->connect->lastInsertId();
            if ($result) {
                $_SESSION['error'][0] = "success";
                $_SESSION['error'][1] = "با موفقیت ثبت شد!";
                $url = "../files/image/products/" . $product_id . '/';
                if (!is_dir($url)) {
                    mkdir($url);
                }
                $query = "update  products set product_img =? where id=? ";
                $result_up = $this->upload_image($file['product_img'], 2, $url, $query, $product_id);
                header("location:list_products.php");
            } else {
                $_SESSION['error'][0] = "danger";
                $_SESSION['error'][1] = "  مشکل در ثبت اطلاعات!";
                header("location:list_products.php");
            }
        } else {
            $_SESSION['error'][0] = "danger";
            $_SESSION['error'][1] = " اطلاعات را تکمیل کنید!";
            header("location:list_products.php");
        }
    }

    function edit_product($info = [], $file = [], $pr_id = '')
    {
        $pr_id = $this->filter($pr_id);
        $category = $this->filter($info['category']);
        $product_name = $this->filter($info['product_name']);
        $seller = $this->filter($info['seller']);
        $waranty = $this->filter($info['waranty']);
        $brand = $this->filter($info['brand']);
        $price = $this->filter($info['price']);
        $discount = $this->filter($info['discount']);
        $introduction = $this->filter($info['introduction']);
        $tags = $this->filter($info['tags']);

        if (!empty($category) and !empty($product_name) and !empty($seller) and !empty($waranty) and !empty($price) and
            !empty($brand) and !empty($discount) and !empty($introduction) and !empty($tags)) {
            $data = [$product_name, $seller, $price, $category, $introduction, $tags, $discount, $brand, $waranty, $pr_id];
            $result = $this->Do_Query("update    products set `product_name`=? , seller =?, price =?,category_id=?, introduction=?,tags=?,discount=?,brand=?,waranty=? where id=?", $data);
            if ($result) {
                $_SESSION['error'][0] = "success";
                $_SESSION['error'][1] = "با موفقیت ثبت شد!";
                $url = "../files/image/products/" . $pr_id . '/';
                if (!is_dir($url)) {
                    mkdir($url);
                }
                if (!empty($file['product_img'])) {
                    $query = "update  products set product_img =? where id=? ";
                    $result_up = $this->upload_image($file['product_img'], 2, $url, $query, $pr_id);
                }
                header("location:list_products.php");
            } else {
                $_SESSION['error'][0] = "danger";
                $_SESSION['error'][1] = "  مشکل در ثبت اطلاعات!";
                header("location:list_products.php");
            }
        } else {
            $_SESSION['error'][0] = "danger";
            $_SESSION['error'][1] = " اطلاعات را تکمیل کنید!";
            header("location:list_products.php");
        }
    }

    function edit_user($info = [], $userid = '')
    {
        $userid = $this->filter($userid);

        $name = $this->filter($info['name']);
        $family = $this->filter($info['family']);
        $username = $this->filter($info['username']);
        $email = $this->filter($info['email']);
        $password = $this->filter($info['password']);

        if (!empty($name) and !empty($family) and !empty($email) and !empty($password) and !empty($username)) {
            $data = [$name, $family, $username, $this->password_hash($password), $email, $userid];
            $result = $this->Do_Query("update users set `name`=? , family=? , username =?, password =?, email=?  where id=?", $data);
            if ($result) {
                $_SESSION['error'][0] = "success";
                $_SESSION['error'][1] = "با موفقیت ثبت شد!";
            } else {
                $_SESSION['error'][0] = "danger";
                $_SESSION['error'][1] = "  مشکل در ثبت اطلاعات!";
            }
        } else {
            $_SESSION['error'][0] = "danger";
            $_SESSION['error'][1] = " اطلاعات را تکمیل کنید!";
        }
        header("location:list_users.php");
    }

    function get_slider_images($id = "")
    {
        $id = $this->filter($id);
        if (empty($id)) {
            $result = $this->Do_Select(" select * from slider order by id desc ");
            if (is_array($result)) {
                return $result;
            } else {
                return [];
            }
        } else {
            $result = $this->Do_Select(" select * from slider where id=? order by id desc ", [$id], 1);
            if (is_array($result)) {
                return $result;
            } else {
                return [];
            }
        }
    }

    function delete_slider($id = "")
    {
        $img = $this->get_slider_images($id);
        $id = $this->filter($id);
        $result = $this->Do_Query("delete from slider where id=?", [$id]);
        if ($result) {
            $url = "../files/image/slider/" . $img['img_name'];
            unlink($url);
            $_SESSION['error'][0] = "success";
            $_SESSION['error'][1] = "حدف شد!";
        } else {
            $_SESSION['error'][0] = "danger";
            $_SESSION['error'][1] = "  مشکل در حذف!";
        }

        header("location:listslide.php");
    }

    function delete_product($id = "")
    {
        $id = $this->filter($id);
        $product = $this->get_products($id);
        $result = $this->Do_Query("delete from products where id=?", [$id]);
        if ($result) {
            $url = "../files/image/products/" . $product['id'] . '/' . $product['product_img'];
            unlink($url);
            rmdir("../files/image/products/" . $product['id']);
            $_SESSION['error'][0] = "success";
            $_SESSION['error'][1] = "حدف شد!";
        } else {
            $_SESSION['error'][0] = "danger";
            $_SESSION['error'][1] = "  مشکل در حذف!";
        }
        header("location:list_products.php");
    }

    function upload_image($info = [], $size = '2', $url = '', $query = "", $query_param = '')
    {
        $name = $this->filter($info['name']);
        $size = $this->filter($info['size']);
        $type = $this->filter($info['type']);
        $error = $this->filter($info['error']);
        $temp = $info['tmp_name'];

        if ($error == 0) {
            $up_size = (($size * 8) * 1024) * 1024; //convert to MB
            if ($size > $up_size) { //2MB
                $_SESSION['error'][0] = "danger";
                $_SESSION['error'][1] = " حجم تصویر بیش از 2 مگابایت است!";
                return false;
            }
            $path = ['image/jpeg', 'image/png', 'image/jpg'];
            if (in_array($type, $path)) {
                $exe = end(explode('.', $name));
                $img_new_name = time();
                $img_url = $url . $img_new_name . '.' . $exe;
                move_uploaded_file($temp, $img_url);
                if (!empty($query_param)) {
                    $result = $this->Do_Query($query, [$img_new_name . '.' . $exe, $query_param]);
                } else {
                    $result = $this->Do_Query($query, [$img_new_name . '.' . $exe]);
                }
                if ($result) {
                    $_SESSION['error'][0] = "success";
                    $_SESSION['error'][1] = "با موفقیت ارسال شد!";
                    return true;
                } else {
                    $_SESSION['error'][0] = "danger";
                    $_SESSION['error'][1] = "  مشکل در ارسال تصویر!";
                    return false;
                }
            } else {
                $_SESSION['error'][0] = "danger";
                $_SESSION['error'][1] = " فرمت تصویر نامعتبر است!";
                return false;
            }
        } else {
            $_SESSION['error'][0] = "danger";
            $_SESSION['error'][1] = "  مشکل در ارسال تصویر!";
            return false;
        }
    }

    function upload_slider($img = [])
    {
        $url = "../files/image/slider/";
        $query = "insert into  slider set img_name =? ";
        $result_up = $this->upload_image($img, 2, $url, $query);

        header("location:listslide.php");
    }

    function get_product_category_option($id = "")
    {
        $id = $this->filter($id);
        if (empty($id)) {
            $result = $this->Do_Select("select * from product_category where parent=0");
            if ($result) {
                $options = "";
                foreach ($result as $row) {
                    $options = $options . " <option value=" . $row['id'] . ">" . $row['cat_name'] . "</option>";
                }
                print_r($options);
            } else {
                return false;
            }
        } else {
            $result = $this->Do_Select("select * from product_category where id=?", [$id], 1);
            if ($result) {
                print_r(" <option value=" . $result['id'] . ">" . $result['cat_name'] . "</option>");
            } else {
                return false;
            }
        }
    }

    function get_product_category($id = "")
    {
        $id = $this->filter($id);
        if (empty($id)) {
            $result = $this->Do_Select("select * from product_category where parent=0");
            if ($result) {
                return $result;
            } else {
                return false;
            }
        } else {
            $result = $this->Do_Select("select * from product_category where id=?", [$id], 1);
            if ($result) {
                return $result;
            } else {
                return false;
            }
        }
    }

    function delete_product_category($id = "")
    {
        $id = $this->filter($id);
        if (!empty($id)) {
            $result = $this->Do_Query("delete  from product_category where id=?", [$id]);
            if ($result) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    function get_product_category_childs($id = "")
    {
        $id = $this->filter($id);
        if (!empty($id)) {
            $result = $this->Do_Select("select * from product_category where parent=?", [$id]);
            if ($result) {
                return $result;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    function cat_status($status = "", $id = "")
    {
        $id = $this->filter($id);
        if ($status == 'active') {
//            $status = "ACTIVE";
            $this->Do_Query("update product_category set status='ACTIVE' where id=?", [$id]);
        } else if ($status == "inactive") {
//            $status = "INACTIVE";
            $this->Do_Query("update product_category set status='INACTIVE' where id=?", [$id]);
        }

    }

    function get_products($id = '', $page = 0)
    {
        $page = $this->filter($page);
        $start_page = ($page - 1) * 12;
        $id = $this->filter($id);
        if (empty($id)) {
            $result = $this->Do_Select("select products.*,product_category.cat_name from products left join  product_category on products.category_id=product_category.id order by products.id desc  limit $start_page ,12 ");
            return $result;
        } else {
            $result = $this->Do_Select("select * from products where id=?", [$id], 1);
            return $result;
        }
    }

    function get_comments($cat_id = '')
    {
        $cat_id = $this->filter($cat_id);
        if (!empty($cat_id)) {
            $result = $this->Do_Select("select comments.* , products.product_name from comments left join  products  on comments.post_id=products.id  where   comments.id=? order by comments.id desc   ", [$cat_id], 1);
            return $result;
        } else {
            $result = $this->Do_Select("select comments.* , products.product_name from comments left join  products  on comments.post_id=products.id     order by id desc   ");
            return $result;
        }
    }

    function delete_comments($id = "")
    {
        $id = $this->filter($id);
        $result = $this->Do_Query("delete from comments where id=?", [$id]);
        if ($result) {
            $_SESSION['error'][0] = "success";
            $_SESSION['error'][1] = "حدف شد!";
        } else {
            $_SESSION['error'][0] = "danger";
            $_SESSION['error'][1] = "  مشکل در حذف!";
        }
        header("location:list_comments.php");
    }

    function edit_comment($info = [], $comment_id = '')
    {
        $comment_id = $this->filter($comment_id);

        $name = $this->filter($info['name']);
        $mobile = $this->filter($info['mobile']);
        $comment = $this->filter($info['comment']);

        if (!empty($name) and !empty($mobile) and !empty($comment)) {
            $data = [$name, $mobile, $comment, $comment_id];
            $result = $this->Do_Query("update comments set `name`=? , mobile=? , comment =?   where id=? ", $data);
            if ($result) {
                $_SESSION['error'][0] = "success";
                $_SESSION['error'][1] = "با موفقیت ثبت شد!";
            } else {
                $_SESSION['error'][0] = "danger";
                $_SESSION['error'][1] = "  مشکل در ثبت اطلاعات!";
            }
        } else {
            $_SESSION['error'][0] = "danger";
            $_SESSION['error'][1] = " فیلد را تکمیل کنید!";
        }
        header("location:list_comments.php");
    }

    function add_replay($replay = "", $comment_id = '')
    {
        $comment_id = $this->filter($comment_id);

        $replay = $this->filter($replay);

        if (!empty($replay) and !empty($comment_id)) {
            $data = [$replay, $comment_id];
            $result = $this->Do_Query("update comments set `replay`=?   where id=? ", $data);
            if ($result) {
                $_SESSION['error'][0] = "success";
                $_SESSION['error'][1] = "با موفقیت ثبت شد!";
            } else {
                $_SESSION['error'][0] = "danger";
                $_SESSION['error'][1] = "  مشکل در ثبت اطلاعات!";
            }
        } else {
            $_SESSION['error'][0] = "danger";
            $_SESSION['error'][1] = " فیلد را تکمیل کنید!";
        }
        header("location:list_comments.php");
    }

//    end admin


//    web site
    function get_slider_web()
    {
        $result = $this->Do_Select(" select * from slider  where status='ACTIVE' order by id desc ");
        if (is_array($result)) {
            return $result;
        } else {
            return [];
        }
    }

    function password_hash($password)
    {
        return password_hash($password, PASSWORD_BCRYPT, array('cost' => 12));
    }

    function get_meno($id = '')
    {
        $id = $this->filter($id);
        if (empty($id)) {
            $result = $this->Do_Select("select * from product_category where parent=0 and status='ACTIVE'");
            if ($result) {
                return $result;
            } else {
                return false;
            }
        } else {
            $result = $this->Do_Select("select * from product_category where parent=? and status='ACTIVE'", [$id]);
            if ($result) {
                return $result;
            } else {
                return false;
            }
        }
    }

    function password_verify($password = '', $password_hash = '')
    {
        if (password_verify($password, $password_hash)) {
            return true;
        } else {
            return false;
        }
    }

    function get_products_web($id = '', $page = 0)
    {
        $id = $this->filter($id);
//        $page = $this->filter($page);
        $start_page = ($page - 1) * 12;
        if (empty($id)) {
            $result = $this->Do_Select("select products.*,product_category.cat_name from products left join  product_category on products.category_id=product_category.id where products.status='ACTIVE' order by products.id desc limit $start_page ,12 ");
            return $result;
        } else {
            $result = $this->Do_Select("select products.*,product_category.cat_name from products left join  product_category on products.category_id=product_category.id where products.id=?", [$id], 1);
            return $result;
        }
    }

    function get_products_search($search = "")
    {
        $search = $this->filter($search);
        $result = $this->Do_Select("select products.*,product_category.cat_name from products left join  product_category on products.category_id=product_category.id where    products.product_name like ? ", [$search]);
        return $result;
    }

    function get_products_count()
    {
        $pro_count = $this->Do_Select("select count(id) as pro_count from products where status='ACTIVE'", [], 1);
        return $pro_count['pro_count'];
    }

    function get_pro_cat_web($cat_id = '')
    {
        $id = $this->filter($cat_id);
        $result = $this->Do_Select("select products.*,product_category.cat_name from products left join  product_category on products.category_id=product_category.id where product_category.id=? order by products.id desc   ", [$id]);
        return $result;

    }

    function get_products_comments($cat_id = '')
    {
        $id = $this->filter($cat_id);
        $result = $this->Do_Select("select * from comments   where status='ACTIVE'  and post_id=? order by id desc   ", [$id]);
        return $result;

    }

    function add_comments($info = [], $pro_id = '')
    {
        $pro_id = $this->filter($pro_id);
        $name = $this->filter($info['name']);
        $mobile = $this->filter($info['mobile']);
        $comments = $this->filter($info['comment']);

        if (!empty($name) and !empty($mobile) and !empty($comments)) {
            $data = [$name, $mobile, $comments, time(), $pro_id];
            $result = $this->Do_Query("insert into  comments (`name` , mobile , comment , insert_date ,post_id) values (?,?,?,?,?)", $data);
            if ($result) {
                $_SESSION['error'][0] = "success";
                $_SESSION['error'][1] = "با موفقیت ثبت شد!";
            } else {
                $_SESSION['error'][0] = "danger";
                $_SESSION['error'][1] = "  مشکل در ثبت اطلاعات!";
            }
        } else {
            $_SESSION['error'][0] = "danger";
            $_SESSION['error'][1] = " اطلاعات را تکمیل کنید!";
        }
    }

    function add_address($address = '')
    {
        $address = $this->filter($address);
        $id = $this->filter($_SESSION['user']);

        if (!empty($address) and !empty($id)) {
            $data = [$address, 'PAID', $id];
            $result = $this->Do_Query("update  basket set address=?  , pay_status=? where user_id=?", $data);
            if ($result) {
                $_SESSION['error'][0] = "success";
                $_SESSION['error'][1] = "با موفقیت پرداخت شد!";
                header('location:panel.php');
            } else {
                $_SESSION['error'][0] = "danger";
                $_SESSION['error'][1] = "  مشکل در ثبت اطلاعات!";
            }
        } else {
            $_SESSION['error'][0] = "danger";
            $_SESSION['error'][1] = " اطلاعات را تکمیل کنید!";
        }
    }

    function delete_basket($id = "")
    {
        $id = $this->filter($id);
        $result = $this->Do_Query("delete from basket where id=?", [$id]);
        if ($result) {
            $_SESSION['error'][0] = "success";
            $_SESSION['error'][1] = "حدف شد!";
        } else {
            $_SESSION['error'][0] = "danger";
            $_SESSION['error'][1] = "  مشکل در حذف!";
        }
    }

    function add_basket($product_id = '')
    {
        if (isset($_SESSION['user'])) {
            $user_id = $this->filter($_SESSION['user']);
            $product_id = $this->filter($product_id);

            if (!empty($user_id) and !empty($product_id)) {
                $data = [$user_id, $product_id];
                $is_pro = $this->Do_Select("select id from basket where user_id=? and product_id=?", $data, 1);
                if (!empty($is_pro['id']) and $is_pro['id'] > 0) {
                    $result = $this->Do_Query("update basket set pro_count=pro_count+1  where user_id=? and product_id=? ", $data);
                } else {
                    $data = [$user_id, $product_id, time()];
                    $result = $this->Do_Query("insert into basket  (user_id,product_id,insert_date)values (?,?,?)", $data);
                    if ($result) {
                        $_SESSION['error'][0] = "success";
                        $_SESSION['error'][1] = "با موفقیت ثبت شد!";
//                    header('location:../basket.php');
                    } else {
                        $_SESSION['error'][0] = "danger";
                        $_SESSION['error'][1] = "  مشکل در ثبت اطلاعات!";
                    }
                }
            } else {
                $_SESSION['error'][0] = "danger";
                $_SESSION['error'][1] = " فیلد را تکمیل کنید!";
            }
        } else {
            $_SESSION['error'][0] = 0;
            $user_id = 406;
            $_SESSION['user'] = 406;
            $product_id = $this->filter($product_id);

            if (!empty($user_id) and !empty($product_id)) {
                $data = [$user_id, $product_id];
                $is_pro = $this->Do_Select("select id from basket where user_id=? and product_id=?", $data, 1);
                if (!empty($is_pro['id']) and $is_pro['id'] > 0) {
                    $result = $this->Do_Query("update basket set pro_count=pro_count+1  where user_id=? and product_id=? ", $data);
                } else {
                    $data = [$user_id, $product_id, time()];
                    $result = $this->Do_Query("insert into basket  (user_id,product_id,insert_date)values (?,?,?)", $data);
                    if ($result) {
                        $_SESSION['error'][0] = "success";
                        $_SESSION['error'][1] = "با موفقیت ثبت شد!";
//                    header('location:../basket.php');
                    } else {
                        $_SESSION['error'][0] = "danger";
                        $_SESSION['error'][1] = "  مشکل در ثبت اطلاعات!";
                    }
                }
            } else {
                $_SESSION['error'][0] = "danger";
                $_SESSION['error'][1] = " فیلد را تکمیل کنید!";
            }
        }
    }

    function get_basket()
    {

        if (!empty($_SESSION['user']) and isset($_SESSION['user'])) {
            $user_id = $this->filter($_SESSION['user']);
            $result = $this->Do_Select("select p.product_name  , p.price, u.name   ,b.* from basket b
                                               left join products p on p.id=b.product_id  
                                               left join  users u on u.id=b.user_id where b.pay_status='UNPAID' and b.user_id=? ", [$user_id]);
            return $result;
        } else {
//            header("location:login.php");
        }
    }
    //end web
}

$functions = new functions('book_shop', "root", "");