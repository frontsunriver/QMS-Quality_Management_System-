<!DOCTYPE html>

<html lang="en">



<head>

	<meta charset="utf-8">

	<meta http-equiv="X-UA-Compatible" content="IE=edge">

	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>Register</title>



	<!-- Global stylesheets -->

<!--	<link href="http://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">-->

	<link href="<?=base_url(); ?>assets/css/icons/icomoon/styles.css" rel="stylesheet" type="text/css">

	<link href="<?=base_url(); ?>assets/css/bootstrap.css" rel="stylesheet" type="text/css">

	<link href="<?=base_url(); ?>assets/css/core.css" rel="stylesheet" type="text/css">

	<link href="<?=base_url(); ?>assets/css/components.css" rel="stylesheet" type="text/css">

	<link href="<?=base_url(); ?>assets/css/colors.css" rel="stylesheet" type="text/css">

	<script type="text/javascript" src="<?=base_url(); ?>assets/js/plugins/loaders/pace.min.js"></script>

	<script type="text/javascript" src="<?=base_url(); ?>assets/js/core/libraries/jquery.min.js"></script>

	<script type="text/javascript" src="<?=base_url(); ?>assets/js/core/libraries/bootstrap.min.js"></script>

	<script type="text/javascript" src="<?=base_url(); ?>assets/js/plugins/loaders/blockui.min.js"></script>

	<script type="text/javascript" src="<?=base_url(); ?>assets/js/plugins/forms/wizards/steps.min.js"></script>

	<script type="text/javascript" src="<?=base_url(); ?>assets/js/plugins/forms/selects/select2.min.js"></script>

	<script type="text/javascript" src="<?=base_url(); ?>assets/js/plugins/forms/styling/uniform.min.js"></script>

	<script type="text/javascript" src="<?=base_url(); ?>assets/js/core/libraries/jasny_bootstrap.min.js"></script>

	<script type="text/javascript" src="<?=base_url(); ?>assets/js/plugins/forms/validation/validate.min.js"></script>

	<script type="text/javascript" src="<?=base_url(); ?>assets/js/plugins/extensions/cookie.js"></script>



	<script type="text/javascript" src="<?=base_url(); ?>assets/js/core/app.js"></script>

	<script type="text/javascript" src="<?=base_url(); ?>assets/js/pages/wizard_steps.js"></script>

	<!-- /theme JS files -->



</head>



