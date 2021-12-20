
<?php $this->load->view('Admin/header.php'); ?>
<body class="navbar-top">
	<!-- Main navbar -->
	<?php $this->load->view('Admin/main_header.php'); ?>
	<!-- /main navbar -->
	<!-- Page container -->
	<div class="page-container">
		<!-- Page content -->
		<div class="page-content">
			<!-- Main sidebar -->
			<?php $this->load->view('Admin/sidebar'); ?>
			<!-- /main sidebar -->
			<!-- Main content -->
			<div class="content-wrapper">
				<!-- Page header -->
				<div class="page-header page-header-default">
					<div class="page-header-content">
						<div class="page-title">
							<h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Home</span> - Dashboard</h4>
						</div>
					</div>
					<div class="breadcrumb-line">
						<ul class="breadcrumb">
							<li><a href="index-2.html"><i class="icon-home2 position-left"></i> Home</a></li>
							<li class="active">Dashboard</li>
						</ul>

						<ul class="breadcrumb-elements">
							<li><a href="#"><i class="icon-comment-discussion position-left"></i> Support</a></li>
						</ul>
					</div>
				</div>
				<!-- /page header -->
				<!-- Content area -->
				<div class="content">
					<!-- Dashboard content -->
					<div class="row">
						<div class="col-lg-12">
							<!-- Latest posts -->
							<div class="panel panel-flat">
								<div class="panel-heading">
									<h6 class="panel-title">Latest posts</h6>
									<div class="heading-elements">
										<ul class="icons-list">
					                		<li><a data-action="collapse"></a></li>
					                		<li><a data-action="reload"></a></li>
					                		<li><a data-action="close"></a></li>
					                	</ul>
				                	</div>
			                	</div>
								<div class="panel-body">
									<div class="row">
										<div class="col-lg-6">
											<ul class="media-list content-group">
												<li class="media stack-media-on-mobile">
				                					<div class="media-left">
														<div class="thumb">
															<a href="#">
																<img src="<?=base_url(); ?>assets/images/demo/flat/1.png" class="img-responsive img-rounded media-preview" alt="">
																<span class="zoom-image"><i class="icon-play3"></i></span>
															</a>
														</div>
													</div>

				                					<div class="media-body">
														<h6 class="media-heading"><a href="#">Up unpacked friendly</a></h6>
							                    		<ul class="list-inline list-inline-separate text-muted mb-5">
							                    			<li><i class="icon-book-play position-left"></i> Video tutorials</li>
							                    			<li>14 minutes ago</li>
							                    		</ul>
														The him father parish looked has sooner. Attachment frequently gay terminated son...
													</div>
												</li>

												<li class="media stack-media-on-mobile">
				                					<div class="media-left">
														<div class="thumb">
															<a href="#">
																<img src="<?=base_url(); ?>assets/images/demo/flat/21.png" class="img-responsive img-rounded media-preview" alt="">
																<span class="zoom-image"><i class="icon-play3"></i></span>
															</a>
														</div>
													</div>

				                					<div class="media-body">
														<h6 class="media-heading"><a href="#">It allowance prevailed</a></h6>
							                    		<ul class="list-inline list-inline-separate text-muted mb-5">
							                    			<li><i class="icon-book-play position-left"></i> Video tutorials</li>
							                    			<li>12 days ago</li>
							                    		</ul>
														Alteration literature to or an sympathize mr imprudence. Of is ferrars subject as enjoyed...
													</div>
												</li>
											</ul>
										</div>

										<div class="col-lg-6">
											<ul class="media-list content-group">
												<li class="media stack-media-on-mobile">
				                					<div class="media-left">
														<div class="thumb">
															<a href="#">
																<img src="<?=base_url(); ?>assets/images/demo/flat/12.png" class="img-responsive img-rounded media-preview" alt="">
																<span class="zoom-image"><i class="icon-play3"></i></span>
															</a>
														</div>
													</div>

				                					<div class="media-body">
														<h6 class="media-heading"><a href="#">Case read they must</a></h6>
							                    		<ul class="list-inline list-inline-separate text-muted mb-5">
							                    			<li><i class="icon-book-play position-left"></i> Video tutorials</li>
							                    			<li>20 hours ago</li>
							                    		</ul>
														On it differed repeated wandered required in. Then girl neat why yet knew rose spot...
													</div>
												</li>

												<li class="media stack-media-on-mobile">
				                					<div class="media-left">
														<div class="thumb">
															<a href="#">
																<img src="<?=base_url(); ?>assets/images/demo/flat/15.png" class="img-responsive img-rounded media-preview" alt="">
																<span class="zoom-image"><i class="icon-play3"></i></span>
															</a>
														</div>
													</div>

				                					<div class="media-body">
														<h6 class="media-heading"><a href="#">Too carriage attended</a></h6>
							                    		<ul class="list-inline list-inline-separate text-muted mb-5">
							                    			<li><i class="icon-book-play position-left"></i> FAQ section</li>
							                    			<li>2 days ago</li>
							                    		</ul>
														Marianne or husbands if at stronger ye. Considered is as middletons uncommonly...
													</div>
												</li>
											</ul>
										</div>
									</div>
								</div>
							</div>
							<!-- /latest posts -->
						</div>
					</div>
					<!-- /dashboard content -->


					<!-- Footer -->
					<?php $this->load->view('Admin/footer'); ?>
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
