<?php
$action = $_GET['action']?$_GET['action']:'search';
$ax = array('changestatus'=>'changestatus','search'=>'search','payout'=>'payout','nopayout'=>'nopayout','dowload' => 'dowload');
if (!isset($ax[$action])) $action = 'search';

require_once(ENMASSE_LIB."/PHPExcel/PHPExcel.php");
require_once(ENMASSE_ADMIN."/merchant-settlement-functions.php");
require_once (ENMASSE_ADMIN."/em-session.php");
switch ($action) {
		
		case 'search':
			$filters = array();
			if(isset($_POST['filter'])) {
				$filters = $_POST['filter'];
			}
			
			if(isset($_GET['pg'])) {
				$p =$_GET['pg'];
			}
			else {
				$p = 1;
			}
			
			$merchants = getMerchantSettlementList($filters); 
			$total = count($merchants);
			$itemPerPage = get_option('posts_per_page',5);
			$limit = ($p - 1) * $itemPerPage;
			$totalposts = $total/$itemPerPage;
			$merchants = getMerchantSettlementList($filters,$limit,$itemPerPage);
			$paging = pagination($totalposts,$p,$totalposts-1,$prev,$next,array('page'=>'enmasse_merchant_setlement','action'=>'search')) ;
			require_once (ENMASSE_ADMIN."/merchant-settlement-list.php");
			break;
		case 'changestatus':
			$em_session = new EmSession();
			$em_session->em_clear_session('cupon_id');
			$status = $_POST['status_action'];
			$dstring = $_REQUEST['id'];
			if($status && $dstring) {
				updateSettlementStatus($status,$dstring);
			}
			$em_session->em_set_session('cupon_id',$dstring);
			break;
		case 'dowload':
			$em_session = new EmSession();
			$dstring = $em_session->em_get_session('cupon_id');
			$filters['coupon_id'] = implode(",",$dstring);
			$data = getMerchantSettlementList($filters);
			$filepath = createReport($data);
			header("Cache-Control: public");
			header("Content-Description: File Transfer");
			header("Content-Disposition: attachment; filename=dealcouponreport.xls");
			header("Content-Type: application/zip");
			header("Content-Transfer-Encoding: binary");
			readfile($filepath);
			exit;
	}