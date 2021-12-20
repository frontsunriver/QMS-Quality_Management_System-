<style>
	.header.header-nav-menu .header-nav-main nav > ul > li > a {
		text-transform: initial;
		font-size: 13px;
	}
</style>

<script>
	$(function(){
		$("li#<?= $menu_id ?>").addClass("active");
	});
</script>

<?php $user = $this->session->userdata('user'); ?>

<!-- start: header -->
<header class="header header-nav-menu">
	<div class="logo-container">
		<a href="<?= base_url('welcome') ?>" class="logo">
			<img src="<?= base_url(PORTO_URL . 'img/logo.png') ?>" width="140" height="35" alt="Porto Admin" />
		</a>
		<button class="btn header-btn-collapse-nav d-lg-none" data-toggle="collapse" data-target=".header-nav">
			<i class="fas fa-bars"></i>
		</button>

		<!-- start: header nav menu -->
		<div class="header-nav collapse">
			<div class="header-nav-main header-nav-main-effect-1 header-nav-main-sub-effect-1">
				<nav>
					<ul class="nav nav-pills" id="mainNav">
						<li id="manufacturing_orders">
							<a class="nav-link" href="<?= base_url('manufacture/manuorder') ?>">
								Manufacturing Orders
							</a>
						</li>
						<li id="work_orders">
							<a class="nav-link" href="<?= base_url('manufacture/workorder') ?>">
								Work Orders
							</a>
						</li>
						<!--<li id="inspection" class="dropdown">
							<a class="nav-link dropdown-toggle" href="#">
								Inspection
							</a>
							<ul class="dropdown-menu">
								<li>
									<a class="nav-link" href="<?/*= base_url('manufacture/conduct') */?>">
										Conduct An Inspection
									</a>
								</li>
							</ul>
						</li>-->
						<?php if ($user->type == 'manufacturing') : ?>
							<li id="planing" class="dropdown">
								<a class="nav-link dropdown-toggle" href="#">
									Planing
								</a>
								<ul class="dropdown-menu">
									<li>
										<a class="nav-link" href="<?= base_url('manufacture/plan?type=product') ?>">
											Product Planing
										</a>
									</li>
									<li>
										<a class="nav-link" href="<?= base_url('manufacture/plan?type=material') ?>">
											Material Planing
										</a>
									</li>
								</ul>
							</li>
						<?php endif; ?>
						<?php if ($user->type == 'monitor') : ?>
							<li id="manufacturing_system" class="dropdown">
								<a class="nav-link dropdown-toggle" href="#" title="Manufacturing System Quality & Food Saftey Assurance">
									Manufacturing System
								</a>
								<ul class="dropdown-menu">
									<li>
										<a class="nav-link" href="<?= base_url('manufacture/qualitycheck') ?>">
											Quality Check
										</a>
									</li>
								</ul>
							</li>
						<?php endif; ?>
						<li id="report" class="dropdown">
							<a class="nav-link dropdown-toggle" href="#" title="Manufacturing System Quality & Food Saftey Assurance">
								Report
							</a>
							<ul class="dropdown-menu">
								<li>
									<a class="nav-link" href="<?= base_url('manufacture/manuorderreport') ?>">
										Manufacturing Orders Report
									</a>
								</li>
								<!--
								<li>
									<a class="nav-link" href="index.html">
										Quality Checks Report
									</a>
								</li>
								<li>
									<a class="nav-link" href="index.html">
										Traceability
									</a>
								</li> -->
								<li>
									<a class="nav-link" href="<?= base_url('manufacture/wastereport') ?>">
										Waste Report
									</a>
								</li>
								<li>
									<a class="nav-link" href="<?= base_url('manufacture/traceability') ?>">
										Traceability
									</a>
								</li>
							</ul>
						</li>
						<li id="customer">
							<a class="nav-link" href="<?= base_url('manufacture/customer') ?>">
								Customer
							</a>
						</li>
						<li id="supplier">
							<a class="nav-link" href="<?= base_url('manufacture/supplier') ?>">
								Supplier
							</a>
						</li>
						<li id="order" class="dropdown">
							<a class="nav-link dropdown-toggle" href="#" title="Order">
								Order
							</a>
							<ul class="dropdown-menu">
								<li>
									<a class="nav-link" href="<?= base_url('manufacture/purchaseorder') ?>">
										Purchase Order
									</a>
								</li>
								<li>
									<a class="nav-link" href="<?= base_url('manufacture/salesorder') ?>">
										Sales Order
									</a>
								</li>
								<li>
									<a class="nav-link" href="<?= base_url('manufacture/shiporder') ?>">
										Ship Order
									</a>
								</li>
							</ul>
						</li>
						<!-- <li class="dropdown">
							<a class="nav-link dropdown-toggle" href="#" title="Manufacturing System Quality & Food Saftey Assurance">
								Invoice
							</a>
							<ul class="dropdown-menu">
								<li>
									<a class="nav-link" href="index.html">
										Manage Invoice
									</a>
								</li>
							</ul>
						</li> -->
						<?php if ($user->type == 'manufacturing') : ?>
							<li id="master_data" class="dropdown">
								<a class="nav-link dropdown-toggle" href="#" title="Manufacturing System Quality & Food Saftey Assurance">
									Master Data
								</a>
								<ul class="dropdown-menu">
									<li class="dropdown-submenu">
										<a class="nav-link" href="#">
											Product
										</a>
										<ul class="dropdown-menu">
											<li>
												<a class="nav-link" href="<?= base_url('manufacture/product/create') ?>">
													Create Product
												</a>
											</li>
											<li>
												<a class="nav-link" href="<?= base_url('manufacture/product') ?>">
													Manage Product
												</a>
											</li>
										</ul>
									</li>
									<li>
										<a class="nav-link" href="<?= base_url('manufacture/warehouse') ?>">
											Warehouse
										</a>
									</li>
									<li>
										<a class="nav-link" href="<?= base_url('manufacture/category') ?>">
											Product Category
										</a>
									</li>
									<li>
										<a class="nav-link" href="<?= base_url('manufacture/bill') ?>">
											Bill of Material
										</a>
									</li>
									<li>
										<a class="nav-link" href="<?= base_url('manufacture/workcenter') ?>">
											Work Center
										</a>
									</li>
									<li>
										<a class="nav-link" href="<?= base_url('manufacture/routing') ?>">
											Routing
										</a>
									</li>
									<li>
										<a class="nav-link" href="<?= base_url('manufacture/wastecategory') ?>">
											Waste Category
										</a>
									</li>
									<li>
										<a class="nav-link" href="<?= base_url('manufacture/operationtype') ?>">
											Operation Type
										</a>
									</li>
									<li>
										<a class="nav-link" href="<?= base_url('manufacture/material') ?>">
											Material Wise Stocks
										</a>
									</li>
								</ul>
							</li>
						<?php endif; ?>
					</ul>
				</nav>
			</div>
		</div>
		<!-- end: header nav menu -->
	</div>

	<!-- start: search & user box -->
	<div class="header-right">
		<span class="separator"></span>

		<div id="userbox" class="userbox">
			<a href="#" data-toggle="dropdown">
				<figure class="profile-picture">
					<img src="<?= base_url(PORTO_URL . 'img/!logged-user.jpg') ?>" class="rounded-circle" data-lock-picture="<?= base_url(PORTO_URL . 'img/!logged-user.jpg') ?>" />
				</figure>
				<div class="profile-info">
					<span class="name"><?= $user->username ?></span>
					<span class="role"><?= $user->type ?></span>
				</div>

				<i class="fa custom-caret"></i>
			</a>

			<div class="dropdown-menu">
				<ul class="list-unstyled">
					<li class="divider"></li>
					<li>
						<a role="menuitem" tabindex="-1" href="<?= base_url('auth/logout') ?>"><i class="fas fa-power-off"></i> Logout</a>
					</li>
				</ul>
			</div>
		</div>
	</div>
	<!-- end: search & user box -->
</header>
