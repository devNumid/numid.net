<!-- BODY -->
<main class="main h-100" id="top">
	<div class="header">	
		<a href="#" class="logo"><img src="assets/img/logo.webp" alt="" width="48" height="48"></a> <span class="logo-title">NUMID WALLET</span>	
		<div class="header-right">
			<span class="text-center">
				<a class="links" href="https://t.me/numid">
					<img src="assets/img/telegram.webp" class="icone rounded" alt="" width="32" height="32" >
				</a>
				<a class="links" href="https://twitter.com/Numid6">
					<img src="assets/img/twitter.webp" class="icone rounded" alt="" width="32" height="32">
				</a>
				<a class="links" href="https://github.com/devNumid/numid.net">
					<img src="assets/img/github.webp" class="icone rounded" alt="" width="32" height="32">
				</a>
			</span>
			<a class="header-right-a" href="openwallet">Access wallet</a>
			<a class="header-right-a" href="createwallet">Create new wallet</a>
		</div>
	</div>
	<div class="min-header">
		<a href="#" class="logo"><img src="assets/img/logo.webp" alt="" width="48" height="48"></a>	
		<a href="#main_nav" id="access_nav" class="access_aid"></a>
		<nav id="main_nav">
			<ul>
				<li>
					<a class="header-right-a" href="openwallet">Access wallet</a>
				</li>
				<li>
					<a class="header-right-a" href="createwallet">Create new wallet</a>
				</li>
				<li>	
					<span class="text-center">
						<a class="links" href="https://t.me/numid">
							<img src="assets/img/telegram.webp" class="icone rounded" alt="" width="32" height="32" >
						</a>
						<a class="links" href="https://twitter.com/Numid6">
							<img src="assets/img/twitter.webp" class="icone rounded" alt="" width="32" height="32">
						</a>
						<a class="links" href="https://github.com/devNumid/numid.net">
							<img src="assets/img/github.webp" class="icone rounded" alt="" width="32" height="32">
						</a>
					</span>
				</li>			
			</ul>
			<p><a href="#body" id="access_top" class="access_aid">Skip to top</a></p>
		</nav>
		<script>
			var nav = document.getElementById('access_nav'),
				body = document.body;

			nav.addEventListener('click', function(e) {
				body.className = body.className? '' : 'with_nav';
				e.preventDefault();
			});
		</script>
	</div>
	<div class="container" data-layout="container" style="top:100px;margin-bottom:200px;">
		<!-- MAIN -->
		<div class="content h-100">
			<div>
			
				<!-- TMP -->
				<!-- CHRONO -->	
				<?php require_once ROOT_PATH.'/views/chrono.php'; ?>
				<!-- TMP -->
				
				<div class="row d-flex justify-content-center mt-2">
					<div class="col-sm-10 col-md-5 col-lg-4 col-xl-4 col-xxl-4 mt-2">
						<div class="card bg-card-gradient">
							<div class="card-body">
								<img src="assets/img/logo.webp" alt="" width="50" height="50">
								<p style="margin-left:10px;color:#6E7479;font-weight:bold;font-size:14px;">WELCOME BACK</p>
								<h5 style="height:100px;">Access your existing Cardano wallet here</h5>
								<button type="button" class="btn btn-secondary" onclick="window.location.replace('openwallet');">ACCESS WALLET</button>
							</div>
						</div>
					</div>
					<div class="col-sm-10 col-md-5 col-lg-4 col-xl-4 col-xxl-4 mt-2">
						<div class="card bg-card-gradient">
							<div class="card-body">
								<img src="assets/img/logo.webp" alt="" width="50" height="50">
								<p style="margin-left:10px;color:#6E7479;font-weight:bold;font-size:14px;">NEW TO NUMID ?</p>
								<h5 style="height:100px;">Create new wallet to send, recieve and stake ADA tokens</h5>
								<button type="button" class="btn btn-danger" onclick="window.location.replace('createwallet');">CREATE NEW WALLET</button>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row d-flex justify-content-center mt-5">
				<div class="col-sm-10 col-md-5 col-lg-4 col-xl-4 col-xxl-4 mt-2">
					<div class="text-justify slide">
						<h6><i class="far fa-star fa-3x" style="color:#f5803e"></i><span style="margin-left:20px;">Numid wallet</span></h6>
						<p><span style="color:#FFF;font-size:14px;"> Numid is a simple, secure, non-custodial wallet for storing and staking ADA on the cardano blockchain</span></p>
					</div>
				</div>
				<div class="col-sm-10 col-md-5 col-lg-4 col-xl-4 col-xxl-4 mt-2">
					<div class="text-justify slide">
						<h6><i class="fas fa-award fa-3x" style="color:#f5803e"></i><span style="margin-left:20px;">The hightest rewards</span></h6>
						<p><span style="color:#FFF;font-size:14px;"> The first wallet that gives you the ability to build stakepools without the hassle of running and maintaining a node. By sharing your affiliation link and growing your network you can earn 2% pool rewards on top of your 5% staking rewards !</span></p>
					</div>
				</div>
			</div>
			<div class="row d-flex justify-content-center mt-2">
				<div class="col-sm-10 col-md-5 col-lg-4 col-xl-4 col-xxl-4 mt-2">
					<div class="text-justify slide">
						<h6><i class="fas fa-question fa-3x" style="color:#f5803e"></i><span style="margin-left:20px;">What is staking</span></h6>
						<p><span style="color:#FFF;font-size:14px;">Staking in the crypto ecosystem entails locking your crypto assets to participate in validating transactionsn on the network. In the case of Cardano you delegate your ADA through your wallet to a staking pool which is run by a pool operator to process and secure operations on the blockchain. In return you recieve rewards every epoch (5 days) from which the staking pool takes a small fee, in this case 5%.</span></p>
					</div>
				</div>
				<div class="col-sm-10 col-md-5 col-lg-4 col-xl-4 col-xxl-4 mt-2">
					<div class="text-justify slide">
						<h6><i class="fas fa-comments-dollar fa-3x" style="color:#f5803e"></i><span style="margin-left:20px;">Why stake with Numid wallet</span></h6>
						<p><span style="color:#FFF;font-size:14px;">What makes Numid wallet unique compared to other solutions is the ability to not only earn rewards on your stake but also on your affiliates. 2% of the pool rewards will be sent to refferals for the total amount staked by their affiliates. So the larger your network the bigger rewards you get.</span></p>
					</div>
				</div>
			</div>
		</div>
	</div>
	<footer class="text-center text-lg-start bg-light text-muted">
		<div class="text-center corp p-2">
			© 2021 Copyright:
			<a class="text-reset fw-bold" href="https://numid.net">Numid.net</a>
			<p>By using this application you agree to the <a href="terms">Terms of Use.</a><p>
		</div>
	</footer>
</main>