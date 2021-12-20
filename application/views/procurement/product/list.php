<style>
	.list-inline li .text-black, .list-inline li .text-bold, .list-inline li .text-muted {
		text-align: initial;
	}
	.media-body .media-heading {
		margin-bottom: 0px;
	}
	.media-body .text-muted {
		font-size: 12px;
	}
</style>

<div class="content">
	<div class="panel panel-flat">
		<div class="panel-heading" style="border-bottom: 1px solid #eee;">
			<h5 class="panel-title" style="display: inline-block;">Product</h5>
			<!-- <button type="button" class="btn bg-blue pull-right" onclick="javascript:onCreate();">Create</button> -->
			<div class="form-group pull-right">
				<div class="form-group has-feedback" style="position: relative;">
					<input type="text" class="form-control" placeholder="Filter">
					<div class="form-control-feedback">
						<i class="icon-search4 text-size-base"></i>
					</div>
				</div>
			</div>
		</div>
		<div class="container-fluid">
			<?php for ($i = 0; $i < 4; $i ++) : ?>
				<div class="row">
					<div class="col-lg-3 col-md-6">
						<div class="panel panel-body">
							<div class="media">
								<div class="media-left">
									<a href="#" data-popup="lightbox">
										<img src="<?= base_url(PRODUCT_URL . 'product1.png') ?>" width="120" height="120" />
									</a>
								</div>

								<div class="media-body">
									<h5 class="media-heading text-black">Product Name</h5>
									<h7 class="text-bold">9 Variants</h7>
									<div class="text-muted">Price: $ 35.00</div>
									<div class="text-muted">On Hand: 450.000 Unit(s)</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-3 col-md-6">
						<div class="panel panel-body">
							<div class="media">
								<div class="media-left">
									<a href="#" data-popup="lightbox">
										<img src="<?= base_url(PRODUCT_URL . 'product1.png') ?>" width="120" height="120" />
									</a>
								</div>

								<div class="media-body">
									<h5 class="media-heading text-black">Product Name</h5>
									<h7 class="text-bold">9 Variants</h7>
									<div class="text-muted">Price: $ 35.00</div>
									<div class="text-muted">On Hand: 450.000 Unit(s)</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-3 col-md-6">
						<div class="panel panel-body">
							<div class="media">
								<div class="media-left">
									<a href="#" data-popup="lightbox">
										<img src="<?= base_url(PRODUCT_URL . 'product1.png') ?>" width="120" height="120" />
									</a>
								</div>

								<div class="media-body">
									<h5 class="media-heading text-black">Product Name</h5>
									<h7 class="text-bold">9 Variants</h7>
									<div class="text-muted">Price: $ 35.00</div>
									<div class="text-muted">On Hand: 450.000 Unit(s)</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-3 col-md-6">
						<div class="panel panel-body">
							<div class="media">
								<div class="media-left">
									<a href="#" data-popup="lightbox">
										<img src="<?= base_url(PRODUCT_URL . 'product1.png') ?>" width="120" height="120" />
									</a>
								</div>

								<div class="media-body">
									<h5 class="media-heading text-black">Product Name</h5>
									<h7 class="text-bold">9 Variants</h7>
									<div class="text-muted">Price: $ 35.00</div>
									<div class="text-muted">On Hand: 450.000 Unit(s)</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			<?php endfor; ?>
		</div>
	</div>
</div>

<script type="text/javascript" src="<?= base_url(JS_URL . 'core/libraries/jquery_ui/interactions.min.js') ?>"></script>
<script type="text/javascript" src="<?= base_url(JS_URL . 'core/libraries/jquery_ui/widgets.min.js') ?>"></script>
<script type="text/javascript" src="<?= base_url(JS_URL . 'core/libraries/jquery_ui/effects.min.js') ?>"></script>

<script type="text/javascript" src="<?= base_url(JS_URL . 'user/manufacture/product/list.js') ?>"></script>