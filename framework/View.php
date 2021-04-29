<?php
	session_start();

	class View {

		private $styles;
		private $header;
		private $body;
		private $scripts;
		private $dataView;

		public function __construct($action, $controller, $dataView) {
			$path = "views/";
			if ($controller != "") $path = $path . $controller . "/";

			$this->styles = $path . "css.php";
			if (!file_exists($this->styles)) $this->styles = null;

			$this->header = $path . "header.php";
			if (!file_exists($this->header)) $this->header = null;

			$this->body = $path . $action . ".php";

			$this->scripts = $path . "js.php";
			if (!file_exists($this->scripts)) $this->scripts = null;

			$this->dataView = $dataView;
		}

		public function build($dataTemplate) {		
			if ($this->styles != null){
				$dataTemplate['styles'] = $this->buildFile($this->styles, array());			
			}else{
				$dataTemplate['styles'] = "";
			}
			
			if ($this->header != null){
				$dataTemplate['header'] = $this->buildFile($this->header, array());			
			}else{
				$dataTemplate['header'] = "";
			}

			$dataTemplate['body'] = $this->buildFile($this->body, $this->dataView);
			
			if ($this->scripts != null){
				$dataTemplate['scripts'] = $this->buildFile($this->scripts, array());			
			}else{
				$dataTemplate['scripts'] = "";
			}
			
			echo $this->buildFile('views/template.php', $dataTemplate);			
		}

		private function buildFile($file, $data) {
			if (file_exists($file)) {
				if ($data != null) extract($data);
				ob_start();
				require $file;
				return ob_get_clean();
			}else{
				throw new Exception("The '$file' file is not found");
			}
		}
	}
?>