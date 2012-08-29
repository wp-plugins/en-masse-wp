<?php
	$action = $_GET['action']?$_GET['action']:'list';
	$ax = array('list'=>'list','upload'=>'upload','barcode'=>'barcode','qrcode'=>'qrcode');
	if (!isset($ax[$action])) $action = 'list';
	require_once(ENMASSE_ADMIN."/deal-functions.php");
	switch ($action) {
		case "list":
			if(isset($_GET['pg'])){
				$p =$_GET['pg'];
			}
			else{
				$p = 1;
			}
			$query = 'SELECT Count(*) as count from '.ENMASSE_COUPON_ELEMENT;
			$total = $wpdb->get_results($query);
			$itemPerPage = get_option('posts_per_page',5);
			$limit = ($p - 1) * $itemPerPage;
			$totalposts = $total[0]->count/$itemPerPage;
			$prev = $p - 1;
			$next = $p + 1;
			$query = 'SELECT * FROM '.ENMASSE_COUPON_ELEMENT.' ORDER BY ID ASC LIMIT '.$limit.','.$itemPerPage;
			$paging = pagination($totalposts,$p,$totalposts-1,$prev,$next,array('page'=>'enmasse_couponeditor')) ;
			$coupons = $wpdb->get_results($query);
			if (isset($_POST['submit'])):
			echo $_FILES['file'];
			for($i=1;$i<8;$i++){
				$data = array(	"x" => esc_html($_POST['cp-x'.$i]),
						"y" => esc_html($_POST['cp-y'.$i]),
						"font_size" => esc_html($_POST['cp-font_size'.$i]),
						"width" => esc_html($_POST['cp-width'.$i]),
						"height" => esc_html($_POST['cp-height'.$i])
				);
				$wpdb->update(ENMASSE_COUPON_ELEMENT,$data,array('id'=>$i));
			}
			$sendback = add_query_arg(array('updated'=>1));
			$sendback = remove_query_arg( array('noheader'), $sendback );
			wp_redirect($sendback); exit();
			endif;
			global $coupon;
			$query ='SELECT cp.* FROM ' . ENMASSE_COUPON_ELEMENT . ' cp WHERE cp.id='.intval(esc_html($_GET['id']));
			$coupon = $wpdb->get_results($query);
			$coupon = $coupon[0];
			require_once(ENMASSE_ADMIN."/coupon-list.php");
			break;
		case "upload" :
			$uploads = wp_upload_dir();
			$temp = preg_split('/[\/\\\\]+/', $_FILES['async-upload']["name"]);
			$filename = $temp[count($temp)-1];
			$error = do_validate_file($filename);
			if(empty($error)) 
			{
				$uploadvalue = do_upload($uploads['path'],$filename);
				if($uploadvalue !=null) {
					
					update_option('coupon_bg_url', $uploads['url'].'/'.$uploadvalue);
					$sendback = add_query_arg(array('page'=>'enmasse_couponeditor'));
					$sendback = remove_query_arg( array('noheader','action'), $sendback );
					wp_redirect($sendback); exit();
				}
				else 
				{
					$sendback = add_query_arg(array('page'=>'enmasse_couponeditor'));
					$sendback = remove_query_arg( array('noheader','action'), $sendback );
					wp_redirect($sendback); exit();
				}
			}
			else 
			{
					$sendback = add_query_arg(array('page'=>'enmasse_couponeditor','message'=>$error));
					$sendback = remove_query_arg( array('noheader','action'), $sendback );
					wp_redirect($sendback); exit();
			}
			break;
		case "barcode":
			$num = $_GET['num'];
			generateBarcode($num);
			die;
		case "qrcode":
			$val = $_GET['val'];
			generateQrcode($val);
			
	}
	
?>