<style>
	td, th {
		text-align: center;
		word-break: keep-all !important;
	}
	.lightgray {
		background-color: lightgray;
	}
	#modal_waste div.row {
		margin-bottom: 10px;
	}
</style>

<div class="content">
	<div class="panel panel-flat">
		<div class="panel-heading">
			<h5 class="panel-title" style="display: inline-block;">Material</h5>
			<!-- <button type="button" class="btn bg-blue pull-right" onclick="javascript:onAdd();">ADD</button> -->
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

<div id="modal_waste" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Waste Material</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
            <form id="waste_form">
            	<input type="hidden" id="waste_id" name="waste[id]">

                <div class="modal-body">
					<div class="form-group">
					    <div class="row">
					        <div class="col-sm-4">
					            <label>&nbsp;&nbsp;Material Name:</label>
					        </div>
					        <div class="col-sm-7">
					        	<label id="material_name"></label>
					        </div>
					    </div>
					    <div class="row">
					        <div class="col-sm-4">
					            <label>&nbsp;&nbsp;Waste Category:</label>
					        </div>
					        <div class="col-sm-6">
					        	<select class="form-control" name="waste[waste_category_id]">
					        		<?php foreach ($waste_categories as $item) : ?>
					        			<option value="<?= $item->id ?>"><?= $item->name ?></option>
					        		<?php endforeach; ?>
					        	</select>
					        </div>
					    </div>
					    <div class="row">
					        <div class="col-sm-4">
					            <label>&nbsp;&nbsp;Quantity:</label>
					        </div>
					        <div class="col-sm-5">
					        	<input type="number" class="form-control" name="waste[quantity]" min="1">
					        </div>
					    </div>
					    <div class="row">
					        <div class="col-sm-4">
					            <label>&nbsp;&nbsp;Reason:</label>
					        </div>
					        <div class="col-sm-8">
					        	<textarea class="form-control" name="waste[reason]"></textarea>
					        </div>
					    </div>
					</div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn bg-blue">Waste</button>
                    <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript" src="<?= base_url(JS_URL . 'user/warehouse/material.js') ?>"></script>