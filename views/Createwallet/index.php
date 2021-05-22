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
							<div class="row text-left justify-content-between align-items-center mb-2">
								<form id="frm-createwallet" data-url="/createwallet/register" data-method="post" data-selector="label" class="needs-validation" novalidate>
									<div name="alert-info" class=""></div>
									<div id="a-section" class="showdiv">
										<div class="text-center">
											<p>Generate your wallet and save your mnemonic words in safe place</p>
											<div class="mt-2">
												<a class="btn btn-falcon-warning btn-sm mr-1 mb-1" href="javascript:void(0);" onclick="GenerateWallet();"><i class="fas fa-copy"></i> Generate</a> 
											</div>											
										</div>
									</div>									
									<div id="g-section" class="hidediv">
										<div class="text-center">
											<div class="input-group mt-2">
												<textarea id="mnemonic" type="text" class="form-control mt-2" name="mnemonic" placeholder="Seed phrase" rows="4" cols="40" style="overflow:hidden;resize:none;" data-selector="serialize" readonly></textarea>
												<div class="valid-feedback text-left"></div>
												<div class="invalid-feedback text-left">Please fill out this field with at min 15 words and max 24 words.</div>
											</div>
											<div class="mt-2">
												<a id="cptxt" class="btn btn-falcon-warning btn-sm mr-1 mb-1" data-clipboard-target="#mnemonic" href="javascript:void(0);" onclick="CopieToClipboard('cptxt');"><i class="fas fa-copy"></i> Copy</a> 
											</div>
											<div class="form-group form-check mt-4">
												<input class="form-check-input" type="checkbox" name="mnemonic_confirmation" data-selector="serialize" required>I confirm that I have saved the mnemonic sequence in a secure place.</strong>
												<div class="valid-feedback text-left"></div>
												<div class="invalid-feedback text-left">You must save mnemonic sequence in a secure place.</div>
											</div>
											<div class="input-button mt-4">
												<a class="btn btn-falcon-default btn-sm mr-1 mb-1" href="javascript:void(0);" onclick="showNext();"><i class="fas fa-arrow-circle-right"></i> NEXT</a>
											</div>
										</div>
									</div>
									<div id="m-section" class="hidediv">
										<div class="text-center">
											<div class="form-group mt-2">
												<input type="password" class="form-control" name="passphrase" placeholder="Password" maxlength="50" data-selector="serialize" required>
												<div class="valid-feedback text-left"></div>
												<div id="c-txtpwd" class="invalid-feedback tdata-ext-left">Please fill out this field with at minimum 10 characters.</div>
											</div>
											<div class="form-group mt-2">
												<input type="password" class="form-control" name="cpassphrase" placeholder="Password confirmation" maxlength="50" data-selector="serialize" required>
												<div class="valid-feedback text-left"></div>
												<div id="c-txtcpwd" class="invalid-feedback text-left">Please fill out this field with at minimum 10 characters.</div>
											</div>
											<button class="btn btn-lg btn-outline-warning btn-block mt-4" type="submit">CREATE WALLET</button>
										</div>
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