<?php
	$action = $_GET['action']?$_GET['action']:'list';
	$ax = array('list'=>'list','add'=>'add','edit'=>'edit','delete'=>'delete');
	if (!isset($ax[$action])) $action = 'list';
	switch ($action) {
		case 'list':
			$locx = $wpdb->get_results( 'SELECT a.*,p.name AS pname FROM ' . ENMASSE_LOCATION . ' a LEFT JOIN ' . ENMASSE_LOCATION . ' p ON a.parent_id = p.id ORDER BY a.parent_id ASC');
			require_once(ENMASSE_ADMIN."/location-list.php");
		break;
		case 'add':
			if (isset($_POST['submit'])):
				if(trim(esc_html($_POST['loc-name']))=='')
				{
					$sendback = add_query_arg(array('page'=>'enmasse_location','message'=>'Please input Name field !'));
					$sendback = remove_query_arg( array('noheader'), $sendback );
					wp_redirect($sendback); exit();	
				}
				else
				{
					$insert = "INSERT INTO " . ENMASSE_LOCATION .
					" (name,description,parent_id,published,created_at,updated_at) " .
						"VALUES ('".esc_html($_POST['loc-name'])."','".esc_html($_POST['loc-description'])."','".esc_html($_POST['loc-parent'])."',1,NOW( ),NOW( ))";
					$result = $wpdb->query( $insert );
					$sendback = add_query_arg(array('page'=>'enmasse_location','added'=>1));
					$sendback = remove_query_arg( array('noheader'), $sendback );
					wp_redirect($sendback); exit();
				}
			endif;
			require_once(ENMASSE_ADMIN."/location-add.php");
		break;
		case 'edit':
			if (isset($_POST['submit'])):
				$update = "UPDATE " . ENMASSE_LOCATION .
				" SET name = '".esc_html($_POST['loc-name'])."',description = '".esc_html($_POST['loc-description'])."',parent_id = '".esc_html($_POST['loc-parent'])."',published = 1,updated_at = NOW( ) WHERE id='".intval(esc_html($_GET['id']))."'";
				$result = $wpdb->query( $update );
				$sendback = add_query_arg(array('page'=>'enmasse_location','updated'=>1));
				$sendback = remove_query_arg( array('noheader'), $sendback );
				wp_redirect($sendback); exit();
			endif;
			$loc = $wpdb->get_results( 'SELECT a.* FROM ' . ENMASSE_LOCATION . ' a WHERE a.id='.intval(esc_html($_GET['id'])) );
			$loc = $loc[0];
			require_once(ENMASSE_ADMIN."/location-edit.php");
		break;
		case 'delete':
			if (is_array($_REQUEST['id']))
				$dstring = implode(",",$_REQUEST['id']);
			else $dstring = $_REQUEST['id'];
			$delete = "DELETE FROM ". ENMASSE_LOCATION . " WHERE id IN (" . $dstring . ")";
			$result = $wpdb->query( $delete );
			$sendback = add_query_arg(array('page'=>'enmasse_location','deleted'=>count($_REQUEST['id'])));
			$sendback = remove_query_arg( array('action', 'action2','noheader','id'), $sendback );
			wp_redirect($sendback); exit();
		break;
	}
?>