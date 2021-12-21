<style type="text/css">
	.thumb-rounded, .thumb-rounded .caption-overflow, .thumb-rounded img {
		border-radius: 0%!important;
	}
</style>

<section class="LoginBox">
	<form action="<?= base_url('auth/payment_option') ?>" class="login-form" method="post" style="padding: 20px 20px;">
		<div class="panel" style="margin-bottom: 0px;">
			<div class="panel-body">
				<div class="thumb thumb-rounded">
					<img src="<?= base_url(IMG_URL . 'company.jpg') ?>" alt="" />
					<div class="caption-overflow">
						<span>
							<a href="#" class="btn border-white text-white btn-flat btn-icon btn-rounded btn-xs"><i class="icon-collaboration"></i></a>
							<a href="#" class="btn border-white text-white btn-flat btn-icon btn-rounded btn-xs ml-5"><i class="icon-question7"></i></a>
						</span>
					</div>
				</div>
				<h6 class="content-group text-center text-semibold no-margin-top">
					<small class="display-block" style="color: green; font-size: 20px; font-weight: 700;">Payment</small>
				</h6>
				<div class="form-group has-feedback">
					<input type="hidden" class="form-control" name="total_amount" value="<?= $plan->total_amount ?>" />
					<input type="hidden" class="form-control" name="consultant_id" value="<?= $company->consultant_id ?>" />
					<input type="hidden" class="form-control" name="plan_id" value="<?= $company->plan_id ?>" />
					<input type="text" class="form-control text-center" name="total" value="You have to pay <?= $plan->total_amount ?> $" style="font-weight: 500;" readonly />
				</div>
				<div class="row">
    	            <div class="col-md-6">
						<div class="radio">
							<label>
								<input type="radio" name="usertype" class="control-info" value="employee" checked>
								sales@ims99.com
							</label>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<a class="btn btn-primary stripe-button-el clickme">
							<span style="display: block;"><i class="icon-reply position-left"></i> Previous</span>
						</a>
					</div>
					<div class="col-md-6">
						<script src="https://checkout.stripe.com/checkout.js" class="stripe-button" data-key="<?= $stripe['publishable_key']; ?>" data-description="Access for a year" data-amount="<?= ($plan->total_amount) * 100 ?>" data-locale="auto"></script>
					</div>
				</div>
			</div>
		</div>
	</form>
</section>

<script>
	$(".clickme").click(function() {
		if(confirm("Are you sure you want to navigate away from this page?"))
			history.go(-1);
		return false;
	});
</script>