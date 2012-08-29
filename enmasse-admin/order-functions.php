<?php
function getStatusButton($oderStatus = "Pending")
{		
	$waitting = '';
	$refuned ='';
	$delivered ='';
	$canclled='';
	$paid = '';
	$cancelled='';
	switch ($oderStatus):
	case "Partial Paid": $waitting = "Waiting for refund";$refuned="Refunded";$delivered = "Delivered"; break;
	case "Paid": $waitting = "Waiting for refund";$refuned="Refunded";$delivered = "Delivered"; break;
	case "Delivered": $waitting = "Waiting for refund";$refuned="Refunded";  break;
	case"Waiting for refund":$refuned="Refunded"; break;
	case"Cancelled":break;
	default:
		$paid = "Paid";$canclled="Cancelled";
	endswitch;
	$html = '';
	if($waitting != ''):
		$waitting = '<lable for="sttWatting" >'.$waitting.'</lable><input id="sttWatting" name="status" type="radio"  value="'.$waitting.'" class="rad">';
		$html = $html.$waitting;
	endif;
	if($refuned != ''):
		$refuned = '<lable for="sttRefurn" >'.$refuned.'</lable><input id="sttRefurn" name="status" type="radio"  value="'.$refuned.'" class="rad">';
		$html = $html.$refuned;
	endif;
	if($delivered != ''):
		$delivered = '<lable for="sttDelivered" >'.$delivered.'</lable><input id="sttDelivered" name="status" type="radio"  value="'.$delivered.'" class="rad">';
		$html = $html.$delivered;
	endif;
	if($paid != ''):		
		$paid = '<lable for="sttPaid" >'.$paid.'</lable><input id="sttPaid" name="status" type="radio"   value="'.$paid.'" class="rad">';
		$canclled = '<lable for="sttCancelled" >'.$canclled.'</lable><input id="sttCancelled" name="status" type="radio"  value="'.$canclled.'" class="rad">';
		$html = $html.$paid.$canclled;
	endif;
	return $html;		
}

function searchOrder($filter = array(),$limit = 0,$start = 0)
{
	global  $wpdb;
	
	$query = 'SELECT o.*,d.deal_code,d.name as deal_name,p.name as pay_name from '
	.ENMASSE_ORDER.' AS o INNER JOIN '
	.ENMASSE_ORDER_ITEM.' as i on o.id =i.order_id INNER JOIN '
	.ENMASSE_DEAL.' as d on i.unit_id = d.id LEFT JOIN '
	.ENMASSE_PAY_GATEWAY.' AS p ON o.paygate_id = p.id ';
	$wheres = array();
	if($filter['dealname'] != "") {
		$name = $filter['dealname'];
		$name = strtoupper($name);
		$name = strip_tags($name);
		$name = trim ($name);
		$wheres[] = " d.name 	LIKE '%".$name."%' ";
	}
	if($filter['dealcode'] != "") {
		$dealcodes = explode(" ", $filter['dealcode']);
		if(count($dealcodes) == 1){
			$dealcodes =explode(",", $filter['dealcode']);
		}
		$dealcode = '';
		foreach ($dealcodes as $id => $value)
		{
			$dealcode = $dealcode. "'".$value."'";
			if($id < count($dealcodes)-1) {
				$dealcode = $dealcode. ",";
			}
			
		}
		
		$wheres[] = " d.deal_code IN (".$dealcode.") ";
	}
	if($filter['status'] !="") {
		$wheres[] = " o.status = '".trim($filter['status'])."' ";
	}
	if(!empty($wheres)) {
		$query = $query." WHERE";
		foreach($wheres as $id => $value){
			if($id >0) {
				$query = $query." AND ";
			}
			$query = $query.$value;
		}
	}
	if($limit != 0 || $start !=0)
	{
		$query = $query." LIMIT ".$limit.",".$start;
	}
	$result = $wpdb->get_results($query);
	return  $result;
}