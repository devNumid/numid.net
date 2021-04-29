<?php
	abstract class Controller {

		private $action;
		protected $request;

		public function setRequest(Request $request) {
			$this->request = $request;
		}

		public function executeAction($action) {
			if (method_exists($this, $action)) {
				$this->action = $action;
				$this->{$this->action}();
			}else {
				throw new Exception("This action '$action' is undefined in ".get_class($this)." class");
			}
		}

		public abstract function index();

		protected function buildView($DataArray) {
			$controller = str_replace("Controller", "", get_class($this));
			$view = new View($this->action, $controller, $DataArray['dataView']);
			$view->build($DataArray['dataTemplate']);
		}
	}
?>