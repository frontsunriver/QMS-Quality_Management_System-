<!DOCTYPE html>
<html lang="en">

<head>
	<title>Quality Circle</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="<?=base_url(); ?>assets/home/css/bootstrap.min.css" rel="stylesheet" type="text/css">
	<link href="<?=base_url(); ?>assets/home/css/animate.css" rel="stylesheet" type="text/css">

	<link href="<?=base_url(); ?>assets/home/css/font-awesome.min.css" rel="stylesheet" type="text/css">	
	<link href="<?=base_url(); ?>assets/home/css/all.css" rel="stylesheet" 
		  integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">	
	<link href="<?=base_url(); ?>assets/home/css/css.css" rel="stylesheet">
	<link rel="stylesheet" href="<?=base_url(); ?>assets/home/css/style.css" type="text/css">
	<link rel="stylesheet" href="<?=base_url(); ?>assets/home/css/responsive.css" type="text/css">

	<script type="text/javascript" src="<?=base_url(); ?>assets/home/js/jquery.min.js"></script>
	<script type="text/javascript" src="<?=base_url(); ?>assets/home/js/fontawesome.js"></script>
	<script type="text/javascript" src="<?=base_url(); ?>assets/home/js/wow.min.js"></script>
	<script type="text/javascript" src="<?=base_url(); ?>assets/home/js/bootstrap.min.js"></script>
	<script src="https://checkout.stripe.com/checkout.js"></script>
	<style type="text/css">
		.header_menu_active{color: #0892d0!important;}
	</style>
</head>
<body>
	<div class="Header">
		<div class="topHeader">
			<div class="container">
				<div class="row">
					<div class="col-lg-6 col-sm-6 col-xs-12">

						<a href="mailto:support@qualitycircleint.com"><i class="fas fa-envelope emailiconTop"></i>
							support@qualitycircleint.com</a>
						<a href="tel:19037818111"><img src="<?php echo base_url()?>assets/home/Images/united-states.png" class="emailiconTop"> 1-903-781-8111</a>
						<a href="tel:18769601111"><img src="<?php echo base_url()?>assets/home/Images/jamaica.png" class="emailiconTop"> 1-876-960-1111</a>
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
					<a class="navbar-brand" href="<?php echo base_url('index.php/welcome')?>"><img src="<?php echo base_url()?>assets/home/Images/logo-top.png"></a>
				</div>
				<div class="collapse navbar-collapse" id="myNavbar">
					<ul class="nav navbar-nav navbar-right nil">
						<li ><a class="<?php echo $menu_title && $menu_title == 'home'? 'header_menu_active':''?>" href="<?php echo base_url('index.php/welcome')?>">Home</a></li>
						<?php if($this->session->userdata('admin_id') && ($this->session->userdata('plan_type') == 'real' || $this->session->userdata('plan_type') == 'trial')):?>
						<li><a class="<?php echo $menu_title && $menu_title == 'pricing'? 'header_menu_active':''?>" href="<?php echo base_url('index.php/auth/reg_pay_plans')?>">Pricing</a></li>
						<?php endif;?>
						<li><a href="#">Smart Solutions</a>
							<ul class="Submenu">
								<li><a href="https://fsscverificationsoftware.com/">Verification Software</a></li>
								<li><a href="http://isoprocessbasedauditexperts.com">Process Auditing Software</a></li>
								<!--<li><a href="https://contractsigningsoftware.com">Contract Signing Software</a></li>-->
								<li><a href="http://isoimplementationsoftware.com">Implementation Software</a></li>
								<li><a href="https://www.gosmartacademy.com/">Virtual Academy</a></li>
							</ul>
						</li>
						<li><a class="<?php echo $menu_title && $menu_title == 'about'? 'header_menu_active':''?>" href="<?php echo base_url('index.php/welcome/aboutus')?>">About Us</a></li>
						<?php if($this->session->userdata('superadmin_id')):?>
						<li><a href="<?php echo base_url('index.php/welcome/superadmindashboard')?>">Dashboard</a></li>
						<?php endif;?>
						<?php if($this->session->userdata('admin_id') && ($this->session->userdata('plan_type') == 'real' || $this->session->userdata('plan_type') == 'trial')):?>
						<li><a href="<?php echo base_url('index.php/welcome/admindashboard')?>">Dashboard</a></li>
						<?php endif;?>
						<?php if($this->session->userdata('consultant_id')):?>
						<li><a href="<?php echo base_url('index.php/welcome/consultantdashboard')?>">Dashboard</a></li>
						<?php endif;?>
						<?php if($this->session->userdata('employee_id')):?>
						<li><a href="<?php echo base_url('index.php/welcome/employeedashboard')?>">Dashboard</a></li>
						<?php endif;?>
						<?php if(!$this->session->userdata('username')):?>
						<li><a class="<?php echo $menu_title && $menu_title == 'signup'? 'header_menu_active':''?>" href="<?php echo base_url('index.php/welcome/register')?>">Sign Up</a></li>
						<?php endif;?>
						<?php if(!$this->session->userdata('username')):?>
						<li><a href="<?php echo base_url('index.php/welcome/login')?>" class="Login hvr-shutter-out-horizontal">Login</a></li>
						<?php endif;?>
						<?php if($this->session->userdata('username')):?>
						<li><a href="<?php echo base_url('index.php/welcome/logout')?>" class="Login hvr-shutter-out-horizontal">Logout</a></li>
						<?php endif;?>
					</ul>
				</div>
			</div>
		</nav>
	</div>
