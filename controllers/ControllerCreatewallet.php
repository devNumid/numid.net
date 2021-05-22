<?php
	require_once 'framework/Controller.php';
	require_once 'models/App.php';
	require_once 'class/class_client.php';	
	require_once 'class/class_globales.php';
	
	require_once 'lib/mnemonic/BIP39.php';
	require_once 'lib/mnemonic/WordList.php';
	require_once 'lib/mnemonic/Mnemonic.php';
	
	use \FurqanSiddiqui\BIP39\BIP39;
	
	class ControllerCreatewallet extends Controller {

		private $db;
		private $gf;

		public function __construct() {
			$this->db = new App();
			$this->gf = new Globales();	
			$this->gf->Authentification("public");
			$this->updateReferralLink();
		}

		public function index() {
			$dataTemplate = array("titre"      => "Create Wallet",
								  "visibility" => false, 
								  "menu"       => "");				
			
			$dataView = array();		
			
			$this->buildView(array("dataTemplate" => $dataTemplate, "dataView" => $dataView));	
		}
		
		public function genmnemonic(){
			$mnemonic_sentence = BIP39::Generate(24);
			$mnemonic = $mnemonic_sentence->words;
			if (count($mnemonic) == 24){
				echo json_encode(array("code" => "createwords", "mnemonic" => $mnemonic));
			}else{
				echo json_encode(array("code" => "warning", "message" => "an error has occurred, unable create mnemonic words."));
			}			
		}		
		
		public function register(){
			$PostArray = $this->gf->extractPostData(array("passphrase", "cpassphrase", "mnemonic", "mnemonic_confirmation"));
			if ($PostArray['mnemonic_confirmation'] == "on"){
				if ($PostArray['passphrase'] == $PostArray['cpassphrase'] ){
					$resultat = $this->connectWallet($PostArray['passphrase'], $PostArray['mnemonic']);	
					if($resultat['status']){
						echo json_encode(array("status"  => true,
						                       "code"    => "success",
											   "message" => "you wallet has been successfully created please <a href=\"openwallet\" ><strong>click here</strong></a> to open your wallet."));				
					}else{
						echo json_encode($resultat);
					}	
				}else{
					echo json_encode(array("status"  => false,
					                       "code"    => "warning", 
										   "message" => "the passphrases are not equal."));	
				}
			}else{
				echo json_encode(array("status"  => false,
									   "code"    => "warning", 
									   "message" => "you must save mnemonic sequence in a secure place."));
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
					$this->AddUser($walletID);					
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
								$this->AddUser($walletID);						
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
		
		private function AddUser($walletID){				
			if (!$this->db->isUserRegistred(array($walletID))){
				$this->AddReferral($walletID, $_SESSION['reflink']);													
				$reflink = uniqid();	
				$date = date ("Y-m-d H:i:s", mktime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));
				$this->db->AddUser(array($walletID, $reflink, $date));	
			}
		}
		
		private function updateReferralLink(){
			$urlData = $this->gf->extractGetData();
			if ($urlData['status']){
				if ($this->db->isValidReferralLink(array($urlData['data'])) == 0){
					$_SESSION['reflink'] = null;
				}else{
					$_SESSION['reflink'] = $urlData['data'];
				}
			}else{
				$_SESSION['reflink'] = null;
			}
		}		
				
		private function AddReferral($walletID, $reflink){
			if ($reflink !== null){
				$date = date ("Y-m-d H:i:s", mktime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));
				$walletID_referral = $this->db->getReferralWallet(array($reflink));
				$this->db->AddReferral(array($walletID_referral, $walletID, $date));
				unset($_SESSION['reflink']);				
			}			
		}		
	}
?>