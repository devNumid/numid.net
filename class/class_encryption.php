<?php
	require_once ROOT_PATH."/config/config_encryption.php";

	class Encryption{

		private $cipher;
		private $algo;
		private $cryptkey;

		public function __construct() {
			$this->cipher = ENCRYPT_CIPHER;
			$this->algo = ENCRYPT_ALGO;
			$this->cryptkey = ENCRYPT_KEY;
		}

		public function encrypt($plaintext){
			$ivlen = openssl_cipher_iv_length($this->cipher);
			$iv = openssl_random_pseudo_bytes($ivlen);
			$ciphertext_raw = openssl_encrypt($plaintext, $this->cipher, $this->cryptkey, $options=OPENSSL_RAW_DATA, $iv);
			$hmac = hash_hmac($this->algo, $ciphertext_raw, $this->cryptkey, $as_binary=true);
			return base64_encode( $iv.$hmac.$ciphertext_raw );
		}

		public function decrypt($ciphertext){
			$c = base64_decode($ciphertext);
			$ivlen = openssl_cipher_iv_length($this->cipher);
			$iv = substr($c, 0, $ivlen);
			$hmac = substr($c, $ivlen, $sha2len=32);
			$ciphertext_raw = substr($c, $ivlen+$sha2len);
			$original_plaintext = openssl_decrypt($ciphertext_raw, $this->cipher, $this->cryptkey, $options=OPENSSL_RAW_DATA, $iv);
			$calcmac = hash_hmac($this->algo, $ciphertext_raw, $this->cryptkey, $as_binary=true);
			if (hash_equals($hmac, $calcmac)){
				return $original_plaintext;
			}else{
				return null;
			}
		}
	}
?>