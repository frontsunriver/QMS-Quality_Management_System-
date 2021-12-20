<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta charset="utf-8">

	<title><?= $title ?></title>

	<link rel="stylesheet" type="text/css" href="<?= base_url(CSS_URL . 'icons/icomoon/styles.css') ?>">
	<link rel="stylesheet" type="text/css" href="<?= base_url(CSS_URL . 'bootstrap.css') ?>">
	<link rel="stylesheet" type="text/css" href="<?= base_url(CSS_URL . 'core.css') ?>">
	<link rel="stylesheet" type="text/css" href="<?= base_url(CSS_URL . 'components.css') ?>">
	<link rel="stylesheet" type="text/css" href="<?= base_url(CSS_URL . 'colors.css') ?>">

	<script type="text/javascript" src="<?= base_url(PLUGINS_URL . 'loaders/pace.min.js') ?>"></script>
	<script type="text/javascript" src="<?= base_url(PLUGINS_URL . 'core/libraries/jquery.min.js') ?>"></script>
	<script type="text/javascript" src="<?= base_url(PLUGINS_URL . 'core/libraries/bootstrap.min.js') ?>"></script>
	<script type="text/javascript" src="<?= base_url(PLUGINS_URL . 'loaders/blockui.min.js') ?>"></script>
	<script type="text/javascript" src="<?= base_url(PLUGINS_URL . 'tables/datatables/datatables.min.js') ?>"></script>
	<script type="text/javascript" src="<?= base_url(PLUGINS_URL . 'core/app.js') ?>"></script>
	<script type="text/javascript" src="<?= base_url(JS_URL . 'bootbox.min.js') ?>"></script>
</head>

<style>
	ul.navigation > li > a.active {
		background-color: #26a69a;
		color: white;
	}
</style>

<body class="navbar-top">
	<div class="navbar navbar-inverse navbar-fixed-top">
		<div class="navbar-header">
			<a class="navbar-brand" href="#"><img src="<?= base_url(IMG_URL . 'logo_light.png') ?>" alt=""></a>

			<ul class="nav navbar-nav visible-xs-block">
				<li><a data-toggle="collapse" data-target="#navbar-mobile"><i class="icon-tree5"></i></a></li>
				<li><a class="sidebar-mobile-main-toggle"><i class="icon-paragraph-justify3"></i></a></li>
			</ul>
		</div>

		<div class="navbar-collapse collapse" id="navbar-mobile">
			<ul class="nav navbar-nav">
				<li><a class="sidebar-control sidebar-main-toggle hidden-xs"><i class="icon-paragraph-justify3"></i></a></li>
			</ul>

			<ul class="nav navbar-nav navbar-right">
				<li class="dropdown dropdown-user" ><a href="<?= base_url('welcome') ?>"　class="dropdown-toggle"><span>Home</span></a></li>
				<li class="dropdown dropdown-user">
					<a class="dropdown-toggle" data-toggle="dropdown">
					
						<span>
							<?php
								$user = $this->session->userdata('user');
								if ($user) {
									$admin = $user->username;
									echo $admin;
								}
							?>
						</span>
						<i class="caret"></i>
					</a>
					<ul class="dropdown-menu dropdown-menu-right">
						<li><a href="<?= base_url('admin/edit_profile') ?>"><i class="icon-user-plus"></i> Edit profile</a></li>
						<li class="divider"></li>
						<li><a href="<?= base_url('admin/default_logo') ?>"><i class="icon-image4"></i>Default Logo</a></li>
						<li class="divider"></li>
						<li><a href="<?= base_url('auth/logout') ?>"><i class="icon-switch2"></i> Logout</a></li>
					</ul>
				</li>
			</ul>
		</div>
	</div>

	<div class="page-container">
		<div class="page-content">
			<?php $this->load->view('layout/admin/aside') ?>

			<div class="content-wrapper">