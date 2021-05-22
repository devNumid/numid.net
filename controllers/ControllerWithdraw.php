<?php
	require_once 'framework/Controller.php';
	require_once 'models/App.php';
	require_once 'class/class_client.php';
	require_once 'class/class_globales.php';
	
	class ControllerWithdraw extends Controller {

		private $db;
		private $gf;
		private $auth;

		public function __construct() {
			$this->db = new App();
			$this->gf = new Globales();	
			$this->auth = $this->gf->Authentification('private');
			$this->gf->isWalletSynchronized($this->auth["id"], "withdraw");
		}

		public function index() {				
			$dataTemplate = array("titre" => "Withdraw");	
		
			$Balance = $this->GetWithdawableBalance($this->auth["id"]);			
			$balance_avaible = $Balance["avaiable"];
			$balance_reward = $Balance["reward"];
			$balance_withdrawble = $balance_avaible+$balance_reward;
			$balance_affiliation = $this->GetAffiliationBalance($this->auth["id"]);
			$dataView = array("wallet_list"         => $this->GenAddressList($this->auth["id"]),
							  "withdrawble_balance" => $this->gf->ConvertLovelaceToAda($balance_withdrawble),
							  "avaible_balance"     => $this->gf->ConvertLovelaceToAda($balance_avaible),
							  "delegation_balance"  => $this->gf->ConvertLovelaceToAda($balance_reward),
							  "afiiliation_balance" => $this->gf->ConvertLovelaceToAda($balance_affiliation),
							  "menu"                => $this->gf->InitMenuArray("withdraw", "active"));
		
			$this->buildView(array("dataTemplate" => $dataTemplate, "dataView" => $dataView));			
		}

		public function register(){
			$PostArray = $this->gf->extractPostData(array("recipient-name", "recipient-address"));
			$client = new Client();
			$json = $client->isValidAddress($PostArray['recipient-address']);
			$response = json_decode($json, true);
			if ($response['status']){
				if ($this->db->isRecipientNameExiste(array($this->auth["id"], $PostArray['recipient-name'])) == 0){
					if ($this->db->isRecipientAddressExiste(array($this->auth["id"], $PostArray['recipient-address'])) == 0){
						$this->db->RegisterRecipient(array($this->auth["id"], $PostArray['recipient-name'], $PostArray['recipient-address']));
						$recipient_list = $this->GenAddressList($this->auth["id"]);
						echo json_encode(array("code" => "success", "message" => "this recipient was successfully registered", "recipient" => $recipient_list));
					}else{
						echo json_encode(array("code" => "warning", "message" => "this recipient address was previously registered"));
					}
				}else{
					echo json_encode(array("code" => "warning", "message" => "this recipient name was previously registered"));
				}
			}else{
				echo json_encode(array("code" => "warning", "message" => "this address is invalid"));
			}
		}

		public function request(){
			$PostArray = $this->gf->extractPostData(array("account", "amount"));					
			$Balance = $this->getRecipientAddress($this->auth["id"]);
			$balance_avaible = $Balance["avaiable"];
			$balance_reward = $Balance["reward"];
			$lovelace_balance = $balance_avaible+$balance_reward;						
			if ($PostArray['amount'] == ""){
				$lovelace_amount = $lovelace_balance;
			}else{
				$lovelace_amount = $this->gf->ConvertAdaToLovelace($PostArray['amount']);
			}
			if ($lovelace_balance >= $lovelace_amount){
				$payments = array("payments" => array(array("address" => $PostArray['account'],
															"amount"  => array("quantity" => $lovelace_amount,
																			   "unit"     => "lovelace"))),
								  "withdrawal" => "self");
				$client = new Client();																   
				$json = $client->GetTransactionFee($this->auth["id"], $payments);
				$response = json_decode($json, true);
				if ($response['status']){
					$lovelace_fee = $response['data']['estimated_max']['quantity'];
					$_SESSION['account'] = $PostArray['account'];
					$_SESSION['amount'] = $lovelace_amount;
					$_SESSION['fee'] = $lovelace_fee;
					echo json_encode(array("code"    => "showfee",						                       
										   "account" => $PostArray['account'],
										   "amount"  => $this->gf->ConvertLovelaceToAda($lovelace_amount),
										   "fee"     => $this->gf->ConvertLovelaceToAda($lovelace_fee)));
				}else{
					echo json_encode(array("code" => "error", "message" => "an error has occurred, unable to get transaction fee", "data" => $response));
				}
			}else{
				echo json_encode(array("code" => "warning", "message" => "insufficient funds"));
			}
		}

		public function send(){
			$PostArray = $this->gf->extractPostData(array("passphrase"));	
			$lovelace_amount = $_SESSION['amount'] - $_SESSION['fee'];			
			$req = $this->execPayment($this->auth["id"], $_SESSION['account'], $lovelace_amount, $PostArray['passphrase']);
			unset($_SESSION['account']);
			unset($_SESSION['amount']);
			unset($_SESSION['fee']);
			if ($req){						
				echo json_encode(array("code" => "success", "message" => "amount was successfully withrawed."));
			}else{
				echo json_encode(array("code" => "error", "message" => "an error has occured when withdrawing your funds, contact us to check your problem"));
			}			
		}
		
		public function claim(){
			$lovelace_affiliationRewards = $this->GetAffiliationBalance($this->auth["id"]);
			$lovelace_minWithdraw = $this->gf->ConvertAdaToLovelace(MIN_WITHDRAW_BALANCE);
			if ($lovelace_affiliationRewards >= $lovelace_minWithdraw){					
				$addresse = $this->gf->getWalletAdresse($this->auth["id"]);								
				$req = $this->RegisterPaymentRequest($this->auth["id"], $addresse, $lovelace_affiliationRewards);
				if ($req){						
					echo json_encode(array("code" => "success", "message" => "withdraw request was successfully sent."));
				}else{
					echo json_encode(array("code" => "error", "message" => "an error has occured when withdrawing your funds, contact us to check your problem"));
				}
			}else{
				echo json_encode(array("code" => "warning", "message" => "To withdraw affiliation reward to your account you must have at last ".MIN_WITHDRAW_BALANCE." ADA."));
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
				return true;
			}else{
				return false;
			}
		}		
		
		private function GenAddressList($walletId){
			$wallets = $this->db->getRecipientAddress(array($walletId));
			$comboBox = "<select class=\"form-control\" name=\"account\" data-selector=\"serialize\">";	
			$comboBox .= "<option value=\"\">Select address</option>";
			foreach ($wallets as $wallet){				
				$identifier = $this->gf->CastString($wallet['recipient_address'],10);				
				$comboBox .= "<option value=\"".$wallet['recipient_address']."\">".$wallet['recipient_name']." - (".$identifier.")</option>";
			}
			$comboBox .= "</select>";
			return $comboBox;
		}
		
		private function GetWithdawableBalance($walletId){
			$walletDetail = $this->gf->getWalletDetail($walletId);
			if ($walletDetail != null){
				return array("avaiable" => $walletDetail['balance']['available']['quantity'],
							"reward"   => $walletDetail['balance']['reward']['quantity']);
			}else{
				return null;
			}
		}
		
		private function GetAffiliationBalance($walletId){
			$walletDetail = $this->db->getAffiliationBalance(array($walletId));
			return $walletDetail;
		}
	}
?>