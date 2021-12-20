
<?php $this->load->view('consultant/header.php'); ?>
<body class="navbar-top">
	<!-- Main navbar -->
	<?php $this->load->view('consultant/main_header.php'); ?>
	<!-- /main navbar -->
	<!-- Page container -->
	<div class="page-container">
		<!-- Page content -->
		<div class="page-content">
			<!-- Main sidebar -->
			<?php $this->load->view('consultant/sidebar'); ?>
			<!-- /main sidebar -->
			<!-- Main content -->
			<div class="content-wrapper">
				<!-- Page header -->
				<div class="page-header page-header-default">
					<div class="page-header-content">
						<div class="page-title">
							<h4> <?php
							if ($this->session->userdata('consultant_id')) {
								$consultant_id= $this->session->userdata('consultant_id');

	                            $logo1=$this->db->query("select * from `consultant` where `consultant_id`='$consultant_id'")->row();

	                            $dlogo=$this->db->query("select * from `default_setting` where `id`='1'")->row()->logo;

	                            if(isset($dlogo)) {
									if ($logo1->logo == '1') {
										$logo = $dlogo;
									} else {
										$logo = $logo1->logo;
									}
								}
								else{
	                            	$logo = '';
								}
							}
							?>
								<img src="<?php echo base_url(); ?>uploads/logo/<?=$logo?>" style="height:50px;"></h4>
						</div>
					</div>
					<div class="breadcrumb-line">
						<ul class="breadcrumb">
							<li><a href="#"><i class="icon-home2 position-left"></i> Home</a></li>
							<li class="active">Dashboard</li>
						</ul>
					</div>
				</div>
				<!-- /page header -->
				<!-- Content area -->
				<div class="content">
					<!-- Dashboard content -->
                    <?php
                      if($comp->plan_type=='trial') { ?>
                      	 <div class="alert alert-styled-right alert-styled-custom alert-arrow-right alpha-teal alert-bordered">
							<button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
							<span class="text-semibold">Thank you!</span>  for Using our Service. Your Trial will be expired on <?=$comp->expired?>
				        </div>
                    <?php   } ?>
                     
                        <?php if($comp->plan_type=='real') { ?>
                      	 <div class="alert alert-styled-right alert-styled-custom alert-arrow-right alpha-teal alert-bordered">
							<button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
							<span class="text-semibold">Thank you!</span>   for purchasing our Service . Your Membership will be expired on <b><?=$comp->expired?></b>
				        </div>
                      <?php   } ?>
					<div class="row">
						<div class="col-lg-12">
							<!-- Latest posts -->
							<div class="panel panel-flat">
							 <div class="row">
								 <div class="col-md-4">
								 </div>
				    	<div class="col-md-4">
				    		<div class="panel panel-body border-top-brown text-center">
								<h6 class="no-margin text-semibold">Total Number of Actions in the </h6>
								<button type="button" class="btn bg-brown" data-toggle="modal" data-target="#modal_brown">Queue:  <?php echo $action_open_nums;?></button>
							</div>
				    	</div>
				    </div>
								<div class="panel-body">
									    <!-- Notifications and dialogs -->
				    <div class="row">
				        <div class="col-md-6">
				    		<div class="panel panel-body border-top-brown text-center">
						       <h6 class="content-group text-semibold">
						        INSPECTION
				               </h6>
				               <div class="row">
				               <a href="<?php echo base_url(); ?>index.php/Consultant/report">
				               	  <div class="col-lg-12">
                               	    <div class="panel panel-body border-top-brown text-center">
									<h6 class="no-margin text-semibold">VIEW MONITORING REPORT</h6>
									</div>
                                  </div>
                                </a>
				               </div>
                               <div class="row">
                               <a href="<?php echo base_url(); ?>index.php/Consultant/conduct">
				               	  <div class="col-lg-12">
                               	    <div class="panel panel-body border-top-brown text-center">
									<h6 class="no-margin text-semibold">CONDUCT AN INSPECTION</h6>
									</div>
                                  </div>
                                </a>
				               </div>
				               <div class="row">
				               <a href="<?php echo base_url(); ?>index.php/Consultant/verification_log" >
				               	  <div class="col-lg-12">
                               	    <div class="panel panel-body border-top-brown text-center">
									<h6 class="no-margin text-semibold">VIEW DETAILS OF PREVIOUS MONITORING</h6>
									</div>
                                  </div>
                                </a>
				               </div>
                           </div>
				    	</div>
				    	 <div class="col-md-6">
				    		<div class="panel panel-body border-top-brown text-center">
								<h6 class="content-group text-semibold">
									CORRECTIVE ACTIONS
								</h6>
								 <div class="row">
				               	  <div class="col-lg-12">
				               	  <a href="<?php echo base_url(); ?>index.php/Consultant/resolution_list" >
                               	    <div class="panel panel-body border-top-brown text-center">
									<h6 class="no-margin text-semibold">RESOLVE A CORRECTIVE ACTION</h6>
									</div>
								</a>
                                  </div>
				               </div>
				                <div class="row">
				                <a href="<?php echo base_url(); ?>index.php/Consultant/corrective_action_form" >
				               	  <div class="col-lg-12">
                               	    <div class="panel panel-body border-top-brown text-center">
									<h6 class="no-margin text-semibold">SUBMIT A CORRECTIVE ACTION</h6>
									</div>
                                  </div>
                                </a>
				               </div>
                                 <div class="row">
				               	  <div class="col-lg-12">
				               	    <a href="<?php echo base_url(); ?>index.php/Consultant/corrective_action_report">
                               	    <div class="panel panel-body border-top-brown text-center" style="">
									<h6 class="no-margin text-semibold">CORRECTIVE ACTIONS REPORT</h6>
									</div>
									</a>
                                  </div>
				               </div>
                            </div>
				    	</div>
				    </div>
								</div>
							</div>
							<!-- /latest posts -->
						</div>
					</div>
					<!-- /dashboard content -->

					<!-- Footer -->
					<?php $this->load->view('consultant/footer'); ?>
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
