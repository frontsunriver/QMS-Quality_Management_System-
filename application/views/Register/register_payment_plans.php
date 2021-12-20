<style>
	.thumb-rounded, .thumb-rounded .caption-overflow, .thumb-rounded img {
		border-radius: 0% !important;
	}
</style>

<section class="LoginBox">
	<form action="<?= base_url('auth/add_purchase') ?>" class="login-form" method="post" style="padding: 20px 20px;">
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
					<small class="display-block">How many accounts are you going to create?</small>
				</h6>
				<div class="form-group has-feedback">
					<div class="row">
						<div class="col-md-12">
							<?php if(isset($trial_plan)) : ?>
								<div class="radio">
									<label>
										<input type="radio" name="plan_id" class="control-warning" value="<?= $trial_plan->plan_id ?>" />
										<?= $trial_plan->plan_name ?>
									</label>
								</div>
								<div style="padding-left: 27px;">You can use trial for 14 days</div>
								<div style="padding-left: 27px;">User Limit: <?= $trial_plan->no_of_user ?></div>
							<?php endif; ?>
							<?php
							$cnt = 0;
							foreach ($plans as $plan) :
								$cnt ++;
							?>
								<div class="radio">
									<label>
										<input type="radio" name="plan_id" class="control-warning" value="<?= $plan->plan_id ?>" <?= $cnt == 1 ? 'checked' : '' ?> /><?= $plan->plan_name ?>
									</label>
								</div>
								<div style="padding-left: 27px;">Employees Limit: <?= $plan->no_of_user ?></div>
								<div style="padding-left: 27px;">Price: <span style="color: red;">$<?= $plan->total_amount ?></span></div>
							<?php endforeach; ?>
						</div>
					</div>
				</div>
				<button type="submit" class="btn btn-primary btn-block">Next <i class="icon-arrow-right14 position-right"></i></button>
			</div>
		</div>
	</form>
</section>