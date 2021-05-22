<?php
	class Validate{				
		
		private $input;
		private $mask;
		
		function __construct($Input, $Mask){		
			$this->input = $Input;					
			$this->mask = $Mask;
		}

		function __destruct(){			
		}		
		
		function CheckPostedData(){					
			if ($this->input['status']){						
				return $this->validate();							
			}else{						
				return array("status" => false, "code" => "error", "message" => "invalid json");
			}
		}		
		
		private function validate(){								
			$DataArray = $this->input['data'];
			$DataMatch = $this->mask;
			
			if (!empty($DataArray)){
				if (!empty($DataMatch)){					
					if (count($DataArray) == count($DataMatch)){
						$isValid = true;	
						foreach ($DataMatch as $key){																												
							if (!isset($DataArray[$key])){  								
								$isValid = false;								
							}else{	
								$isValid = $this->CheckKey($key);														
							}
							if (!$isValid) break;
						}				
						if ($isValid){
							return array("status"  => true);		
						}else{
							if ($this->CheckKey($key)){
								$message = "invalid ".$key.".";
							}else{
								$message = "invalid input.";				
							}							
							return array("status"  => false, "code" => "error", "message" => $message);		
						}
					}else{
						return array("status"  => false, "code" => "error", "message" => "post data and mask data do not match.");
					}
				}else{
					return array("status"  => false, "code" => "error", "message" => "invalid mask data.");
				}	
			}else{
				return array("status"  => false, "code" => "error", "message" => "invalid post datas.");
			}	
		}		
		
		private function CheckKey($key){
			switch($key){																										
				case "passphrase":	
				case "cpassphrase":	
				case "mnemonic":
				case "mnemonic_confirmation":		
				case "referral":	
				case "email":	
				case "message":										
				case "account":			
				case "amount":										
				case "recipient-name":	
				case "recipient-address":
				case "pool":
					return true; 		
					break;
				default :															
					return false; 		  
			}		
		}
	}
?>
