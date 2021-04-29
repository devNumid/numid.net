<?php
	// CONSTANTES
	define("SERVER_WALLET_URL", "https://localhost:8090");
	
	class WalletApi{

		public function EntryPoint($dataArray){	
			switch ($_data['method']) {
				/* WALLETS */
				case "wallet-create":                            // POST   https://localhost:8090/v2/wallets
				case "wallet-list":                              // GET    https://localhost:8090/v2/wallets
				case "wallet-Statistics":                        // GET    https://localhost:8090/v2/wallets/{walletId}/statistics/utxos
				case "wallet-get":                               // GET    https://localhost:8090/v2/wallets/{walletId}
				case "wallet-delete":                            // DELETE https://localhost:8090/v2/wallets/{walletId}
				case "wallet-update_metadata": 	                 // PUT    https://localhost:8090/v2/wallets/{walletId}
				case "wallet-update_passphrase":	             // PUT    https://localhost:8090/v2/wallets/{walletId}/passphrase
				/* ASSETS */
				case "asset-list_assets":                        // GET    https://localhost:8090/v2/wallets/{walletId}/assets
				case "asset-get_assets":                         // GET    https://localhost:8090/v2/wallets/{walletId}/assets/{policyId}/{assetName}
				case "asset-list_assets_empty_name":             // GET    https://localhost:8090/v2/wallets/{walletId}/assets/{policyId}
				/* ADDRESSES */
				case "addresse-get":                             // GET    https://localhost:8090/v2/wallets/{walletId}/addresses
				case "addresse-inspect_address":   	             // GET    https://localhost:8090/v2/addresses/{addressId}
				case "addresse-construct_address":               // POST   https://localhost:8090/v2/addresses
				/* COIN SELECTIONS */
				case "coin-selection_random":                    // POST   https://localhost:8090/v2/wallets/{walletId}/coin-selections/random
				/* TRANSACTIONS */
				case "transaction-estimate_fee":                 // POST   https://localhost:8090/v2/wallets/{walletId}/payment-fees
				case "transaction-create":                       // POST   https://localhost:8090/v2/wallets/{walletId}/transactions
				case "transaction-list":                         // GET    https://localhost:8090/v2/wallets/{walletId}/transactions
				case "transaction-get":                          // GET    https://localhost:8090/v2/wallets/{walletId}/transactions/{transactionId}
				case "transaction-forget":                       // DELETE https://localhost:8090/v2/wallets/{walletId}/transactions/{transactionId}
				/* MIGRATIONS */
				case "migration-migrate":                        // POST   https://localhost:8090/v2/wallets/{walletId}/migrations
				case "migration-calculate_cost":                 // GET    https://localhost:8090/v2/wallets/{walletId}/migrations
				/* STAKE POOLS */
				case "stakepool-list":                           // GET    https://localhost:8090/v2/stake-pools
				case "stakepool-View_maintenance_actions":       // GET    https://localhost:8090/v2/stake-pools/maintenance-actions
				case "stakepool-trigger_maintenance_actions":    // POST   https://localhost:8090/v2/stake-pools/maintenance-actions
				case "stakepool-estimate_fee":                   // GET    https://localhost:8090/v2/wallets/{walletId}/delegation-fees
				case "stakepool-quit":                           // DELETE https://localhost:8090/v2/stake-pools/*/wallets/{walletId}
				case "stakepool-join":                           // PUT    https://localhost:8090/v2/stake-pools/{stakePoolId}/wallets/{walletId}
				/* KEYS */
				case "key-create":                               // POST   https://localhost:8090/v2/wallets/{walletId}/keys/{index}
				case "key-get_public_key":                       // GET    https://localhost:8090/v2/wallets/{walletId}/keys/{role}/{index}
				/* UTILS */
				case "util-current_smash_health":                // GET    https://localhost:8090/v2/smash/health
				/* NETWORK */
				case "network-information":                      // GET    https://localhost:8090/v2/network/information
				case "network-clock":                            // GET    https://localhost:8090/v2/network/clock
				case "network-parameters":                       // GET    https://localhost:8090/v2/network/parameters
				/* PROXY */
				case "proxy-submit_external_transaction":        // POST   https://localhost:8090/v2/proxy/transactions
				/* SETTINGS */
				case "settings-update_settings":                 // PUT    https://localhost:8090/v2/settings
				case "settings-get_settings":                    // GET    https://localhost:8090/v2/settings
				/* EXPERIMENTAL */
				case "experimental-sign_metadata":               // POST   https://localhost:8090/v2/wallets/{walletId}/signatures/{role}/{index}

					$_req = $this->SendRequest(SERVER_WALLET_URL.$_data['params']['uri'], $_data['params']['method'], $_data['params']['json']);
					switch ($_req['http_code']){
						case 200: /* OK */
						case 201: /* CREATED */
						case 202: /* ACCEPTED */
							$_response = json_decode($_req['http_response'], true);
							if (json_last_error() == JSON_ERROR_NONE){
								return (array("status"    => true,
											  "http_code" => $_req['http_code'],
											  "data"      => $_response));
							}else{
								return (array("status" => false,
											  "error"  => "invalid json"));
							}
							break;

						case 204: /* NO CONTENT */
							return (array("status"    => true,
										  "http_code" => $_req['http_code'],
										  "data"      => null));
							break;

						case 400: /* BAD REQUEST */
						case 403: /* FORBIDDEN */
						case 404: /* NOT FOUND */
						case 406: /* NOT ACCEPTABLE */
						case 409: /* CONFLICT */
						case 415: /* UNSUPPORTED MEDIA TYPE */
							$_response = json_decode($_req['http_response'], true);
							if (json_last_error() == JSON_ERROR_NONE){
								return (array("status"    => false,
											  "http_code" => $_req['http_code'],
											  "data"      => $_response));
							}else{
								return (array("status" => false,
											  "error"  => "invalid json"));
							}
							break;

						default :
							return (array("status" => false,
										  "error"  => "unhandled response",
										  "data"   => $_req));
					}
					break;

				default:
					return (array("status" => false,
								  "error"  => "invalid commande"));
			}
		}

		private function SendRequest($_url, $_methode, $_payload){
			if ($_payload == null){
				$options = array(
						CURLOPT_CUSTOMREQUEST  => $_methode,
						CURLOPT_RETURNTRANSFER => true,
						CURLOPT_HEADER         => false,
						CURLOPT_FOLLOWLOCATION => true,
						CURLOPT_MAXREDIRS      => 10,
						CURLOPT_ENCODING       => "",
						CURLOPT_USERAGENT      => "numid.net",
						CURLOPT_AUTOREFERER    => true,
						CURLOPT_CONNECTTIMEOUT => 120,
						CURLOPT_TIMEOUT        => 120,
				);
			}else{
				$options = array(
						CURLOPT_CUSTOMREQUEST  => $_methode,
						CURLOPT_HTTPHEADER     => array('Content-Type: application/json'),
						CURLOPT_POSTFIELDS     => $_payload,
						CURLOPT_RETURNTRANSFER => true,
						CURLOPT_HEADER         => false,
						CURLOPT_FOLLOWLOCATION => true,
						CURLOPT_MAXREDIRS      => 10,
						CURLOPT_ENCODING       => "",
						CURLOPT_USERAGENT      => "numid.net",
						CURLOPT_AUTOREFERER    => true,
						CURLOPT_CONNECTTIMEOUT => 120,
						CURLOPT_TIMEOUT        => 120,
				);
			}
			$ch = curl_init($_url);
			curl_setopt_array($ch, $options);
			$_response = curl_exec($ch);
			$_httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			curl_close($ch);
			return array("http_response" => $_response, "http_code" => $_httpcode);
		}
	}
?>