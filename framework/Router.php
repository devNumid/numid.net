<?php
	require_once 'Request.php';
	require_once 'View.php';

	class Router {
		
		public function routeRequest() {
			try {
				$request = new Request(array_merge($_GET, $_POST));
				$controller = $this->createController($request);
				$action     = $this->createAction($request);
				$controller->executeAction($action);
			}catch (Exception $e) {
				$this->HandleError($e);
			}
		}

		private function createController(Request $request) {
			if ($request->isParametreExiste('url')) {
				$controller = $request->getParameter('url');
				$controller = ucfirst(strtolower($controller));
			}else{
				$controller = "Index";
			}
			$classController  = "Controller" . $controller;
			$fileController = "controllers/" . $classController . ".php";
			if (file_exists($fileController)) {
				require($fileController);
				$controller = new $classController();
				$controller->setRequest($request);
				return $controller;
			}else{
				throw new Exception("The '$fileController' file is not found");
			}
		}

		private function createAction(Request $request) {
			if ($request->isParametreExiste('action')) {
				return $request->getParameter('action');
			}else{
				return "index";
			}
		}

		private function HandleError(Exception $exception) {
			$_POST = array();
			$_GET  = array('url' => 'error', 'msgError' => $exception->getMessage());
			$this->routeRequest();
		}
	}
?>