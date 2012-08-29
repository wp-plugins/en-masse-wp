<?php
	$action = $_GET['action']?$_GET['action']:'list';
	$ax = array('list'=>'list','edit'=>'edit','search'=>'search');
	if (!isset($ax[$action])) $action = 'list';
	require_once(ENMASSE_ADMIN."/order-functions.php");
	require_once( _FILE_PATH . '/enmasse_includes/mail.class.php');
	switch ($action) {
		case 'list':
			if(isset($_GET['pg'])){
				$p =$_GET['pg'];
			}
			else{
				$p = 1;
			}
			$query = 'SELECT Count(*) as count from '
					.ENMASSE_ORDER.' AS o INNER JOIN '
					.ENMASSE_PAY_GATEWAY.' AS p ON o.paygate_id = p.id LEFT JOIN '
					.ENMASSE_ORDER_ITEM.' as i on o.id =i.order_id INNER JOIN '
					.ENMASSE_DEAL.' as d on i.unit_id = d.id';
			$total = $wpdb->get_results($query);
			
			$itemPerPage = get_option('	posts_per_page',5);
			$limit = ($p - 1) * $itemPerPage;
			$totalposts = $total[0]->count/$itemPerPage;
			$prev = $p - 1;
			$next = $p + 1;
			//pagination
			$query = 'SELECT o.*,d.deal_code,d.name as deal_name,p.name as pay_name from '
					.ENMASSE_ORDER.' o INNER JOIN '
					.ENMASSE_ORDER_ITEM.' i ON o.id = i.order_id LEFT JOIN '
					.ENMASSE_PAY_GATEWAY.' p ON o.paygate_id = p.id INNER JOIN '
					.ENMASSE_DEAL.' d ON i.unit_id = d.id  ORDER BY o.ID DESC LIMIT '.$limit.','.$itemPerPage;
			$paging = pagination($totalposts,$p,$totalposts-1,$prev,$next,array('page'=>'enmasse_order','action'=>'list')) ;
			$orders = $wpdb->get_results($query);
			require_once(ENMASSE_ADMIN."/order-list.php");
			break;
		case 'edit':
			if (isset($_POST['submit'])):
			$data = array(
			"description" => esc_html($_POST['order-description']),
			"status" => esc_html($_POST['status']),
			"updated_at" => date('Y-m-d g:i:s A')
			);
			$order_item = array(
					"status" => esc_html($_POST['status']),
					"updated_at" => date('Y-m-d g:i:s A')
			);
			$wpdb->update(ENMASSE_ORDER, $data,array('id'=>$_REQUEST['id']));
			
			$wpdb->update(ENMASSE_ORDER_ITEM, $order_item,array('order_id'=>$_REQUEST['id']));
			
			if(esc_html($_POST['status']) == "Delivered"){
				$deal_id = esc_html($_POST['deal-id']);
				$unit_qty = esc_html($_POST['unit_qty']);
				$deal = $wpdb->get_results('SELECT cur_sold_qty, min_needed_qty, status FROM '.ENMASSE_DEAL.' WHERE id = "'.$deal_id.'"');
				$deal = $deal[0];
				$new_sold_qty = (int)$deal->cur_sold_qty + $unit_qty;
				if($deal->status != 'Confirmed'):
					if($new_sold_qty < (int)$deal->min_needed_qty){
						$wpdb->update(ENMASSE_DEAL,array('cur_sold_qty'=>$new_sold_qty),array('id'=>$deal_id));
					}else{
						$wpdb->update(ENMASSE_DEAL,array('cur_sold_qty'=>$new_sold_qty,'status'=>'Confirmed'),array('id'=>$deal_id));
						
						$orders = $wpdb->get_results("SELECT d.name AS deal_name, o.id AS order_id, u.user_email, u.display_name, o.delivery FROM ".ENMASSE_ORDER." o INNER JOIN ".ENMASSE_ORDER_ITEM." i INNER JOIN ".ENMASSE_DEAL." d INNER JOIN ".$wpdb->prefix."users u ON o.id = i.order_id AND i.unit_id = d.id AND o.buyer_id = u.ID WHERE d.id = ".$deal_id);
						foreach($orders as $order){
							$mailObj = new Enmasse_Mail();
							$delivery = json_decode($order->delivery,true);
							if($delivery[0] == null):
								$mailObj->sendConfirmDealBuyermail($order->user_email, $order->order_id, $order->deal_name, $order->display_name,$order->display_name,$order->user_email);
								$mailObj->sendConfirmDealReceivermail($order->user_email, $order->order_id, $order->deal_name, $order->display_name, $order->display_name, "", "#");
							else:
								$mailObj->sendConfirmDealBuyermail($order->user_email, $order->order_id, $order->deal_name, $order->display_name,$delivery[0],$delivery[1]);
								$mailObj->sendConfirmDealReceivermail($order->user_email, $order->order_id, $order->deal_name, $order->display_name, $delivery[0], "", "#");
							endif;
						}
					}
				else:
					$wpdb->update(ENMASSE_DEAL,array('cur_sold_qty'=>$new_sold_qty),array('id'=>$deal_id));
				endif;
			}
			if(esc_html($_POST['status']) == "Cancelled"){
				$order = $wpdb->get_results("SELECT d.name AS deal_name, o.id AS order_id, u.user_email, u.display_name, o._refund as refundAmt FROM ".ENMASSE_ORDER." o INNER JOIN ".ENMASSE_ORDER_ITEM." i INNER JOIN ".ENMASSE_DEAL." d INNER JOIN ".$wpdb->prefix."users u ON o.id = i.order_id AND i.unit_id = d.id AND o.buyer_id = u.ID WHERE o.id = ".$_REQUEST['id']);
				$order = $order[0];
				$mailObj = new Enmasse_Mail();
				$mailObj->sendVoidDealmail($order->user_email, $order->display_name, $order->order_id, $order->deal_name, $order->refundAmt);
			}
			if(esc_html($_POST['status']) == "Paid"){
				$deal_id = esc_html($_POST['deal-id']);
				$deal = $wpdb->get_results('SELECT status FROM '.ENMASSE_DEAL.' WHERE id = "'.$deal_id.'"');
				$deal = $deal[0];
				if($deal->status == "Confirmed"){
					$order = $wpdb->get_results("SELECT d.name AS deal_name, o.id AS order_id, u.user_email, u.display_name, o._refund as refundAmt FROM ".ENMASSE_ORDER." o INNER JOIN ".ENMASSE_ORDER_ITEM." i INNER JOIN ".ENMASSE_DEAL." d INNER JOIN ".$wpdb->prefix."users u ON o.id = i.order_id AND i.unit_id = d.id AND o.buyer_id = u.ID WHERE o.id = ".$_REQUEST['id']);
					$order = $order[0];
					$mailObj = new Enmasse_Mail();
					$delivery = json_decode($order->delivery,true);
					if($delivery[0] == null):
						$mailObj->sendConfirmDealReceivermail($order->user_email, $order->order_id, $order->deal_name, $order->display_name, $order->display_name, "", "#");
					else:
						$mailObj->sendConfirmDealReceivermail($order->user_email, $order->order_id, $order->deal_name, $order->display_name, $delivery[0], "", "#");
					endif;
				}
			}
			$sendback = add_query_arg(array('page'=>'enmasse_order','updated'=>1,'action'=>'list'));
			$sendback = remove_query_arg( array('noheader'), $sendback );
			wp_redirect($sendback); exit();
			endif;
			$query = 'SELECT o.*,d.id as deal_id,d.name as deal_name,i.*,p.name as pay_name from '
			.ENMASSE_ORDER.' AS o INNER JOIN '
			.ENMASSE_ORDER_ITEM.' as i on o.id = i.order_id INNER JOIN '
			.ENMASSE_DEAL.' as d on i.unit_id = d.id LEFT JOIN '
			.ENMASSE_PAY_GATEWAY.' AS p ON o.paygate_id = p.id '
			.' WHERE o.ID ='.$_REQUEST['id'];
			$order = $wpdb->get_results($query);
			$order = $order[0];
			require_once(ENMASSE_ADMIN."/order-edit.php");
			break;
		case 'search':
			
			//paging nation
			
			if(isset($_GET['pg'])){
				$p =$_GET['pg'];
			}
			else{
				$p = 1;
			}
			$filter = $_POST['filter'];
		
			$orders = searchOrder($filter);
			$total = count($orders);
			$itemPerPage = get_option('	posts_per_page',5);
			$limit = ($p - 1) * $itemPerPage;
			$totalposts = $total/$itemPerPage;
			$prev = $p - 1;
			$next = $p + 1;
			
			$paging = pagination($totalposts,$p,$totalposts-1,$prev,$next,array('page'=>'enmasse_order','action'=>'search')) ;
			$orders =searchOrder($filter,$limit,$itemPerPage);
			require_once(ENMASSE_ADMIN."/order-list.php");
			break;
	}