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
				<div id="syncing" class="col-xl-12 col-lg-12 col-md-12 col-sm-12 mb-3 pe-md-2">
					<div class="card h-md-100">		
						<div class="card-header pb-0">
							<h6 class="mb-0 mt-2 d-flex align-items-center">Affiliation link</h6>
						</div>
						<div class="bg-holder bg-card" style="background-image:url(assets/img/bg-card_3);"></div>  
						<div class="card-body d-flex" style="z-index:100;">
							<div class="row flex-grow-1">
								<div class="col">
									<textarea id="ReferralLink" type="text" class="form-control mt-2" rows="1" cols="40" style="overflow:hidden;resize:none;" readonly><?= $share_link; ?></textarea>												
								</div>					
							</div>
						</div>
						<div class="card-footer text-muted" style="z-index:100;">
							<button id="cptxt" data-clipboard-target="#ReferralLink" class="btn btn-falcon-warning btn-sm mr-1 mb-1" type="button" onclick="CopieToClipboard('cptxt');"><i class="fas fa-copy"></i> Copy</button>
						</div>
					</div>
				</div>
			</div>
			<div class="row justify-content-md-center">
				<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 mb-3 pe-md-2">
					<div class="card h-md-100">		
						<div class="card-header pb-0">
							<h6 class="mb-0 mt-2 d-flex align-items-center">Affilates</h6>
						</div>
						<div class="bg-holder bg-card" style="background-image:url(assets/img/bg-card_1);"></div>
						<div class="card-body d-flex" style="z-index:100;">
							<div class="row flex-grow-1">
								<div class="col">
									<div class="table-responsive mt-3">
										<table id="trxmax" class="table table-sm table-dashboard data-table no-wrap mb-0 fs--1 w-100">
											<thead class="bg-200">
												<tr>
													<th class="sort">Action</th>	
													<th class="sort">Affilate address</th>									
													<th class="sort">Live stake (ADA)</th>
													<th class="sort">Registration date</th>
												</tr>
											</thead>
											<tbody class="bg-white">
												<?= $Referral; ?>											
											</tbody>
											<tfoot class="bg-200">
												<tr>
													<th class="sort">Action</th>	
													<th class="sort">Affilate address</th>									
													<th class="sort">Live stake (ADA)</th>
													<th class="sort">Registration date</th>
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
		</div>
	</div>
</main>