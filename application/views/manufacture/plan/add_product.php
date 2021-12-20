<div class="modal-header">
	<h5 class="modal-title">Add Product Planing</h5>
	<button type="button" class="close" data-dismiss="modal">&times;</button>
</div>
<form id="add_form" action="<?= base_url('manufacture/plan/add') ?>" method="post" class="form-group">
	<input type="hidden" name="type" value="product">
	<div class="modal-body">
		<div class="row">
			<div class="col-lg-6">
				<div class="row" style="margin-bottom: 15px;">
					<label class="col-lg-5 control-label pt-2 text-right">Product:&nbsp;</label>
					<div class="col-lg-7">
						<select data-plugin-selectTwo class="form-control populate placeholder" name="plan[product_id]" data-plugin-options='{ "placeholder": "Select a product", "allowClear": true }' required>
							<?php foreach ($products as $product) : ?>
								<?php if (isset($product->variants)) { ?>
									<optgroup label="<?= $product->name ?>">
										<?php foreach ($product->variants as $item) : ?>
											<option value="<?= $product->id ?>@<?= $item ?>"><?= $item ?></option>
										<?php endforeach; ?>
									</optgroup>
								<?php } else { ?>
									<option value="<?= $product->id ?>"><?= $product->name ?></option>
								<?php } ?>
							<?php endforeach; ?>
						</select>
					</div>
				</div>
				<div class="row">
					<label class="col-lg-5 control-label pt-2 text-right">Frequency:&nbsp;</label>
					<div class="col-lg-7">
						<select class="form-control mb-3" name="plan[frequency]">
							<?php $frequencies = ['Onetime', 'Daily', 'Weekly', 'Monthly', 'Yearly']; ?>
							<?php foreach ($frequencies as $key => $value) : ?>
								<option value="<?= $value ?>"><?= $value ?></option>
							<?php endforeach; ?>
						</select>
					</div>
				</div>
				<div class="row">
					<label class="col-lg-5 control-label pt-2 text-right">Order Date:&nbsp;</label>
					<div class="col-lg-7">
						<input type="text" id="order_date" class="form-control mb-3" name="plan[order_date]" style="background-color: white;" value="">
					</div>
				</div>
			</div>
			<div class="col-lg-6">
				<div class="row">
					<label class="col-lg-4 control-label pt-2 text-right">Work Center:&nbsp;</label>
					<div class="col-lg-7">
						<select class="form-control mb-3" name="plan[workcenter_id]">
							<?php foreach ($workcenters as $workcenter) : ?>
								<option value="<?= $workcenter->id ?>"><?= $workcenter->name ?></option>
							<?php endforeach; ?>
						</select>
					</div>
				</div>
				<div class="row">
					<label class="col-lg-4 control-label pt-2 text-right">Production Manager:&nbsp;</label>
					<div class="col-lg-7">
						<select class="form-control mb-3" name="plan[responsible_id]">
							<?php foreach ($employees as $employee) : ?>
								<option value="<?= $employee->employee_id ?>"><?= $employee->employee_name ?></option>
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

<script>
	$(function(){
		// Initialize Product Variants
		$('[data-plugin-selectTwo]').each(function() {
			var $this = $( this ),
				opts = {};

			var pluginOptions = $this.data('plugin-options');
			if (pluginOptions)
				opts = pluginOptions;

			$this.themePluginSelect2(opts);
		});
	});
</script>