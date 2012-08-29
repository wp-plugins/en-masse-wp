<?php
function searchReport($filter = array(),$limit = 0,$start = 0)
{
	global  $wpdb;

	$query = "SELECT d.*, s.name as sale_name,m.name as merchant_name FROM "
		.ENMASSE_DEAL.' AS d   INNER JOIN '
		.ENMASSE_ORDER_ITEM.' AS oi LEFT JOIN '
		.ENMASSE_SALES_PERSON. ' AS s ON d.sales_person_id = s.id LEFT JOIN '
		.ENMASSE_MERCHANT_BRANCH. ' AS m ON d.merchant_id = m.id '
		.'WHERE d.id = oi.order_id AND d.cur_sold_qty >0';
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
	if($filter['saleperson_id'] != "") {
		$wheres[] = " d.sales_person_id = '".trim($filter['saleperson_id'])."' ";
	}
	if($filter['merchant_id'] != "") {
		$wheres[] = " d.merchant_id = '".trim($filter['merchant_id'])."' ";
	}
	
	
	if($filter['fromdate'] !="")
	{
		$wheres[] = "d.start_at >= '".dateFormat($filter['fromdate'],'Y-m-d H:i:s')."'";
	}
	if($filter['todate'] !="")
	{
		$wheres[] = "d.end_at <='".dateFormat($filter['todate'],'Y-m-d H:i:s')."'";
	}
	if(!empty($wheres)) {
		$query = $query." AND ";
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