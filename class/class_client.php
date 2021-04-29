<?php
	require_once ROOT_PATH.'/api/api.php';
		
	class Client{

		public function OpenWallet($username, $passphrase, $mnemonic_sentence){
			$_json = json_encode(array("name"                   => $username,
									   "mnemonic_sentence"      => $mnemonic_sentence,
									   "passphrase"             => $passphrase));										   
			$req = array ("method" => "wallet-create", "params" => array("uri" => "/v2/wallets", "json" => $_json, "method" => "POST"));		
			$wallet = new WalletApi();
			return $wallet->EntryPoint($dataArray);
		}
						
		public function GetWallet($walletId){
			$req = array ("method" => "wallet-get", "params" => array("uri" => "/v2/wallets/".$walletId, "json" => null, "method" => "GET"));
			$wallet = new WalletApi();
			return $wallet->EntryPoint($dataArray);	
		}	
		
		public function GetAddress($walletId){
			$req = array ("method" => "network-information", "params" => array("uri" => "/v2/wallets/".$walletId."/addresses", "json" => null, "method" => "GET"));
			$wallet = new WalletApi();
			return $wallet->EntryPoint($dataArray);	
		}	

		public function GetDelegationFee($walletId){
			$req = array ("method" => "stakepool-estimate_fee", "params" => array("uri" => "/v2/wallets/".$walletId."/delegation-fees", "json" => null, "method" => "GET"));
			$wallet = new WalletApi();
			return $wallet->EntryPoint($dataArray);		
		}
		
		public function JoinDelegation($stakePoolId, $walletId ,$passphrase){
			$_json = json_encode(array("passphrase" => $passphrase));									   
			$req = array ("method" => "stakepool-join", "params" => array("uri" => "/v2/stake-pools/".$stakePoolId."/wallets/".$walletId, "json" => $_json, "method" => "PUT"));
			$wallet = new WalletApi();
			return $wallet->EntryPoint($dataArray);
		}
		
		public function QuitDelegation($walletId ,$passphrase){
			$_json = json_encode(array("passphrase" => $passphrase));		
			$req = array ("method" => "stakepool-quit", "params" => array("uri" => "/v2/stake-pools/*/wallets/".$walletId, "json" => $_json, "method" => "DELETE"));
			$wallet = new WalletApi();
			return $wallet->EntryPoint($dataArray);
		}
		
		public function GetTransactionList($walletId){			
			$req = array ("method" => "transaction-list", "params" => array("uri" => "/v2/wallets/".$walletId."/transactions", "json" => null, "method" => "GET"));
			$wallet = new WalletApi();
			return $wallet->EntryPoint($dataArray);	
		}
		
		public function isValidAddress($addressId){	
			$req = array ("method" => "addresse-inspect_address", "params" => array("uri" => "/v2/addresses/".$addressId, "json" => null, "method" => "GET"));
			$wallet = new WalletApi();
			return $wallet->EntryPoint($dataArray);	
		}

		public function GetTransactionFee($walletId ,$payments){
			$_json = json_encode($payments);	 	
			$req = array ("method" => "transaction-estimate_fee", "params" => array("uri" => "/v2/wallets/".$walletId."/payment-fees", "json" => $_json, "method" => "POST"));			
			$wallet = new WalletApi();
			return $wallet->EntryPoint($dataArray);	
		}	
		
		public function CreateTransactions($walletId ,$payments){
			$_json = json_encode($payments);				
			$req = array ("method" => "transaction-create", "params" => array("uri" => "/v2/wallets/".$walletId."/transactions", "json" => $_json, "method" => "POST"));
			$wallet = new WalletApi();
			return $wallet->EntryPoint($dataArray);
		}
	}
?>