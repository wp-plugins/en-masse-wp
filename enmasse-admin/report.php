<?php
$action = $_GET['action']?$_GET['action']:'list';
$ax = array('list' => 'list','pdf' => 'pdf','excel' => 'excel','search' => 'search');
require_once(ENMASSE_ADMIN."/report-functions.php");
if (!isset($ax[$action])) $action = 'list'; 
switch ($action) {
	case 'list':
		$em_session = new EmSession();
		$em_session->em_clear_session('filter');
		$em_session->em_clear_session('p');
		$query = "SELECT d.*, s.name as sale_name,m.name as merchant_name FROM "
		.ENMASSE_DEAL.' AS d   INNER JOIN '
		.ENMASSE_ORDER_ITEM.' AS oi ON d.id = oi.order_id LEFT JOIN '
		.ENMASSE_SALES_PERSON. ' AS s ON d.sales_person_id = s.id LEFT JOIN '
		.ENMASSE_MERCHANT_BRANCH. ' AS m ON d.merchant_id = m.id '
		.'WHERE d.cur_sold_qty >0';
		
		if(isset($_GET['pg'])){
			$p =$_GET['pg'];
		}
		else{
			$p = 1;
		}
		$em_session->em_set_session('p',$p);
		$total = $wpdb->get_results($query);
		$itemPerPage = get_option('	posts_per_page',5);
		$limit = ($p - 1) * $itemPerPage;
		$totalposts = $total[0]->count/$itemPerPage;
		$prev = $p - 1;
		$next = $p + 1;
		
		$query =$query.' LIMIT '.$limit.','.$itemPerPage;
		$reports = $wpdb->get_results($query);	
		$paging = pagination($totalposts,$p,$totalposts-1,$prev,$next,array('page'=>'enmasse_report','action'=>'list')) ;
		require_once(ENMASSE_ADMIN."/report-list.php");
		break;
	
	case 'search':
		
		if(isset($_GET['pg'])) {
			$p =$_GET['pg'];
		}
		else {
			$p = 1;
		}
		$em_session = new EmSession();
		$filter = $_POST['filter'];
		$em_session->em_set_session('filter' ,$filter);
		$em_session->em_set_session('p',$p);
		$reports = searchReport($filter);
		$total = count($reports);
		$itemPerPage = get_option('	posts_per_page',5);
		$limit = ($p - 1) * $itemPerPage;
		$totalposts = $total/$itemPerPage;
		$prev = $p - 1;
		$next = $p + 1;
		$paging = pagination($totalposts,$p,$totalposts-1,$prev,$next,array('page'=>'enmasse_report','action'=>'search')) ;
		$reports = searchReport($filter,$limit,$itemPerPage);
		
		require_once(ENMASSE_ADMIN."/report-list.php");
		break;
	case 'excel':
		$em_session = new EmSession();
		$p = $em_session->em_get_session('p');
		
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->getProperties()->setCreator("Enmasse Editor");
		$filter = $em_session->em_get_session('filter');
		
		$reports = searchReport($filter);
		$total = count($reports);
		$itemPerPage = get_option('	posts_per_page',5);
		$limit = ($p - 1) * $itemPerPage;
		
		$reports = searchReport($filter,$limit,$itemPerPage);
		$j = 1;
		$a = 'A';$b ='B';$c = 'C';$d = 'D' ; $e = 'E' ;$f = 'F'; $g = 'G'; $h = 'H'; $i = 'I';
		$objPHPExcel->setActiveSheetIndex(0);
	
		$objPHPExcel->getActiveSheet()->SetCellValue($a.$j, 'Deal Code');
		$objPHPExcel->getActiveSheet()->SetCellValue($b.$j, 'Deal Name');
		$objPHPExcel->getActiveSheet()->SetCellValue($c.$j, 'Sale Person');
		$objPHPExcel->getActiveSheet()->SetCellValue($d.$j, 'Merchant');
		$objPHPExcel->getActiveSheet()->SetCellValue($e.$j, 'Quantity Sold');
		$objPHPExcel->getActiveSheet()->SetCellValue($f.$j, 'Unit Price');
		$objPHPExcel->getActiveSheet()->SetCellValue($g.$j, 'Total Sales');
		$objPHPExcel->getActiveSheet()->SetCellValue($h.$j, 'Commission Percentage');
		$objPHPExcel->getActiveSheet()->SetCellValue($i.$j, 'Total Commission Amount');

		$total_commission_amount = 0;
		foreach ($reports as $report) {
			$j++;
			$total_sales = $report->price * $report->cur_sold_qty;
			$total_amount = ($total_sales * $report->commission_percent) / 100;
			$objPHPExcel->getActiveSheet()->SetCellValue($a.$j,$report->deal_code);
			$objPHPExcel->getActiveSheet()->SetCellValue($b.$j,$report->name);
			$objPHPExcel->getActiveSheet()->SetCellValue($c.$j,$report->sale_name);
			$objPHPExcel->getActiveSheet()->SetCellValue($d.$j,$report->merchant_name);
			$objPHPExcel->getActiveSheet()->SetCellValue($e.$j,$report->cur_sold_qty);
			$objPHPExcel->getActiveSheet()->SetCellValue($f.$j,$report->price);
			$objPHPExcel->getActiveSheet()->SetCellValue($g.$j,$total_sales);
			$objPHPExcel->getActiveSheet()->SetCellValue($h.$j,$report->commission_percent);
			$objPHPExcel->getActiveSheet()->SetCellValue($i.$j, $total_amount);
			$total_commission_amount = $total_commission_amount + $total_amount;
		
		}
		$j++;
		$objPHPExcel->getActiveSheet()->SetCellValue($h.$j,'Total');
		$objPHPExcel->getActiveSheet()->SetCellValue($i.$j, $total_commission_amount);
		$objPHPExcel->getActiveSheet()->setTitle('Commission Reprot');
		$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
		$objWriter->save( ENMASSE_TEMP_PATH.'/commissionreport.xlsx');
		$filepath = ENMASSE_TEMP_PATH.'/commissionreport.xlsx';
		// Set headers
		header("Cache-Control: public");
		header("Content-Description: File Transfer");
		header("Content-Disposition: attachment; filename=commissionreport.xlsx");
		header("Content-Type: application/zip");
		header("Content-Transfer-Encoding: binary");
		
		// Read the file from disk
		readfile($filepath);
		exit;
	case "pdf":
		$em_session = new EmSession();
		$p = $em_session->em_get_session('p');
		$filter = $em_session->em_get_session('filter');
		$reports = searchReport($filter);
		
		$total = count($reports);
		$itemPerPage = get_option('	posts_per_page',5);
		$limit = ($p - 1) * $itemPerPage;
		$reports = searchReport($filter,$limit,$itemPerPage);
		
		$result = '<table style="border:1px dotted #D5D5D5; border-collapse: collapse;"><tr valign="middle"><th style="border:1px dotted #D5D5D5;" align="center" width="30">'
						."No".'</th><th style="border:1px dotted #D5D5D5;" align="center" width="80">'
						."Deal Code".'</th><th style="border:1px dotted #D5D5D5;" align="center" width="80">'
						."Merchant".'</th><th style="border:1px dotted #D5D5D5;" align="center" width="60">'
						."Sale Person".'</th><th style="border:1px dotted #D5D5D5;" align="center" width="60">'
						."Qty Sold".'</th><th style="border:1px dotted #D5D5D5;" align="center" width="80">'
						."Unit Price".'</th><th style="border:1px dotted #D5D5D5;" align="center" width="80">'
						."Total Sales".'</th><th style="border:1px dotted #D5D5D5;" align="center" width="80">'
						."Commission Percentage".'</th><th style="border:1px dotted #D5D5D5;" align="left" width="150">'
						."Total Commission Amount".'</th></tr>';
						$i = 0;
						$total_commission_amount = 0;
						foreach ($reports as $report)
						{
								
							$i++;
							$total_sales = $report->price * $report->cur_sold_qty;
							$total_amount = ($total_sales * $report->commission_percent) / 100;
							$result .= '<tr>
							<td style="border:1px dotted #D5D5D5;" align="center">'.$i.'</td>
							<td style="border:1px dotted #D5D5D5;">'.$report->deal_code.'</td>
							<td style="border:1px dotted #D5D5D5;">'.$report->merchant_name.'</td>
							<td style="border:1px dotted #D5D5D5;">'.$report->merchant_name.'</td>
							<td style="border:1px dotted #D5D5D5;" align="center">'.$report->cur_sold_qty.'</td>
							<td style="border:1px dotted #D5D5D5;" align="center">'.$report->price.'</td>
							<td style="border:1px dotted #D5D5D5;" align="center">'.$total_sales.'</td>
							<td style="border:1px dotted #D5D5D5;" align="center">'.$report->commission_percent.' % </td>
							<td style="border:1px dotted #D5D5D5;" align="center">'.$total_amount.'</td></tr>';
							$total_commission_amount += $total_amount;
						}
						$result .= '<tr><td style="border-right:1px dotted #D5D5D5; text-align:right" colspan="8"   >Total: </td>
						<td style="border:1px dotted #D5D5D5;" align="center" align="center">' .$total_commission_amount. '</td></tr></table>';
					
		$html2pdf = new HTML2PDF('P', 'A4', 'en');
		$html2pdf->setDefaultFont('Arial');
		$html2pdf->writeHTML($result);
		$outFileName = 'report-' .date_i18n('d-m-Y').'.pdf';
		$html2pdf->Output($outFileName,'I');
		header("Content-Disposition:attachment;filename=downloaded.pdf");
		exit;
}
?>