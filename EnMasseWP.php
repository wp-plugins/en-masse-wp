<?php
/*
Plugin Name: EnMasse Wordpress 1.0
Plugin URI: http://www.matamko.com
Description: EnMasse Wordpress is a Wordpress flugin that allows users to install a coupon shopping feature to their website. It allows customers to purchase any types of coupon online and facilitates great management in dealing of the coupons. Its implementation involves a frontend and a backend administrator site, both for the purpose of simplifying the management of coupons and deals.
Version: 1.0
Author: Matamko .Inc
Author URI: http://www.matamko.com
License: GPL2
*/
define('ENMASSE_ADMIN',dirname(__FILE__)."/enmasse-admin");
define('ENMASSE_LIB',dirname(__FILE__)."/library");
define('ENMASSE_TEMP_PATH',dirname(__FILE__)."/tmp");

require_once(ENMASSE_ADMIN."/em-session.php");
require_once (ENMASSE_LIB."/phpbarcode/phpbarcode.php");
include (ENMASSE_LIB.'/phpqrcode/qrlib.php');
require(dirname(__FILE__)."/installer.php");
register_activation_hook(__FILE__,'enmasse_installer');
require(dirname(__FILE__)."/admin-functions.php");

?>