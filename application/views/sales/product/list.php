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
			<h5 class="panel-title" style="display: inline-block;">Product Wise Stock</h5>
			<!-- <button type="button" class="btn bg-blue pull-right" onclick="javascript:onCreate();">Create</button> -->
			<div class="form-group pull-right">
				<div class="form-group has-feedback" style="position: relative;">
					<form action="<?= base_url('warehouse/product') ?>" method="get">
						<input type="text" class="form-control" placeholder="Filter" name="search" value="<?= $search ?>" />
						<div class="form-control-feedback">
							<i class="icon-search4 text-size-base"></i>
						</div>
					</form>
				</div>
			</div>
		</div>
		<div class="container-fluid">
			<?php if (empty($products)) : ?>
				<div class="row" style="text-align: center; display: block;">
					No Products ...
				</div>
			<?php else : ?>
				<?php foreach ($products as $product) : ?>
					<div class="row">
						<?php foreach ($product as $item) : ?>
							<div class="col-lg-3 col-md-6">
								<div class="panel panel-body">
									<div class="media">
										<div class="media-left">
											<img src="<?= base_url(PRODUCT_URL . (!$item['image'] ? '' : $item['image']) ) ?>" width="120" height="120" style="padding: 10px;" />
										</div>

										<div class="media-body">
											<h5 class="media-heading text-black"><?= $item['name'] ?></h5>
											<h7 class="text-bold"><?= $item['variant'] ?></h7>
											<div class="text-muted">Price: $ <?= $item['sales_price'] ?></div>
											<div class="text-muted">On Hand: <?= $item['quantity'] > 0 ? '<b style="color: red;">' : '' ?><?= $item['quantity'] ?>.000<?= $item['quantity'] > 0 ? '</b>' : '' ?> Unit(s)</div>
										</div>
									</div>
								</div>
							</div>
						<?php endforeach; ?>
					</div>
				<?php endforeach; ?>
			<?php endif; ?>
		</div>
	</div>
</div>

<script type="text/javascript" src="<?= base_url(JS_URL . 'core/libraries/jquery_ui/interactions.min.js') ?>"></script>
<script type="text/javascript" src="<?= base_url(JS_URL . 'core/libraries/jquery_ui/widgets.min.js') ?>"></script>
<script type="text/javascript" src="<?= base_url(JS_URL . 'core/libraries/jquery_ui/effects.min.js') ?>"></script>

<script type="text/javascript" src="<?= base_url(JS_URL . 'user/sales/product/list.js') ?>"></script>