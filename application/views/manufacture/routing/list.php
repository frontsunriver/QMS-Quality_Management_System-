<style>
	td, th {
		text-align: center;
		word-break: keep-all !important;
	}
</style>

<div class="content">
	<div class="panel panel-flat">
		<div class="panel-heading">
			<h5 class="panel-title" style="display: inline-block;">Routing</h5>
			<a class="btn bg-blue pull-right" href="<?= base_url('manufacture/routing/add') ?>">ADD</a>
		</div>
		<table class="table datatable-routing"></table>
	</div>
</div>

<script type="text/javascript" src="<?= base_url(JS_URL . 'user/manufacture/routing/list.js') ?>"></script>