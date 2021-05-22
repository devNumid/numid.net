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
				<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 mb-3 pe-md-2">
					<div class="card h-md-100">		
						<div class="card-header pb-0">
							<h6 class="mb-0 mt-2 d-flex align-items-center">Rewards history</h6>
						</div>
						<div class="bg-holder bg-card" style="background-image:url(assets/img/bg-card_2);"></div>
						<div class="card-body d-flex" style="z-index:100;">
							<div class="row flex-grow-1">
								<div class="col">
									<div class="table-responsive mt-3">
										<table id="trxmax" class="table table-sm table-dashboard data-table no-wrap mb-0 fs--1 w-100">
											<thead class="bg-200">
												<tr>
													<th class="sort">Epoch</th>			
													<th class="sort">Delegation rewards (ADA)</th>
													<th class="sort">Affiliation rewards (ADA)</th>
													<th class="sort">Date</th>	
												</tr>
											</thead>
											<tbody class="bg-white">
												<?= $Rewards; ?>											
											</tbody>
											<tfoot class="bg-200">
												<tr>
													<th class="sort">Epoch</th>			
													<th class="sort">Delegation rewards (ADA)</th>
													<th class="sort">Affiliation rewards (ADA)</th>
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
		</div>
	</div>
</main>

