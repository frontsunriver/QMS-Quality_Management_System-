
<?php $this->load->view('header_url.php'); ?>
<style type="text/css">
	.thumb-rounded, .thumb-rounded .caption-overflow, .thumb-rounded img {
    border-radius: 0%!important;
}
</style>
<body class="login-container">

	<!-- Main navbar -->
	<div class="navbar navbar-inverse">
		<div class="navbar-header">
		
			<ul class="nav navbar-nav pull-right visible-xs-block">
				<li><a data-toggle="collapse" data-target="#navbar-mobile"><i class="icon-tree5"></i></a></li>
			</ul>
		</div>

		<div class="navbar-collapse collapse" id="navbar-mobile">
			<ul class="nav navbar-nav navbar-right">
				<li>
					<a href="<?php echo base_url(); ?>index.php/Welcome/logout">
						<i class="icon-lock"></i> Logout
					</a>
				</li>
			</ul>
		</div>
	</div>
	<!-- /main navbar -->


	<!-- Page container -->
	<div class="page-container">

		<!-- Page content -->
		<div class="page-content">

			<!-- Main content -->
			<div class="content-wrapper">

				<!-- Content area -->
				<div class="content">

					<!-- Unlock user -->
					<form action="<?php echo base_url(); ?>index.php/Auth/upgrade_process_done" class="login-form" method="post">
						<input type="hidden" name="plan_id" value="<?php echo $plan_id;?>">

						<div class="panel">
							<div class="panel-body">
								<div class="thumb thumb-rounded">
									
									<div class="caption-overflow">
										<span>
											<a href="#" class="btn border-white text-white btn-flat btn-icon btn-rounded btn-xs"><i class="icon-collaboration"></i></a>
											<a href="#" class="btn border-white text-white btn-flat btn-icon btn-rounded btn-xs ml-5"><i class="icon-question7"></i></a>
										</span>
									</div>
								</div>
						  <h6 class="content-group text-center text-semibold no-margin-top">
							Terms and Conditions</h6>

								<div class="form-group has-feedback">
									

									 <div class="row">
                            	            <div class="col-md-12">
												<div class="radio">
													<label>
<p>
THIS AGREEMENT ("Agreement") DESCRIBES THE TERMS AND CONDITIONS THAT APPLY TO AND GOVERN YOUR USE OF THE Test WEB SITE AND THE SERVICES AVAILABLE THEREON ("Test services" or "Services"). By clicking in the box on the Site indicating your acceptance of these terms and conditions, you represent that you have read, understand and agree to this Agreement and are legally bound to the terms and conditions of this Agreement.</p>
												</label>
									<div class="form-group">
											<label class="checkbox-inline">
											<input type="checkbox" class="styled" name="checkeds" style="height: 18px;width: 37px;" required>
										
											<b>  I Agree </b>
										    </label>
									</div>
												</div>
											</div>
                                     </div>
								</div>
								<div class="row">
									 <div class="col-md-6">
									 	<a  class="btn btn-primary btn-block clickme">Prev </a>
									 </div>
									 <div class="col-md-6">
									 	<button type="submit" class="btn btn-primary btn-block pull-right">Next</button>
									 </div>
								</div>
							</div>
						</div>
					</form>
					<!-- /unlock user -->
					<!-- Footer -->
					
					<!-- /footer -->

				</div>
			</div>
		</div>
	</div>

	<script type="text/javascript">
		$('.clickme').click(function() {
   if(confirm("Are you sure you want to navigate away from this page?"))
   {
      history.go(-1);
   }        
   return false;
});
	</script>
</body>
</html>
