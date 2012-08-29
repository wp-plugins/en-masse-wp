<?php
class  EmSession {
	function  __construct() {
		
	}
	public function em_set_session($key = null, $data = array()) {
		if($key && !empty($data)) 	{
			$_SESSION[$key]= $data;
		}
	}
	public function  em_get_session($key) {
		if(isset($_SESSION[$key])) {
			return $_SESSION[$key];
		}
		return null;
	}
	
	public function  em_clear_session($key = null) {
		if($key) {
			unset($_SESSION[$key]);
		}
	}
	
	public function em_destroy() {
		session_destroy();
	}
}