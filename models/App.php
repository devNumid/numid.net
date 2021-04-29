<?php
	require_once 'framework/Model.php';
		
	class App extends Model {
				
		public function __construct() {			
			$this->Open_DB($_SERVER["DOCUMENT_ROOT"]."/log/log_App.log");
		}	
		
		function __destruct(){			
			$this->Close_DB();
		}
		
		/* WALLET */
		
		public function isUserRegistred($data) {
			return $this->SqlCount("users" ,"wallet_id=?" ,$data);
		}
		
		public function AddUser($data){						
			return $this->SqlInsert("users" ,"wallet_id ,ref_link, date" ,"? ,?, ?" ,$data);
		}	

		public function isValidReferralLink($data) {
			return $this->SqlCount("users" ,"ref_link=?" ,$data);
		}
		
		public function getReferralWallet($data){
			$DataRow = $this->SqlSelect("users" ,"wallet_id", "ref_link=?" ,$data);
			return $this->GetPdoResult($DataRow, 0, 'wallet_id');	
		}
		
		public function AddReferral($data){						
			return $this->SqlInsert("affiliates" ,"wallet_id ,affiliate_wallet_id ,date" ,"? ,? ,?" ,$data);
		}
		
		/* DASHBOARD */					
				
		public function getLocalPools(){					
			$DataRow = $this->SqlSelect("local_pools" ,"pool_id", "" ,array());
			$index = count($DataRow);
			$pool_list = array();
			for ($i=0; $i<$index; $i++){
				array_push($pool_list, $this->GetPdoResult($DataRow, $i, 'pool_id'));
			}			
			return $pool_list;	
		}
		
		public function getPoolStaturation($data){			
			$DataRow = $this->SqlSelect("pools" ,"saturation", "pool_id=?" ,$data);			
			return $this->GetPdoResult($DataRow, 0, 'saturation');
		}	
		
		public function isPoolExiste($data){
			return $this->SqlCount("pools", "pool_id=?" ,$data);	
		}
		
		/* REWARDS */
		
		function getUserRewardsStatistics($data){		
			$DataRow = $this->SqlSelect("users_rewards" ,"*", "wallet_id=?" ,$data);
			$index = count($DataRow);
			$rewards_list = array();
			for ($i=0; $i<$index; $i++){
				array_push($rewards_list, array ('epoch'                => $this->GetPdoResult($DataRow, $i, 'epoch'),
												 'delegation_rewards'   => $this->GetPdoResult($DataRow, $i, 'delegation_rewards'),
												 'affilatation_rewards' => $this->GetPdoResult($DataRow, $i, 'affilatation_rewards'),
												 'date'                 => $this->GetPdoResult($DataRow, $i, 'date')));	
			}			
			return $rewards_list;					
		}
		
		/* REFERRAL */
		
		public function getReferrals($data){
			$DataRow = $this->SqlSelect("affiliates" ,"affiliate_wallet_id, date", "wallet_id=?" ,$data);
			$index = count($DataRow);
			$referral_list = array();
			for ($i=0; $i<$index; $i++){
				array_push($referral_list, array("affiliate_wallet_id" => $this->GetPdoResult($DataRow, $i, 'affiliate_wallet_id'),
												 "date"                => $this->GetPdoResult($DataRow, $i, 'date')));
			}			
			return $referral_list;			
		}		
		
		public function getShareLink($data){
			$DataRow = $this->SqlSelect("users" ,"ref_link", "wallet_id=?" ,$data);
			return $this->GetPdoResult($DataRow, 0, 'ref_link');			
		}
		
		/* WITHDRAW */
		
		public function isRecipientNameExiste($data){
			return $this->SqlCount("users_recipient_address" ,"wallet_id=? AND recipient_name=?" ,$data);				
		}
		
		public function isRecipientAddressExiste($data){
			return $this->SqlCount("users_recipient_address" ,"wallet_id=? AND recipient_address=?" ,$data);				
		}
		
		public function RegisterRecipient($data){
			return $this->SqlInsert("users_recipient_address" ,"wallet_id ,recipient_name ,recipient_address" ,"? ,? ,?" ,$data);		
		}
		
		public function getRecipientAddress($data){
			$DataRow = $this->SqlSelect("users_recipient_address" ,"recipient_name, recipient_address", "wallet_id=?" ,$data);
			$index = count($DataRow);
			$recipient_list = array();
			for ($i=0; $i<$index; $i++){
				array_push($recipient_list, array("recipient_name"    => $this->GetPdoResult($DataRow, $i, 'recipient_name'),
											      "recipient_address" => $this->GetPdoResult($DataRow, $i, 'recipient_address')));
			}			
			return $recipient_list;		
		}
				
		public function getAffiliationBalance($data){
			$DataRow = $this->SqlSelect("users_rewards" ,"affilatation_rewards", "wallet_id=?" ,$data);
			return $this->GetPdoResult($DataRow, 0, 'affilatation_rewards');
		}
		
		public function RegisterPaymentRequest($data){
			return $this->SqlInsert("affilatation_payment_request" ,"wallet_id ,recipient_address ,amount" ,"? ,? ,?" ,$data);
		}
		
		/* CONTACT */
		
		public function sendMessage($data){
			return $this->SqlInsert("messages" ,"wallet_id ,email ,message ,status ,date" ,"?, ?, ? ,? ,?" ,$data);
		}
	}
?>