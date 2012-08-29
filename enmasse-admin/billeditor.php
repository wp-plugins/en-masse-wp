<?php
	$action = $_GET['action']?$_GET['action']:'list';
	$ax = array('list'=>'list','edit'=>'edit','preview'=>'preview');
	if (!isset($ax[$action])) $action = 'list';
	switch ($action) {
		case 'list':
			if(isset($_GET['pg'])){
				$p =$_GET['pg'];
			}
			else{
				$p = 1;
			}
			$query = 'SELECT Count(*) as count from '.ENMASSE_BILL_TEMPLATE;
			$total = $wpdb->get_results($query);
			$itemPerPage = get_option('posts_per_page',5);
			$limit = ($p - 1) * $itemPerPage;
			$totalposts = $total[0]->count/$itemPerPage;
			$prev = $p - 1;
			$next = $p + 1;
			$query = 'SELECT * FROM '.ENMASSE_BILL_TEMPLATE.' ORDER BY ID DESC LIMIT '.$limit.','.$itemPerPage;
			$paging = pagination($totalposts,$p,$totalposts-1,$prev,$next,array('page'=>'enmasse_billeditor','action'=>'list')) ;
			$bills = $wpdb->get_results($query);
			require_once(ENMASSE_ADMIN."/billeditor-list.php");
		break;
		case 'edit':
			if(isset($_POST['submit'])):
				$data = array(	"content" => $_POST['content'],
							  	"updated_at" => date('Y-m-d g:i:s A',time()+7*3600)
				);
		   		$wpdb->update(ENMASSE_BILL_TEMPLATE,$data,array('id'=>$_REQUEST['id']));
				$sendback = add_query_arg(array('updated'=>1));
				$sendback = remove_query_arg( array('noheader'), $sendback );
				wp_redirect($sendback); exit();
			endif;
			global $bill;
			$query ='SELECT bt.* FROM ' . ENMASSE_BILL_TEMPLATE . ' bt WHERE bt.id='.intval(esc_html($_GET['id']));
			$bill = $wpdb->get_results($query);
			$bill = $bill[0];
			require_once(ENMASSE_ADMIN."/billeditor-edit.php");
		break;
		case 'preview':
			$order = $wpdb->get_results("SELECT o.id as order_id,o.buyer_id, d.id as deal_id, d.name as deal_name, ot.unit_price, ot.total_price, ot.unit_qty, p.name, o.description
									FROM ".ENMASSE_ORDER." o, ".ENMASSE_ORDER_ITEM." ot, ".ENMASSE_DEAL." d, ".ENMASSE_PAY_GATEWAY." p
									WHERE ot.order_id = o.id
									AND ot.unit_id = d.id
									AND o.paygate_id = p.id
									LIMIT 0 , 30");
			
			$sOderDetail = '<table border="1"><tr valign="middle"><th align="center" style="width:30px;">
							No</th><th style="width:60px;">
							Quantity</th><th style="width:50px;">
							Deal ID</th><th align="center" style="width:320px; ">
							Description</th><th style="width:50px;">
							Unit Price</th><th style="width:50px;">
							Tax</th><th style="width:80px;">
							Total</th></tr>';
							
			$sOderDetail .= '<tr valign="middle"><td align="center">
								1</td><td align="center">'
								.$order[0]->unit_qty.'</td><td align="center">'
								.$order[0]->deal_id.'</td><td style="width:300px;text-align: left">'
								.$order[0]->deal_name.'</td><td align="center">'
								.$order[0]->unit_price.'</td><td align="center">'
								. '</td><td align="center">'
								.$order[0]->total_price.'</td></tr>';
										
			$sOderDetail .= '<tr><td colspan="7" style="text-align:right" >Total Amount: ' .$order[0]->total_price. '</td></tr></table>';
			
			$billtemp = $wpdb->get_results("SELECT *
										FROM ".ENMASSE_BILL_TEMPLATE."
										WHERE id=1");
										
			$content .= str_replace('\"', '"',$billtemp[0]->content);
			$user = get_user_by('id',$order[0]->buyer_id);
			$arParam = array();
			$arParam['[BUYER_NAME]'] = $user->first_name." ".$user->last_name;
			$arParam['[BUYER_EMAIL]'] = $user->user_email;
			$arParam['[BILL_NUMBER]'] = $order[0]->order_id;
			$arParam['[BILL_DATE]'] = date('Y-m-d g:i:s A',time()+7*3600);
			$arParam['[PAYMENT_METHOD]'] = $order[0]->name;
			$arParam['[BILL_DETAIL]'] = $sOderDetail;
			$arParam['[BILL_DESCRIPTION]'] = $order[0]->description;

			$arSearch = array_keys($arParam);
			$content = str_replace($arSearch, $arParam,$content);
			
			$html2pdf = new HTML2PDF('P','A4','en');
			$html2pdf->setDefaultFont('Arial');
			$html2pdf->WriteHTML($content);		
			$html2pdf->Output('bill_preview.pdf','D');
			exit;
			
		break;
	}
?>