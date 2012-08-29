<?php  
global $wpdb;
define('ENMASSE_CATEGORY',$wpdb->prefix . 'enmasse_category');
define('ENMASSE_LOCATION',$wpdb->prefix . 'enmasse_location');
define('ENMASSE_DEAL',$wpdb->prefix . 'enmasse_deal');
define('ENMASSE_DEAL_CATEGORY',$wpdb->prefix . 'enmasse_deal_category');
define('ENMASSE_DEAL_LOCATION',$wpdb->prefix . 'enmasse_deal_location');
define('ENMASSE_MERCHANT_BRANCH',$wpdb->prefix.'enmasse_merchant_branch');
define('ENMASSE_SALES_PERSON',$wpdb->prefix.'enmasse_sales_person');
define('ENMASSE_BILL_TEMPLATE',$wpdb->prefix.'enmasse_bill_template');
define('ENMASSE_COMMENT',$wpdb->prefix.'enmasse_comment');
define('ENMASSE_COMMENT_SPAMMER',$wpdb->prefix.'enmasse_comment_spammer');
define('ENMASSE_COUPON_ELEMENT',$wpdb->prefix.'enmasse_coupon_element');
define('ENMASSE_EMAIL_TEMPLATE',$wpdb->prefix.'enmasse_email_template');
define('ENMASSE_ORDER',$wpdb->prefix.'enmasse_order');
define('ENMASSE_ORDER_ITEM',$wpdb->prefix.'enmasse_order_item');
define('ENMASSE_ORDER_INVITE',$wpdb->prefix.'enmasse_order_invite');
define('ENMASSE_PAY_GATEWAY',$wpdb->prefix.'enmasse_pay_gateway');
define('ENMASSE_SETTING',$wpdb->prefix.'enmasse_setting');
define('ENMASSE_TAX',$wpdb->prefix.'enmasse_tax');
define('ENMASSE_INVTY',$wpdb->prefix.'enmasse_invty');

function enmasse_page_id($slug = null) {
	$idObj = get_page_by_path($slug);
	$id = $idObj->ID;
	return $id;
}

