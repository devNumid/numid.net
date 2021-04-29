<?php		
	require_once ROOT_PATH.'/class/class_token.php';
	require_once ROOT_PATH.'/class/class_cookie.php';
	require_once ROOT_PATH.'/config/config_domain.php';
	
	class Auth{

		function CheckAuth(){			
			$cookie = new Cookie();
			$AccessToken = $cookie->Get_Cookie("access_token");			
			$Tk = new Token(DOMAIN_FULL);			
			$req = $Tk->CheckAccessToken($AccessToken);			
			if ($req['status']){
				return array("status" =>true, "id" =>$req['id']); 
			}else{
				if ($req['expired']){
					$RefreshToken = $cookie->Get_Cookie("refresh_token");
					$req = $Tk->CheckRefreshToken($RefreshToken);
					if ($req['status']){
						$Resultat = $Tk->UpdateAccessToken($req['id']);						
						if ($Resultat){							
							return array("status" =>true, "id" =>$req['id']); 
						}else{						
							return array("status" =>false, "id" =>""); 					
						}
					}else{					
						return array("status" =>false, "id" =>""); 					
					}
				}else{					
					return array("status" =>false, "id" =>""); 					
				}
			}			
		}
		
		function Logout(){		
			$cookie = new Cookie();
			$cookie->unSetNoHttp_Cookie("refresh_token", "/", DOMAIN_FULL);
			$cookie->unSetNoHttp_Cookie("access_token", "/", DOMAIN_FULL);	
			header("Location: openwallet");			
		}	
	}
?>
