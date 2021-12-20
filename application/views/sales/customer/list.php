<style>
	td, th {
		text-align: center;
		word-break: keep-all !important;
	}
</style>

<div class="content">
	<div class="panel panel-flat">
		<div class="panel-heading">
			<h5 class="panel-title" style="display: inline-block;">Customer</h5>
			<button type="button" class="btn bg-blue pull-right" onclick="javascript:onAdd();">ADD</button>
		</div>
		<table class="table datatable-customer"></table>
	</div>
</div>

<div id="modal_save" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title"></h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
            <form id="add_form">
                <div class="modal-body">
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn bg-blue">Save</button>
                    <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript" src="<?= base_url(JS_URL . 'user/sales/customer.js') ?>"></script>