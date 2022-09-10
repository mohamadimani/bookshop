-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 07, 2022 at 04:58 PM
-- Server version: 10.4.8-MariaDB
-- PHP Version: 7.3.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `book_shop`
--

-- --------------------------------------------------------

--
-- Table structure for table `basket`
--

CREATE TABLE `basket` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `product_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `pro_count` int(10) UNSIGNED NOT NULL DEFAULT 1,
  `status` enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
  `insert_date` varchar(20) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `pay_status` enum('PAID','UNPAID') DEFAULT 'UNPAID'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `basket`
--

INSERT INTO `basket` (`id`, `user_id`, `product_id`, `pro_count`, `status`, `insert_date`, `address`, `pay_status`) VALUES
(22, 18, 29, 1, 'ACTIVE', '1622320569', NULL, 'UNPAID'),
(23, 406, 29, 3, 'ACTIVE', '1623602129', NULL, 'UNPAID'),
(24, 406, 27, 1, 'ACTIVE', '1623602156', NULL, 'UNPAID'),
(25, 406, 28, 1, 'ACTIVE', '1627416502', NULL, 'UNPAID'),
(26, 0, 28, 2, 'ACTIVE', '1641548101', NULL, 'UNPAID');

-- --------------------------------------------------------

--
-- Table structure for table `baskets`
--

CREATE TABLE `baskets` (
  `id` int(10) UNSIGNED NOT NULL,
  `customer_id` int(10) UNSIGNED NOT NULL,
  `amount` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(10) UNSIGNED NOT NULL,
  `post_id` int(10) UNSIGNED DEFAULT NULL,
  `comment` varchar(255) DEFAULT NULL,
  `name` varchar(40) DEFAULT NULL,
  `status` enum('ACTIVE','INACTIVE') DEFAULT 'ACTIVE',
  `replay` varchar(255) DEFAULT NULL,
  `insert_date` varchar(20) DEFAULT NULL,
  `mobile` varchar(12) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(20) NOT NULL,
  `credit` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `name`, `credit`) VALUES
(1, 'امجدی', 100000);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(10) UNSIGNED NOT NULL,
  `product_name` varchar(100) DEFAULT NULL,
  `category_id` int(10) UNSIGNED DEFAULT 0,
  `price` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `introduction` text DEFAULT NULL,
  `tags` varchar(255) DEFAULT NULL,
  `product_img` varchar(100) DEFAULT NULL,
  `status` enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
  `insert_date` varchar(20) DEFAULT NULL,
  `waranty` varchar(100) DEFAULT NULL,
  `discount` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `brand` varchar(100) DEFAULT NULL,
  `seller` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `product_name`, `category_id`, `price`, `introduction`, `tags`, `product_img`, `status`, `insert_date`, `waranty`, `discount`, `brand`, `seller`) VALUES
(26, 'تفکر نیچه', 8, 10000, 'دیوار این محصول آخرین گفتگو، نقد و متن‌های ماندگار را در اینجا دنبال کنید\r\nویژگی‌های محصول:\r\n\r\nکد کالا:\r\n\r\n45113\r\n\r\nشابک:\r\n\r\n9789647675727\r\n\r\nطول:\r\n\r\n21\r\n\r\nعرض:\r\n\r\n14.5\r\n\r\nارتفاع:\r\n\r\n1.3\r\n\r\nوزن:\r\n\r\n255\r\n\r\nنویسنده:\r\n\r\nنوشین شاهنده\r\n\r\nانتشارات:\r\n\r\nروشنگران و مطالعات زنان\r\n\r\nموضوع:\r\n\r\nفلسفه\r\n\r\nزبان:\r\n\r\nفارسي\r\n\r\nجلد:\r\n\r\nنرم\r\n\r\nقطع:\r\n\r\nرقعي\r\n\r\nتعداد صفحه:\r\n\r\n224', 'ندارد', '1622319260.jpg', 'ACTIVE', '1622319260', 'ندارد', 120000, 'ندارد', 'مدیر'),
(27, 'خلاصه کتاب «دانسته هایت را به کار بگیر»', 9, 10000, 'خلاصه کتاب «دانسته هایت را به کار بگیر»\r\nنویسنده: کن بلانچارد\r\nمترجم: سعید محمدی\r\nخلاصه شده توسط محسن سیف', 'کتاب', '1622319334.jpg', 'ACTIVE', '1622319334', 'ندارد', 120000, 'ندارد', 'مدیر'),
(28, 'کتاب «فراتر از قهرمانی»', 10, 10000, 'این کتاب در قالب داستان یک مسابقه ورزشی، به زبانی بسیار ساده از فراز و نشیب های رسیدن به موفقیت سخن می گوید و دارای نکات و تجربیات کلیدی ارزشمندی است که برای رسیدن به هر هدفی، مشترک و کاربردی است. یکی از ویژگی های کتاب این است که موانع و راه غلبه بر آنها را با توجه به شرایط کشورمان بیان کرده است و از این نظر مطالعه این کتاب بر کتابهای خارجی ارجحیت دارد.\r\nبا مطالعه این کتاب ضمن اینکه با داستان پیش می روید، در فراز و نشیب‌هایی که برای نویسنده پیش می آید، 42 درس آموزنده را یاد می گیرید که این درسها برای هر کسی با هر هدفی مشترک است؛ به همین دلیل در هر قسمت، سوالاتی مطرح می شود که شما با فکر کردن به آنها، خودتان را برای رسیدن به رویایتان، آماده می کنید.\r\nخواندن این کتاب برای تمام افراد زیرکی که می خواهند با استفاده از تجربیات افراد مجرب، در کوتاهترین زمان و با کمترین هزینه، گامی موثر در جهت موفقیت خود بردارند، یک پیشنهاد عالی است.\r\n \r\nعنوان: 42 گام شگفت انگیز برای کسانی که رویایی در سر دارند\r\nموضوع: موفقیت، انگیزشی، سرسختی، پشتکار،مسابقه ورزشی\r\nنویسنده: محسن سیف\r\nانتشارات: نوآوران سینا\r\nسرشناسه: سیف، محسن، 1365-\r\nشابک: 9-96-8534-600-978\r\nشماره کتابشناسی ملی: 5176035\r\nرده بندی دیویی: 1/158\r\nتعداد صفحات: 96\r\nنوبت چاپ: اول- بهار 97\r\nچاپ: شریف', 'کتاب', '1622319406.jpg', 'ACTIVE', '1622319405', 'ندارد', 120000, 'ندارد', 'مدیر'),
(29, 'دن کیشوت ایرانی', 9, 1000000, 'در گذر زمان، رمان «دایی جان ناپلئون» به فهرست «خواندنی‌ترین رمان‌های ایرانی» راه یافت. اما در ابتدا رمان مورد اقبال نبود. پزشکزاد نه از گروه ملتزمان ادبی بود و نه جزء آوانگاردها به شمار می‌رفت. جریان مسلط نقدِ زمانه نیز چشم بر کار او بست.حتی وقتی به مدد سریال موفق ناصر تقوایی شهره خاص وعام شد، برای نویسنده خود جایی در جمع نویسندگان جا سنگین دست‌وپا نکرد. زیرا این رمان، مثلاً مانند سووشونِ سیمین دانشور، در زمره رمان‌های ملتزم به گفتمان پُر طرفدارِ غرب‌زدگی، نبود. این یادداشت از حسن میرعابدینی مولف کتاب «صدسال داستان‌نویسی ایران» در مجله اندیشه پویا شماره ۴۳. خرداد و تیر ۱۳۹۶ چاپ شده است و ما در وینش آن را بازنشر می‌کنیم.', 'کتاب', '1622319810.jpg', 'ACTIVE', '1622319810', 'ندارد', 1200000, 'ندارد', 'مدیر');

-- --------------------------------------------------------

--
-- Table structure for table `product_category`
--

CREATE TABLE `product_category` (
  `id` int(10) UNSIGNED NOT NULL,
  `cat_name` varchar(30) DEFAULT NULL,
  `parent` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `status` enum('ACTIVE','INACTIVE') DEFAULT 'ACTIVE'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `product_category`
--

INSERT INTO `product_category` (`id`, `cat_name`, `parent`, `status`) VALUES
(8, 'رمان', 0, 'ACTIVE'),
(9, 'علمی', 0, 'ACTIVE'),
(10, 'تاریخی', 0, 'ACTIVE'),
(11, 'کتاب رمان', 8, 'ACTIVE'),
(12, 'کتاب علمی', 9, 'ACTIVE'),
(13, 'کتاب تاریخی', 10, 'ACTIVE');

-- --------------------------------------------------------

--
-- Table structure for table `slider`
--

CREATE TABLE `slider` (
  `id` int(10) UNSIGNED NOT NULL,
  `img_name` varchar(50) DEFAULT NULL,
  `upload_date` varchar(20) DEFAULT NULL,
  `first_img` enum('ACTIVE','INACTIVE') DEFAULT NULL,
  `status` enum('ACTIVE','INACTIVE') DEFAULT 'ACTIVE'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `slider`
--

INSERT INTO `slider` (`id`, `img_name`, `upload_date`, `first_img`, `status`) VALUES
(12, '1622319454.jpg', NULL, NULL, 'ACTIVE'),
(13, '1622319464.jpg', NULL, NULL, 'ACTIVE');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(30) DEFAULT NULL,
  `family` varchar(30) DEFAULT NULL,
  `sex` enum('MALE','FMALE') DEFAULT NULL,
  `mobile` varchar(14) DEFAULT NULL,
  `birthdate` varchar(30) DEFAULT NULL,
  `username` varchar(30) DEFAULT NULL,
  `password` varchar(200) DEFAULT NULL,
  `last_login` varchar(30) DEFAULT NULL,
  `status` enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `family`, `sex`, `mobile`, `birthdate`, `username`, `password`, `last_login`, `status`) VALUES
(1, 'امجدی', 'امجدی', 'MALE', '09191930406', '1370/09/25', 'admin', '$2y$12$NRWrWgbrZsGAliZKdqyymOfjF29y1FGIZkP6wGK.GYFX90XoPzinO', NULL, 'ACTIVE');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(30) DEFAULT NULL,
  `username` varchar(30) DEFAULT NULL,
  `family` varchar(30) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `email` varchar(40) DEFAULT NULL,
  `mobile` varchar(13) DEFAULT NULL,
  `status` enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `family`, `password`, `email`, `mobile`, `status`) VALUES
(19, 'تست', '09123456789', 'تستس', '$2y$12$TkPVfwBXs1w74p5g.vhnXObWN4MTvCkQ2eESxDikaLdwJCjmGF/2q', 'test@test.com', NULL, 'ACTIVE');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `basket`
--
ALTER TABLE `basket`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `baskets`
--
ALTER TABLE `baskets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_category`
--
ALTER TABLE `product_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `slider`
--
ALTER TABLE `slider`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `basket`
--
ALTER TABLE `basket`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `baskets`
--
ALTER TABLE `baskets`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `product_category`
--
ALTER TABLE `product_category`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `slider`
--
ALTER TABLE `slider`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
