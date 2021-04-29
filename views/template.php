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
		<?= $styles; ?>		
	</head>
	<body class="h-100" style="">
		<!-- MAIN -->
		<main class="main h-100" id="top">
			<div class="container h-100" data-layout="container">
				<?php if($visibility){ ?>
				<!-- LEFT NAVBAR -->
				<nav class="navbar navbar-light navbar-vertical navbar-expand-xl">
					<div class="d-flex align-items-center">						
						<a class="navbar-brand" href="index.html">
							<div class="d-flex align-items-center py-3"><img src="assets/img/logo.webp" alt="" width="70" height="70"></div>
						</a>
					</div>					
					<div class="collapse navbar-collapse" id="navbarVerticalCollapse">
						<div class="navbar-vertical-content scrollbar">
							<ul class="navbar-nav flex-column mb-3" id="navbarVerticalNav">
								<li class="nav-item">
									<div class="row mt-3 mb-2">
										<div class="col-auto navbar-vertical-label">Menu</div>
										<div class="col ps-0">
											<hr class="mb-0 navbar-vertical-divider">
										</div>
									</div>										
									<a class="nav-link <?= $menu['dashboard']; ?>" href="dashboard" role="button">
										<div class="d-flex align-items-center">
											<span class="nav-link-icon">
												<i class="fas fa-home"></i>
											</span>
											<span class="nav-link-text ps-1">Dashboard</span>
										</div>
									</a>
									<a class="nav-link <?= $menu['rewards']; ?>" href="rewards" role="button">
										<div class="d-flex align-items-center">
											<span class="nav-link-icon">
												<i class="fas fa-star"></i>
											</span>
											<span class="nav-link-text ps-1">Rewards</span>
										</div>
									</a>
									<a class="nav-link <?= $menu['referral']; ?>" href="referral" role="button">
										<div class="d-flex align-items-center">
											<span class="nav-link-icon">
												<i class="fas fa-users"></i>
											</span>
											<span class="nav-link-text ps-1">Referral program</span>
										</div>
									</a>								
									<a class="nav-link <?= $menu['withdraw']; ?>" href="withdraw" role="button">
										<div class="d-flex align-items-center">
											<span class="nav-link-icon">
												<i class="fas fa-landmark"></i>
											</span>
											<span class="nav-link-text ps-1">Withdraw</span>
										</div>
									</a>									
									<a class="nav-link <?= $menu['contact']; ?>" href="contact" role="button">
										<div class="d-flex align-items-center">
											<span class="nav-link-icon">
												<i class="fas fa-headset"></i>
											</span>
											<span class="nav-link-text ps-1">Contact</span>
										</div>
									</a>
									<a class="nav-link <?= $menu['logout']; ?>" href="logout" role="button">
										<div class="d-flex align-items-center">
											<span class="nav-link-icon">
												<i class="fas fa-sign-out-alt"></i>
											</span>
											<span class="nav-link-text ps-1">Logout</span>
										</div>
									</a>							
								</li>
							</ul>
						</div>
					</div>					
				</nav>
				<?php } ?>
				<!-- MAIN -->
				<div class="content h-100">
					<?php if($visibility){ ?>
					<!-- TOP NAVBAR -->	
					<nav class="navbar navbar-light navbar-glass navbar-top navbar-expand">
						<button class="btn navbar-toggler-humburger-icon navbar-toggler me-1 me-sm-3" type="button" data-bs-toggle="collapse" data-bs-target="#navbarVerticalCollapse" aria-controls="navbarVerticalCollapse" aria-expanded="false" aria-label="Toggle Navigation"><span class="navbar-toggle-icon"><span class="toggle-line"></span></span></button>
						<a class="navbar-brand me-1 me-sm-3" href="index.html">
							<div class="d-flex align-items-center py-3"><img src="assets/img/logo.webp" alt="" width="70" height="70"></div>
						</a>						
					</nav>
					<?php } ?>
					<!-- BODY -->	
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
				</div>
			</div>
		</main>
		<!-- JS -->
		<script src="assets/modules/jquery/js/jquery-3.6.0.min.js"></script>		
		<script src="assets/modules/bootstrap/v5.0.0-beta1/js/bootstrap.min.js"></script>
		<script src="https://kit.fontawesome.com/2c02d2a00d.js" crossorigin="anonymous"></script>		
		<script src="assets/js/logreg.min.js"></script>
		<?= $scripts; ?>
	</body>
</html>