<?php
function searchDealCuponReport($filter = array(),$limit = 0,$start = 0)
{
	global  $wpdb;
	$result = array();
	if(isset($filter['deal_id']) && $filter['deal_id'] != "") {
		$query = "SELECT d.*,O.buyer_id,o.description as comment,o.created_at as purcharse_date, s.name as sale_name,m.name as merchant_name,i.name as coupon_serial, i.status as coupon_status FROM "
			.ENMASSE_DEAL.' AS d   INNER JOIN '
			.ENMASSE_ORDER_ITEM.' AS oi ON d.id = oi.unit_id LEFT JOIN '
			.ENMASSE_ORDER.' AS o ON o.id = oi.order_id LEFT JOIN '
			.ENMASSE_SALES_PERSON. ' AS s ON d.sales_person_id = s.id LEFT JOIN '
			.ENMASSE_MERCHANT_BRANCH. ' AS m ON d.merchant_id = m.id LEFT JOIN '
			.ENMASSE_INVTY. ' as i ON d.id = i.unit_id '
			.'WHERE  oi.status = "delivered"';
		$wheres = array();
		if($filter['deal_id'] != "")
		{
			$wheres[] = " AND d.id =".$filter['deal_id'];
		}
		
		if(!empty($wheres)) {
			
			foreach($wheres as $id => $value){
				
				$query = $query.$value;
			}
		}
		
		if($limit != 0 || $start !=0)
		{
			$query = $query." LIMIT ".$limit.",".$start;
		}
		$result = $wpdb->get_results($query);
		
	}
	
	return  $result;
}