<style>
	td, th {
		text-align: center;
		word-break: keep-all !important;
	}
</style>

<div class="content">
	<div class="panel panel-flat">
		<div class="panel-heading">
			<h5 class="panel-title" style="display: inline-block;">Work Centers</h5>
			<button type="button" class="btn bg-blue pull-right" onclick="javascript:onCreate();">Create</button>
		</div>
		<table class="table datatable-work"></table>
	</div>
</div>

<script type="text/javascript" src="<?= base_url(PLUGINS_URL . 'forms/selects/bootstrap_select.min.js') ?>"></script>
<script type="text/javascript" src="<?= base_url(PLUGINS_URL . 'forms/validation/validate.min.js') ?>"></script>
<script type="text/javascript" src="<?= base_url(PLUGINS_URL . 'tables/datatables/datatables.min.js') ?>"></script>
<script type="text/javascript" src="<?= base_url(PLUGINS_URL . 'tables/datatables/extensions/fixed_columns.min.js') ?>"></script>
<script type="text/javascript" src="<?= base_url(PLUGINS_URL . 'tables/datatables/extensions/col_reorder.min.js') ?>"></script>
<script type="text/javascript" src="<?= base_url(PLUGINS_URL . 'tables/datatables/extensions/buttons.min.js') ?>"></script>

<script type="text/javascript" src="<?= base_url(JS_URL . 'user/manufacture/work/list.js') ?>"></script>