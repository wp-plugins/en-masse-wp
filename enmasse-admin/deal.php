<?php

	$action = $_GET['action']?$_GET['action']:'list';
	if(isset($_REQUEST['change_satus']))
	{
		$action = 'change_satus';
	}
	$ax = array('change_satus'=>'change_satus','list'=>'list','add'=>'add','edit'=>'edit','delete'=>'delete','preview'=>'preview');
	if (!isset($ax[$action])) $action = 'list';		
	require_once(ENMASSE_ADMIN."/deal-functions.php");
	switch ($action) {
		
		case 'list':	
			if(isset($_GET['pg'])){
				$p =$_GET['pg'];
			}
			else{
				$p = 1;
			}
			$query = 'SELECT Count(*) as count from '.ENMASSE_DEAL;
			$total = $wpdb->get_results($query);
			$itemPerPage = get_option('	posts_per_page',5);
			$limit = ($p - 1) * $itemPerPage;
			$totalposts = $total[0]->count/$itemPerPage;
			$prev = $p - 1;
			$next = $p + 1;
			//pagination
			if(isset($_REQUEST['userID']))
				$query = 'SELECT a.*,u.name AS uname FROM ' . ENMASSE_DEAL . ' a LEFT JOIN  ' . ENMASSE_SALES_PERSON . ' u ON a.sales_person_id = u.id WHERE u.user_id = '.$_REQUEST['userID'].' ORDER BY a.id DESC LIMIT '.$limit.','.$itemPerPage;
			else
				$query = 'SELECT a.*,u.name AS uname FROM ' . ENMASSE_DEAL . ' a LEFT JOIN  ' . ENMASSE_SALES_PERSON . ' u ON a.sales_person_id = u.id ORDER BY a.id DESC LIMIT '.$limit.','.$itemPerPage;
			$paging = pagination($totalposts,$p,$totalposts-1,$prev,$next,array('page'=>'enmasse_deal','action'=>'list')) ;
			$deals = $wpdb->get_results($query);		
			session_unregister('data');
			require_once(ENMASSE_ADMIN."/deal-list.php");
		break;
		case 'add':
		   	if (isset($_POST['submit'])):
				$data = array("name" => esc_html($_POST['deal-name']),
							"slug_name"=>makeSlug(esc_html($_POST['deal-name'])),
							"deal_code" =>getNewDealCode(),
							"description"=>$_POST['deal-description'],	
							"short_desc"=>$_POST['deal-sort-description'],
							"highlight"=>$_POST['deal-highlights'],
							"terms"=>$_POST['deal-terms'],
							"origin_price" =>esc_html($_POST['deal-origin-price']),
							"price" =>esc_html($_POST['deal-price']),
							"start_at" => dateFormat(esc_html($_POST['deal-start-at']),"Y-m-d H:i:s"),
							"end_at" => dateFormat(esc_html($_POST['deal-end-at']),"Y-m-d H:i:s"),
							"min_needed_qty" =>esc_html($_POST['deal-min-needed-qty']),
							"max_buy_qty" =>esc_html($_POST['deal-max-buy-qty']) ,
							"max_coupon_qty" => esc_html($_POST['deal-max-coupon-qty']),
							"sales_person_id" =>esc_html($_POST['deal-sale-person-id']),
							"merchant_id" =>esc_html($_POST['deal-merchant-id']),
							"prepay_percent" =>esc_html($_POST['deal-prepay-percen']),
							"commission_percent" => esc_html($_POST['deal-commission-percent']),
							"published" => esc_html($_POST['published']),	
							"auto_confirm" =>esc_html($_POST['confirm']),
							"created_at" => date('Y-m-d g:i:s A'),
							"updated_at" => date('Y-m-d g:i:s A')
					);
				if($_POST['submit'] == 'Preview')
					$data['status'] = 'Preview';
				else
					$data['status'] = status_of_deal(dateFormat(esc_html($_POST['deal-start-at']),"Y-m-d H:i:s"),dateFormat(esc_html($_POST['deal-end-at']),"Y-m-d H:i:s"));
					
				$cats = $_POST['deal-cat'];
				$locs = $_POST['deal-loc'];
				session_register('data');
				$_SESSION['data'] = $data;
				
				if($_POST['deal-merchant-id'] == 0){
					$sendback = add_query_arg(array('page'=>'enmasse_deal','message'=>'You must select a merchant'));
					$sendback = remove_query_arg( array('noheader'), $sendback );
					wp_redirect($sendback); exit();	
				}else if($_POST['deal-sale-person-id'] == 0){
					$sendback = add_query_arg(array('page'=>'enmasse_deal','message'=>'You must select a sale person'));
					$sendback = remove_query_arg( array('noheader'), $sendback );
					wp_redirect($sendback); exit();	
				}else if(empty($_POST['deal-loc'])){
					$sendback = add_query_arg(array('page'=>'enmasse_deal','message'=>'You must select location'));
					$sendback = remove_query_arg( array('noheader'), $sendback );
					wp_redirect($sendback); exit();	
				}else if($_POST['deal-price'] > $_POST['deal-origin-price']){
					$sendback = add_query_arg(array('page'=>'enmasse_deal','message'=>'Price cannot be greater than Original Price'));
					$sendback = remove_query_arg( array('noheader'), $sendback );
					wp_redirect($sendback); exit();	
				}else if(dateFormat(esc_html($_POST['deal-start-at']),"Y-m-d H:i:s") > dateFormat(esc_html($_POST['deal-end-at']),"Y-m-d H:i:s")){
					$sendback = add_query_arg(array('page'=>'enmasse_deal','message'=>'End date should be greater than Start date '));
					$sendback = remove_query_arg( array('noheader'), $sendback );
					wp_redirect($sendback); exit();	
				}else if(dateFormat(esc_html($_POST['deal-end-at']),"Y-m-d H:i:s")< dateFormat(date("Y-m-d H:i:s"),"Y-m-d H:i:s")) {
					
					$sendback = add_query_arg(array('page'=>'enmasse_deal','message'=>'Start Date should not be less than today'));
					$sendback = remove_query_arg( array('noheader'), $sendback );
					wp_redirect($sendback); exit();	
				}
				else{
					$wpdb->insert(ENMASSE_DEAL,$data);
					$dealId = $wpdb->insert_id;
					
					if($dealId !== 0 && !empty($cats))
					{
						foreach($cats as $id => $value)
						{   
							$data = array();
							$data["deal_id"] = $dealId;
							$data["category_id"] = $value;
							$wpdb ->insert(ENMASSE_DEAL_CATEGORY,$data);
						}
					}
					foreach($locs as $id => $value )
					{
						$data = array();
						$data["deal_id"] = $dealId;
						$data["location_id"] = $value;
						$wpdb->insert(ENMASSE_DEAL_LOCATION,$data);
					}					
					session_unregister('data');
					if($_POST['submit'] == 'Preview')
						$sendback = add_query_arg(array('page'=>'enmasse_deal','added'=>1,'did'=>base64_encode($dealId)));
					else
						$sendback = add_query_arg(array('page'=>'enmasse_deal','added'=>1));
					$sendback = remove_query_arg( array('noheader'), $sendback );
					wp_redirect($sendback); exit();	
				}
			endif;
			require_once(ENMASSE_ADMIN."/deal-add.php");
		break;
		case 'edit':
			if (isset($_POST['submit'])):
				$data = array("name" => esc_html($_POST['deal-name']),
							"slug_name"=>makeSlug(esc_html($_POST['deal-name'])),
							"deal_code" =>getNewDealCode(),
							"description"=>$_POST['deal-description'],	
							"short_desc"=>$_POST['deal-sort-description'],
							"highlight"=>$_POST['deal-highlights'],
							"terms"=>$_POST['deal-terms'],
							"origin_price" =>esc_html($_POST['deal-origin-price']),
							"price" =>esc_html($_POST['deal-price']),
							"start_at" => dateFormat(esc_html($_POST['deal-start-at']),"Y-m-d H:i:s"),
							"end_at" => dateFormat(esc_html($_POST['deal-end-at']),"Y-m-d H:i:s"),
							"min_needed_qty" =>esc_html($_POST['deal-min-needed-qty']),
							"max_buy_qty" =>esc_html($_POST['deal-max-buy-qty']) ,
							"max_coupon_qty" => esc_html($_POST['deal-max-coupon-qty']),
							"sales_person_id" =>esc_html($_POST['deal-sale-person-id']),
							"merchant_id" =>esc_html($_POST['deal-merchant-id']),
							"prepay_percent" =>esc_html($_POST['deal-prepay-percen']) ,
							"commission_percent" => esc_html($_POST['deal-commission-percent']),
							"published" => esc_html($_POST['published']),	
							"auto_confirm" =>esc_html($_POST['confirm']),
							"updated_at" => date('Y-m-d g:i:s A')
				);
				if($_POST['submit'] == 'Preview')
					$data['status'] = 'Preview';
				else
					$data['status'] = status_of_deal(dateFormat(esc_html($_POST['deal-start-at']),"Y-m-d H:i:s"),dateFormat(esc_html($_POST['deal-end-at']),"Y-m-d H:i:s"));
				
				$cats = $_POST['deal-cat'];
				$locs = $_POST['deal-loc'];
				session_register('data');
				$_SESSION['data'] = $data;
				
				if($_POST['deal-merchant-id'] == 0){
					$sendback = add_query_arg(array('page'=>'enmasse_deal','message'=>'You must select a merchant'));
					$sendback = remove_query_arg( array('noheader'), $sendback );
					wp_redirect($sendback); exit();	
				}else if($_POST['deal-sale-person-id'] == 0){
					$sendback = add_query_arg(array('page'=>'enmasse_deal','message'=>'You must select a sale person'));
					$sendback = remove_query_arg( array('noheader'), $sendback );
					wp_redirect($sendback); exit();	
				}else if(empty($_POST['deal-loc'])){
					$sendback = add_query_arg(array('page'=>'enmasse_deal','message'=>'You must select location'));
					$sendback = remove_query_arg( array('noheader'), $sendback );
					wp_redirect($sendback); exit();	
				}else if($_POST['deal-price'] > $_POST['deal-origin-price']){
					$sendback = add_query_arg(array('page'=>'enmasse_deal','message'=>'Price cannot be greater than Original Price'));
					$sendback = remove_query_arg( array('noheader'), $sendback );
					wp_redirect($sendback); exit();	
				}else if(dateFormat(esc_html($_POST['deal-start-at']),"Y-m-d H:i:s") > dateFormat(esc_html($_POST['deal-end-at']),"Y-m-d H:i:s")){
					$sendback = add_query_arg(array('page'=>'enmasse_deal','message'=>'End date should be greater than Start date '));
					$sendback = remove_query_arg( array('noheader'), $sendback );
					wp_redirect($sendback); exit();	
				}
				else{				
					$wpdb->update(ENMASSE_DEAL, $data,array('id'=>$_REQUEST['id']));
					// save cataglory and location
					$wpdb ->query("DELETE FROM ".ENMASSE_DEAL_CATEGORY." WHERE deal_id = ".$_REQUEST['id']);
					$wpdb ->query("DELETE FROM ".ENMASSE_DEAL_LOCATION." WHERE deal_id = ".$_REQUEST['id']);
					
					if(!empty($cats))
					{
						foreach($cats as $id => $value)
						{   
							$data = array();
							$data["deal_id"] = $_REQUEST['id'];
							$data["category_id"] = $value;
							$wpdb ->insert(ENMASSE_DEAL_CATEGORY,$data);
						}
					}
						foreach($locs as $id => $value )
						{
							$data = array();
							$data["deal_id"] = $_REQUEST['id'];
							$data["location_id"] = $value;
							$wpdb->insert(ENMASSE_DEAL_LOCATION,$data);
						}	
					session_unregister('data');
					if($_POST['submit'] == 'Preview')
						$sendback = add_query_arg(array('page'=>'enmasse_deal','updated'=>1,'did'=>base64_encode($_REQUEST['id'])));
					else
						$sendback = add_query_arg(array('page'=>'enmasse_deal','updated'=>1));
					$sendback = remove_query_arg( array('noheader'), $sendback );
					wp_redirect($sendback); exit();	
				}
			endif;
			global $deal,$cats,$locs; 
			
			//get deal
			$query ='SELECT d.* FROM ' . ENMASSE_DEAL. ' d WHERE d.id='.intval(esc_html($_GET['id']));
			$deal = $wpdb->get_results($query);
			$deal = $deal[0];
			
			//get categlory
			$wpdb -> show_errors();
			$query = 'SELECT c.category_id AS id  FROM '.ENMASSE_DEAL_CATEGORY.' c WHERE deal_id = '.$_GET['id'];
			$catx = $wpdb -> get_results($query);
			foreach ($catx as $cat)
			{
				$cats[$cat->id] = $cat->id;
			}
			// get location
			$query = 'SELECT l.location_id  AS id FROM '.ENMASSE_DEAL_LOCATION.' l WHERE l.deal_id = '.$_GET['id'];
			$locx = $wpdb -> get_results($query);
			
			foreach ($locx as $loc)
			{
				$locs[$loc->id] = $loc->id;
			}
			
			require_once(ENMASSE_ADMIN."/deal-edit.php");
		break;
		case 'delete':
			
			if (is_array($_REQUEST['id']))
				$dstring = implode(",",$_REQUEST['id']);
			else $dstring = $_REQUEST['id'];
			$delete = "DELETE FROM ". ENMASSE_DEAL. " WHERE id IN (" . $dstring . ")";
			$result = $wpdb->query( $delete );
			$sendback = add_query_arg(array('page'=>'enmasse_deal','updated'=>count($_REQUEST['id'])));
			$sendback = remove_query_arg( array('action', 'action2','noheader','id'), $sendback );
			wp_redirect($sendback); exit();
		break;
		case 'change_satus':
			if (isset($_REQUEST['change_satus'])){
				if (is_array($_REQUEST['id']))
					$dstring = implode(",",$_REQUEST['id']);
				else $dstring = $_REQUEST['id'];
				
				$status = $_REQUEST['dealstatus'];
				$canChange = checkPrivousStatus($status, $dstring);
				if($canChange) {
					setDealStatus($status, $dstring);
					do_send_mail($status, $dstring);
					$sendback = add_query_arg(array('page'=>'enmasse_deal','updated'=>count($_REQUEST['id'])));
					$sendback = remove_query_arg( array('action', 'action2','noheader','id','change_satus'), $sendback );
					wp_redirect($sendback); exit();
				}
				else 
				{	
					$sendback = add_query_arg(array('page'=>'enmasse_deal'));
					$sendback = remove_query_arg( array('action', 'action2','noheader','id','change_satus'), $sendback );
					wp_redirect($sendback); exit();
				}
			
			}
			break;
		
	
	}