function enmasse_installer() {
	global $wpdb;
	$enmasse_db_version = '1';
	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
	if($wpdb->get_var("SHOW TABLES LIKE '".ENMASSE_CATEGORY."'") != ENMASSE_CATEGORY)
	{
		$sql = "CREATE TABLE " . ENMASSE_CATEGORY . " (
		  `id` bigint(20) NOT NULL AUTO_INCREMENT,
		  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
		  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
		  `parent_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
		  `published` tinyint(1) NOT NULL,
		  `created_at` datetime NOT NULL,
		  `updated_at` datetime NOT NULL,
		  PRIMARY KEY (`id`),
		  UNIQUE KEY `name` (`name`)
		);";
		dbDelta($sql);
		add_option("enmasse_db_version", $enmasse_db_version);
	}
	if($wpdb->get_var("SHOW TABLES LIKE '".ENMASSE_LOCATION."'") != ENMASSE_LOCATION)
	{
		$sql = "CREATE TABLE " . ENMASSE_LOCATION . " (
		  `id` bigint(20) NOT NULL AUTO_INCREMENT,
		  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
		  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
		  `parent_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
		  `published` tinyint(1) NOT NULL,
		  `created_at` datetime NOT NULL,
		  `updated_at` datetime NOT NULL,
		  PRIMARY KEY (`id`),
		  UNIQUE KEY `name` (`name`)
  		);";
		dbDelta($sql);
	}	
	if($wpdb->get_var("SHOW TABLES LIKE '".ENMASSE_DEAL."'") != ENMASSE_DEAL)
	{
		$sql = "CREATE TABLE " . ENMASSE_DEAL . " (
		  `id` bigint(20) NOT NULL AUTO_INCREMENT,
		  `deal_code` varchar(12) COLLATE utf8_unicode_ci NOT NULL,
		  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
		  `slug_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
		  `short_desc` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
		  `highlight` text COLLATE utf8_unicode_ci NOT NULL,
		  `pic_dir` varchar(550) COLLATE utf8_unicode_ci NOT NULL,
		  `terms` text COLLATE utf8_unicode_ci NOT NULL,
		  `description` text COLLATE utf8_unicode_ci,
		  `origin_price` decimal(10,2) DEFAULT NULL,
		  `price` decimal(10,2) DEFAULT NULL,
		  `min_needed_qty` int(11) NOT NULL,
		  `max_buy_qty` int(11) NOT NULL,
		  `max_coupon_qty` int(11) NOT NULL DEFAULT '-1',
		  `max_qty` int(11) NOT NULL,
		  `cur_sold_qty` int(11) NOT NULL,
		  `start_at` datetime DEFAULT NULL,
		  `end_at` datetime DEFAULT NULL,
		  `merchant_id` bigint(20) DEFAULT NULL,
		  `sales_person_id` bigint(20) DEFAULT NULL,
		  `status` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'On Sales',
		  `published` tinyint(1) NOT NULL,
		  `position` int(11) NOT NULL,
		  `pay_by_point` tinyint(4) NOT NULL DEFAULT '0',
		  `created_at` datetime NOT NULL,
		  `updated_at` datetime NOT NULL,
		  `prepay_percent` tinyint(1) DEFAULT '100',
		  `commission_percent` tinyint(1) DEFAULT '100',
		  `auto_confirm` tinyint(1) DEFAULT '0',
		  PRIMARY KEY (`id`),
		  UNIQUE KEY `slug_name` (`slug_name`),
		  KEY `merchant_id_idx` (`merchant_id`),
		  KEY `deal_code` (`deal_code`)
  		);";
		dbDelta($sql);
	}
	if($wpdb->get_var("SHOW TABLES LIKE '".ENMASSE_DEAL_CATEGORY."'") != ENMASSE_DEAL_CATEGORY)
	{
		$sql = "CREATE TABLE " . ENMASSE_DEAL_CATEGORY . " (
		  `id` int(20) NOT NULL AUTO_INCREMENT,
		  `deal_id` int(20) NOT NULL,
		  `category_id` int(20) NOT NULL,
		  PRIMARY KEY (`id`)
  		);";
		dbDelta($sql);
	}
	if($wpdb->get_var("SHOW TABLES LIKE '".ENMASSE_DEAL_LOCATION."'") != ENMASSE_DEAL_LOCATION)
	{
		$sql = "CREATE TABLE " . ENMASSE_DEAL_LOCATION . " (
		  `id` int(20) NOT NULL AUTO_INCREMENT,
		  `deal_id` int(20) NOT NULL,
		  `location_id` int(20) NOT NULL,
		  PRIMARY KEY (`id`)
  		);";
		dbDelta($sql);
	}
	if($wpdb->get_var("SHOW TABLES LIKE '".ENMASSE_MERCHANT_BRANCH."'") != ENMASSE_MERCHANT_BRANCH)
	{
		$sql = "CREATE TABLE ".ENMASSE_MERCHANT_BRANCH . "(
		  `id` bigint(20) NOT NULL AUTO_INCREMENT,
		  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
		  `address` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
		  `user_id` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
		  `sales_person_id` bigint(20) NOT NULL,
		  `web_url` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
		  `logo_url` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
		  `location_id` int(11) NOT NULL,
		  `description` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
		  `google_map_width` float NOT NULL,
		  `google_map_height` float NOT NULL,
		  `google_map_zoom` tinyint(4) NOT NULL,
		  `branches` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
		  `published` tinyint(1) NOT NULL,
		  `created_at` datetime NOT NULL,
		  `updated_at` datetime NOT NULL,
		  PRIMARY KEY (`id`),
		  UNIQUE KEY `name` (`name`)
		);";
		dbDelta($sql);
	}
	if($wpdb->get_var("SHOW TABLES LIKE '".ENMASSE_SALES_PERSON."'") != ENMASSE_SALES_PERSON)
	{
		$sql = "CREATE TABLE " . ENMASSE_SALES_PERSON . "(
		  `id` bigint(20) NOT NULL AUTO_INCREMENT,
		  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
		  `user_id` bigint(20) NOT NULL ,
		  `address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
		  `phone` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
		  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
		  `published` tinyint(1) NOT NULL,
		  `created_at` datetime NOT NULL,
		  `updated_at` datetime NOT NULL,
		  PRIMARY KEY (`id`),
		  UNIQUE KEY `name` (`name`)
		);";
		dbDelta($sql);
	}
	if($wpdb->get_var("SHOW TABLES LIKE '".ENMASSE_COMMENT."'") != ENMASSE_COMMENT)
	{
		$sql = "CREATE TABLE " . ENMASSE_COMMENT . "(
		  `id` int(11) NOT NULL AUTO_INCREMENT,
		  `deal_id` int(11) NOT NULL,
		  `user_id` int(11) NOT NULL,
		  `comment` varchar(1000) NOT NULL,
		  `rating` tinyint(1) NOT NULL,
		  `created_at` datetime NOT NULL,
		  `status` tinyint(1) NOT NULL,
		  PRIMARY KEY (`id`)
		);";
		dbDelta($sql);
	}
	if($wpdb->get_var("SHOW TABLES LIKE '".ENMASSE_PAY_GATEWAY."'") != ENMASSE_PAY_GATEWAY)
	{
		$sql = "CREATE TABLE " . ENMASSE_PAY_GATEWAY . "(
		  `id` int(11) NOT NULL AUTO_INCREMENT,
		  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
		  `description` longtext COLLATE utf8_unicode_ci NOT NULL,
		  `class_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
		  `attributes` longtext COLLATE utf8_unicode_ci NOT NULL,
		  `attribute_config` longtext COLLATE utf8_unicode_ci NOT NULL,
		  `published` tinyint(1) NOT NULL,
		  `created_at` datetime NOT NULL,
		  `updated_at` datetime NOT NULL,
		  PRIMARY KEY (`id`),
		  UNIQUE KEY `name` (`name`),
		  UNIQUE KEY `class_name` (`class_name`)
		);";
		dbDelta($sql);
		$sql = "INSERT INTO `" . ENMASSE_PAY_GATEWAY . "` (`id`, `name`, `description`, `class_name`, `attributes`, `attribute_config`, `published`, `created_at`, `updated_at`) VALUES
(1, 'Cash', 'Dear customers,\r\n\r\nCash/Bank Transfer payment is only convenient for customers living in Singapore. For overseas payment, we would like to encourage users to pay through Credit/Debit card or PayPal option.\r\n\r\nFor payment through Cash/Bank Transfer, please kindly follow these steps:\r\n<ol>\r\n	<li>Go to your nearest ATM or online iBanking and transfer the payment to account: <strong>123-234456-7</strong></li>\r\n	<li>Print screen your transfer page if you are using iBanking, or get a receipt from the machine if you transfer through ATM</li>\r\n	<li>Email us the image of the receipt/print screen and kindly state the reference no.</li>\r\n	<li>We will mark your order as paid as soon when we receive your email.</li>\r\n	<li>Payment is to be done within 7 days from the date of purchase or else your order will be cancelled automatically.</li>\r\n</ol>\r\nThank you!', 'cash', '', '[]', 1, '2012-04-18 05:13:28', '2012-04-20 10:24:09');";
		dbDelta($sql);
	}
	if($wpdb->get_var("SHOW TABLES LIKE '".ENMASSE_ORDER."'") != ENMASSE_ORDER)
	{
		$sql = "CREATE TABLE " . ENMASSE_ORDER . "(
		  `id` bigint(20) NOT NULL AUTO_INCREMENT,
		  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
		  `buyer_id` bigint(20) DEFAULT NULL,
		  `referral_id` bigint(20) NOT NULL,
		  `paygate_id` bigint(20) DEFAULT NULL,
		  `_amount` decimal(10,2) DEFAULT '0.00',
		  `_paid` decimal(10,2) DEFAULT NULL,
		  `_refund` int(11) NOT NULL,
		  `session_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
		  `invoice_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
		  `status` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
		  `delivery` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
		  `created_at` datetime NOT NULL,
		  `updated_at` datetime NOT NULL,
		  PRIMARY KEY (`id`),
		  KEY `buyer_id_idx` (`buyer_id`),
		  KEY `paygate_id_idx` (`paygate_id`)
		);";
		dbDelta($sql);
	}
	if($wpdb->get_var("SHOW TABLES LIKE '".ENMASSE_ORDER_ITEM."'") != ENMASSE_ORDER_ITEM)
	{
		$sql = "CREATE TABLE " . ENMASSE_ORDER_ITEM . "(
		  `id` bigint(20) NOT NULL AUTO_INCREMENT,
		  `order_id` bigint(20) DEFAULT NULL,
		  `unit_id` bigint(20) DEFAULT NULL,
		  `unit_price` decimal(10,2) DEFAULT NULL,
		  `unit_qty` bigint(20) DEFAULT NULL,
		  `total_price` decimal(10,2) DEFAULT NULL,
		  `status` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
		  `created_at` datetime NOT NULL,
		  `updated_at` datetime NOT NULL,
		  PRIMARY KEY (`id`),
		  KEY `unit_id_idx` (`unit_id`),
		  KEY `order_id_idx` (`order_id`)
		);";
		dbDelta($sql);
	}
	if($wpdb->get_var("SHOW TABLES LIKE '".ENMASSE_COUPON_ELEMENT."'") != ENMASSE_COUPON_ELEMENT)
	{
		$sql = "CREATE TABLE " . ENMASSE_COUPON_ELEMENT . "(
		  `id` bigint(255) NOT NULL AUTO_INCREMENT,
		  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
		  `x` int(11) NOT NULL,
		  `y` int(11) NOT NULL,
		  `font_size` int(2) NOT NULL,
		  `width` int(2) NOT NULL,
		  `height` int(2) NOT NULL,
		  `published` tinyint(1) NOT NULL,
		  PRIMARY KEY (`id`),
		  UNIQUE KEY `name` (`name`)
		);";
		dbDelta($sql);
		
		/* SQL Template */
		
		$sql = 'INSERT INTO `'.ENMASSE_COUPON_ELEMENT.'` (`id`, `name`, `x`, `y`, `font_size`, `width`, `height`, `published`) VALUES
		(\'dealName\', 13, 533, 20, 652, 77, 0),
		(\'merchantName\', 333, 651, 14, 331, 51, 0),
		(\'highlight\', 15, 725, 10, 311, 68, 0),
		(\'personName\', 15, 649, 14, 310, 52, 0),
		(\'term\', 334, 725, 10, 330, 69, 0);';
		dbDelta($sql);
	
		
	}
	if($wpdb->get_var("SHOW TABLES LIKE '".ENMASSE_EMAIL_TEMPLATE."'") != ENMASSE_EMAIL_TEMPLATE)
	{
		$sql = "CREATE TABLE " . ENMASSE_EMAIL_TEMPLATE . "(
  			`id` bigint(20) NOT NULL AUTO_INCREMENT,
  			`slug_name` varchar(225) COLLATE utf8_unicode_ci NOT NULL,
			`avail_attribute` varchar(225) COLLATE utf8_unicode_ci NOT NULL,
			`subject` varchar(225) COLLATE utf8_unicode_ci DEFAULT NULL,
			`content` text COLLATE utf8_unicode_ci,
			`created_at` datetime NOT NULL,
			`updated_at` datetime NOT NULL,
			PRIMARY KEY (`id`),
			UNIQUE KEY `slug_name` (`slug_name`)
		);";
		dbDelta($sql);
		
		/* SQL Template */
		
		$sql = 'INSERT INTO `'.ENMASSE_EMAIL_TEMPLATE.'` (`id`, `slug_name`, `avail_attribute`, `subject`, `content`, `created_at`, `updated_at`) VALUES
		(\'receipt\', \'$buyerName, $buyerEmail, $deliveryName, $deliveryEmail, $orderId, $dealName, $totalPrice, $createdAt\', \'You have made an Order\', \'Hi $buyerName,\r\n\r\nYou have made an Order at EnMasse with following detail:\r\n<table border=\\"0\\">\r\n<tbody>\r\n<tr>\r\n<td><strong>Order:</strong>$orderId</td>\r\n</tr>\r\n<tr>\r\n<td><strong>Deal:</strong>$dealName</td>\r\n</tr>\r\n<tr>\r\n<td><strong>Total Qty:</strong>$totalQty</td>\r\n</tr>\r\n<tr>\r\n<td><strong>Total Price:</strong>$totalPrice</td>\r\n</tr>\r\n<tr>\r\n<td><strong>Purchase Date:</strong>$createdAt</td>\r\n</tr>\r\n<tr>\r\n<td><strong>Delivery:</strong>$deliveryName ($deliveryEmail)</td>\r\n</tr>\r\n</tbody>\r\n</table>\', \'0000-00-00 00:00:00\', \'2012-05-02 02:33:42\'),
		(\'confirm_deal_buyer\', \'$orderId, $dealName, $buyerName, $deliveryName, $deliveryEmail\', \'Deal $dealName has been confirmed.\', \'Hi $buyerName,\r\n\r\nYour deal $dealName you ordered has been confirmed.\r\n\r\nThe coupon will be delivered to $deliveryName ($deliveryEmail)\r\n\r\nOrder Id: $orderId\', \'0000-00-00 00:00:00\', \'2012-05-02 02:39:30\'),
		(\'confirm_deal_receiver\', \'$orderId, $dealName, $buyerName, $deliveryName, $deliveryMsg, $linkToCoupon\', \'Receive your coupon !!!\', \'Hi $deliveryName,\r\n\r\n$buyerName has bought you a set of coupon for <a href=\\"$linkToCoupon\\" target=\\"_blank\\">$dealName</a>\r\n\r\n$deliveryMsg\r\nPlease go to <a href=\\"$linkToCoupon\\" target=\\"_blank\\">$linkToCoupon</a> if the hyperlink has being blocked.\', \'0000-00-00 00:00:00\', \'2012-05-02 02:39:02\'),
		(\'void_deal\', \'$buyerName, $orderId, $dealName, $refundAmt\', \'Deal $dealName has been canceled\', \'Hi $buyerName,\r\n\r\nThe Order($orderId) for deal $dealName has been cancel.\r\n\r\n$refundAmt will be refunded to you.\', \'0000-00-00 00:00:00\', \'2012-05-02 02:38:08\'),
		(\'void_deal_with_point\', \'$buyerName, $orderId, $dealName, $refundAmt, $refundPoint\', \'Deal $dealName has been canceled\', \'Hi $buyerName,\r\n\r\nThe Order($orderId) for deal $dealName has been cancel.\r\n\r\n$refundAmt cash and $refundPoint point(s) will be refunded to you.\r\n\r\nHowever you can get all the refund in point by going to My Orders page and choose the amount of point you want to get back.\', \'0000-00-00 00:00:00\', \'2012-05-02 02:37:34\');
		';
		dbDelta($sql);
			
	}
	if($wpdb->get_var("SHOW TABLES LIKE '".ENMASSE_BILL_TEMPLATE."'") != ENMASSE_BILL_TEMPLATE)
	{
		$sql = "CREATE TABLE " . ENMASSE_BILL_TEMPLATE . "(
		  `id` bigint(20) NOT NULL AUTO_INCREMENT,
		  `slug_name` varchar(225) COLLATE utf8_unicode_ci NOT NULL,
		  `avail_attribute` varchar(225) COLLATE utf8_unicode_ci NOT NULL,
		  `content` text COLLATE utf8_unicode_ci,
		  `created_at` datetime NOT NULL,
		  `updated_at` datetime NOT NULL,
		  PRIMARY KEY (`id`),
		  UNIQUE KEY `slug_name` (`slug_name`)
		);";
		dbDelta($sql);
		/* SQL Template */
		
		$sql = 'INSERT INTO `'.ENMASSE_BILL_TEMPLATE.'` (`slug_name`, `avail_attribute`, `content`, `created_at`, `updated_at`) VALUES (\'buyer_receipt\', \'[BUYER_NAME], [BUYER_EMAIL], [BILL_NUMBER], [BILL_DATE], [BILL_DETAIL], [BILL_DESCRIPTION]\', \'<p style=\\"text-align: right;\\">Mc-Well Deal</p>\r\n<p style=\\"text-align: right;\\">Am Altheimer</p>\r\n<p style=\\"text-align: right;\\">Eck 5�80331 M�nchen</p>\r\n<p style=\\"text-align: right;\\">Telefon: 089 12 00 00 00</p>\r\n<p style=\\"text-align: right;\\">Mail: info@mc-welldeal.de</p>\r\n<p style=\\"text-align: left;\\">Web: www.mc-welldeal.de</p>\r\n<p style=\\"text-align: left;\\">Mc-Well Deal</p>\r\n<p style=\\"text-align: left;\\">Altheimer Eck 5</p>\r\n<p style=\\"text-align: left;\\">[BUYER_NAME]</p>\r\n<p style=\\"text-align: left;\\">[BUYER_EMAIL]</p>\r\n<p style=\\"text-align: right;\\">Number :[BILL_NUMBER]</p>\r\n<p style=\\"text-align: right;\\">Date :[BILL_DATE]</p>\r\n\r\n<h1 style=\\"text-align: center;\\">BILL (German: RECHNUNG)</h1>\r\n<p style=\\"text-align: center;\\">[BILL_DETAIL]</p>\r\n<p style=\\"text-align: left;\\">Payment Method: [PAYMENT_METHOD]</p>\r\n<p style=\\"text-align: left;\\">Note: [BILL_DESCRIPTION]</p>\', \'2012-04-18 00:00:00\', \'2012-04-26 04:49:12\');';
		dbDelta($sql);
		
	}
	if($wpdb->get_var("SHOW TABLES LIKE '".ENMASSE_INVTY."'") != ENMASSE_INVTY)
	{
		$sql = "CREATE TABLE " . ENMASSE_INVTY . "(
		`id` BIGINT(20) NOT NULL AUTO_INCREMENT,
		`order_item_id` BIGINT(20) NOT NULL,
		`unit_id` INT(11) NOT NULL,
		`name` VARCHAR(255) NOT NULL COLLATE 'utf8_unicode_ci',
		`deallocated_at` DATETIME NOT NULL,
		`status` VARCHAR(30) NOT NULL COLLATE 'utf8_unicode_ci',
		`created_at` DATETIME NOT NULL,
		`settlement_status` VARCHAR(50) NOT NULL DEFAULT 'Not_Paid_Out' COLLATE 'utf8_unicode_ci',
		PRIMARY KEY (`id`)
		);";
		dbDelta($sql);
	}
	if($wpdb->get_var("SHOW TABLES LIKE '".ENMASSE_TAX."'") != ENMASSE_TAX)
	{
		$sql = "CREATE TABLE " . ENMASSE_TAX . "(
		`id` bigint(20) NOT NULL AUTO_INCREMENT,
		`name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
		`tax_rate` double NOT NULL,
		`published` tinyint(1) NOT NULL,
		`created_at` datetime NOT NULL,
		`updated_at` datetime NOT NULL,
		PRIMARY KEY (`id`),
		UNIQUE KEY `name` (`name`)
		);";
		dbDelta($sql);
	}
	
	/* VERSION 1.0 */
	
	add_option("enmasse_company_name", 'Your company name');
	add_option("enmasse_company_adress_1", 'Your company  address 1');
	add_option("enmasse_company_adress_2", 'Your company  address 2');
	add_option("enmasse_company_city", 'Singapore');
	add_option("enmasse_company_state", 'Your company state');
	add_option("enmasse_company_country", 'Your country');
	add_option("enmasse_company_postal_code", 'Your company postal code');
	add_option("enmasse_taxnumber_1", 'Your company tax number 1');
	add_option("enmasse_taxnumber_2", 'Your company tax number 2');
	add_option("enmasse_currency_symbol", '$');
	add_option("enmasse_currency_decimal_place",0);
	add_option("enmasse_currency_type", 'prefix'); //prefix or suffix
	add_option("enmasse_bill_setting",'1');
	add_option("coupon_bg_url",plugins_url(). '/' .plugin_basename(dirname(__FILE__)).'/images/18040samplecoupon.jpg');
	
	/*
	 * @smtp config;
	 */
	add_option("enmasse_smtp_email",'admin@gmail.com');
	add_option("enmasse_smtp_email_pass",'admin');
	add_option("enmasse_smtp_secure",'ssl');
	add_option("enmasse_smtp_host",'smtp.gmail.com');
	add_option("enmasse_smtp_port",'465');
		
	/* PAGE */
	
	if (enmasse_page_id('/cart/') == 0):
		$pages = array(
			array('data'=>array('post_status'=>'publish','post_title'=>'All deals','post_name'=>'alldeals','post_parent'=>0,'post_type'=>'page'),'meta'=>array('meta_key'=>'_wp_page_template','meta_value'=>'enmasse_alldeals_page.php')),
			array('data'=>array('post_status'=>'publish','post_title'=>'Cart','post_name'=>'cart','post_parent'=>0,'post_type'=>'page'),'meta'=>array('meta_key'=>'_wp_page_template','meta_value'=>'enmasse_cart_page.php')),		
			array('data'=>array('post_status'=>'publish','post_title'=>'Company','post_name'=>'company','post_parent'=>0,'post_type'=>'page')),
			array('data'=>array('post_status'=>'publish','post_title'=>'Contact us','post_name'=>'contact-us','post_parent'=>0,'post_type'=>'page')),
			array('data'=>array('post_status'=>'publish','post_title'=>'Customer Support','post_name'=>'customer-support','post_parent'=>0,'post_type'=>'page')),
			array('data'=>array('post_status'=>'publish','post_title'=>'Deal','post_name'=>'deal','post_parent'=>0,'post_type'=>'page'),'meta'=>array('meta_key'=>'_wp_page_template','meta_value'=>'enmasse_deal_page.php')),
			array('data'=>array('post_status'=>'publish','post_title'=>'Expired Deals','post_name'=>'expired-deals','post_parent'=>0,'post_type'=>'page'),'meta'=>array('meta_key'=>'_wp_page_template','meta_value'=>'enmasse_expireddeals_page.php')),
			array('data'=>array('post_status'=>'publish','post_title'=>'FAQ','post_name'=>'faq','post_parent'=>0,'post_type'=>'page')),
			array('data'=>array('post_status'=>'publish','post_title'=>'Forgot password','post_name'=>'forgot-password','post_parent'=>0,'post_type'=>'page'),'meta'=>array('meta_key'=>'_wp_page_template','meta_value'=>'enmasse_forgotpassword_page.php')),
			array('data'=>array('post_status'=>'publish','post_title'=>'My Account','post_name'=>'my-account','post_parent'=>0,'post_type'=>'page'),'meta'=>array('meta_key'=>'_wp_page_template','meta_value'=>'enmasse_myaccount_page.php')),
	
			array('data'=>array('post_status'=>'publish','post_title'=>'Sign In','post_name'=>'sign-in','post_parent'=>0,'post_type'=>'page'),'meta'=>array('meta_key'=>'_wp_page_template','meta_value'=>'enmasse_signin_page.php')),
			array('data'=>array('post_status'=>'publish','post_title'=>'Sign Up','post_name'=>'sign-up','post_parent'=>0,'post_type'=>'page'),'meta'=>array('meta_key'=>'_wp_page_template','meta_value'=>'enmasse_signin_page.php')),
			array('data'=>array('post_status'=>'publish','post_title'=>'Terms of Use','post_name'=>'terms-of-use','post_parent'=>0,'post_type'=>'page')),
			array('data'=>array('post_status'=>'publish','post_title'=>'Upcoming','post_name'=>'upcoming','post_parent'=>0,'post_type'=>'page'),'meta'=>array('meta_key'=>'_wp_page_template','meta_value'=>'enmasse_upcoming_page.php')),
		);
		foreach ($pages as $pagew):
			$post_id = wp_insert_post($pagew['data'],$wp_error);
			if (is_array($pagew['meta'])) update_post_meta($post_id, $pagew['meta']['meta_key'], $pagew['meta']['meta_value']);	
		endforeach;	
		$subpages = array(
			array('data'=>array('post_status'=>'publish','post_title'=>'Merchant Page','post_name'=>'merchant-page','post_parent'=>enmasse_page_id('/my-account/'),'post_type'=>'page'),'meta'=>array('meta_key'=>'_wp_page_template','meta_value'=>'enmasse_merchant_page.php')),
			array('data'=>array('post_status'=>'publish','post_title'=>'My Orders','post_name'=>'my-orders','post_parent'=>enmasse_page_id('/my-account/'),'post_type'=>'page'),'meta'=>array('meta_key'=>'_wp_page_template','meta_value'=>'enmasse_myorders_page.php')),
			array('data'=>array('post_status'=>'publish','post_title'=>'Sale Page','post_name'=>'sale-page','post_parent'=>enmasse_page_id('/my-account/'),'post_type'=>'page'),'meta'=>array('meta_key'=>'_wp_page_template','meta_value'=>'enmasse_sales_page.php')),
			array('data'=>array('post_status'=>'publish','post_title'=>'Sale Reports','post_name'=>'sale-reports','post_parent'=>enmasse_page_id('/my-account/'),'post_type'=>'page'),'meta'=>array('meta_key'=>'_wp_page_template','meta_value'=>'enmasse_salesreports_page.php')),
			array('data'=>array('post_status'=>'publish','post_title'=>'Checkout','post_name'=>'checkout','post_parent'=>enmasse_page_id('/cart/'),'post_type'=>'page'),'meta'=>array('meta_key'=>'_wp_page_template','meta_value'=>'enmasse_checkout_page.php')),
		);
		foreach ($subpages as $pagew):
			$post_id = wp_insert_post($pagew['data'],$wp_error);
			if (is_array($pagew['meta'])) update_post_meta($post_id, $pagew['meta']['meta_key'], $pagew['meta']['meta_value']);	
		endforeach;		
		
		/* MENU */
	endif;
	add_option("enmasse_db_version", $enmasse_db_version);

	if($wpdb->get_var("SELECT COLUMN_NAME 
			FROM INFORMATION_SCHEMA.COLUMNS
			WHERE TABLE_NAME = '".ENMASSE_MERCHANT_BRANCH."' AND COLUMN_NAME='address'") != 'address') {
			$sql = "ALTER TABLE ".ENMASSE_MERCHANT_BRANCH." ADD address VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER name;";
			$wpdb->query($sql);
	}
	
	
}