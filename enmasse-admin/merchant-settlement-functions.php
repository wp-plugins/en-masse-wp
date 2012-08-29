<?php


// update merchant settlement status to Not_Paid_Out or Paid_Out
function  updateSettlementStatus($status = 'Paid_Out',$arrId = array()) {
	global  $wpdb;
	
	#$data = array('settlement_status' => $status);
	$where = " WHERE id IN (".implode(",",$arrId).")";
	$query = "UPDATE ".ENMASSE_INVTY.
			 " SET settlement_status ='".$status."'".$where;
	 
	$wpdb->query($query);
}

function  createReport($data = array()) {
	$objPHPExcel = new PHPExcel();
	$objPHPExcel->getProperties()->setCreator("Enmasse Editor");
	$_j = 1;
	$a = 'A';$b ='B';$c = 'C';$d = 'D' ; $e = 'E' ;$f = 'F'; $g = 'G'; $h = 'H'; $i = 'I';$j='J';
	$objPHPExcel->setActiveSheetIndex(0);
	$objPHPExcel->getActiveSheet()->SetCellValue($a.$_j, 'Coupon ID');
	$objPHPExcel->getActiveSheet()->SetCellValue($b.$_j, 'Deal Code');
	$objPHPExcel->getActiveSheet()->SetCellValue($c.$_j, 'Buyer Name');
	$objPHPExcel->getActiveSheet()->SetCellValue($d.$_j, 'Buyer Email');
	$objPHPExcel->getActiveSheet()->SetCellValue($e.$_j, 'Order Comment');
	$objPHPExcel->getActiveSheet()->SetCellValue($f.$_j, 'Purchase Date');
	$objPHPExcel->getActiveSheet()->SetCellValue($g.$_j, 'Coupon Price');
	$objPHPExcel->getActiveSheet()->SetCellValue($h.$_j, 'Coupon Serial');
	$objPHPExcel->getActiveSheet()->SetCellValue($i.$_j, 'Coupon Status');
	$objPHPExcel->getActiveSheet()->SetCellValue($j.$_j, 'Settlement Status');
	$objPHPExcel->getActiveSheet()->setTitle('Deal Coupon Report Reprot');
	
	foreach ($data as $row) {
		$_j ++;
		$buyer = get_userdata($row->buyer_id);
		$objPHPExcel->getActiveSheet()->SetCellValue($a.$_j,$row->coupon_id);
		$objPHPExcel->getActiveSheet()->SetCellValue($b.$_j,$row->deal_code);
		$objPHPExcel->getActiveSheet()->SetCellValue($c.$_j,$buyer->user_nicename);
		$objPHPExcel->getActiveSheet()->SetCellValue($d.$_j,$buyer->user_email);
		$objPHPExcel->getActiveSheet()->SetCellValue($e.$_j,$row->order_description);
		$objPHPExcel->getActiveSheet()->SetCellValue($f.$_j,dateFormat($row->created_at,'m-d-Y'));
		$objPHPExcel->getActiveSheet()->SetCellValue($g.$_j,$row->unit_price);
		$objPHPExcel->getActiveSheet()->SetCellValue($h.$_j,$row->coupon_serial);
		$objPHPExcel->getActiveSheet()->SetCellValue($i.$_j,$row->coupon_status);
		$objPHPExcel->getActiveSheet()->SetCellValue($j.$_j,$row->coupon_settlement_status);
	}
	$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
	$objWriter->save( ENMASSE_TEMP_PATH.'/commissionreport.xls');
	$filepath = ENMASSE_TEMP_PATH.'/commissionreport.xls';
	return $filepath;
}
function  getMerchantSettlementList($filter =  array(),$limit = 0,$order = 0) {
	global  $wpdb;
	$query = "SELECT oi.*,
					 o.description AS order_description ,
					 o.buyer_id ,
					 i.id AS coupon_id , 
					 i.status AS coupon_status ,
					 i.name AS coupon_serial ,
					 i.settlement_status AS coupon_settlement_status ,
					 d.deal_code AS deal_code
					 FROM ".ENMASSE_ORDER_ITEM." oi INNER JOIN ".
					 		ENMASSE_ORDER." o ON oi.order_id = o.id INNER JOIN ".
					 		ENMASSE_DEAL." d ON oi.unit_id = d.id INNER JOIN ".
					 		ENMASSE_INVTY." i ON oi.id = i.order_item_id WHERE ".
					 		" d.status = 'Confirmed' AND ".
					 		" oi.status IN ('Paid','Delivered')";
	$wheres = array();
	if(isset($filter['merchant_id']) && $filter['merchant_id'] != "") {
		$wheres[] = " AND d.merchant_id = '".$filter['merchant_id']."'";
	}
	if(isset($filter['deal_id']) && $filter['deal_id'] != "") {
		$wheres[] = " AND d.id = '".$filter['deal_id']."'";
	}
	if(isset($filter['set_status']) && $filter['set_status'] != "") {
		$wheres[] = " AND i.settlement_status = '".$filter['set_status']."'";
	}
	if(isset($filter['coupon_id']) && $filter['coupon_id'] != "")
	{
		$wheres[] = " AND i.id IN (".$filter['coupon_id'].")";
	}
	if(! empty( $wheres ) ) {
	
		foreach ($wheres as $where) {
			$query = $query.$where;
		}
	}
	if($limit > 0)	{
		$query = $query. "LIMIT ".$limit.",".$order;
	}
	
	$results = $wpdb->get_results($query);
	return  $results;
}

?>