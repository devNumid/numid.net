<?php		
	require_once ROOT_PATH.'/class/class_encryption.php';
	
	class Auth{

		function CheckAuth(){		
			if(isset($_SESSION['token']) && $_SESSION['token'] != "") {
				$crypt = new Encryption();
				$wallet_id = $crypt->decrypt($_SESSION['token']);
				if ($wallet_id != null){
					return array("status" => true, 
					             "id"     => $wallet_id); 
				}else{
					return array("status" => false, 
					             "id"     => ""); 		
				}				
			}else{
				return array("status" => false, 
				             "id"     => ""); 	
			}		
		}
		
		function Logout(){		
			session_unset();
			session_destroy();
			header("Location: openwallet");			
		}	
	}
?>
