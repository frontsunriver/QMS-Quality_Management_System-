<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?=$title ?? ''?></title>
<!--	<link href="http://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">-->
	
	<link href="<?=base_url(); ?>assets/css/icons/icomoon/styles.css" rel="stylesheet" type="text/css">
	<link href="<?=base_url(); ?>assets/css/bootstrap.css" rel="stylesheet" type="text/css">
	<link href="<?=base_url(); ?>assets/css/core.css" rel="stylesheet" type="text/css">
	<link href="<?=base_url(); ?>assets/css/components.css" rel="stylesheet" type="text/css">
	<link href="<?=base_url(); ?>assets/css/colors.css" rel="stylesheet" type="text/css">
	<!-- /global stylesheets -->
	<!-- Core JS files -->
	<script type="text/javascript" src="<?=base_url(); ?>assets/js/plugins/loaders/pace.min.js"></script>
	<script type="text/javascript" src="<?=base_url(); ?>assets/js/core/libraries/jquery.min.js"></script>
	<script type="text/javascript" src="<?=base_url(); ?>assets/js/core/libraries/bootstrap.min.js"></script>
	<script type="text/javascript" src="<?=base_url(); ?>assets/js/plugins/loaders/blockui.min.js"></script>
	<!-- /core JS files -->
	<!-- Theme JS files -->
	<script type="text/javascript" src="<?=base_url(); ?>assets/js/plugins/visualization/d3/d3.min.js"></script>
	<script type="text/javascript" src="<?=base_url(); ?>assets/js/plugins/visualization/d3/d3_tooltip.js"></script>
	<script type="text/javascript" src="<?=base_url(); ?>assets/js/plugins/forms/styling/switchery.min.js"></script>
	<script type="text/javascript" src="<?=base_url(); ?>assets/js/plugins/forms/styling/uniform.min.js"></script>
	<script type="text/javascript" src="<?=base_url(); ?>assets/js/plugins/forms/selects/bootstrap_multiselect.js"></script>
	<script type="text/javascript" src="<?=base_url(); ?>assets/js/plugins/ui/moment/moment.min.js"></script>
	<script type="text/javascript" src="<?=base_url(); ?>assets/js/plugins/pickers/daterangepicker.js"></script>
	<script type="text/javascript" src="<?=base_url(); ?>assets/js/plugins/ui/nicescroll.min.js"></script>
	<script type="text/javascript" src="<?=base_url(); ?>assets/js/core/app.js"></script>
	<!-- <script type="text/javascript" src="<?=base_url(); ?>assets/js/pages/dashboard.js"></script> -->
	<script type="text/javascript" src="<?=base_url(); ?>assets/js/pages/layout_fixed_custom.js"></script>
	<!-- /theme JS files -->


    

</head>

<body class="navbar-top">

	<!-- Main navbar -->
	<?php $this->load->view('admin/main_header')?>
	<!-- /main navbar -->


	<!-- Page container -->
	<div class="page-container">

		<!-- Page content -->
		<div class="page-content">

			<!-- Main sidebar -->
			<?php $this->load->view('admin/sidebar')?>
			<!-- /main sidebar -->


			<!-- Main content -->
			<div class="content-wrapper">

				<!-- Page header -->
				<div class="page-header page-header-default">
					
					<div class="breadcrumb-line">
						<ul class="breadcrumb">
							<li><a href="#"><i class="icon-home2 position-left"></i> Home</a></li>
							
							<li class="active">Edit Profile</li>
						</ul>

						
					</div>
				</div>
				<!-- /page header -->


				<!-- Content area -->
				<div class="content">
                   <?php if($this->session->flashdata('message')=='update_success') { ?>
                      	  <div class="alert alert-styled-right alert-styled-custom alert-arrow-right alpha-teal alert-bordered">
							<button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
							Profile Successfully Updated.. 
				        </div>
                      <?php   } ?>
                    <?php if($this->session->flashdata('phone_response')) { ?>
                        <div class="alert alert-danger alert-styled-right alert-arrow-right alert-bordered">
                            <button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
                            <?= $this->session->flashdata('phone_response')['message'] ?>
                        </div>
                    <?php   } ?>
					<!-- Form horizontal -->
					<div class="panel panel-flat">
						<div class="panel-heading">
							<div class="heading-elements">
								<ul class="icons-list">
			                		<li><a data-action="collapse"></a></li>
			                	</ul>
		                	</div>
						</div>

						<div class="panel-body">
							<form class="form-horizontal" action="<?php echo base_url();?>index.php/admin/update_profile" method="post" enctype="multipart/form-data">
								<fieldset class="content-group">
									<legend class="text-bold">Edit Profile</legend>
									<div class="form-group">
										<label class="control-label col-lg-2">Username</label>
										<div class="col-lg-10">
											<input type="text" class="form-control" name="username" value="<?=$profile->username?>">
										</div>
									</div>
						           <div class="form-group">
										<label class="control-label col-lg-2">Email</label>
										<div class="col-lg-10">
											<input type="email" class="form-control" name="email" value="<?=$profile->email?>" readonly>
										</div>
									</div>
                                    <div class="form-group">
                                        <label class="control-label col-lg-2">Phone</label>
                                        <div class="col-lg-10">
                                            <input type="text" class="form-control" name="phone" value="<?=$profile->phone?>" placeholder="+12345678910">
                                        </div>
                                    </div>
								</fieldset>
								<div class="text-right">
									<button type="submit" class="btn btn-primary">Edit <i class="icon-arrow-right14 position-right"></i></button>
								</div>
							</form>
						</div>
					</div>
					<!-- /form horizontal -->
                    <?php if($this->session->flashdata('password')) { $password_message = $this->session->flashdata('password'); ?>
                        <div class="alert alert-<?= ($password_message['success'] ? 'success':'danger') ?> alert-styled-right alert-arrow-right alert-bordered">
                            <button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
                            <?= $password_message['message'] ?>
                        </div>
                    <?php   } ?>
                    <!-- Form horizontal -->
                    <div class="panel panel-flat">
                        <div class="panel-heading">
                            <div class="heading-elements">
                                <ul class="icons-list">
                                    <li><a data-action="collapse"></a></li>
                                </ul>
                            </div>
                        </div>

                        <div class="panel-body">
                            <form class="form-horizontal" action="<?php echo base_url();?>index.php/admin/update_password" method="post" enctype="multipart/form-data">
                                <fieldset class="content-group">
                                    <legend class="text-bold">Update Password</legend>
                                    <div class="form-group">
                                        <label class="control-label col-lg-2">Old Password</label>
                                        <div class="col-lg-10">
                                            <input type="password" class="form-control" name="old_password" placeholder="Enter Your Previous Password">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-lg-2">Password</label>
                                        <div class="col-lg-10">
                                            <input type="password" class="form-control" name="password" placeholder="Enter Your New Password">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-lg-2">Confirm Password</label>
                                        <div class="col-lg-10">
                                            <input type="password" class="form-control" name="repassword" placeholder="Enter New Confirm Password">
                                        </div>
                                    </div>
                                </fieldset>
                                <div class="text-right">
                                    <button type="submit" class="btn btn-primary">Update <i class="icon-arrow-right14 position-right"></i></button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- /form horizontal -->

					
					<!-- Footer -->
						<?php $this->load->view('admin/footer')?>
					<!-- /footer -->

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
