<?php
	$action = $_GET['action']?$_GET['action']:'list';
	$ax = array('list'=>'list','edit'=>'edit');
	if (!isset($ax[$action])) $action = 'list';
	//require_once(ENMASSE_ADMIN."/emailtemplate-functions.php");
	switch ($action) {
		case 'list':
			if(isset($_GET['pg'])){
				$p =$_GET['pg'];
			}
			else{
				$p = 1;
			}
			$query = 'SELECT Count(*) as count from '.ENMASSE_EMAIL_TEMPLATE;
			$total = $wpdb->get_results($query);
			$itemPerPage = get_option('posts_per_page',5);
			$limit = ($p - 1) * $itemPerPage;
			$totalposts = $total[0]->count/$itemPerPage;
			$prev = $p - 1;
			$next = $p + 1;
			$query = 'SELECT * FROM '.ENMASSE_EMAIL_TEMPLATE.' ORDER BY ID DESC LIMIT '.$limit.','.$itemPerPage;
			$paging = pagination($totalposts,$p,$totalposts-1,$prev,$next,array('page'=>'enmasse_emailtemplate','action'=>'list')) ;
			$email_tmps = $wpdb->get_results($query);
			require_once(ENMASSE_ADMIN."/emailtemplate-list.php");
		break;
		case 'edit':
			if(isset($_POST['submit'])):
				$data = array(	"subject" => esc_html($_POST['subject']),
							  	"content" => $_POST['content'],
							  	"updated_at" => date('Y-m-d g:i:s A',time()+7*3600)
				);
		   		$wpdb->update(ENMASSE_EMAIL_TEMPLATE,$data,array('id'=>$_REQUEST['id']));
				$sendback = add_query_arg(array('updated'=>1));
				$sendback = remove_query_arg( array('noheader'), $sendback );
				wp_redirect($sendback); exit();
			endif;
			global $email_tmp;
			$query ='SELECT pg.* FROM ' . ENMASSE_EMAIL_TEMPLATE . ' pg WHERE pg.id='.intval(esc_html($_GET['id']));
			$email_tmp = $wpdb->get_results($query);
			$email_tmp = $email_tmp[0];
			require_once(ENMASSE_ADMIN."/emailtemplate-edit.php");
		break;
	}
?>