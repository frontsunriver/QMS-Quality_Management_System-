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
						<li id="product">
							<a class="nav-link" href="<?= base_url('warehouse/product') ?>">
								Product Wise Stock
							</a>
						</li>
						<li id="customer">
							<a class="nav-link" href="<?= base_url('manufacture/customer') ?>">
								Customer
							</a>
						</li>
                        <li id="shiporder">
                            <a class="nav-link" href="<?= base_url('warehouse/shiporder') ?>">
                                Ship Order
                            </a>
                        </li>
                        <li id="transfer">
                            <a class="nav-link" href="<?= base_url('warehouse/transfer') ?>">
                                Transfer
                            </a>
                        </li>
						<li id="material">
							<a class="nav-link" href="<?= base_url('warehouse/material') ?>">
								Material Wise Stock
							</a>
						</li>
						<li id="waste_category">
							<a class="nav-link" href="<?= base_url('warehouse/wastecategory') ?>">
								Waste Category
							</a>
						</li>
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