<?php
	require_once 'framework/Controller.php';	
	require_once 'models/App.php';
	require_once 'class/class_client.php';	
	require_once 'class/class_globales.php';
	
	class ControllerDashboard extends Controller {
		
		private $db;
		private $gf;
		private $auth;

		public function __construct() {
			$this->db = new App();
			$this->gf = new Globales();	
			$this->auth = $this->gf->Authentification('private');
			$this->gf->isWalletSynchronized($this->auth["id"], "dashboard");
		}

		public function index() {			
			$Wallet = $this->getWalletInfos($this->auth["id"]);	

			$dataTemplate = array("titre" => "Dashboard");
			
			switch ($_SESSION['status']){
				case "syncing":					
					$isSyncing = "showdiv";
					$isReady = "hidediv";
					$isNotResponding = "hidediv";								
					$delegation_message = '';
					$delegation_action = '';
					$menu = $this->gf->DisableMenuArray("text-danger disabled");
					break;
				case "ready":
					$isSyncing = "hidediv";
					$isReady = "showdiv";
					$isNotResponding = "hidediv";				
					switch ($Wallet['delegation']){
						case "ower":
							$delegation_message = '<span>Your wallet is delegated</span>';
							$delegation_action = '';
							break;
						case "other":
							$delegation_message = '<span>Your wallet is currently delegated to an other pool, please redelegate</span>';
							$delegation_action = '<button type="button" class="btn btn-falcon-warning btn-sm mr-1 mb-1" onclick="$(\'#undelegate-wallet\').modal(\'show\');"><i class="fas fa-sign-out-alt"></i> Undelegate</button>';
							break;
						case "none":
						default:
							$delegation_message = '<span>Your wallet is not delegated</span>';
							$delegation_action = '<form id="frm-getdelegatefee" data-url="/dashboard/getdelegatefee" data-method="post" class="needs-validation" data-selector="modal" novalidate><button class="btn btn-falcon-warning btn-sm mr-1 mb-1" type="submit"><i class="fas fa-sign-in-alt"></i> Delegate</button></form>';
							break;
					}
					$menu = $this->gf->InitMenuArray("dashboard", "active");
					break;
				case "not_responding":
					$isSyncing = "hidediv";
					$isReady = "hidediv";
					$isNotResponding = "showdiv";						
					$delegation_message = '';
					$delegation_action = '';
					$menu = $this->gf->DisableMenuArray("text-danger disabled");
					break;
			}
			$pools = $this->GenPoolLocalList();
			$dataView = array("balance"            => $Wallet['balance'],
							  "delegation_message" => $delegation_message,
							  "delegation_action"  => $delegation_action,
							  "pools"              => $pools,
							  "address"            => $Wallet['addresse'],
							  "isSyncing"          => $isSyncing,
							  "isReady"            => $isReady,
							  "isNotResponding"    => $isNotResponding,
							  "progress"           => $Wallet['progress'],							  
							  "Transactions"       => $this->getClientTransactionTable($this->auth["id"]),
							  "menu"               => $menu);
						  
			$this->buildView(array("dataTemplate" => $dataTemplate, "dataView" => $dataView));			
		}
		
		public function getdelegatefee(){
			$lovelace_balance = $this->gf->getWalletBalance($this->auth["id"], 'total');			
			if ($lovelace_balance !== null){
				$balance = $this->gf->ConvertLovelaceToAda($lovelace_balance);
				if ($balance >= MIN_DELEGATION_BALANCE){
					$client = new Client();
					$json = $client->GetDelegationFee($this->auth["id"]);
					$DataArray = json_decode($json, true);
					if ($DataArray['status']){
						$fee = $DataArray['data']['estimated_max']['quantity'];
						$deposit = $DataArray['data']['deposit']['quantity'];
						$total_fee = $fee + $deposit;
						$total_fee = $this->gf->ConvertLovelaceToAda($total_fee);
						echo json_encode(array("code" => "delegationfee", "data" => $total_fee));
					}else{
						echo json_encode(array("code" => "warning", "message" => "an error has occurred, unable to get delegation detail."));
					}
				}else{
					echo json_encode(array("code" => "warning", "message" => "To delegate your account you must have at last ".MIN_DELEGATION_BALANCE." ADA"));
				}
			}else{
				echo json_encode(array("code" => "warning", "message" => "an error has occurred, unable to get your wallet data."));
			}
		}

		public function delegate(){
			$PostArray = $this->gf->extractPostData(array("passphrase", "pool"));
			if ($this->db->isPoolExiste($PostArray['pool']) == 1){
				$client = new Client();
				$json = $client->JoinDelegation($PostArray['pool'], $this->auth["id"], $PostArray['passphrase']);
				$DataArray = json_decode($json, true);
				if ($DataArray['status']){
					echo json_encode(array("code" => "delegated"));
				}else{
					echo json_encode(array("code" => "warning", "message" => "an error has occurred, unable to join delegation."));
				}
			}else{
				echo json_encode(array("code" => "warning", "message" => "invalid pool ID."));
			}
		}

		public function undelegate(){
			$PostArray = $this->gf->extractPostData(array("passphrase"));					
			$lovelace_RewardBalance = $this->gf->getWalletBalance($this->auth["id"], 'reward');
			if ($lovelace_RewardBalance != null){
				if ($lovelace_RewardBalance >= 1000000){					
					$addresse = $this->gf->getWalletAdresse($this->auth["id"]);
					if ($lovelace_RewardBalance != null){
						$req = $this->execPayment($this->auth["id"], $addresse, $lovelace_RewardBalance, $PostArray['passphrase']);
						if ($req['status']){
							$client = new Client();
							$json = $client->QuitDelegation($this->auth["id"], $PostArray['passphrase']);
							$DataArray = json_decode($json, true);
							if ($DataArray['status']){
								echo json_encode(array("code" => "undelegated"));
							}else{
								echo json_encode(array("code" => "warning", "message" => "an error has occurred, unable to quit delegation. ".$DataArray['data']['message']));
							}
						}else{
							echo json_encode(array("code" => "warning", "message" => "an error has occurred, unable to withdraw reward to you wallet.".$req['data']));
						}				
					}else{
						echo json_encode(array("code" => "warning", "message" => "an error has occurred, unable to get wallet address."));
					}				
				}else{
					echo json_encode(array("code" => "warning", "message" => "You can't undelegate now with this wallet your reward balance must be at last at 1000000 lovelace, currently you have only ".$lovelace_RewardBalance." lovelace, contrariwise you can open an other account in our wallet and delegatate it."));
				}				
			}else{
				echo json_encode(array("code" => "warning", "message" => "an error has occurred, unable to get wallet reward balance."));
			}
		}
		
		function execPayment($walletId, $account, $amount, $passphrase){
			$payments = array("passphrase" => $passphrase,
							  "payments"   => array(array("address" => $account,
														  "amount"  => array("quantity" => $amount,
																			 "unit"     => "lovelace"))),
							  "withdrawal" => "self");
			$client = new Client();
			$json = $client->CreateTransactions($walletId, $payments);
			$response = json_decode($json, true);
			if ($response['status']){					
				return array("status" => true);
			}else{
				return array("status" => false, "data" => $json);
			}
		}

		private function getWalletInfos($walletId){
			$walletDetail = $this->gf->getWalletDetail($walletId);
			if ($walletDetail !== null){			
				$addresse = $this->gf->getWalletAdresse($walletId);
				if ($addresse !== null){					
					if ($walletDetail['delegation']['active']['status'] == "delegating"){					
						$delegation = $this->getPoolOwner($walletDetail['delegation']['active']['target']);
					}else{
						$delArray = $walletDetail['delegation']['next'];
						if (count($delArray) != 0){
							if ($delArray[0]['status'] == "delegating"){
								$delegation = $this->getPoolOwner($delArray[0]['target']);
							}else{
								$delegation = "none";
							}
						}else{
							$delegation = "none";
						}
					}
					$status = $walletDetail['state']['status'];
					if ($status == "syncing"){
						$progress = $walletDetail['state']['progress']['quantity'];
					}else{
						$progress = 100;
					}
					return array("balance"    => $this->gf->ConvertLovelaceToAda($walletDetail['balance']['total']['quantity']),
								 "delegation" => $delegation,
								 "addresse"   => $addresse,
								 "status"     => $status,
								 "progress"   => $progress);
				}else{
					return null;
				}
			}else{
				return null;
			}
		}
		
		private function getPoolOwner($walletPool){
			$found = false;
			$pools = $this->db->getLocalPools();						
			foreach($pools as $pool){	
				if ($walletPool == $pool){								
					$found = true;
					break;
				}
			}						
			if ($found){
				return "ower";
			}else{
				return "other";
			}		
		}
		
		private function getClientTransactionTable($walletId){
			$client = new Client();
			$json = $client->GetTransactionList($walletId);
			$DataArray = json_decode($json, true);		
			if ($DataArray['status']){				
				return $this->GenTransactionTab($DataArray['data']);				
			}else{
				return "";
			}
		}
		
		private function GenTransactionTab($Transactions){
			$Table = "";
			$_id = 0;
			foreach($Transactions as $transaction){
				$Id = $transaction['id'];
				$Amount = number_format(round($transaction['amount']['quantity']/1000000, 2) ,2);
				$Date = gmdate("d-m-Y h:i:s", strtotime($transaction['inserted_at']["time"]));
				$Direction = $transaction['direction'];
				$Table .= "<tr>";				
				$Table .= "	<td class=\"text-truncate\" style=\"max-width:50px;\"><a href=\"https://explorer.cardano.org/en/transaction?id=".$Id."\">".$Id."</a></td>";
				if ($Direction == "incoming"){
					$Table .= "	<td style=\"width:150px;color: green;\" >".$Amount."</td>";
				}else{					
					$Amount = (float)$Amount * -1;										
					$Table .= "	<td style=\"width:150px;color: red;\" >".$Amount."</td>";
				}
				$Table .= "	<td class=\"text-center\" style=\"width:200px;\">".$Date."</td>";
				$Table .= "</tr>";
				$_id++;
			}
			return $Table;
		}
		
		private function GenPoolLocalList(){
			$comboBox = "<select class=\"form-control\" id=\"PoolId\">";			
			$compteur = 1;
			$pools = $this->db->getLocalPools();
			foreach($pools as $pool){
				$saturation = $this->db->getPoolStaturation(array($pool));				
				$saturation = $saturation * 100;
				$saturation = number_format(round($saturation, 2) ,2);			
				$comboBox .= "<option value=\"".$pool."\">Pool ID ".$compteur." - saturation (".$saturation."%)</option>";
				$compteur++;
			}
			$comboBox .= "</select>";
			return $comboBox;
		}
	}
?>