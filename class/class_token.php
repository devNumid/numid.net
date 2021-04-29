<?php
	use \Firebase\JWT\JWT;
	require_once ROOT_PATH.'/lib/firebase/vendor/autoload.php';
	require_once ROOT_PATH.'/class/class_encryption.php';		
	require_once ROOT_PATH.'/config/config_token.php';
	
	class Token{
		
		private $m_domaine;
		
		function __construct($domain_full) {			
			$this->m_domaine = $domain_full;
		}

		function GenTokens($Id){			
			$refresh_token = $this->GenerateRefreshToken($Id);		
			$access_token = $this->GenerateAccessToken($Id, false, ACCESS_TOKEN_VALID_DURATION);		
			if (($refresh_token!=null)&&($access_token!=null)){
				return array("status"        => true, 
							 "refresh_token" => $refresh_token, 
							 "access_token"  => $access_token);
			}else{
				return array("status" => false);
			}
		}
		
		function GenerateRefreshToken($id){
			try{
				$token_expiration_time = time()+REFRESH_TOKEN_VALID_DURATION;
				$tokenData = [
					'id'  => $id,
					'exp' => $token_expiration_time
				];
				$serialized = json_encode($tokenData);				
				$crypt = new Encryption();
				$refresh_token = $crypt->encrypt($serialized);
				return $refresh_token;
			} catch (Exception $e) {
				return null;
			}
		}

		function GenerateAccessToken($id, $session, $ttl){
			try{				
				$time_now = time();
				$token_genratig_time = $time_now + $ttl;
				$token = array(
							"iss" => $this->m_domaine,
							"iat" => $time_now,
							"nbf" => $time_now,
							"exp" => $token_genratig_time,
							"id"  => $id,
							"ses" => $session
						);		
				$access_token = $this->EncodeJWT($token);
				return $access_token;				
			} catch (Exception $e) {
				return null;
			}
		}		

		function UpdateAccessToken($id){
			try{						
				$AccessToken = $this->GenerateAccessToken($id, false, ACCESS_TOKEN_VALID_DURATION);
				return ($AccessToken!=null);
			}catch(Exception $e){
				return false;
			}
		}
		
		function CheckRefreshToken($token){
			try{
				$crypt = new Encryption();
				$serialized = json_decode($crypt->decrypt($token), true);
				if ( (isset($serialized)) && (array_key_exists('exp', $serialized))  && (array_key_exists('id', $serialized)) ){
					if (time() > $serialized['exp']){
						return array ("status"  => false,
									  "expire"  => true,
									  "message" => "refresh token expired");
					}else{
						return array ("status"  => true,
									  "expire"  => false,
									  "message" => "OK",
									  "id"      => $serialized['id']);
					}
				}else{
					return array ("status"  => false,
								  "expire"  => false,
								  "message" => "invalid refresh token");
				}

			} catch (Exception $e) {
				return array ("status"  => false,
							  "expire"  => false,
							  "message" => "exception occured");
			}
		}

		function CheckAccessToken($token){
			try{
				$decodedKey = $this->DecodeJWT($token);
				if ($decodedKey["iss"] == $this->m_domaine){					
					return array("status"  => true,
								 "expired" => false,
								 "message" => "authentified user",
								 "id"      => $decodedKey["id"],	
								 "session" => $decodedKey["ses"]);					
				}else{
					return array("status"  => false,
								 "expired" => false,
								 "message" => "invalid issuer");
				}
			}catch(Firebase\JWT\ExpiredException $e){
				return array("status"  => false,
							 "expired" => true,
							 "message" => "expired access token");

			}catch(Firebase\JWT\UnexpectedValueException $e){
				return array("status"  => false,
							 "expired" => false,
							 "message" => "invalid value");

			}catch(Firebase\JWT\SignatureInvalidException $e){
				return array("status"  => false,
							 "expired" => false,
							 "message" => "invalid signature");

			}catch(Firebase\JWT\BeforeValidException $e){					
				return array("status"  => false,
							 "expired" => false,	
							 "message" => "invalid access token");

			}catch(Firebase\JWT\DomainException $e){
				return array("status"  => false,
							  "expired" => false,	
							  "message" => "invalid encryption");

			}catch(Exception $e){				
				return array("status"  => false,
							 "expired" => false,	
							 "message" => "unhandled exception");
			}
		}

		function EncodeJWT($token){
			return JWT::encode($token, TOKEN_SECRET_KEY);
		}

		function DecodeJWT($jwt){
			return (array) JWT::decode($jwt, TOKEN_SECRET_KEY, array('HS256'));
		}
		
		function GetAuthorizationToken(){
			$token = null;
			$headers = apache_request_headers();
			if(isset($headers['Authorization'])){
				$token = $headers['Authorization'];
			}
			return $token;
		}
	}
?>
