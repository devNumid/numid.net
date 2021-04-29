<?php
	class Request {
		
		private $parametres;

		public function __construct($parametres) {
			$this->parametres = $parametres;
		}

		public function isParametreExiste($name) {
			return (isset($this->parametres[$name]) && $this->parametres[$name] != "");
		}

		public function getParameter($name) {
			if ($this->isParametreExiste($name)) {
				return $this->parametres[$name];
			}else{
				throw new Exception("The '$name' param is missing from the request");
			}
		}
	}
?>