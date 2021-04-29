<?php
    require_once ROOT_PATH.'/class/class_client.php';	
	require_once ROOT_PATH.'/class/class_auth.php';
	require_once ROOT_PATH.'/class/class_validate.php';
	
	class Globales{
				
		public function InitMenuArray($selector, $commande){			
			$menuArray = array('dashboard'    => '', 
							   'rewards'      => '', 
							   'referral'     => '',							  
							   'withdraw'     => '',							  
							   'contact'      => '',
							   'logout'       => '');
			$menuArray[$selector] = $commande;
			return $menuArray;
		}
		
		public function DisableMenuArray($commande){
			$menuArray = array('dashboard'    => 'active', 
							   'rewards'      => $commande, 
							   'referral'     => $commande,							  
							   'withdraw'     => $commande,							  
							   'contact'      => $commande,
							   'logout'       => '');					
			return $menuArray;
		}
		
		
		public function Authentification($selector) {
			$UserAuth = new Auth();
			$resultat = $UserAuth->CheckAuth();
			switch($selector){
				case "private":
					if ($resultat["status"]){						
						return $resultat;
					}else{
						$UserAuth->Logout();
					}
					break;
				case "public":
					if ($resultat["status"]) header('Location: dashboard');					
					break;
			}
		}	

		public function getWalletSynchronizationStatus($walletId){
			$Wallet = $this->getWalletDetail($walletId);			
			if ($Wallet != null){				
				switch ($Wallet['state']['status']){
					case "syncing":						
						$_SESSION['status'] = "syncing";
						break;
					case "ready":
						$_SESSION['status'] = "ready";
						break;
					case "not_responding":
						$_SESSION['status'] = "not_responding";
						break;
				}
				return $Wallet;
			}else{
				header('Location: unavailable');		
			}			
		}
		
		public function isWalletSynchronized($walletId, $selector){
			if (isset($_SESSION['status'])){			
				switch($selector){
					case "dashboard":
						break;
					case "referral":
					case "rewards":
					case "withdraw":
					case "contact":				
						if ($_SESSION['status'] != "ready") header("Location: dashboard");				
				}
			}else{
				$Wallet = $this->getWalletSynchronizationStatus($walletId);
			}
		}
		
		public function extractPostData($postData){
			$decodedJson = $this->getPostData();
			$validate = new Validate($decodedJson, $postData);
			$check = $validate->CheckPostedData();
			if ($check['status']){
				return $decodedJson['data'];
			}else{
				echo json_encode($check);
				exit;
			}
		}	
		
		public function extractGetData(){
			return $this->getGetData();
		}	
		
		public function getWalletBalance($walletId, $account){
			$client = new Client();
			$json = $client->GetWallet($walletId);
			$DataArray = json_decode($json, true);
			if ($DataArray['status']){				
				return $DataArray['data']['balance'][$account]['quantity'];
			}else{
				return null;
			}
		}
				
		public function getWalletDetail($walletId){
			$client = new Client();
			$json = $client->GetWallet($walletId);
			$DataArray = json_decode($json, true);
			if ($DataArray['status']){
				return $DataArray['data'];
			}else{
				return null;
			}
		}
		
		public function getWalletAdresse($walletId){
			$client = new Client();
			$json = $client->GetAddress($walletId);
			$DataArray = json_decode($json, true);
			if ($DataArray['status']){
				return $DataArray['data'][0]['id'];
			}else{
				return null;
			}
		}
		
		public function getWalletAdresseList($walletId){
			$client = new Client();
			$json = $client->GetAddress($walletId);
			$DataArray = json_decode($json, true);
			if ($DataArray['status']){
				return $DataArray['data'];
			}else{
				return null;
			}
		}
				
		public function ConvertLovelaceToAda($lovelace){
			$ada = $lovelace / 1000000;
			return number_format(round ($ada ,2) ,2);
		}
		
		public function ConvertAdaToLovelace($ada){
			return $ada * 1000000;
		}
		
		public function CastString($string, $length){
			return substr($string, 0, $length)."...".substr($string, strlen($string)-$length, $length);				
		}
			
		public function getPostData() {		
			$json = file_get_contents('php://input');	
			$myJSON = json_decode($json, true);
			if (json_last_error() == JSON_ERROR_NONE){
				return array("status" => true, "data" => $myJSON);
			}else{
				return array("status" => false);
			}					
		}
		 
		public function getGetData(){
			if ((isset($_Get['m']))&&($_Get['m']!="")){			
				return array("status" => true, "data" => $this->requete->getParametre('m'));				
			}else{
				return array("status" => false);				
			}
		}		
	}
?>
