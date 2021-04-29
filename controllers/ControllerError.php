<?php
	require_once 'framework/Controller.php';
	require_once 'class/class_globales.php';
	
	class ControllerError extends Controller {

		private $gf;

		public function __construct() {
			$this->gf = new Globales();	
		}

		public function index() {
			$dataTemplate = array("titre"      => "Error",
								  "visibility" => false, 
								  "menu"       => "");	
			
			$dataView = array("msgErreur" => "Page not found");
	
			$this->buildView(array("dataTemplate" => $dataTemplate, "dataView" => $dataView));
		}
	}
?>