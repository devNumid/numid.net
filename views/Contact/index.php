<div class="row justify-content-md-center mt-5">
	<div class="col-sm-10 col-md-8 col-lg-8 col-xl-8 col-xxl-8">
		<div class="card h-md-100">		
			<div class="card-header pb-0">
				<h6 class="mb-0 mt-2 d-flex align-items-center">Do you need help contact us</h6>
			</div>
			<div class="bg-holder bg-card" style="background-image:url(assets/img/bg-card_4);"></div>  
			<div class="card-body d-flex" style="z-index:100;">
				<div class="row flex-grow-1">
					<div class="col">
						<form id="frm-contact" data-url="contact/send" data-method="post" data-selector="modal" class="needs-validation" novalidate>																							
							<div class="text-center">
								<div class="form-group mt-2">
									<input type="email" class="form-control" name="email" placeholder="Your email address" maxlength="50" data-selector="serialize" required>
									<div class="valid-feedback text-left"></div>
									<div class="invalid-feedback text-left">Please fill out this field with a valid email address.</div>
								</div>	
								<div class="form-group mt-2">					
									<textarea type="text" class="form-control" name="message" placeholder="Enter your message here" rows="4" cols="50" data-selector="serialize" required></textarea>
									<div class="valid-feedback text-left"></div>
									<div class="invalid-feedback text-left">Please fill out this field.</div>
								</div>
								<button id="submit" class="btn btn-lg btn-outline-warning btn-block mt-4" type="submit">SEND</button>				
							</div>	
						</form>			
					</div>					
				</div>
			</div>		
		</div>
	</div>
</div>
