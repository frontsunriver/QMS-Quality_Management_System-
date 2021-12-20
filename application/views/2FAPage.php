<style>
	label {
		font-size: 13px;
	}
	.help-block > a {
		font-size: 12px;
	}
	.help-block > a:hover {
		box-shadow: none;
		transition: initial;
	}
	small > p {
		color: red;
		font-size: 14px;
		font-weight: bold;
	}
	.content-divider > span {
		background-color: white;
	}
</style>


<?php 
$CI =& get_instance();
$userData = $CI->session->userdata('temp_user');
?>

<section class="LoginBox">
	<form class="wow zoomIn" id="login_form" action="<?= base_url('auth/submitAnswer') ?>" method="post">
		<div class="login-form">
			<div class="text-center">
				<div class="icon-object border-warning-400 text-warning-400"><i class="icon-people"></i></div>
				<h5 class="content-group-lg">Answer Your Security Question
					<small class="display-block">
						<?= validation_errors() ?>
						<?= isset($flash) ? "<p>{$flash['msg']}</p>" : '' ?>
					</small>
				</h5>
			</div>

			<div class="form-group has-feedback has-feedback-left">
				<input type="text" readonly="" class="form-control input-lg" name="security[question]" placeholder="Security Question" value="<?= $userData->security_question; ?>" />
			</div>

			<div class="form-group has-feedback has-feedback-left">
				<input type="text" class="form-control input-lg" name="security[answer]" placeholder="Enter your security answer" />
			</div>

			<div class="form-group">
				<!-- <a href="javascript:login()" class="btn bg-slate btn-block btn-lg content-group">Submit <i class="icon-arrow-right14 position-right"></i></a> -->
				<button type="submit" class="btn bg-slate btn-block btn-lg content-group">Submit <i class="icon-arrow-right14 position-right"></i></button>
			</div>

			<div class="content-divider text-muted form-group"><span>Don't have an account?</span></div>

			<a href="<?= base_url('auth/register') ?>" class="btn bg-slate btn-block btn-lg content-group">Register</a>
			<!--<span class="help-block text-center">
				By continuing, you're confirming that you've read and agree to our <a href="#">Terms and Conditions</a> and <a href="#">Cookie Policy</a>
			</span>-->
		</div>
	</form>
</section>