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
				<div id="syncing" class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-3 pe-md-2 <?= $isSyncing; ?>">
					<div class="card h-md-100">
						<div class="card-header pb-0">
							<h6 class="mb-0 mt-2 d-flex align-items-center">Balance</h6>
						</div>
						<div class="bg-holder bg-card" style="background-image:url(assets/img/bg-card_3);"></div>
						<div class="card-body d-flex" style="z-index:100;">
							<div class="row flex-grow-1">
								<div class="col">
									<div class="fs-4 fw-normal font-sans-serif text-700 lh-1 mb-1">Sync</div>
								</div>
								<div class="col">
									<div class="progress">
										<div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="<?= $progress; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?= $progress; ?>%"></div>
									</div>
								</div>
							</div>
						</div>
						<div class="card-footer text-muted" style="z-index:100;">
							<button type="button" class="btn btn-falcon-warning btn-sm mr-1 mb-1" onclick="window.location.replace('dashboard');"><i class="fas fa-sync-alt"></i> Refresh</button>
							<span class="badge badge-soft-primary mb-1 ml-2"><?= $progress; ?>%</span>
						</div>
					</div>
				</div>
				<div id="ready" class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-3 pe-md-2 <?= $isReady; ?>">
					<div class="card h-md-100">
						<div class="card-header pb-0">
							<h6 class="mb-0 mt-2 d-flex align-items-center">Balance</h6>
						</div>
						<div class="bg-holder bg-card" style="background-image:url(assets/img/bg-card_3);"></div>
						<div class="card-body d-flex" style="z-index:100;">
							<div class="row flex-grow-1">
								<div class="col">
									<div class="fs-4 fw-normal font-sans-serif text-700 lh-1 mb-1"><?= $balance; ?></div>
								</div>
								<div class="col-auto ps-0">
									<img src="assets/img/ada.white.webp" width="32" heigth="32"/>
								</div>
							</div>
						</div>
						<div class="card-footer text-muted" style="z-index:100;">
							<h6 class="d-flex align-items-center mb-3">Address</h6>
							<div class="input-group">
								<textarea id="AccountID" type="text" class="form-control" name="mnemonic" placeholder="Mnemonic words" rows="1" cols="10" style="overflow:hidden;resize:none;margin-right:20px;" readonly><?= $address; ?></textarea>
								<button id="cptxt" data-clipboard-target="#AccountID" class="btn btn-falcon-warning btn-sm" type="button" onclick="CopieToClipboard('cptxt');"><i class="fas fa-copy"></i> Copy</button>
							</div>
						</div>
					</div>
				</div>
				<div id="not-responding" class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-3 pe-md-2 <?= $isNotResponding; ?>">
					<div class="card h-md-100">
						<div class="card-header pb-0">
							<h6 class="mb-0 mt-2 d-flex align-items-center">Balance</h6>
						</div>
						<div class="bg-holder bg-card" style="background-image:url(assets/img/bg-card_3);"></div>
						<div class="card-body d-flex" style="z-index:100;">
							<div class="row flex-grow-1">
								<div class="col">
									<div class="fs-4 fw-normal font-sans-serif text-700 lh-1 mb-1">Not responding</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-3 pe-md-2">
					<div class="card h-md-100">
						<div class="card-header pb-0">
							<h6 class="mb-0 mt-2 d-flex align-items-center">ADA Price chart</h6>
						</div>
						<div class="bg-holder bg-card" style="background-image:url(assets/img/bg-card_4);"></div>
						<div class="card-body d-flex" style="z-index:100;">
							<div class="row flex-grow-1">
								<div class="col">
									<div class="tradingview-widget-container">
										<div id="tradingview_490c2"></div>												
										<script type="text/javascript" src="https://s3.tradingview.com/tv.js"></script>
										<script type="text/javascript">
											new TradingView.widget({
												"autosize": true,		
												"symbol": "KRAKEN:ADAUSD",
												"interval": "D",
												"timezone": "Etc/UTC",
												"theme": "dark",
												"style": "3",
												"locale": "en",
												"toolbar_bg": "#F5803E",
												"enable_publishing": false,
												"hide_top_toolbar": true,
												"hide_legend": true,
												"save_image": false,
												"container_id": "tradingview_490c2"
											});
										</script>					
									</div>
								</div>
							</div>
						</div>
						<div class="card-footer text-muted" style="z-index:100;">			
							<a href="https://fr.tradingview.com/symbols/ADAUSD/?exchange=KRAKEN" rel="noopener" target="_blank"><span style="color:#F5803E;">Provided by TradingView</span></a>
						</div>
					</div>
				</div>
			</div>
			<div class="row justify-content-md-center">
				<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 mb-3 pe-md-2 <?= $isReady; ?>">
					<div class="card h-md-100">
						<div class="card-header pb-0">
							<h6 class="mb-0 mt-2 d-flex align-items-center">Delegation</h6>
						</div>
						<div class="bg-holder bg-card" style="background-image:url(assets/img/bg-card_2);"></div>
						<div class="card-body d-flex" style="z-index:100;">
							<div class="container h-100">
								<div class="row h-100 justify-content-center align-items-center">
									<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 px-1 py-1">
										<?= $delegation_message; ?>
									</div>
									<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 px-1 py-1">
										<?= $pools; ?>
									</div>
								</div>
							</div>
						</div>
						<div class="card-footer text-muted" style="z-index:100;">
							<?= $delegation_action; ?>
						</div>
					</div>
				</div>
			</div>
			<div class="row justify-content-md-center">
				<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 mb-3 pe-md-2 <?= $isReady; ?>">
					<div class="card h-md-100">
						<div class="card-header pb-0">
							<h6 class="mb-0 mt-2 d-flex align-items-center">Transactions History</h6>
						</div>
						<div class="bg-holder bg-card" style="background-image:url(assets/img/bg-card_3);"></div>
						<div class="card-body d-flex" style="z-index:100;">
							<div class="row flex-grow-1">
								<div class="col">
									<div class="table-responsive mt-3">
										<table id="trxmin" class="table table-sm table-dashboard data-table no-wrap mb-0 fs--1 w-100">
											<thead class="bg-200">
												<tr>										
													<th class="sort">Tx N°</th>
													<th class="sort">Amount (ADA)</th>
													<th class="sort">Date</th>
												</tr>
											</thead>
											<tbody class="bg-white">
												<?= $Transactions; ?>
											</tbody>
											<tfoot class="bg-200">
												<tr>										
													<th class="sort">Tx N°</th>
													<th class="sort">Amount (ADA)</th>
													<th class="sort">Date</th>
												</tr>
											</tfoot>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- xMODAL 1 -->
			<div id="delegate-wallet" class="modal fade" tabindex="-1" role="dialog">
				<div class="modal-dialog modal-dialog-centered" role="document">
					<div class="modal-content">
						<div class="card w-100">		
							<div class="card-header pb-0">
								<h6 class="mb-0 mt-2 d-flex align-items-center" style="font-size:18px;color:#F5803E;"><i class="fas fa-sign-in-alt"></i> Join delegatation</h6>
							</div>
							<div class="bg-holder bg-card" style="background-image:url(assets/img/bg-card_1);"></div>   
							<div class="card-body d-flex" style="z-index:100;">		
								<form id="frm-delegatewallet" data-url="/dashboard/delegate" data-method="post" data-selector="label" class="needs-validation w-100" novalidate>
									<div name="alert-info" class=""></div>		
									<div class="form-group mt-2">
										<span>POOL</span>
										<input id="pool" type="text" class="form-control" name="pool" data-selector="serialize" readonly>							
									</div>	
									<div class="form-group mt-2">
										<span>FEE</span>
										<div class="input-group mb-2">					
											<input id="fee" type="text" class="form-control" name="fee" data-selector="" readonly>
											<div class="input-group-append">
												<span class="input-group-text"><strong>ADA</strong></span>
											</div>
										</div>	
									</div>
									<div class="form-group mt-2">
										<span>PASSPHRASE</span>
										<input type="password" class="form-control" name="passphrase" placeholder="Passphrase" maxlength="50" data-selector="serialize" required>
										<div class="valid-feedback text-left"></div>
										<div id="c-txtpwd" class="invalid-feedback text-left">Please fill out this field with at minimum 10 characters.</div>
									</div>
									<div class="text-center">	
										<button class="btn btn-lg btn-outline-warning btn-block mt-4" type="submit">JOIN DELEGATATION</button>
									</div>
								</form>									
							</div>								
						</div>
					</div>	
				</div>
			</div>
			<!-- xMODAL 2 -->
			<div id="undelegate-wallet" class="modal fade" tabindex="-1" role="dialog">
				<div class="modal-dialog modal-dialog-centered" role="document">
					<div class="modal-content">
						<div class="card w-100">		
							<div class="card-header pb-0">
								<h6 class="mb-0 mt-2 d-flex align-items-center" style="font-size:18px;color:#F5803E;"><i class="fas fa-sign-out-alt"></i> Quit delegatation</h6>
							</div>
							<div class="bg-holder bg-card" style="background-image:url(assets/img/bg-card_1);"></div>   
							<div class="card-body d-flex" style="z-index:100;">						
								<form id="frm-undelegatewallet" data-url="/dashboard/undelegate" data-method="post" data-selector="label" class="needs-validation w-100" novalidate>
									<div name="alert-info" class=""></div>
									<h6 class="text-justify">In order to undelegate you wallet from an other pool, we must withdraw your reward balance to your main wallet balance.</h6>
									<div class="text-center mt-4">
										<div class="form-group">
											<input type="password" class="form-control" name="passphrase" placeholder="Passphrase" maxlength="50" data-selector="serialize" required>
											<div class="valid-feedback text-left"></div>
											<div id="c-txtpwd" class="invalid-feedback text-left">Please fill out this field with at minimum 10 characters.</div>
										</div>
										<button class="btn btn-lg btn-outline-warning btn-block mt-4" type="submit">QUIT DELEGATION</button>
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