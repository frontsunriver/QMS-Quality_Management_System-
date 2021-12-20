<style>
	td, th {
		text-align: center;
		word-break: keep-all !important;
	}
</style>

<div class="content">
	<div class="panel panel-flat">
		<div class="panel-heading">
			<h5 class="panel-title" style="display: inline-block;">Ship Orders</h5>
			<!-- <button type="button" class="btn bg-blue pull-right" onclick="javascript:onCreate();">Create</button> -->
		</div>
		<table class="table datatable-shiporder"></table>
	</div>
</div>

<script type="text/javascript" src="<?= base_url(JS_URL . 'user/warehouse/shiporder/list.js') ?>"></script>