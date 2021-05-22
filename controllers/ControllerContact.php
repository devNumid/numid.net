<?php
	require_once 'framework/Controller.php';
	require_once 'models/App.php';
	require_once 'class/class_globales.php';
	
	class ControllerContact extends Controller {

		private $db;
		private $gf;
		private $auth;

		public function __construct() {
			$this->db = new App();
			$this->gf = new Globales();
			$this->auth = $this->gf->Authentification('private');
			$this->gf->isWalletSynchronized($this->auth["id"], "contact");
		}

		public function index() {			
			$dataTemplate = array("titre" => "Contact");	
			$dataView = array("menu" => $this->gf->InitMenuArray("contact", "active"));
			
			$this->buildView(array("dataTemplate" => $dataTemplate, "dataView" => $dataView));			
		}

		public function send() {
			$DataArray = $this->gf->extractPostData(array("email","message"));
			$resultat = $this->db->sendMessage(array($this->auth["id"],
													 $DataArray['email'],	
													 $DataArray['message'],
													 0,
													 date ("Y-m-d H:i:s", mktime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")))));
			if ($resultat){
				echo json_encode (array("status"  => true,
										"code"    => "success",
										"message" => "your message was successfully sent."));
			}else{
				echo json_encode (array("status"  => false,
										"code"    => "error",
										"message" => "an error has occured when sending your message, please try again later."));
			}
		}
	}
?>