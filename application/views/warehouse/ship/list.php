<style>
	td, th {
		text-align: center;
		word-break: keep-all !important;
	}
</style>
<input type="hidden" id="base_url" value="<?php echo base_url()?>">
<div class="content">
	<div class="panel panel-flat">
		<div class="panel-heading">
			<h5 class="panel-title" style="display: inline-block;">Ship Order</h5>
            <button type="button" class="btn bg-blue pull-right" onclick="onCreate();">Create</button>
		</div>
		<table class="table table-ship">
        </table>
	</div>
</div>

<script type="text/javascript" src="<?= base_url(PLUGINS_URL . 'forms/selects/bootstrap_select.min.js') ?>"></script>
<script type="text/javascript" src="<?= base_url(PLUGINS_URL . 'forms/validation/validate.min.js') ?>"></script>
<script type="text/javascript" src="<?= base_url(PLUGINS_URL . 'tables/datatables/datatables.min.js') ?>"></script>
<script type="text/javascript" src="<?= base_url(PLUGINS_URL . 'tables/datatables/extensions/fixed_columns.min.js') ?>"></script>
<script type="text/javascript" src="<?= base_url(PLUGINS_URL . 'tables/datatables/extensions/col_reorder.min.js') ?>"></script>
<script type="text/javascript" src="<?= base_url(PLUGINS_URL . 'tables/datatables/extensions/buttons.min.js') ?>"></script>

<script type="text/javascript" src="<?= base_url(JS_URL . 'user/warehouse/ship/list.js') ?>"></script>