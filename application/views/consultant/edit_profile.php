<?php $this->load->view('consultant/header')?>

<body class="navbar-top">

	<!-- Main navbar -->
	<?php $this->load->view('consultant/main_header')?>
	<!-- /main navbar -->


	<!-- Page container -->
	<div class="page-container">

		<!-- Page content -->
		<div class="page-content">

			<!-- Main sidebar -->
			<?php $this->load->view('consultant/sidebar')?>
			<!-- /main sidebar -->


			<!-- Main content -->
			<div class="content-wrapper">

				<!-- Page header -->
				<div class="page-header page-header-default">
					<div class="page-header-content">
						<div class="page-title">
							<h4> <?php
							if($this->session->userdata('employee_id')) {
								$consultant_id1= $this->session->userdata('consultant_id');
	                            $logo1=$this->db->query("select * from `consultant` where `consultant_id`='$consultant_id1'")->row();
	                             $dlogo=$this->db->query("select * from `default_setting` where `id`='1'")->row()->logo;
	                            if ($logo1->logo=='1') {
	                            	$logo=$dlogo;
	                            }else{
	                            	 $logo=$logo1->logo;
	                            }
							}
							?>
								<img src="<?php echo base_url(); ?>uploads/logo/<?=$logo?>" style="height:50px;"> Edit Profile</h4>
						</div>
					</div>

					<div class="breadcrumb-line">
						<ul class="breadcrumb">
							<li><a href="#"><i class="icon-home2 position-left"></i> Home</a></li>
							
							<li class="active">Edit Profile</li>
						</ul>

						<ul class="breadcrumb-elements">
							<li><a href="#"><i class="icon-comment-discussion position-left"></i> Support</a></li>
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
							<form class="form-horizontal" action="<?php echo base_url();?>index.php/consultant/update_profile" method="post" enctype="multipart/form-data">
								<fieldset class="content-group">
									<legend class="text-bold">Edit Profile</legend>

									<div class="form-group">
										<label class="control-label col-lg-2">Email</label>
										<div class="col-lg-10">
											<input type="text" class="form-control" name="employee_email" value="<?=$profile->employee_email?>" readonly>
										</div>
									</div>
                                    <div class="form-group">
                                        <label class="control-label col-lg-2">Phone</label>
                                        <div class="col-lg-10">
                                            <input type="text" class="form-control" name="phone" value="<?=$profile->employee_phone?>" placeholder="+12345678910">
                                        </div>
                                    </div>

									<div class="form-group">
										<label class="control-label col-lg-2">Username</label>
										<div class="col-lg-10">
											<input type="text" class="form-control" name="username" value="<?=$profile->username?>">
										</div>
									</div>
									<!-- sponsor.png -->
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
                            <form class="form-horizontal" action="<?php echo base_url();?>index.php/consultant/update_password" method="post" enctype="multipart/form-data">
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
