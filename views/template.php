<!DOCTYPE html>
<html lang="en-US" class="dark chrome windows fontawesome-i2svg-active fontawesome-i2svg-complete h-100">
	<head>
		<title><?= $titre; ?></title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="theme-color" content="#ffffff">
		<link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.ico">		
		<link href="assets/css/custom.min.css" rel="stylesheet">		
		<link href="assets/css/theme.min.css" rel="stylesheet" id="style-default">
		<!-- TMP -->
		<link href="assets/modules/countdown/css/flipdown.css" rel="stylesheet">
		<!-- TMP -->
		<?= $styles; ?>		
	</head>
	<body class="h-100" style="">				
		<!-- MAIN -->
		<?= $body; ?>	
		<!--WAITING -->
		<div id="loading-indicator" class="load-disable_background hidediv">
			<img src="assets/img/loading.gif" class="load-indicator"/>
			<div class="load-text">Please wait...</div>
		</div>
		<!-- xMODAL -->
		<div id="alert-message" class="modal fade" tabindex="-1" role="dialog">
			<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="card h-md-100 w-100">		
					<div class="card-header pb-0">
						<h6 id="xTitre" class="mb-0 mt-2 d-flex align-items-center" style="font-size: 18px;"></h6>
					</div>
					<div class="bg-holder bg-card" style="background-image:url(assets/img/bg-card_3);"></div>   
					<div class="card-body d-flex" style="z-index:100;">
						<p><div id="xMessage" style="color:#FFF;"></div></p>
					</div>								
				</div>						
			</div>
		</div>
		<!-- JS -->
		<script src="assets/modules/jquery/js/jquery-3.6.0.min.js"></script>		
		<script src="assets/modules/bootstrap/v5.0.0-beta1/js/bootstrap.min.js"></script>
		<script src="https://kit.fontawesome.com/2c02d2a00d.js" crossorigin="anonymous"></script>		
		<script src="assets/js/logreg.js"></script>
		<!-- TMP -->
		<script src="assets/modules/countdown/js/flipdown.js"></script>
		<!-- TMP -->
		<?= $scripts; ?>
	</body>
</html>