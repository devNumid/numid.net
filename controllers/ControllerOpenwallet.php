<?php
	require_once 'framework/Controller.php';
	require_once 'models/App.php';
	require_once 'class/class_client.php';
	require_once 'class/class_encryption.php';	
	require_once 'class/class_globales.php';
	
	class ControllerOpenwallet extends Controller {

		private $db;
		private $gf;

		public function __construct() {
			$this->db = new App();
			$this->gf = new Globales();	
			$this->gf->Authentification("public");			
		}

		public function index() {
			$dataTemplate = array("titre"      => "Open Wallet",
								  "visibility" => false, 
								  "menu"       => "");				
			
			$dataView = array();		
			
			$this->buildView(array("dataTemplate" => $dataTemplate, "dataView" => $dataView));	
		}		
			
		public function open(){
			$PostArray = $this->gf->extractPostData(array("passphrase", "mnemonic"));						
			$resultat = $this->connectWallet($PostArray['passphrase'], $PostArray['mnemonic']);
			if($resultat['status']){				
				$crypt = new Encryption();
				$_SESSION['token'] = $crypt->encrypt($resultat['wallet']);
				echo json_encode(array("status"  => true,												  
									   "code"    => "redirect",										  
									   "message" => "authorised access",
									   "url"     => "dashboard"));										
			}else{
				echo json_encode($resultat);
			}				
		}	
						
		private function connectWallet($passphrase, $mnemonic){
			$vmnemonic = explode(" ", $mnemonic);
			if ((count($vmnemonic) >= 15)||(count($vmnemonic) <= 24)){
				$client = new Client();				
				$json = $client->OpenWallet(uniqid(), $passphrase, $vmnemonic);
				$DataArray = json_decode($json, true);
				if ($DataArray['status']){
					$walletID = $DataArray['data']['id'];					
					return array("status" => true,
								 "wallet" => $DataArray['data']['id']);
				}else{
					if (isset($DataArray['http_code'])){
						if (($DataArray['http_code'] == 409)&&($DataArray['data']['code'] == "wallet_already_exists")){
							$haystack = $DataArray['data']['message'];
							$needle0 = "This operation would yield a wallet with the following id: ";
							$needle1 = " However, I already know of a wallet with this id.";
							if ((strpos($haystack ,$needle0) !== false)&&(strpos($haystack ,$needle1) !== false)){							
								$walletID = substr($haystack, strlen($needle0), 40);													
								return array("status" => true,
											 "wallet" => $walletID);	
							}else{
								return array("status"  => false,
											 "code"    => "warning", 
											 "message" => "an error has occurred, unable create or open your wallet.1".strpos($haystack ,$needle1));
							}
						}else{	
							return array("status"  => false,
										 "code"    => "warning", 
										 "message" => "an error has occurred, unable create or open your wallet.0");
						}
					}else{
						header('Location: unavailable');	
					}
				}
			}else{
				return array ("status"  => false,
							  "code"    => "warning", 
							  "message" => "the mnemonic word number must be betwin 15 and 24 words");
			}
		}		
	}
?>