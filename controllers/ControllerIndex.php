<?php
	require_once 'framework/Controller.php';
	require_once 'class/class_globales.php';
	
	class ControllerIndex extends Controller {
	
		private $gf;

		public function __construct() {
			$this->gf = new Globales();	
			$this->gf->Authentification("public");			
		}

		public function index() {
			$dataTemplate = array("titre"      => "Index",
								  "visibility" => false, 
								  "menu"       => "");				
			
			$dataView = array();		
			
			$this->buildView(array("dataTemplate" => $dataTemplate, "dataView" => $dataView));	
		}		
	}
?>