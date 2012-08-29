<?php
	$action = $_GET['action']?$_GET['action']:'list';
	$ax = array('list'=>'list','add'=>'add','edit'=>'edit','delete'=>'delete','getuser'=>'getuser');
	
	if (!isset($ax[$action])) $action = 'list';
	require_once(ENMASSE_ADMIN."/merchant-functions.php");
	switch ($action) {
		case 'list':
			if(isset($_GET['pg'])){
				$p =$_GET['pg'];
			}
			else{
				$p = 1;
			}
			$query = 'SELECT Count(*) as count,(SELECT us.user_login FROM ' . $wpdb->prefix. 'users us WHERE m.sales_person_id = us.ID) sale_name  FROM ' . ENMASSE_MERCHANT_BRANCH. ' m LEFT JOIN ' . $wpdb->prefix. 'users u ON m.user_id = u.ID ORDER BY m.id ASC';
			$total = $wpdb->get_results($query);
			$itemPerPage = get_option('	posts_per_page',5);
			$limit = ($p - 1) * $itemPerPage;
			$totalposts = $total[0]->count/$itemPerPage;
			$prev = $p - 1;
			$next = $p + 1;
			//pagination
			$query = 'SELECT *,(SELECT s.name FROM ' . ENMASSE_SALES_PERSON. ' s WHERE m.sales_person_id = s.id) sale_name  FROM ' . ENMASSE_MERCHANT_BRANCH. ' m LEFT JOIN ' . $wpdb->prefix. 'users u ON m.user_id = u.ID ORDER BY m.id ASC LIMIT '.$limit.','.$itemPerPage;
			$paging = pagination($totalposts,$p,$totalposts-1,$prev,$next,array('page'=>'enmasse_merchant','action'=>'list')) ;
			$mers = $wpdb->get_results($query);
			require_once(ENMASSE_ADMIN."/merchant-list.php");
			break;
		case 'add':
			if (isset($_POST['submit'])):
			$query = "SELECT u.ID from ".$wpdb->prefix."users"." u WHERE u.user_login='".$_POST['mer-user-id']."'";
			$userID = $wpdb->get_row($query);
			if( ! empty($userID))
			{
				$post = $_POST;
				for($i=1; $i<=$post['num_of_branches'];$i++)
				{
					$branches["branch" . $i] = array();
				}
				$removeId = 0;
				foreach ($post as $key=>$value)
				{
					$temp = explode("-", $key);
					if(count($temp)==2)
					{
						if($temp[0]=="remove")
						{
							$removeId = $temp[1];
						}
						if($temp[1]!=$removeId)
						{
							$branches["branch" . $temp[1]][$temp[0]] = $value;
						}
					}
				}
				$final = array();
				if (!empty($branches)) {
					foreach($branches as $branch)
					{
						if(!empty($branch))
						{
							$final[$branch['branchname']] = $branch;
						}				
					}
				}
				$insert = "INSERT INTO " . ENMASSE_MERCHANT_BRANCH.
				" (name,address,user_id,sales_person_id,web_url,logo_url,location_id,description,google_map_width,google_map_height,google_map_zoom,branches,published,created_at,updated_at) " .
				"VALUES ('"
					.esc_html($_POST['mer-name'])."','"
					.esc_html($_POST['mer-address'])."','"
					.esc_html($userID->ID)."','"
					.esc_html($_POST['mer-sale-person-id'])."','"
					.esc_html($_POST['mer-web-url'])."','"
					.esc_html($_POST['mer-logo-url'])."','"
					.esc_html($_POST['mer-location-id'])."','"
					.$_POST['mer-description']."','"
					.esc_html($_POST['mer-google-map-width'])."','"
					.esc_html($_POST['mer-google-map-height'])."','"
					.esc_html($_POST['mer-google-map-zoom'])."','"
					.json_encode($final)
					."',1,NOW( ),NOW( ))";
				$result = $wpdb->query( $insert );
				
				$sendback = add_query_arg(array('page'=>'enmasse_merchant','added'=>1));
				$sendback = remove_query_arg( array('noheader'), $sendback );
				wp_redirect($sendback); exit();
			}
			endif;
			$query = 'Select * from  '.$wpdb->prefix.'users';
			global $users;
			$users = $wpdb->get_results($query);
			require_once(ENMASSE_ADMIN."/merchant-add.php");
			break;
		case 'edit':
			if (isset($_POST['submit'])):
				$post = $_POST;
				for($i=1; $i<=$post['num_of_branches'];$i++)
				{
					$branches["branch" . $i] = array();
				}
				$removeId = 0;
				foreach ($post as $key=>$value)
				{
					$temp = explode("-", $key);
					if(count($temp)==2)
					{
						if($temp[0]=="remove")
						{
							$removeId = $temp[1];
						}
						if($temp[1]!=$removeId)
						{
							$branches["branch" . $temp[1]][$temp[0]] = esc_html($value);
						}
					}
				}
				$final = array();
				if (!empty($branches)) {
					foreach($branches as $branch)
					{
						if(!empty($branch))
						{
							$final[$branch['branchname']] = $branch;
						}				
					}
				}
				$update = "UPDATE " . ENMASSE_MERCHANT_BRANCH .
				" SET name = '".esc_html($_POST['mer-name'])
					."',address = '".esc_html($_POST['mer-address'])
					."',sales_person_id = '".esc_html($_POST['mer-sale-person-id'])
					."',web_url = '".esc_html($_POST['mer-web-url'])
					."',logo_url = '".esc_html($_POST['mer-logo-url'])
					."',location_id = '".esc_html($_POST['mer-web-url'])
					."',description = '".$_POST['mer-description']
					."',google_map_width = '".esc_html($_POST['mer-google-map-width'])
					."',google_map_height = '".esc_html($_POST['mer-google-map-height'])
					."',google_map_zoom = '".esc_html($_POST['mer-google-map-zoom'])
					."',branches = '".json_encode($final)
					."',published = 1,updated_at = NOW( ) WHERE id='".intval(esc_html($_GET['id']))."'";
				$result = $wpdb->query( $update );
				$sendback = add_query_arg(array('page'=>'enmasse_merchant','updated'=>1));
				$sendback = remove_query_arg( array('noheader'), $sendback );
				wp_redirect($sendback); exit();
			endif;
			global  $mer;
			$mer = $wpdb->get_results( 'SELECT a.*,u.user_login as uname FROM ' . ENMASSE_MERCHANT_BRANCH . ' a INNER JOIN ' . $wpdb->prefix.'users u ON a.user_id = u.ID  WHERE a.id='.intval(esc_html($_GET['id'])) );
			$mer = $mer[0];
			require_once(ENMASSE_ADMIN."/merchant-edit.php");
			break;
		case 'delete':
			if (is_array($_REQUEST['id']))
				$dstring = implode(",",$_REQUEST['id']);
			else $dstring = $_REQUEST['id'];
			$delete = "DELETE FROM ". ENMASSE_MERCHANT_BRANCH . " WHERE id IN (" . $dstring . ")";
			$result = $wpdb->query( $delete );
			$sendback = add_query_arg(array('page'=>'enmasse_merchant','deleted'=>count($_REQUEST['id'])));
			$sendback = remove_query_arg( array('action', 'action2','noheader','id'), $sendback );
			wp_redirect($sendback); exit();
			
			break;
		case 'getuser':
			get_user_ajax('merchant');
			exit();
			break;
	}