<body>



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

					<a href="<?php echo base_url(); ?>index.php/Welcome/index">

						<i class="icon-user"></i> Sign In

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

			<!-- Main sidebar -->

			<!-- /main sidebar -->

			<!-- Main content -->

			<div class="content-wrapper">

				<!-- Content area -->

				<div class="row">

				<div class="col-md-3"></div>

					<div class="col-md-6">

						 <div class="content">

					<!-- Basic setup -->

		            <div class="panel panel-white">

						<div class="panel-heading">

							<div class="text-center">

								<div class="icon-object border-warning-400 text-warning-400"><i class="icon-people"></i></div>

								<h5 class="content-group-lg">Create-account <small class="display-block" style="color: red;font-weight:700;font-size:14px;"><?php echo validation_errors(); ?></small></h5>

							</div>

						</div>



	                	<form class="steps-basic" action="#">

							<h6>Personal data</h6>

							<fieldset>

								<div class="row">

									<div class="col-md-6">

										<div class="form-group">

											<label>Applicant name:</label>

											<input type="text" name="name" class="form-control" placeholder="John Doe">

										</div>

									</div>



									<div class="col-md-6">

										<div class="form-group">

											<label>Email address:</label>

											<input type="email" name="email" class="form-control" placeholder="your@email.com">

										</div>

									</div>

								</div>



								<div class="row">

									<div class="col-md-6">

										<div class="form-group">

											<label>Phone #:</label>

											<input type="text" name="tel" class="form-control" placeholder="+99-99-9999-9999" data-mask="+99-99-9999-9999">

										</div>

									</div>



									<div class="col-md-6">

										<label>Date of birth:</label>

										<div class="row">

											<div class="col-md-4">

												<div class="form-group">

													<select name="birth-month" data-placeholder="Month" class="select">

														<option></option>

														<option value="1">January</option>

														<option value="2">February</option>

														<option value="3">March</option>

														<option value="4">April</option>

														<option value="5">May</option>

														<option value="6">June</option>

														<option value="7">July</option>

														<option value="8">August</option>

														<option value="9">September</option>

														<option value="10">October</option>

														<option value="11">November</option>

														<option value="12">December</option>

													</select>

												</div>

											</div>



											<div class="col-md-4">

												<div class="form-group">

													<select name="birth-day" data-placeholder="Day" class="select">

														<option></option>

														<option value="1">1</option>

														<option value="2">2</option>

														<option value="3">3</option>

														<option value="4">4</option>

														<option value="5">5</option>

														<option value="6">6</option>

														<option value="7">7</option>

														<option value="8">8</option>

														<option value="9">9</option>

														<option value="...">...</option>

														<option value="31">31</option>

													</select>

												</div>

											</div>



											<div class="col-md-4">

												<div class="form-group">

													<select name="birth-year" data-placeholder="Year" class="select">

														<option></option>

														<option value="1">1980</option>

														<option value="2">1981</option>

														<option value="3">1982</option>

														<option value="4">1983</option>

														<option value="5">1984</option>

														<option value="6">1985</option>

														<option value="7">1986</option>

														<option value="8">1987</option>

														<option value="9">1988</option>

														<option value="10">1989</option>

														<option value="11">1990</option>

													</select>

												</div>

											</div>

										</div>

									</div>

								</div>

							</fieldset>



							<h6>Your education</h6>

							<fieldset>

								<div class="row">

									<div class="col-md-6">

										<div class="form-group">

											<label>University:</label>

			                                <input type="text" name="university" placeholder="University name" class="form-control">

		                                </div>

									</div>



									<div class="col-md-6">

										<div class="form-group">

											<label>Country:</label>

		                                    <select name="university-country" data-placeholder="Choose a Country..." class="select">

		                                        <option></option> 

		                                        <option value="1">United States</option> 

		                                        <option value="2">France</option> 

		                                        <option value="3">Germany</option> 

		                                        <option value="4">Spain</option> 

		                                    </select>

	                                    </div>

									</div>

								</div>



								<div class="row">

									<div class="col-md-6">

										<div class="form-group">

											<label>Degree level:</label>

			                                <input type="text" name="degree-level" placeholder="Bachelor, Master etc." class="form-control">

		                                </div>



										<div class="form-group">

											<label>Specialization:</label>

			                                <input type="text" name="specialization" placeholder="Design, Development etc." class="form-control">

		                                </div>

									</div>



									<div class="col-md-6">

										<div class="row">

											<div class="col-md-6">

												<label>From:</label>

												<div class="row">

													<div class="col-md-6">

														<div class="form-group">

						                                    <select name="education-from-month" data-placeholder="Month" class="select">

						                                    	<option></option>

						                                        <option value="January">January</option> 

						                                        <option value="...">...</option> 

						                                        <option value="December">December</option> 

						                                    </select>

					                                    </div>

													</div>



													<div class="col-md-6">

														<div class="form-group">

						                                    <select name="education-from-year" data-placeholder="Year" class="select">

						                                        <option></option> 

						                                        <option value="1995">1995</option> 

						                                        <option value="...">...</option> 

						                                        <option value="1980">1980</option> 

						                                    </select>

					                                    </div>

													</div>

												</div>

											</div>



											<div class="col-md-6">

												<label>To:</label>

												<div class="row">

													<div class="col-md-6">

														<div class="form-group">

						                                    <select name="education-to-month" data-placeholder="Month" class="select">

						                                    	<option></option>

						                                        <option value="January">January</option> 

						                                        <option value="...">...</option> 

						                                        <option value="December">December</option> 

						                                    </select>

					                                    </div>

													</div>



													<div class="col-md-6">

														<div class="form-group">

						                                    <select name="education-to-year" data-placeholder="Year" class="select">

						                                        <option></option> 

						                                        <option value="1995">1995</option> 

						                                        <option value="...">...</option> 

						                                        <option value="1980">1980</option> 

						                                    </select>

					                                    </div>

													</div>

												</div>

											</div>

										</div>



										<div class="form-group">

											<label>Language of education:</label>

			                                <input type="text" name="education-language" placeholder="English, German etc." class="form-control">

		                                </div>

									</div>

								</div>

							</fieldset>



							<h6>Your experience</h6>

							<fieldset>

								<div class="row">

									<div class="col-md-6">

										<div class="form-group">

											<label>Company:</label>

			                                <input type="text" name="experience-consultant" placeholder="company name" class="form-control">

		                                </div>



										<div class="form-group">

											<label>Position:</label>

			                                <input type="text" name="experience-position" placeholder="company name" class="form-control">

		                                </div>



										<div class="row">

											<div class="col-md-6">

												<label>From:</label>

												<div class="row">

													<div class="col-md-6">

														<div class="form-group">

						                                    <select name="education-from-month" data-placeholder="Month" class="select">

						                                    	<option></option>

						                                        <option value="January">January</option> 

						                                        <option value="...">...</option> 

						                                        <option value="December">December</option> 

						                                    </select>

					                                    </div>

													</div>



													<div class="col-md-6">

														<div class="form-group">

						                                    <select name="education-from-year" data-placeholder="Year" class="select">

						                                        <option></option> 

						                                        <option value="1995">1995</option> 

						                                        <option value="...">...</option> 

						                                        <option value="1980">1980</option> 

						                                    </select>

					                                    </div>

													</div>

												</div>

											</div>



											<div class="col-md-6">

												<label>To:</label>

												<div class="row">

													<div class="col-md-6">

														<div class="form-group">

						                                    <select name="education-to-month" data-placeholder="Month" class="select">

						                                    	<option></option>

						                                        <option value="January">January</option> 

						                                        <option value="...">...</option> 

						                                        <option value="December">December</option> 

						                                    </select>

					                                    </div>

													</div>



													<div class="col-md-6">

														<div class="form-group">

						                                    <select name="education-to-year" data-placeholder="Year" class="select">

						                                        <option></option> 

						                                        <option value="1995">1995</option> 

						                                        <option value="...">...</option> 

						                                        <option value="1980">1980</option> 

						                                    </select>

					                                    </div>

													</div>

												</div>

											</div>

										</div>

									</div>



									<div class="col-md-6">

		                                <div class="form-group">

											<label>Brief description:</label>

		                                    <textarea name="experience-description" rows="4" cols="4" placeholder="Tasks and responsibilities" class="form-control"></textarea>

		                                </div>



										<div class="form-group">

											<label class="display-block">Recommendations:</label>

		                                    <input name="recommendations" type="file" class="file-styled">

		                                    <span class="help-block">Accepted formats: pdf, doc. Max file size 2Mb</span>

		                                </div>

									</div>

								</div>

							</fieldset>



							<h6>Additional info</h6>

							<fieldset>

								<div class="row">

									<div class="col-md-6">

										<div class="form-group">

											<label class="display-block">Applicant resume:</label>

		                                    <input type="file" name="resume" class="file-styled">

		                                    <span class="help-block">Accepted formats: pdf, doc. Max file size 2Mb</span>

	                                    </div>

									</div>



									<div class="col-md-6">

										<div class="form-group">

											<label>Where did you find us?</label>

		                                    <select name="source" data-placeholder="Choose an option..." class="select-simple">

		                                        <option></option> 

		                                        <option value="monster">Monster.com</option> 

		                                        <option value="linkedin">LinkedIn</option> 

		                                        <option value="google">Google</option> 

		                                        <option value="adwords">Google AdWords</option> 

		                                        <option value="other">Other source</option>

		                                    </select>

	                                    </div>

									</div>

								</div>



								<div class="row">

									<div class="col-md-6">

										<div class="form-group">

											<label>Availability:</label>

											<div class="radio">

												<label>

													<input type="radio" name="availability" class="styled">

													Immediately

												</label>

											</div>



											<div class="radio">

												<label>

													<input type="radio" name="availability" class="styled">

													1 - 2 weeks

												</label>

											</div>



											<div class="radio">

												<label>

													<input type="radio" name="availability" class="styled">

													3 - 4 weeks

												</label>

											</div>



											<div class="radio">

												<label>

													<input type="radio" name="availability" class="styled">

													More than 1 month

												</label>

											</div>

										</div>

									</div>



									<div class="col-md-6">

										<div class="form-group">

											<label>Additional information:</label>

		                                    <textarea name="additional-info" rows="5" cols="5" placeholder="If you want to add any info, do it here." class="form-control"></textarea>

	                                    </div>

									</div>

								</div>

							</fieldset>

						</form>

		            </div>

		            <!-- /basic setup -->

					<!-- Footer -->

					<div class="footer text-muted">

						&copy; 2018. <a href="#">EMS</a> by <a href="#" target="_blank">EMS</a>

					</div>

					<!-- /footer -->

                </div>

					</div>

					<div class="col-md-3"></div>

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

