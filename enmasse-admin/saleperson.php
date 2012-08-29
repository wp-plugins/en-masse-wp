<?php
	$action = $_GET['action']?$_GET['action']:'list';
	$ax = array('list'=>'list','add'=>'add','edit'=>'edit','delete'=>'delete','getuser'=>'getuser');
	
	if (!isset($ax[$action])) $action = 'list';
	//require_once(ENMASSE_ADMIN."/SLA-functions.php");
	switch ($action) {
		case 'list':
			//config pagination
			if(isset($_GET['pg'])){
				$p =$_GET['pg'];
			}
			else{
				$p = 1;
			}
			$query = 'SELECT COUNT(*) AS count FROM ' . ENMASSE_SALES_PERSON. ' s INNER JOIN ' . $wpdb->prefix.'users  u  ON s.user_id = u.id  ORDER BY s.name ASC';
			$total = $wpdb->get_results($query);
			$itemPerPage = get_option('	posts_per_page',5);
			$limit = ($p - 1) * $itemPerPage;
			$totalposts = $total[0]->count/$itemPerPage;
			$prev = $p - 1;
			$next = $p + 1;
			$query = 'SELECT s.*,u.user_login AS uname FROM ' . ENMASSE_SALES_PERSON. ' s INNER JOIN ' . $wpdb->prefix.'users  u  ON s.user_id = u.id  ORDER BY s.name ASC LIMIT '.$limit.','.$itemPerPage;
			$sales = $wpdb->get_results($query);
			$paging = pagination($totalposts,$p,$totalposts-1,$prev,$next,array('page'=>'enmasse_saleperson','action'=>'list')) ;
			require_once(ENMASSE_ADMIN."/saleperson-list.php");
			break;
		case 'add':
			if (isset($_POST['submit'])):
				$query = "SELECT * FROM ".ENMASSE_SALES_PERSON." s INNER JOIN ".$wpdb->prefix."users u ON s.user_id = u.ID WHERE u.user_login='".$_POST['sale-user-id']."'";
				$userID = $wpdb->get_results($query);
				if(!empty($userID)){
					$sendback = add_query_arg(array('page'=>'enmasse_saleperson','error'=>"This user is already create a sale person"));
					$sendback = remove_query_arg( array('noheader'), $sendback );
					wp_redirect($sendback); exit();
				}
				
				$query = "SELECT * FROM ".ENMASSE_SALES_PERSON." s WHERE s.name = '".$_POST['sale-name']."'";
				$userID = $wpdb->get_results($query);
				if(!empty($userID)){
					$sendback = add_query_arg(array('page'=>'enmasse_saleperson','error'=>"This sale name is duplicated! Please try with other name"));
					$sendback = remove_query_arg( array('noheader'), $sendback );
					wp_redirect($sendback); exit();
				}
				
				$query = "SELECT * FROM ".$wpdb->prefix."users s WHERE s.user_login = '".$_POST['sale-user-id']."'";
				$userID = $wpdb->get_results($query);
				if(empty($userID)){
					$sendback = add_query_arg(array('page'=>'enmasse_saleperson','error'=>"This user name is invalid!"));
					$sendback = remove_query_arg( array('noheader'), $sendback );
					wp_redirect($sendback); exit();
				}
				
				$query = "SELECT u.ID from ".$wpdb->prefix."users u WHERE u.user_login='".$_POST['sale-user-id']."'";
				$userID = $wpdb->get_row($query);
				if( ! empty($userID))
				{
					$insert = "INSERT INTO " . ENMASSE_SALES_PERSON.
					" (name,user_id,address,phone,email,published,created_at,updated_at) " .
					"VALUES ('"
						.esc_html($_POST['sale-name'])."','"
						.esc_html($userID->ID)."','"
						.esc_html($_POST['sale-address'])."','"
						.esc_html($_POST['sale-phone'])."','"
						.esc_html($_POST['sale-email'])."',"
						."1,NOW( ),NOW( ))";
					$result = $wpdb->query( $insert );
					$user = new WP_User($userID->ID);
					$user->set_role('contributor');
				}	
				$sendback = add_query_arg(array('page'=>'enmasse_saleperson','added'=>1));
				$sendback = remove_query_arg( array('noheader'), $sendback );
				wp_redirect($sendback); exit();
			endif;
			require_once(ENMASSE_ADMIN."/saleperson-add.php");
			break;
		case 'edit':
			if (isset($_POST['submit'])):
				$query = "SELECT * FROM ".ENMASSE_SALES_PERSON." s WHERE s.name = '".$_POST['sale-name']."' AND s.id != ".$_GET['id']."";
				$userID = $wpdb->get_results($query);
				if(!empty($userID)){
					$sendback = add_query_arg(array('page'=>'enmasse_saleperson','message'=>"This sale name is duplicated! Please try with other name"));
					$sendback = remove_query_arg( array('noheader'), $sendback );
					wp_redirect($sendback); exit();
				}
				$update = "UPDATE " . ENMASSE_SALES_PERSON .
				" SET name = '".esc_html($_POST['sale-name'])."',
								address = '".esc_html($_POST['sale-address'])
								."',phone = '".esc_html($_POST['sale-phone'])
								."',email = '".esc_html($_POST['sale-email'])
								."',published =1,updated_at = NOW( ) WHERE id='"
								.intval(esc_html($_GET['id']))."'";
								
				$result = $wpdb->query( $update );					
				$sendback = add_query_arg(array('page'=>'enmasse_saleperson','updated'=>1));
				$sendback = remove_query_arg( array('noheader'), $sendback );
				wp_redirect($sendback); exit();				
			endif;
			$sale = $wpdb->get_results( 'SELECT * FROM ' . ENMASSE_SALES_PERSON. ' s INNER JOIN ' . $wpdb->prefix.'users  u  ON s.user_id = u.id WHERE s.id='.intval(esc_html($_GET['id'])) );
			$sale = $sale[0];
			require_once(ENMASSE_ADMIN."/saleperson-edit.php");
			break;
		case 'delete':
			if (is_array($_REQUEST['id']))
				$dstring = implode(",",$_REQUEST['id']);
			else $dstring = $_REQUEST['id'];
			$delete = "DELETE FROM ". ENMASSE_SALES_PERSON . " WHERE id IN (" . $dstring . ")";
			$result = $wpdb->query( $delete );
			$user = new WP_User($userID->ID);
			$user->set_role('subscriber');
			$sendback = add_query_arg(array('page'=>'enmasse_saleperson','deleted'=>count($_REQUEST['id'])));
			$sendback = remove_query_arg( array('action', 'action2','noheader','id'), $sendback );
			wp_redirect($sendback); exit();
			
			break;
		case 'getuser':
			get_user_ajax('sale');
			exit;
	}
