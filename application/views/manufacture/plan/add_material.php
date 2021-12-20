<div class="modal-header">
	<h5 class="modal-title">Add Material Planing</h5>
	<button type="button" class="close" data-dismiss="modal">&times;</button>
</div>
<form id="add_form" action="<?= base_url('manufacture/plan/add') ?>" method="post" class="form-group">
	<input type="hidden" name="type" value="material">
	<div class="modal-body">
		<div class="row">
			<div class="col-lg-6">
				<div class="row">
					<label class="col-lg-5 control-label pt-2 text-right">Material:&nbsp;</label>
					<div class="col-lg-6">
						<select class="form-control mb-3" name="plan[material_id]">
							<?php foreach ($materials as $material) : ?>
								<option value="<?= $material->id ?>"><?= $material->name ?></option>
							<?php endforeach; ?>
						</select>
					</div>
				</div>
				<div class="row">
					<label class="col-lg-5 control-label pt-2 text-right">Demand Quantity:&nbsp;</label>
					<div class="col-lg-6">
						<input type="number" class="form-control mb-3" name="plan[demand_quantity]" value="1">
					</div>
				</div>
				<div class="row">
					<label class="col-lg-5 control-label pt-2 text-right">Order Date:&nbsp;</label>
					<div class="col-lg-6">
						<input type="text" id="order_date" class="form-control mb-3" name="plan[order_date]" style="background-color: white;" value="">
					</div>
				</div>
			</div>
			<div class="col-lg-6">
				<div class="row">
					<label class="col-lg-5 control-label pt-2 text-right">Warehouse:&nbsp;</label>
					<div class="col-lg-6">
						<select class="form-control mb-3" name="plan[warehouse_id]">
							<?php foreach ($warehouses as $warehouse) : ?>
								<option value="<?= $warehouse->id ?>"><?= $warehouse->name ?></option>
							<?php endforeach; ?>
						</select>
					</div>
				</div>
				<div class="row">
					<label class="col-lg-5 control-label pt-2 text-right">Frequency:&nbsp;</label>
					<div class="col-lg-6">
						<select class="form-control mb-3" name="plan[frequency]">
							<?php $frequencies = ['Onetime', 'Daily', 'Weekly', 'Monthly', 'Yearly']; ?>
							<?php foreach ($frequencies as $key => $value) : ?>
								<option value="<?= $value ?>"><?= $value ?></option>
							<?php endforeach; ?>
						</select>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="modal-footer">
		<button type="submit" class="btn bg-blue">Save</button>
		<button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
	</div>
</form>