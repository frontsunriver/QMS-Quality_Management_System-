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
					<form id="searchForm" action="<?= base_url('manufacture/manuorderreport') ?>" method="get">
						<!-- <label>Type:&nbsp;</label>
						<div class="col-md-3">
							<?php $types = [-1 => 'ALL', 0 => 'NEW', 1 => 'AWAITING RAW MATERIALS', 2 => 'READY TO PRODUCE', 3 => 'PRODUCTION STARTED', 4 => 'DONE', 5 => 'TRANSFER']; ?>
							<select class="form-control" name="type" onchange="javascript:onSearch();">
								<?php foreach ($types as $key => $value) : ?>
									<option value="<?= $key ?>" <?= $type == $key ? 'selected' : '' ?>><?= $value ?></option>
								<?php endforeach; ?>
							</select>
						</div> -->
						<!-- <label>Date Range:&nbsp;</label>
						<div class="col-md-3">
							<div class="input-group">
								<input type="text" name="daterange" class="form-control daterange-basic" style="background-color: white;" value="<?= $daterange ?>" readonly>
							</div>
						</div> -->
					</form>
				</div>
			</div>
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
<script src="<?= base_url(JS_URL . 'user/procurement/purchaseorderreport.js') ?>"></script>