<?php
/**
 * @package EnMasse
 * @subpackage EnMasse_WP
 * @since EnMasse WP 1.0
 **/
require_once (ABSPATH  . 'wp-admin/includes/class-wp-list-table.php');
include (ABSPATH . 'wp-includes/pluggable.php');
include_once (ABSPATH . 'wp-admin/includes/plugin.php');
include_once (ABSPATH . WPINC . '/functions.php');
require_once (ENMASSE_ADMIN."/exec.functions.php");
global $fluginurl,$siteurl;
$siteurl = get_option('siteurl');
$fluginurl = plugins_url(). '/' .plugin_basename(dirname(__FILE__));
function  enmasse_admin_menu() {
	
    if(function_exists(add_object_page))
    {
    	
        add_object_page ('EnMasse WP', 'EnMasse WP', 8,'enmasse_home', 'enmasse_dashboad',plugins_url(). '/' .plugin_basename(dirname(__FILE__)).'/enmasse-admin/images/favicon.png');
    }
    else
    {
        add_menu_page ('EnMasse WP', 'EnMasse WP',8,'enmasse_home', 'enmasse_dashboad',plugins_url(). '/' .plugin_basename(dirname(__FILE__)).'/enmasse-admin/images/favicon.png'); 
    }
         add_submenu_page('enmasse_home', 'EnMasse WP', 'Dashboard', 8, 'enmasse_home','enmasse_dashboad'); // Default
		 add_submenu_page('enmasse_home', 'EnMasse WP', 'Category', 8, 'enmasse_category', 'enmasse_category'); 
		 add_submenu_page('enmasse_home', 'EnMasse WP', 'Location', 8, 'enmasse_location', 'enmasse_location'); 
		 add_submenu_page('enmasse_home', 'EnMasse WP', 'Payment Gateway', 8, 'enmasse_paymentgateway', 'enmasse_paymentgateway');
		 add_submenu_page('enmasse_home', 'EnMasse WP', 'Coupon Editor', 8, 'enmasse_couponeditor', 'enmasse_couponeditor');
		 add_submenu_page('enmasse_home', 'EnMasse WP', 'Email Template', 8, 'enmasse_emailtemplate', 'enmasse_emailtemplate');
		 add_submenu_page('enmasse_home', 'EnMasse WP', 'Bill Editor', 8, 'enmasse_billeditor', 'enmasse_billeditor');
		 add_submenu_page('enmasse_home', 'EnMasse WP', 'Sale Person', 8, 'enmasse_saleperson', 'enmasse_saleperson');
		 add_submenu_page('enmasse_home', 'EnMasse WP', 'Merchant', 1, 'enmasse_merchant', 'enmasse_merchant');
		 add_submenu_page('enmasse_home', 'EnMasse WP', 'Deal', 1, 'enmasse_deal','enmasse_deal');
		 add_submenu_page('enmasse_home', 'EnMasse WP', 'Order', 8, 'enmasse_order', 'enmasse_order');
		 add_submenu_page('enmasse_home', 'EnMasse WP', 'Report', 8, 'enmasse_dealReport','enmasse_dealReport');
		 add_submenu_page('enmasse_home', 'EnMasse WP', 'Settings', 8, 'enmasse_settings', 'enmasse_settings');
}
function enmasse_dashboad($page){
	global $wpdb;
	require_once(ENMASSE_ADMIN."/dashboard.php");
}
function enmasse_category($page){
	global $wpdb,$sendback;
	require_once(ENMASSE_ADMIN."/category.php");
}
function enmasse_location($page){
	global $wpdb,$sendback;
	require_once(ENMASSE_ADMIN."/location.php");
}
function enmasse_deal($page){
	global $wpdb;
	require_once(ENMASSE_ADMIN."/deal.php");
}
function enmasse_gen($page){
	global $wpdb;
	require_once(ENMASSE_ADMIN."/category.php");
}
function enmasse_merchant($page) {
	global $wpdb;$sendback;
	require_once(ENMASSE_ADMIN."/merchant.php");
}
function enmasse_saleperson($page)
{
	global $wpdb;$sendback;
	require_once(ENMASSE_ADMIN."/saleperson.php");
}
function enmasse_paymentgateway($page){
	global $wpdb;
	require_once(ENMASSE_ADMIN."/paymentgateway.php");
}
function enmasse_couponeditor($page){
	global $wpdb;
	require_once(ENMASSE_ADMIN."/coupon.php");
}
function enmasse_emailtemplate($page){
	global $wpdb;
	require_once(ENMASSE_ADMIN."/emailtemplate.php");
}
function enmasse_order($page){
	global $wpdb;
	require_once(ENMASSE_ADMIN."/order.php");
}
function enmasse_report($page) {
	global $wpdb;
	require_once(ENMASSE_ADMIN."/report.php");
}
function enmasse_billeditor($page) {
	global $wpdb;
	require_once(ENMASSE_ADMIN."/billeditor.php");
}
function enmasse_dealReport ($page) {
	global $wpdb;
	require_once(ENMASSE_ADMIN."/dealcouponreport.php");
}

