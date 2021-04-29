<?php	
	require_once ROOT_PATH.'/config/config_cookie.php';
	
	class Cookie{

		private $SetHttpsSecureCookie;

		function __construct(){
			$this->SetHttpsSecureCookie = isHTTPS;
		}

		function SetNoHttpCookie($cookie_id ,$value ,$expire ,$path ,$domain){
			$isCreated = setcookie($cookie_id, $value, $expire, $path, $domain, $this->SetHttpsSecureCookie, true);
			return $isCreated;
		}

		function Set_Cookie($cookie_id ,$value ,$expire ,$path ,$domain){
			$isCreated = setcookie($cookie_id, $value, $expire, $path, $domain);
			return $isCreated;
		}

		function isCookie($cookie_id){
			return (isset($_COOKIE[$cookie_id])) ? true : false;
		}

		function Get_Cookie($cookie_id){
			return ($this->isCookie($cookie_id)) ? $_COOKIE[$cookie_id] : null;
		}

		function unSetNoHttp_Cookie($cookie_id ,$path ,$domain){
			if (isset($_COOKIE[$cookie_id])) {
				unset($_COOKIE[$cookie_id]);
				setcookie($cookie_id, null, time()-3600, $path, $domain, $this->SetHttpsSecureCookie, true);
				return true;
			} else {
				return false;
			}
		}

		function unSet_Cookie($cookie_id){
			if (isset($_COOKIE[$cookie_id])) {
				unset($_COOKIE[$cookie_id]);
				setcookie($cookie_id, null, time()-3600, "/", "");
				return true;
			} else {
				return false;
			}
		}
	}
?>
