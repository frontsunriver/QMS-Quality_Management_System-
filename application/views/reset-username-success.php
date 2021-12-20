
<?php $this->load->view('header_url.php'); ?>
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
					<a href="<?php echo base_url(); ?>index.php/Welcome/register">
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
					<form action="#" method="post">
						<div class="login-form">
							<div class="text-center">
								<div class="icon-object border-warning-400 text-warning-400"><i class="icon-envelop"></i></div>
								<h5 class="content-group-lg">Success<small class="display-block" style="color: red;font-weight:700;font-size:20px;">
							           <?php echo validation_errors();
                                        if ($this->session->flashdata('message')) {
                                        echo $this->session->flashdata('message');
                                       }
							           ?>
							    </small></h5>
							</div>
							<div class="form-group has-feedback has-feedback-left">
								
							  <p style="text-align: -webkit-center;">Your username is changed and you are all logged in.</p>
							</div>
							<div class="form-group">
								<a href="<?=base_url();?>" class="btn bg-blue btn-block btn-lg">Back To Login Page <i class="icon-arrow-left14 position-right"></i></a>
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


</script>
</body>

</html>