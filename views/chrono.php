<div class="d-flex justify-content-center mt-5 mb-5">
	<div id="flipdown" class="flipdown"></div>
	 <script>
		/* 30/06/2021 00:00:00: */
		document.addEventListener('DOMContentLoaded', () => {
			var flipdown = new FlipDown(1625011200, { theme: "light",})
								.start()
								.ifEnded(() => {
									$("#flipdown").addClass("hidediv");
								});
		});
	</script>
</div>		