<main class="main h-100" id="top">
	<div class="container h-100" data-layout="container">
		<!-- MENU -->
		<?php require_once ROOT_PATH.'/views/menu.php'; ?>
		<!-- MAIN -->
		<div class="content h-100">
			<!-- TOP NAVBAR -->	
			<?php require_once ROOT_PATH.'/views/navbar.php'; ?>
			
			<!-- TMP -->
			<!-- CHRONO -->	
			<?php require_once ROOT_PATH.'/views/chrono.php'; ?>
			<!-- TMP -->
			
			<!-- BODY -->	
			<div class="row justify-content-md-center mt-5">	
				<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-3 pe-md-2">
					<div class="card h-md-100">
						<div class="card-header pb-0">
							<h6 class="mb-0 mt-2 d-flex align-items-center">Withdrawable funds</h6>
						</div>
						<div class="bg-holder bg-card" style="background-image:url(assets/img/bg-card_3);"></div>
						<div class="card-body d-flex" style="z-index:100;">
							<div class="row flex-grow-1">
								<div class="col">
									<div class="fs-4 fw-normal font-sans-serif text-700 lh-1 mb-1"><?= $withdrawble_balance; ?></div>
								</div>
								<div class="col-auto ps-0">
									<img src="assets/img/ada.white.webp" width="32" heigth="32"/>
								</div>
							</div>
						</div>
						<div class="card-footer text-muted" style="z-index:100;">
							<table>
							<tr>
								<td style="text-align:left;"><h6 class="d-flex" style="color:#F5803E">Wallet balance</h6></td>
								<td style="text-align:right;"><h6 style="margin-left:10px;"><?= $avaible_balance; ?><img style="margin-left:3px;" src="assets/img/ada.white.webp" width="12" heigth="12"/></h6></td>
							</tr>
							<tr>
								<td style="text-align:left;"><h6 class="d-flex" style="color:#F5803E">Rewards balance</h6></td>
								<td style="text-align:right;"><h6 style="margin-left:10px;"><?= $delegation_balance; ?><img style="margin-left:3px;" src="assets/img/ada.white.webp" width="12" heigth="12"/></h6></td>
							</tr>
							</table>
						</div>
					</div>
				</div>
				<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-3 pe-md-2">
					<div class="card h-md-100">
						<div class="card-header pb-0">
							<h6 class="mb-0 mt-2 d-flex align-items-center">Affiliation rewards</h6>
						</div>
						<div class="bg-holder bg-card" style="background-image:url(assets/img/bg-card_4);"></div>
						<div class="card-body d-flex" style="z-index:100;">
							<div class="row flex-grow-1">
								<div class="col">
									<div class="fs-4 fw-normal font-sans-serif text-700 lh-1 mb-1"><?= $afiiliation_balance; ?></div>
								</div>
								<div class="col-auto ps-0">
									<img src="assets/img/ada.white.webp" width="32" heigth="32"/>
								</div>
							</div>
						</div>
						<div class="card-footer text-muted" style="z-index:100;">
							<form id="frm-getaffiliationrewards" data-url="/withdraw/claim" data-method="post" class="needs-validation" data-selector="modal" novalidate>
								<button class="btn btn-falcon-warning btn-sm" type="submit"><i class="fas fa-gift"></i> Claim</button>
							</form>
						</div>
					</div>
				</div>
			</div>
			<div class="row justify-content-md-center">
				<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-3 pe-md-2">
					<div class="card h-md-100">
						<div class="card-header pb-0">
							<h6 class="mb-0 mt-2 d-flex align-items-center">withdraw funds</h6>
						</div>
						<div class="bg-holder bg-card" style="background-image:url(assets/img/bg-card_1);"></div>
						<div class="card-body d-flex" style="z-index:100;">
							<div class="row flex-grow-1">
								<div class="col">
									<form id="frm-getwithdrawfee" data-url="withdraw/request" data-method="post" data-selector="modal" class="needs-validation" novalidate>
										<div class="text-center">
											<div class="form-group">
												<div class="input-group">
													<div id="wallet-list" style="width:100%">
														<?= $wallet_list; ?>
													</div>
													<div class="valid-feedback text-left"></div>
													<div class="invalid-feedback text-left">Please fill out this field.</div>
												</div>
											</div>
											<div class="form-group mt-4">
												<div class="input-group">
													<input id="amount" type="number" class="form-control" name="amount" placeholder="Amount" min="1" data-selector="serialize" required>
													<button type="button" class="btn btn-falcon-warning mr-1 mb-1" style="width:130px;" Onclick="SetMaxWithdraw();"><i class="fas fa-university"></i> Max</button>
													<div class="valid-feedback text-left"></div>
													<div class="invalid-feedback text-left">Please fill out this field.</div>
												</div>
											</div>
											<button class="btn btn-lg btn-outline-warning btn-block mt-4" type="submit">WITHDRAW</button>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-3 pe-md-2">
					<div class="card h-md-100">
						<div class="card-header pb-0">
							<h6 class="mb-0 mt-2 d-flex align-items-center">Add recipient address</h6>
						</div>
						<div class="bg-holder bg-card" style="background-image:url(assets/img/bg-card_2);"></div>
						<div class="card-body d-flex" style="z-index:100;">
							<div class="row flex-grow-1">
								<div class="col">
									<form id="frm-addwallet" data-url="withdraw/register" data-method="post" data-selector="modal" class="needs-validation" novalidate>
										<div class="text-center">
											<div class="form-group">
												<input type="text" class="form-control" name="recipient-name" placeholder="Name" minlength="4" maxlength="20" data-selector="serialize" required>
												<div class="valid-feedback text-left"></div>
												<div class="invalid-feedback text-left">Please fill out this field.</div>
											</div>
											<div class="form-group mt-4">
												<input type="text" class="form-control" name="recipient-address" placeholder="Address" maxlength="103" data-selector="serialize" required>
												<div class="valid-feedback text-left"></div>
												<div class="invalid-feedback text-left">Please fill out this field.</div>
											</div>
											<button class="btn btn-lg btn-outline-warning btn-block mt-4" type="submit">ADD</button>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- xMODAL 1 -->
			<div id="send-withdraw" class="modal fade" tabindex="-1" role="dialog">
				<div class="modal-dialog modal-dialog-centered" role="document">
					<div class="modal-content">
						<div class="card w-100">
							<div class="card-header pb-0">
								<h6 class="mb-0 mt-2 d-flex align-items-center" style="font-size:18px;color:#F5803E;"><i class="fas fa-sign-in-alt"></i> Withdraw</h6>
							</div>
							<div class="bg-holder bg-card" style="background-image:url(assets/img/bg-card_1);"></div>
							<div class="card-body d-flex" style="z-index:100;">
								<form id="frm-withdraw" data-url="/withdraw/send" data-method="post" data-selector="modal" class="needs-validation w-100" novalidate>
									<div name="alert-info" class=""></div>
									<span>ACCOUNT</span>
									<div class="input-group mb-2">
										<input type="text" class="form-control" name="account" readonly>
									</div>
									<span>AMOUNT</span>
									<div class="input-group mb-2">
										<input type="text" class="form-control" name="amount" readonly>
										<div class="input-group-append">
											<span class="input-group-text"><strong>ADA</strong></span>
										</div>
									</div>
									<span>FEE</span>
									<div class="input-group mb-2">
										<input type="text" class="form-control" name="fee" readonly>
										<div class="input-group-append">
											<span class="input-group-text"><strong>ADA</strong></span>
										</div>
									</div>
									<span>PASSPHRASE</span>
									<div class="form-group mt-2">
										<input type="password" class="form-control" name="passphrase" placeholder="Passphrase" maxlength="50" data-selector="serialize" required>
										<div class="valid-feedback text-left"></div>
										<div id="c-txtpwd" class="invalid-feedback text-left">Please fill out this field with at minimum 10 characters.</div>
									</div>
									<div class="text-center">
										<button class="btn btn-lg btn-outline-warning btn-block mt-4" type="submit">SEND WITHDRAW</button>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>			
		</div>
	</div>
</main>

