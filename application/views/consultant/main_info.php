<?php $this->load->view('consultant/header')?>



<body class="navbar-top">



	<!-- Main navbar -->

	<?php $this->load->view('consultant/main_header')?>

	<!-- /main navbar -->





	<!-- Page container -->

	<div class="page-container">

		<?php 
			// echo "<pre>";
			// 	print_r($profile);
			// exit;
		?>



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

							<h4><?php

							if ($this->session->userdata('consultant_id')) {

								$consultant_id= $this->session->userdata('consultant_id');

	                            $logo1=$this->db->query("select * from `consultant` where `consultant_id`='$consultant_id'")->row();



	                            $dlogo=$this->db->query("select * from `default_setting` where `id`='1'")->row()->logo;



	                            if ($logo1->logo=='1') {

	                            	$logo=$dlogo;

	                            }else{

	                            	 $logo=$logo1->logo;

	                            }

							}

							?>

								<img src="<?php echo base_url(); ?>uploads/logo/<?=$logo?>" style="height:50px;">MAIN INFO</h4>

						</div>



						

					</div>



					<div class="breadcrumb-line">

						<ul class="breadcrumb">

							<li><a href="#"><i class="icon-home2 position-left"></i> Home</a></li>

							

							<li class="active">MAIN INFO</li>

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

							<form class="form-horizontal" action="<?php echo base_url();?>index.php/consultant/update_main_info" method="post" enctype="multipart/form-data">

								<fieldset class="content-group">

									<legend class="text-bold">MAIN INFO</legend>

									<div class="form-group">

										<label class="control-label col-lg-2">Username</label>

										<div class="col-lg-10">

											<input type="text" class="form-control" name="username" value="<?=$profile->username?>">

										</div>

									</div>
                                    <div class="form-group">
                                        <label class="control-label col-lg-2">Phone</label>
                                        <div class="col-lg-10">
                                            <input type="text" class="form-control" name="phone" value="<?=$profile->phone?>" placeholder="+12345678910">
                                        </div>
                                    </div>

									<div class="form-group">

										<label class="control-label col-lg-2">Company Name</label>

										<div class="col-lg-10">

											<input type="text" class="form-control" name="consultant_name" value="<?=$profile->consultant_name?>">

										</div>

									</div>

									<div class="form-group">

										<label class="control-label col-lg-2">City</label>

										<div class="col-lg-10">

											<input type="text" class="form-control" name="city" value="<?=$profile->city?>">

										</div>

									</div>

									<div class="form-group">

										<label class="control-label col-lg-2">State</label>

										<div class="col-lg-10">

											<input type="text" class="form-control" name="state" value="<?=$profile->state?>">

										</div>

									</div>

									<div class="form-group">

										<label class="control-label col-lg-2">Address</label>

										<div class="col-lg-10">

											<input type="text" class="form-control" name="address" value="<?=$profile->address?>">

										</div>

									</div>





							<?php

							if ($this->session->userdata('consultant_id')) {

								$consultant_id= $this->session->userdata('consultant_id');

	                            $plan_types=$this->db->query("select * from `consultant` where `consultant_id`='$consultant_id'")->row();

							}

							?>



                              <?php if($plan_types->plan_type=='real') { ?>

									<div class="form-group">

										<label class="control-label col-lg-2">Company Logo</label>

										<div class="col-lg-10">

										



                                              <img src="<?php echo base_url(); ?>uploads/logo/<?=$plan_types->logo?>" style="margin-bottom: 10px;height: 44px;">

                                              <input type="file" class="form-control" name="picture" >

                                           

										</div>

									</div>

                               <?php } ?>

									<!-- sponsor.png -->

								</fieldset>

								<div class="text-right">

									<button type="submit" class="btn btn-primary">UPDATE <i class="icon-arrow-right14 position-right"></i></button>

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
                            <form class="form-horizontal" action="<?php echo base_url();?>index.php/consultant/update_main_info_password" method="post" enctype="multipart/form-data">
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


					<!-- Form horizontal -->


                   <?php if($this->session->flashdata('message')=='update_security_success') { ?>

                      	  <div class="alert alert-styled-right alert-styled-custom alert-arrow-right alpha-teal alert-bordered">

							<button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>

							Security Successfully Updated.. 

				        </div>

                      <?php   } ?>


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

							<form class="form-horizontal" action="<?php echo base_url();?>index.php/consultant/update_security_question" method="post">

								<fieldset class="content-group">

									<legend class="text-bold">Two-step verification <br/> (Help protect your account by enabling extra layers of security.)</legend>

									<div class="form-group">

										<label class="control-label col-lg-2">New Question</label>

										<div class="col-lg-10">

											<!--<input type="text" class="form-control" name="username" value="<?=$profile->username?>">-->

											<select required="" name="question" class="form-control">
												<option value="">Choose Question</option>
												<option <?= isset($profile->security_question) && $profile->security_question == "Your mother's maiden name" ? 'selected' : '' ?> value="Your mother's maiden name">Your mother's maiden name</option>
												<option <?= isset($profile->security_question) && $profile->security_question == "Your first pet's name" ? 'selected' : '' ?> value="Your first pet's name">Your first pet's name</option>
												<option <?= isset($profile->security_question) && $profile->security_question == "The name of your elementary school" ? 'selected' : '' ?> value="The name of your elementary school">The name of your elementary school</option>
												<option <?= isset($profile->security_question) && $profile->security_question == "Your favorite sports team" ? 'selected' : '' ?> value="Your favorite sports team">Your favorite sports team</option>
												<option <?= isset($profile->security_question) && $profile->security_question == "Your best friend's nickname" ? 'selected' : '' ?> value="Your best friend's nickname">Your best friend's nickname</option>
												<option <?= isset($profile->security_question) && $profile->security_question == "The city where you first met your spouse" ? 'selected' : '' ?> value="The city where you first met your spouse">The city where you first met your spouse</option>
											</select>

										</div>

									</div>

									<div class="form-group">
										<label class="control-label col-lg-2">Answer</label>
										<div class="col-lg-10">
											<input required="" type="text" placeholder="Give answer based upon the question" class="form-control" name="answer" value="<?= isset($profile->security_answer) && ($profile->security_answer) ? $profile->security_answer : '' ?>">
										</div>
									</div>
								</fieldset>

								<div class="text-right">
									<button type="submit" class="btn btn-primary">UPDATE <i class="icon-arrow-right14 position-right"></i></button>
								</div>
							</form>
						</div>
					</div>

					<!-- /form horizontal -->



					

					<!-- Footer -->

						<?php $this->load->view('consultant/footer')?>

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

