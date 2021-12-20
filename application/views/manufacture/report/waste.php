<link rel="stylesheet" href="<?= base_url(PORTO_URL . 'vendor/chartist/chartist.min.css') ?>" />

<style>
	.row {
		margin-left: 0;
		margin-right: 0;
	}
	#searchForm > label {
		margin-bottom: 0;
		line-height: 35px;
		vertical-align: middle;
	}
	#searchForm > div.col-md-1, #searchForm > div.col-md-2, #searchForm > div.col-md-3 {
		display: inline-block;
	}
</style>

<div class="content">
	<div class="panel panel-flat">
		<div class="container-fluid">
			<div class="row">
				<div class="col-lg-12">
					<form id="searchForm" action="<?= base_url('manufacture/wastereport') ?>" method="get">
						<label>Waste Type:&nbsp;</label>
						<div class="col-md-1">
							<select class="form-control" name="type" onchange="javascript:onSearch();">
								<option value="material" <?= $type == 'material' ? 'selected' : '' ?>>Material</option>
								<option value="product" <?= $type == 'product' ? 'selected' : '' ?>>Product</option>
							</select>
						</div>
						<label>Waste Category:&nbsp;</label>
						<div class="col-md-2">
							<select class="form-control" name="category" onchange="javascript:onSearch();">
								<option value="-1">All</option>
								<?php foreach ($waste_categories as $item) : ?>
									<option value="<?= $item->id ?>" <?= $category == $item->id ? 'selected' : '' ?>><?= $item->name ?></option>
								<?php endforeach; ?>
							</select>
						</div>
						<label>Waste Date Range:&nbsp;</label>
						<div class="col-md-3">
							<div class="input-group">
								<input type="text" name="daterange" class="form-control daterange-basic" style="background-color: white;" value="<?= $daterange ?>" readonly>
							</div>
						</div>
					</form>
				</div>
			</div>
			<hr/>
			<div class="row">
				<div class="col-md-12">
					<div class="chart chart-md" id="barChart"></div>
				</div>
			</div>
		</div>
	</div>
</div>

<script src="<?= base_url(PLUGINS_URL . 'ui/moment/moment.min.js') ?>"></script>
<script src="<?= base_url(PLUGINS_URL . 'pickers/daterangepicker.js') ?>"></script>
<script src="<?= base_url(PORTO_URL . 'vendor/flot/jquery.flot.js') ?>"></script>
<script src="<?= base_url(PORTO_URL . 'vendor/flot.tooltip/flot.tooltip.js') ?>"></script>
<script src="<?= base_url(PORTO_URL . 'vendor/flot/jquery.flot.categories.js') ?>"></script>
<script src="<?= base_url(PORTO_URL . 'vendor/flot/jquery.flot.resize.js') ?>"></script>
<script src="<?= base_url(PORTO_URL . 'vendor/chartist/chartist.min.js') ?>"></script>

<script>
	var flotBarsData = <?= $report ?>;
</script>
<script src="<?= base_url(JS_URL . 'user/manufacture/report/waste.js') ?>"></script>