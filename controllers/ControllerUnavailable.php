<?php
	require_once 'framework/Controller.php';
	require_once 'class/class_globales.php';
	
	class ControllerUnavailable extends Controller {

		private $gf;

		public function __construct() {
			$this->gf = new Globales();	
		}

		public function index() {	
			$dataTemplate = array("titre"      => "Unavailable",
								  "visibility" => false, 
								  "menu"       => "");	
		
			$dataView = array();
			
			$this->buildView(array("dataTemplate" => $dataTemplate, "dataView" => $dataView));
		}
	}
?>