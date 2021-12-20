

<?php $this->load->view('header_url.php'); ?>

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

					<a href="<?php echo base_url(); ?>auth/register">

						<i class="icon-user"></i> Sign Up

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



					<!-- Advanced login -->

					<form name="forget_pass_form" action="<?=base_url();?>auth/forgot_pass_send_link" method="post">

						<div class="login-form">

							<div class="text-center">

								<div class="icon-object border-warning-400 text-warning-400"><i class="icon-envelop"></i></div>

								<h5 class="content-group-lg">Enter your Register Email Address<small class="display-block" style="color: red;font-weight:700;font-size:20px;">

							           <?php echo validation_errors();

                                        if ($this->session->flashdata('message')) {

                                        echo $this->session->flashdata('message');

                                       }

							           ?>

							    </small></h5>

							</div>

							<div class="form-group has-feedback has-feedback-left">

								<input type="email" class="form-control input-lg" name="email" placeholder="Email" required>

								<div class="form-control-feedback">

									<i class=" icon-envelop text-muted"></i>

								</div>

							</div>
                            <input type="hidden" name="forget_method" value="">
                            <div class="form-group">
                                <a href="javascript:forget('pass')" class="btn bg-slate btn-block btn-lg content-group">Reset Password <i class="icon-arrow-right14 position-right"></i></a>
                            </div>
                            <div class="content-divider text-muted form-group"><span>Or</span></div>
							<div class="form-group">
                                <a href="javascript:forget('user')" class="btn bg-slate btn-block btn-lg content-group">Reset Username <i class="icon-arrow-right14 position-right"></i></a>
							</div>

						</div>

					</form>

					<!-- /advanced login -->



				</div>

				<!-- /content area -->



			</div>

			<!-- /main content -->



		</div>

		<!-- /page content -->



	</div>

	<!-- /page container -->

<script type="text/javascript">

	

console.clear();
function forget(_method) {
    document.querySelector('[name="forget_method"]').value = _method;
    document.forget_pass_form.submit();
}




</script>

</body>



</html>