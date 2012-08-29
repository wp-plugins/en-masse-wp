<?php
	$action = $_GET['action']?$_GET['action']:'list';
	$ax = array('list'=>'list','add'=>'add','edit'=>'edit','delete'=>'delete');
	if (!isset($ax[$action])) $action = 'list';
	require_once(ENMASSE_ADMIN."/paymentgateway-functions.php");
	switch ($action) {
		case 'list':
			if(isset($_GET['pg'])){
				$p =$_GET['pg'];
			}
			else{
				$p = 1;
			}
			$query = 'SELECT Count(*) as count from '.ENMASSE_PAY_GATEWAY;
			$total = $wpdb->get_results($query);
			$itemPerPage = get_option('posts_per_page',5);
			$limit = ($p - 1) * $itemPerPage;
			$totalposts = $total[0]->count/$itemPerPage;
			$prev = $p - 1;
			$next = $p + 1;
			$query = 'SELECT * FROM '.ENMASSE_PAY_GATEWAY.' ORDER BY ID DESC LIMIT '.$limit.','.$itemPerPage;
			$paging = pagination($totalposts,$p,$totalposts-1,$prev,$next,array('page'=>'enmasse_paymentgateway','action'=>'list')) ;
			$pay_gtys = $wpdb->get_results($query);
			require_once(ENMASSE_ADMIN."/paymentgateway-list.php");
		break;
		case 'add':
			if(isset($_POST['submit'])):
				$attribute_names = $_POST['attribute_name'];
				$attribute_values = $_POST['attribute_value'];
				$attribute_config = array();
				$isFirst = true;
				$NumOfAtt = 1;
				$attributes = '';
				foreach($attribute_names as $attribute_name)
				{					
					if($attribute_name!="")
					{
						if($isFirst)
						{
							$attributes .= $attribute_name;
							$isFirst = false;
						}
						else
						{
							$attributes .= "," . $attribute_name;
						}
						$attribute_config[$attribute_name] = $attribute_values[$NumOfAtt];
					}
					$NumOfAtt++;
				}
				$data = array(	"name" => esc_html($_POST['pay-gty-name']), 
  								"description" => $_POST['pay-gty-description'],
							  	"class_name" => esc_html($_POST['pay-gty-classname']),
							  	"published" => esc_html($_POST['published']),
								"attributes" => $attributes,
								"attribute_config" => json_encode($attribute_config),
							  	"created_at" => date('Y-m-d g:i:s A',time()+7*3600),
	                       		"updated_at" => date('Y-m-d g:i:s A',time()+7*3600)
				);
		   		if($wpdb->insert(ENMASSE_PAY_GATEWAY,$data))
				$sendback = add_query_arg(array('page'=>'enmasse_paymentgateway','added'=>1));
				else
					$sendback = add_query_arg(array('page'=>'enmasse_paymentgateway','added'=>0));
				$sendback = remove_query_arg( array('noheader'), $sendback );
				wp_redirect($sendback); exit();
			endif;
			require_once(ENMASSE_ADMIN."/paymentgateway-add.php");
		break;
		case 'edit':
			if(isset($_POST['submit'])):
				$attribute_names = $_POST['attribute_name'];
				$attribute_values = $_POST['attribute_value'];
				$attribute_config = array();
				$isFirst = true;
				$NumOfAtt = 1;
				$attributes = '';
				foreach($attribute_names as $attribute_name)
				{
					if($attribute_name!="")
					{
						if($isFirst)
						{
							$attributes .= $attribute_name;
							$isFirst = false;
						}
						else
						{
							$attributes .= "," . $attribute_name;
						}
						$attribute_config[$attribute_name] = $attribute_values[$NumOfAtt];
					}
					$NumOfAtt++;
				}
				$data = array(	"name" => esc_html($_POST['pay-gty-name']), 
  								"description" =>$_POST['pay-gty-description'],
							  	"class_name" => esc_html($_POST['pay-gty-classname']),
							  	"published" => esc_html($_POST['published']),
								"attributes" => $attributes,
								"attribute_config" => json_encode($attribute_config),
							  	"updated_at" => date('Y-m-d g:i:s A',time()+7*3600)
				);
		   		$wpdb->update(ENMASSE_PAY_GATEWAY,$data,array('id'=>$_REQUEST['id']));
				$sendback = add_query_arg(array('updated'=>1));
				$sendback = remove_query_arg( array('noheader'), $sendback );
				wp_redirect($sendback); exit();
			endif;
			global $pay_gty;
			$query ='SELECT pg.* FROM ' . ENMASSE_PAY_GATEWAY . ' pg WHERE pg.id='.intval(esc_html($_GET['id']));
			$pay_gty = $wpdb->get_results($query);
			$pay_gty = $pay_gty[0];
			require_once(ENMASSE_ADMIN."/paymentgateway-edit.php");
		break;
		case 'delete':
			if (is_array($_REQUEST['id']))
				$dstring = implode(",",$_REQUEST['id']);
			else $dstring = $_REQUEST['id'];
			$delete = "DELETE FROM ". ENMASSE_PAY_GATEWAY. " WHERE id IN (" . $dstring . ")";
			$result = $wpdb->query( $delete );
			$sendback = add_query_arg(array('page'=>'enmasse_paymentgateway','deleted'=>count($_REQUEST['id'])));
			$sendback = remove_query_arg( array('action', 'action2','noheader','id'), $sendback );
			wp_redirect($sendback); exit();
		break;
	}
?>