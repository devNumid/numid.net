<?php
	require_once 'framework/Controller.php';
	require_once 'models/App.php';
	require_once 'class/class_globales.php';

	class ControllerReferral extends Controller {

		private $db;
		private $gf;
		private $auth;

		public function __construct() {
			$this->db = new App();
			$this->gf = new Globales();	
			$this->auth = $this->gf->Authentification('private');
			$this->gf->isWalletSynchronized($this->auth["id"], "referral");
		}

		public function index() {			
			$dataTemplate = array("titre" => "Referral");	
								  
			$dataView = array("Referral"   => $this->GenReferralTab(),
							  "share_link" => $this->GenShareLink(),
							  "menu"       => $this->gf->InitMenuArray("referral", "active"));			
						
			$this->buildView(array("dataTemplate" => $dataTemplate, "dataView" => $dataView));			
		}
		
		private function GenReferralTab(){
			$_id = 0;
			$Table = "";			
			$Referrals = $this->db->getReferrals(array($this->auth["id"]));
			foreach($Referrals as $Referral){				
				$lovelace_balance = $this->gf->getWalletBalance($Referral["affiliate_wallet_id"], 'total');
				if ($lovelace_balance !== null){
					$balance = $this->gf->ConvertLovelaceToAda($lovelace_balance);
				}else{
					$balance = "X.XX";
				}

				$addresse = $this->gf->getWalletAdresse($Referral["affiliate_wallet_id"]);			
				if ($addresse === null) $addresse = "XXXXXXXXXX...XXXXXXXXXX";			

				$Table .= "<tr>";
				$Table .= "	<td class=\"text-center\" style=\"width:20px;\"><button id=\"btn_".$_id."\" data-clipboard-target=\"#addr_".$_id."\" type=\"button\" class=\"btn btn-falcon-light btn-sm mr-1 mb-1\" onclick=\"CopieToClipboard('btn_".$_id."')\"><i class=\"fas fa-copy\"></i></button></td>";
				$Table .= "	<td id='addr_".$_id."' class=\"text-truncate\" style=\"max-width: 50px;\">".$addresse."</td>";
				$Table .= "	<td style=\"width:150px;color: green;\">".$balance."</td>";
				$Table .= "	<td class=\"text-center\" style=\"width:200px;\">".$Referral['date']."</td>";
				$Table .= "</tr>";
				$_id++;
			}
			return $Table;
		}

		private function GenShareLink() {			
			return "https://numid.net/createwallet-".$this->db->getShareLink(array($this->auth["id"]));								
		}	
	}
?>