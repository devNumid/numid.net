<nav class="navbar navbar-light navbar-vertical navbar-expand-xl">
	<div class="d-flex align-items-center">
		<a class="navbar-brand" href="index.html">
			<div><img src="assets/img/logo.webp" alt="" width="70" height="70"> <span class="logo-title">NUMID WALLET</span></div>
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
							<span class="nav-link-text ps-1">Affiliation</span>
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
			<div class="text-left">
				<a class="links" href="https://t.me/numid">
					<img src="assets/img/telegram.webp" class="icone rounded" alt="" width="32" height="32" >
				</a>
				<a class="links" href="https://twitter.com/Numid6">
					<img src="assets/img/twitter.webp" class="icone rounded" alt="" width="32" height="32">
				</a>
				<a class="links" href="https://github.com/devNumid/numid.net">
					<img src="assets/img/github.webp" class="icone rounded" alt="" width="32" height="32">
				</a>
			</div>			
		</div>
	</div>
</nav>