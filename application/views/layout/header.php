<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title><?= $title ?></title>

	<link rel="stylesheet" type="text/css" href="<?= base_url(PLUGINS_URL . 'bootstrap/bootstrap.min.css') ?>">
	<link rel="stylesheet" type="text/css" href="<?= base_url(PLUGINS_URL . 'css/animate.css') ?>">
	<link rel="stylesheet" type="text/css" href="<?= base_url(PLUGINS_URL . 'font-awesome/font-awesome.min.css') ?>">
	<link rel="stylesheet" type="text/css" href="<?= base_url(PLUGINS_URL . 'css/style.css') ?>">
	<link rel="stylesheet" type="text/css" href="<?= base_url(PLUGINS_URL . 'css/responsive.css') ?>">
	<link rel="stylesheet" type="text/css" href="<?= base_url(CSS_URL . 'icons/icomoon/styles.css') ?>">
	<link rel="stylesheet" type="text/css" href="<?= base_url(CSS_URL . 'bootstrap.css') ?>">
	<link rel="stylesheet" type="text/css" href="<?= base_url(CSS_URL . 'core.css') ?>">
	<link rel="stylesheet" type="text/css" href="<?= base_url(CSS_URL . 'components.css') ?>">
	<link rel="stylesheet" type="text/css" href="<?= base_url(CSS_URL . 'colors.css') ?>">
	<link rel="stylesheet" type="text/css" href="<?= base_url(CSS_URL . 'styles.css') ?>">

	<script type="text/javascript" src="<?= base_url(PLUGINS_URL . 'js/jquery.min.js') ?>"></script>
	<script type="text/javascript" src="<?= base_url(PLUGINS_URL . 'bootstrap/bootstrap.min.js') ?>"></script>
	<script type="text/javascript" src="<?= base_url(PLUGINS_URL . 'font-awesome/font-awesome.js') ?>"></script>
	<script type="text/javascript" src="<?= base_url(PLUGINS_URL . 'js/wow.min.js') ?>"></script>
	<script type="text/javascript" src="<?= base_url(PLUGINS_URL . 'forms/styling/uniform.min.js') ?>"></script>

	<style>
		.navbar-nav > li > a.active {
			color: #0892d0;
		}
	</style>
</head>

<?php $user = $this->session->userdata('user'); ?>

<body>
	<div class="Header">
		<div class="topHeader">
			<div class="container">
				<div class="row">
					<div class="col-lg-6 col-sm-6 col-xs-12">
						<a href="mailto:support@qualitycircleint.com"><i class="fas fa-envelope emailiconTop"></i>support@qualitycircleint.com</a>
						<a href="tel:19037818111"><img src="<?= base_url(IMG_URL . 'home/united-states.png') ?>" class="emailiconTop"> 1-903-781-8111</a>
						<a href="tel:18769601111"><img src="<?= base_url(IMG_URL . 'home/jamaica.png') ?>" class="emailiconTop"> 1-876-960-1111</a>
					</div>
				</div>
			</div>
		</div>
		<nav class="navbar navbar-inverse">
			<div class="container">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="<?= base_url('welcome') ?>"><img src="<?= base_url(IMG_URL . 'home/logo-top.png') ?>"></a>
				</div>
				<div class="collapse navbar-collapse" id="myNavbar">
					<ul class="nav navbar-nav navbar-right nil">
						<li>
							<a class="<?= $menu_title == 'home' ? 'active' : '' ?>" href="<?= base_url('welcome') ?>">Home</a>
						</li>
						<?php if (isset($user) && $user->type == 'consultant' && ($user->plan_type == 'real' || $user->plan_type == 'trial')) : ?>
							<li>
								<a class="<?= $menu_title == 'Upgrade'? 'active' : '' ?>" href="<?= base_url('auth/update_process') ?>">Pricing</a>
							</li>
						<?php endif; ?>
						<li>
							<a href="#">Smart Solutions</a>
							<ul class="Submenu">
								<li><a href="https://fsscverificationsoftware.com/">Verification Software</a></li>
								<li><a href="https://isogapauditsoftware.com/">Gap Audit Software</a></li>
								<li><a href="http://isoprocessbasedauditexperts.com/">Process Auditing Software</a></li>
								<!-- <li><a href="#">Contract Signing Software</a></li> -->
								<li><a href="https://www.gosmartacademy.com/">Virtual Academy</a></li>
							</ul>
						</li>
						<li>
							<a class="<?= $menu_title == 'aboutus' ? 'active' : '' ?>" href="<?= base_url('welcome/aboutus') ?>">About Us</a>
						</li>
						<?php if (!$isLogged) : ?>
							<li>
								<a class="<?php echo $menu_title && $menu_title == 'signup'? 'header_menu_active':''?>" href="<?php echo base_url('auth/register')?>">Sign Up</a>
							</li>
							<li>
								<a class="Login hvr-shutter-out-horizontal <?= $menu_title == 'login' ? 'active' : '' ?>" href="<?= base_url('auth/login') ?>">Login</a>
							</li>							
						<?php else : ?>
							<li>
								<a href="<?= base_url('welcome/dashboard') ?>">Dashboard</a>
							</li>
							<li>
								<a href="<?= base_url('auth/logout') ?>" class="Login hvr-shutter-out-horizontal">Logout</a>
							</li>
						<?php endif; ?>
					</ul>
				</div>
			</div>
		</nav>
	</div>