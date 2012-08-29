<?php
	$action = $_GET['action']?$_GET['action']:'setting';
	$ax = array('setting'=>'setting');
	if (!isset($ax[$action])) $action = 'setting';
	switch ($action) {
		case 'setting':
			if (isset($_POST['submit'])):
			$options = $_POST['option'];
			foreach ($options as $option => $newvalue)
			{
				update_option($option, $newvalue);
			}
			endif;
			require_once(ENMASSE_ADMIN."/setting-edit.php");
		break;
	}