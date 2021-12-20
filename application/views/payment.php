<?php require_once('./config.php'); ?>
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
			<a class="navbar-brand" href="#"><img src="assets/images/logo_light.png" alt=""></a>

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
					<form action="<?php echo base_url(); ?>index.php/Auth/payment_option" class="login-form" method="post">
						<div class="panel">
							<div class="panel-body">
								<div class="thumb thumb-rounded">
									<img src="<?php echo base_url(); ?>assets/images/consultant.jpg" alt="">
									<div class="caption-overflow">
										<span>
											<a href="#" class="btn border-white text-white btn-flat btn-icon btn-rounded btn-xs"><i class="icon-collaboration"></i></a>
											<a href="#" class="btn border-white text-white btn-flat btn-icon btn-rounded btn-xs ml-5"><i class="icon-question7"></i></a>
										</span>
									</div>
								</div>
						  <h6 class="content-group text-center text-semibold no-margin-top">
							<small class="display-block" style="color: green;font-size: 20px;font-weight: 700;">Payment</small></h6>

								<div class="form-group has-feedback">
									<input type="hidden" class="form-control" name="total_amount" value="<?=$consultant1->total_amt-@$consultant->total_amt?>" >
									<input type="hidden" class="form-control" name="consultant_id" value="<?=$consultant1->consultant_id?>" >
									<input type="hidden" class="form-control" name="purchase_plan_id" value="<?=$consultant1->purchase_plan_id?>" >
                                      
                                      <input type="hidden" class="form-control" name="plan_id" value="<?=$consultant1->plan_id?>" >
                                    <?php if (count($consultant)==0) { ?>
									<input type="text" class="form-control text-center" name="total" value="You have to pay    <?=$consultant1->total_amt?> $" style="font-weight: 500;" readonly>
	                               <?php } ?>
									<?php if (count($consultant)>0) { ?>
										
									
									<table class="table">
										<tr>
											<td colspan="2" align="center"><b>You Have to Pay</b></td>
										</tr>
										<tr>
											<td>New Plan  Amount</td>
											<td>
												<?=$consultant1->total_amt?> $
											</td>
										</tr>
										<tr>
											<td>Current Plan Amount</td>
											<td>- <?=@$consultant->total_amt?> $</td>
										</tr>
										<tr>
											<td>Due Amount</td>
											<td><?=$consultant1->total_amt-@$consultant->total_amt?>  $</td>
										</tr>
									</table>
									<?php } ?>
								</div>
								 <div class="row">
                            	            <div class="col-md-6">
												<div class="radio">
													<label>
														<input type="radio" name="usertype" class="control-info" value="employee" checked>
														Stripe Payment
													</label>
												</div>
											</div>
                            </div>
                            <div class="row">
                            	<div class="col-md-6">
                            		  <a  class="btn btn-primary stripe-button-el clickme"><span style="display: block; min-height: 30px;"><i class="icon-reply position-left"></i> Previous</span></a>
                            	</div>
                            	<div class="col-md-6">
                            		<script src="https://checkout.stripe.com/checkout.js" class="stripe-button"
							          data-key="<?php echo $stripe['publishable_key']; ?>"
							          data-description="Access for a year"
							          data-amount="<?=($consultant1->total_amt-$consultant->total_amt)*100?>"
							          data-locale="auto">
							         </script>
                            	</div>
                            </div>

                            <?php if(count($consultant)==0 && count($consultant3)!='1') { ?>
	                                 <p><h5 class="text-center">You can use Trial Mode.</h5>
			                           You can use this platform for 2 week freely. </p>
			                           <?php 
			                           $consultant_id=$this->session->userdata('consultant_id');
			                           ?>
								         <a href="<?php echo base_url(); ?>index.php/Auth/trial/<?=$consultant1->purchase_plan_id?>/" type="submit" class="btn btn-primary btn-block">Use Trial Mode <i class="icon-arrow-right14 position-right"></i></a>
			                             <?php }?>
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
