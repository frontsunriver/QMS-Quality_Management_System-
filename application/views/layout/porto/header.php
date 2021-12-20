<!doctype html>
<html class="fixed has-top-menu">
	<head>

		<!-- Basic -->
		<meta charset="UTF-8">

		<title><?= $title ?></title>
		<meta name="keywords" content="HTML5 Admin Template" />
		<meta name="description" content="Porto Admin - Responsive HTML5 Template">
		<meta name="author" content="okler.net">

		<!-- Mobile Metas -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

		<!-- Web Fonts  -->
		<!-- <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800|Shadows+Into+Light" rel="stylesheet" type="text/css"> -->

		<!-- Vendor CSS -->
		<link rel="stylesheet" href="<?= base_url(PORTO_URL . 'vendor/bootstrap/css/bootstrap.css') ?>" />
		<link rel="stylesheet" href="<?= base_url(PORTO_URL . 'vendor/animate/animate.css') ?>">

		<link rel="stylesheet" href="<?= base_url(PORTO_URL . 'vendor/font-awesome/css/fontawesome-all.min.css') ?>" />
		<link rel="stylesheet" href="<?= base_url(PORTO_URL . 'vendor/magnific-popup/magnific-popup.css') ?>" />
		<link rel="stylesheet" href="<?= base_url(PORTO_URL . 'vendor/bootstrap-datepicker/css/bootstrap-datepicker3.css') ?>" />

		<!-- Specific Page Vendor CSS -->
		<!-- <link rel="stylesheet" href="<?= base_url(PORTO_URL . 'vendor/jquery-ui/jquery-ui.css') ?>" /> -->
		<!-- <link rel="stylesheet" href="<?= base_url(PORTO_URL . 'vendor/jquery-ui/jquery-ui.theme.css') ?>" /> -->
		<link rel="stylesheet" href="<?= base_url(PORTO_URL . 'vendor/bootstrap-multiselect/bootstrap-multiselect.css') ?>" />
		<link rel="stylesheet" href="<?= base_url(PORTO_URL . 'vendor/morris/morris.css') ?>" />

		<!-- Theme CSS -->
		<link rel="stylesheet" href="<?= base_url(PORTO_URL . 'css/theme.css') ?>" />

		<!-- Skin CSS -->
		<link rel="stylesheet" href="<?= base_url(PORTO_URL . 'css/skins/default.css') ?>" />

		<!-- Theme Custom CSS -->
		<link rel="stylesheet" href="<?= base_url(PORTO_URL . 'css/custom.css') ?>">

		<link rel="stylesheet" type="text/css" href="<?= base_url(CSS_URL . 'icons/icomoon/styles.css') ?>">
		<link rel="stylesheet" type="text/css" href="<?= base_url(CSS_URL . 'components.css') ?>">
		<link rel="stylesheet" type="text/css" href="<?= base_url(CSS_URL . 'colors.css') ?>">

		<style>
			.content-body {
				padding-bottom: 0;
			}
			.content {
				padding: 0 20px 0 20px;
			}
		</style>

		<!-- Head Libs -->
		<script src="<?= base_url(PORTO_URL . 'vendor/modernizr/modernizr.js') ?>"></script>

		<!-- Vendor -->
		<script src="<?= base_url(PORTO_URL . 'vendor/jquery/jquery.js') ?>"></script>
		<script src="<?= base_url(PORTO_URL . 'vendor/jquery-browser-mobile/jquery.browser.mobile.js') ?>"></script>
		<script src="<?= base_url(PORTO_URL . 'vendor/popper/umd/popper.min.js') ?>"></script>
		<script src="<?= base_url(PORTO_URL . 'vendor/bootstrap/js/bootstrap.js') ?>"></script>
		<script src="<?= base_url(PORTO_URL . 'vendor/bootstrap-datepicker/js/bootstrap-datepicker.js') ?>"></script>
		<script src="<?= base_url(PORTO_URL . 'vendor/common/common.js') ?>"></script>
		<script src="<?= base_url(PORTO_URL . 'vendor/nanoscroller/nanoscroller.js') ?>"></script>
		<script src="<?= base_url(PORTO_URL . 'vendor/magnific-popup/jquery.magnific-popup.js') ?>"></script>
		<script src="<?= base_url(PORTO_URL . 'vendor/jquery-placeholder/jquery-placeholder.js') ?>"></script>
		<script src="<?= base_url(PLUGINS_URL . 'forms/validation/validate.min.js') ?>"></script>
		<script src="<?= base_url(PLUGINS_URL . 'forms/selects/bootstrap_select.min.js') ?>"></script>
		<script src="<?= base_url(PLUGINS_URL . 'tables/datatables/datatables.min.js') ?>"></script>
		<script src="<?= base_url(PLUGINS_URL . 'tables/datatables/extensions/fixed_columns.min.js') ?>"></script>
		<script src="<?= base_url(PLUGINS_URL . 'tables/datatables/extensions/col_reorder.min.js') ?>"></script>
		<script src="<?= base_url(PLUGINS_URL . 'tables/datatables/extensions/buttons.min.js') ?>"></script>

		<script src="<?= base_url(PLUGINS_URL . 'notifications/pnotify.min.js') ?>"></script>
		<script src="<?= base_url(JS_URL . 'bootbox.min.js') ?>"></script>

		<!-- Theme Base, Components and Settings -->
		<script src="<?= base_url(PORTO_URL . 'js/theme.js') ?>"></script>
		
		<!-- Theme Custom -->
		<script src="<?= base_url(PORTO_URL . 'js/custom.js') ?>"></script>
		
		<!-- Theme Initialization Files -->
		<script src="<?= base_url(PORTO_URL . 'js/theme.init.js') ?>"></script>

		<!-- Examples -->
		<script src="<?= base_url(PORTO_URL . 'js/examples/examples.header.menu.js') ?>"></script>
		<script src="<?= base_url(PORTO_URL . 'js/examples/examples.dashboard.js') ?>"></script>

		<script>
			var base_url = '<?= base_url() ?>';

			$(function(){
				<?php if (isset($flash)) { ?>
					<?php if ($flash['success']) { ?>
						new PNotify({
							title: 'Success',
							text: '<?= $flash['msg'] ?>',
							icon: 'icon-checkmark3',
							type: 'success'
						});
					<?php } else { ?>
						new PNotify({
							title: 'Error',
							text: '<?= $flash['msg'] ?>',
							icon: 'icon-checkmark3',
							type: 'error'
						});
					<?php } ?>
				<?php } ?>
			});
		</script>

	</head>

	<body>
		<?php
			$user = $this->session->userdata('user');
			$type = $user->type;
			if ($type == 'monitor')
				$type = 'manufacturing';
			$this->load->view("layout/porto/aside_{$type}");
		?>

		<div class="inner-wrapper">
			<section role="main" class="content-body" style="padding-left: 60px; padding-right: 60px;">
				<header class="page-header">
					<h2><?= $title ?></h2>
				
					<div class="right-wrapper text-right">
						<ol class="breadcrumbs" style="margin-right: 20px;">
							<li>
								<a href="<?= base_url('manufacture/welcome') ?>">
									<i class="fas fa-home"></i>
								</a>
							</li>
							<li><span><?= $title ?></span></li>
						</ol>
					</div>
				</header>