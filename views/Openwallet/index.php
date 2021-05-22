<main class="main h-100" id="top">
	<div class="container h-100" data-layout="container">		
		<!-- MAIN -->
		<div class="content h-100">			
			<!-- BODY -->	
			<div class="row flex-center min-vh-100 py-6">
				<div class="col-sm-10 col-md-8 col-lg-6 col-xl-5 col-xxl-4">
					<div class="d-flex flex-center mb-1">
						<div class="d-flex align-items-center py-3"><img class="me-2" src="assets/img/logo.webp" alt="" width="100" height="100"></div>
					</div>
					<div class="card bg-card-gradient">
						<div class="bg-holder bg-auth-card-shape" style="background-image:url(assets/img/bg-circle.webp);"></div>
						<div class="card-body p-4 p-sm-5" style="z-index:100;">
							<form id="frm-openwallet" data-url="/openwallet/open" data-method="post" data-selector="label" class="needs-validation" novalidate>
								<div name="alert-info" class=""></div>
								<div class="text-center">
									<div class="form-group mt-2">
										<textarea type="text" class="form-control" name="mnemonic" placeholder="Seed phrase" rows="4" cols="50" style="overflow:hidden;resize:none;" data-selector="serialize" ></textarea>
										<div class="valid-feedback text-left"></div>
										<div class="invalid-feedback text-left">Please fill out this field with at min 15 words and max 24 words.</div>
									</div>
									<div class="form-group mt-2">
										<input type="password" class="form-control" name="passphrase" placeholder="Password" maxlength="50" data-selector="serialize" required>
										<div class="valid-feedback text-left"></div>
										<div class="invalid-feedback text-left">Please fill out this field with at minimum 10 characters.</div>
									</div>
									<button class="btn btn-lg btn-outline-warning btn-block mt-4" type="submit">OPEN WALLET</button>
								</div>
							</form>
						</div>
					</div>	
				</div>
			</div>				
		</div>
	</div>
</main>