function enmasse_settings ($page) {
	global  $wpdb;
	require_once (ENMASSE_ADMIN.'/setting.php');
}
function enmasse_admin_head() {
global $fluginurl;
$url = $fluginurl. '/enmasse-admin/css/';
echo "<link rel='stylesheet' type='text/css' href='".$url."admin.css' />\n";
echo "<link rel='stylesheet' type='text/css' href='".$url."jquery-calendar.css' />";
echo "<link rel='stylesheet' href='".$fluginurl."/enmasse-admin/js/themes/ui-lightness/jquery.ui.all.css'>";
echo "
<script src='".$fluginurl."/enmasse-admin/js/util.js'></script>
<script src='".$fluginurl."/enmasse-admin/js/jquery-payment-gateway.js'></script>
<script src='".$fluginurl."/enmasse-admin/js/jquery-merchant-branches.js'></script>
<script src='".$fluginurl."/enmasse-admin/js/jquery-coupon-editor.js'></script>";
}
add_action( 'init', 'my_scripts_method' );
function my_scripts_method() {
	global $fluginurl;
	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'jquery-form');
	wp_enqueue_script( 'hoverIntent');
	wp_enqueue_script( 'common');
	wp_enqueue_script( 'jquery-color');
	wp_enqueue_script( 'wp-ajax-response');
    wp_enqueue_script( 'jquery-ui-core' );
    wp_enqueue_script( 'jquery-widget', 'http://jquery-ui.googlecode.com/svn/trunk/ui/jquery.ui.widget.js', array('jquery', 'jquery-ui-core' ) );
    wp_enqueue_script( 'jquery-position', 'http://jquery-ui.googlecode.com/svn/trunk/ui/jquery.ui.position.js', array('jquery', 'jquery-ui-core' ) );
    wp_enqueue_script( 'jquery-mouse', 'http://jquery-ui.googlecode.com/svn/trunk/ui/jquery.ui.mouse.js', array('jquery', 'jquery-ui-core' ) );
    wp_enqueue_script( 'jquery-accordion', 'http://jquery-ui.googlecode.com/svn/trunk/ui/jquery.ui.accordion.js', array('jquery', 'jquery-ui-core' ) );
    wp_enqueue_script( 'jquery-slider', 'http://jquery-ui.googlecode.com/svn/trunk/ui/jquery.ui.slider.js', array('jquery', 'jquery-ui-core' ) );
    wp_enqueue_script( 'jQuery-tabs', 'http://jquery-ui.googlecode.com/svn/trunk/ui/jquery.ui.tabs.js', array('jquery', 'jquery-ui-core' ) );
    wp_enqueue_script( 'jquery-sortable', 'http://jquery-ui.googlecode.com/svn/trunk/ui/jquery.ui.sortable.js', array('jquery', 'jquery-ui-core' ) );
    wp_enqueue_script( 'jquery-draggable', 'http://jquery-ui.googlecode.com/svn/trunk/ui/jquery.ui.draggable.js', array('jquery', 'jquery-ui-core' ) );
    wp_enqueue_script( 'jquery-droppable', 'http://jquery-ui.googlecode.com/svn/trunk/ui/jquery.ui.droppable.js', array('jquery', 'jquery-ui-core' ) );
    wp_enqueue_script( 'jquery-autocomplete', 'http://jquery-ui.googlecode.com/svn/trunk/ui/jquery.ui.autocomplete.js', array('jquery', 'jquery-ui-core' ) );
    wp_enqueue_script( 'jquery-selectable', 'http://jquery-ui.googlecode.com/svn/trunk/ui/jquery.ui.selectable.js', array('jquery', 'jquery-ui-core' ) );
    wp_enqueue_script( 'jquery-datepicker', 'http://jquery-ui.googlecode.com/svn/trunk/ui/jquery.ui.datepicker.js', array('jquery', 'jquery-ui-core' ) );
    wp_enqueue_script( 'jquery-calendar',$fluginurl.'/enmasse-admin/js/jquery-calendar.js', array('jquery', 'jquery-ui-core' ) );
    wp_enqueue_script( 'jquery-resizable', 'http://jquery-ui.googlecode.com/svn/trunk/ui/jquery.ui.resizable.js', array('jquery', 'jquery-ui-core' ) );
    wp_enqueue_script( 'jquery-dialog', 'http://jquery-ui.googlecode.com/svn/trunk/ui/jquery.ui.dialog.js', array('jquery', 'jquery-ui-core' ) );
    wp_enqueue_script( 'jquery-button', 'http://jquery-ui.googlecode.com/svn/trunk/ui/jquery.ui.button.js', array('jquery', 'jquery-ui-core' ) );
}    
add_action('admin_head', 'enmasse_admin_head');
add_action('admin_menu', 'enmasse_admin_menu');
