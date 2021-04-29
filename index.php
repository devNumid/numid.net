<?php
	require_once 'framework/Router.php';
	require_once 'config/config_php.php';
	require_once 'config/config_constants.php';		
		
	$router = new Router();
	$router->routeRequest();
?>