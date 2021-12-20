<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?=$title?></title>
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

	<script type="text/javascript" src="<?=base_url(); ?>assets/js/pages/layout_fixed_custom.js"></script>
	<!-- /theme JS files -->


    <script type="text/javascript">
	
console.clear();


</script>

</head>

<body class="navbar-top">

	<!-- Main navbar -->
	<?php $this->load->view('Admin/main_header')?>
	<!-- /main navbar -->


	<!-- Page container -->
	<div class="page-container">

		<!-- Page content -->
		<div class="page-content">

			<!-- Main sidebar -->
			<?php $this->load->view('Admin/sidebar')?>
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
							Default Logo Successfully Updated.. 
				        </div>
                      <?php   } ?>
					<!-- Form horizontal -->
					<div class="panel panel-flat">
						<div class="panel-heading">
							<div class="heading-elements">
								<ul class="icons-list">
			                		<li><a data-action="collapse"></a></li>
			                		<li><a data-action="reload"></a></li>
			                		<li><a data-action="close"></a></li>
			                	</ul>
		                	</div>
						</div>

						<div class="panel-body">
							<form class="form-horizontal" action="<?php echo base_url();?>index.php/Admin/update_default" method="post" enctype="multipart/form-data">
								<fieldset class="content-group">
									<legend class="text-bold">Edit Profile</legend>
									<?php
							if ($this->session->userdata('admin_id')) {
								$consultant_id= $this->session->userdata('admin_id');
	                            $logo=$this->db->query("select * from `default_setting` where `id`='1'")->row();
							}
							?>
									<div class="form-group">
										<label class="control-label col-lg-2">Default Logo</label>
										<div class="col-lg-10">
                                              <img src="<?php echo base_url(); ?>uploads/logo/<?=@$logo->logo?>" style="margin-bottom: 10px;height: 84px;">
                                              <input type="file" class="form-control" name="picture" >
										</div>
									</div>
								</fieldset>
								<div class="text-right">
									<button type="submit" class="btn btn-primary">Update</button>
								</div>
							</form>
						</div>
					</div>
					<!-- /form horizontal -->

					
					<!-- Footer -->
						<?php $this->load->view('Admin/footer')?>
					<!-- /footer -->

				</div>
				<!-- /content area -->

			</div>
			<!-- /main content -->

		</div>
		<!-- /page content -->

	</div>
	<!-- /page container -->

</body>

</html>
