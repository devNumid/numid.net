<?php
	require_once 'framework/Controller.php';
	require_once 'class/class_auth.php';

	class ControllerLogout extends Controller {

		public function __construct() {
		}

		public function index() {
			$UserAuth = new Auth();
			$UserAuth->Logout();
		}
	}
?>