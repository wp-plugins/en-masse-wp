<?php
	$action = $_GET['action']?$_GET['action']:'list';
	$ax = array('list'=>'list','add'=>'add','edit'=>'edit','delete'=>'delete');
	if (!isset($ax[$action])) $action = 'list';
	switch ($action) {
		case 'list':
			$catx = $wpdb->get_results( 'SELECT a.*,p.name AS pname FROM ' . ENMASSE_CATEGORY . ' a LEFT JOIN ' . ENMASSE_CATEGORY . ' p ON a.parent_id = p.id ORDER BY a.parent_id ASC');
			require_once(ENMASSE_ADMIN."/category-list.php");
		break;
		case 'add':
			if (isset($_POST['submit'])):
				if(trim(esc_html($_POST['cat-name']))=='')
				{
					$sendback = add_query_arg(array('page'=>'enmasse_category','message'=>'Please input Name field !'));
					$sendback = remove_query_arg( array('noheader'), $sendback );
					wp_redirect($sendback); exit();	
				}
				else if( strlen(esc_html($_POST['cat-name']))<8 || strlen(esc_html($_POST['cat-name']))>50)
				{
					$sendback = add_query_arg(array('page'=>'enmasse_category','message'=>'Name field must have 8-50 character'));
					$sendback = remove_query_arg( array('noheader'), $sendback );
					wp_redirect($sendback); exit();	
				}
				else
				{
					$insert = "INSERT INTO " . ENMASSE_CATEGORY ." (name,description,parent_id,published,created_at,updated_at) " .
					"VALUES ('".esc_html($_POST['cat-name'])."','".esc_html($_POST['cat-description'])."','".esc_html($_POST['cat-parent']						)."',1,NOW( ),NOW( ))";
					$result = $wpdb->query( $insert );
					$sendback = add_query_arg(array('page'=>'enmasse_category','added'=>1));
					$sendback = remove_query_arg( array('noheader'), $sendback );
					wp_redirect($sendback); exit();				
				}

			endif;
			require_once(ENMASSE_ADMIN."/category-add.php");
		break;
		case 'edit':
			if (isset($_POST['submit'])):
				$update = "UPDATE " . ENMASSE_CATEGORY .
				" SET name = '".esc_html($_POST['cat-name'])."',description = '".esc_html($_POST['cat-description'])."',parent_id = '".esc_html($_POST['cat-parent'])."',published = 1,updated_at = NOW( ) WHERE id='".intval(esc_html($_GET['id']))."'";
				$result = $wpdb->query( $update );
				$sendback = add_query_arg(array('page'=>'enmasse_category','updated'=>1));
				$sendback = remove_query_arg( array('noheader'), $sendback );
				wp_redirect($sendback); exit();				
			endif;
			$cat = $wpdb->get_results( 'SELECT a.* FROM ' . ENMASSE_CATEGORY . ' a WHERE a.id='.intval(esc_html($_GET['id'])) );
			$cat = $cat[0];
			require_once(ENMASSE_ADMIN."/category-edit.php");
		break;
		case 'delete':
			if (is_array($_REQUEST['id']))
				$dstring = implode(",",$_REQUEST['id']);
			else $dstring = $_REQUEST['id'];
			$delete = "DELETE FROM ". ENMASSE_CATEGORY . " WHERE id IN (" . $dstring . ")";
			$result = $wpdb->query( $delete );
			$sendback = add_query_arg(array('page'=>'enmasse_category','deleted'=>count($_REQUEST['id'])));
			$sendback = remove_query_arg( array('action', 'action2','noheader','id'), $sendback );
			wp_redirect($sendback); exit();
		break;
	}
?>