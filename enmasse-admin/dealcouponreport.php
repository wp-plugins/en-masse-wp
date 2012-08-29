<?php
$action = $_GET['action']?$_GET['action']:'search';
$ax = array('list' => 'list','pdf' => 'pdf','excel' => 'excel','search' => 'search');
require_once(ENMASSE_ADMIN."/deal-coupon-functions.php");
if(!class_exists('EmSession')) {
	require_once (ENMASSE_ADMIN."/em-session.php");
}
if (!isset($ax[$action])) $action = 'list';
switch ($action) {
	case 'search':
		$em_session = new EmSession();
		$em_session->em_clear_session('p');
		$em_session->em_clear_session('filter');
		if(isset($_GET['pg'])) {
			$p =$_GET['pg'];
		}
		else {
			$p = 1;
		}
		$em_session->em_set_session('p',$p);
		$filter = $_POST['filter'];
		$em_session->em_set_session('filter',$filter);
		$reports = searchDealCuponReport($filter);
		$total = count($reports);
		$itemPerPage = get_option('	posts_per_page',5);
		$limit = ($p - 1) * $itemPerPage;
		$totalposts = $total/$itemPerPage;
		$prev = $p - 1;
		$next = $p + 1;
		$paging = pagination($totalposts,$p,$totalposts-1,$prev,$next,array('page'=>'enmasse_report','action'=>'search')) ;
		$reports = searchDealCuponReport($filter,$limit,$itemPerPage);
			
		require_once(ENMASSE_ADMIN."/deal-coupon-report-list.php");
		break;
	case 'excel':
		$em_session = new EmSession();
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->getProperties()->setCreator("Enmasse Editor");
		// paging
		$filter['deal_id'] = $_GET['dealid'];
		$p = $em_session->em_get_session('p');
		$itemPerPage = get_option('	posts_per_page',5);
		$limit = ($p - 1) * $itemPerPage;
		$itemPerPage = get_option('	posts_per_page',5);
		$limit = ($p - 1) * $itemPerPage;
		$reports = searchDealCuponReport($filter,$limit,$itemPerPage);
		
		
		$j = 1;
		$a = 'A';$b ='B';$c = 'C';$d = 'D' ; $e = 'E' ;$f = 'F'; $g = 'G'; $h = 'H'; 
		$objPHPExcel->setActiveSheetIndex(0);

		$objPHPExcel->getActiveSheet()->SetCellValue($a.$j, 'Buyer Name');
		$objPHPExcel->getActiveSheet()->SetCellValue($b.$j, 'Buyer Email');
		$objPHPExcel->getActiveSheet()->SetCellValue($c.$j, 'Sale Name');
		$objPHPExcel->getActiveSheet()->SetCellValue($d.$j, 'Merchant Name');
		$objPHPExcel->getActiveSheet()->SetCellValue($e.$j, 'Order Comment');
		$objPHPExcel->getActiveSheet()->SetCellValue($f.$j, 'Purchase Date');
		$objPHPExcel->getActiveSheet()->SetCellValue($g.$j, 'Coupon Serial');
		$objPHPExcel->getActiveSheet()->SetCellValue($h.$j, 'Coupon Status');
			
		
		$total_commission_amount = 0;
		foreach ($reports as $report) {
			$j++;
			$buyer  = get_userdata($report->buyer_id);
			$objPHPExcel->getActiveSheet()->SetCellValue($a.$j,$buyer->user_nicename);
			$objPHPExcel->getActiveSheet()->SetCellValue($b.$j,$buyer->user_email);
			$objPHPExcel->getActiveSheet()->SetCellValue($c.$j,$report->sale_name);
			$objPHPExcel->getActiveSheet()->SetCellValue($d.$j,$report->merchant_name);
			$objPHPExcel->getActiveSheet()->SetCellValue($e.$j,$report->comment);
			$objPHPExcel->getActiveSheet()->SetCellValue($f.$j,dateFormat($report->purcharse_date,'d-m-Y'));
			$objPHPExcel->getActiveSheet()->SetCellValue($g.$j,$report->coupon_serial);
			$objPHPExcel->getActiveSheet()->SetCellValue($h.$j,$report->coupon_status);
		}
	
		$objPHPExcel->getActiveSheet()->setTitle('Dealcoupon Reprot');
		$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
		$objWriter->save( ENMASSE_TEMP_PATH.'/dealcoupponreport'.dateFormat().'.xlsx');
		$filepath = ENMASSE_TEMP_PATH.'/dealcoupponreport'.dateFormat().'.xlsx';
		
		// Set headers
		header("Cache-Control: public");
		header("Content-Description: File Transfer");
		header("Content-Disposition: attachment; filename=dealcoupponreport".dateFormat().".xlsx");
		header("Content-Type: application/zip");
		header("Content-Transfer-Encoding: binary");
		readfile($filepath);
		exit;
	case "pdf":
		$filter =array();
		$reports = searchReport($filter);
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
