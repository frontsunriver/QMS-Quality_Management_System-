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
		</div>
		<table class="table table-ship">
        </table>
	</div>
</div>

<script type="text/javascript" src="<?= base_url(JS_URL . 'user/manufacture/shiporder/list.js') ?>"></script>