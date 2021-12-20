<style>
	.mb-3, .my-3 {
		margin-bottom: 0px !important;
	}
	.table th, .table td {
		line-height: 10px;
	}
</style>

<div class="content col-md-8" style="margin-left: auto; margin-right: auto;">
	<div class="panel panel-flat">
		<div class="panel-heading" style="padding-bottom: 0px;">
			<h3 class="panel-title" style="display: inline-block;">
				New&nbsp;&nbsp;
			</h3>
			<div class="pull-right">
				<button type="button" class="btn bg-blue" onclick="javascript:onCreate();">Create</button>
				<button type="button" class="btn btn-default" onclick="javascript:onBack();">Back</button>
			</div>
		</div>
		<div class="container-fluid">
			<form id="create_form" class="form-control" action="<?= base_url('sales/order/create') ?><?= $saleorder ? "/{$saleorder->id}" : '' ?>" method="post">
				<div class="row" style="padding-right: 0px;">
					<div class="row col-lg-12 form-group">
						<div class="col-lg-6 form-group">
							<div class="form-group row">
								<div class="col-lg-2"></div>
								<label class="col-lg-3 control-label pt-2">Customer</label>
								<div class="col-lg-7">
									<select class="form-control mb-3" name="saleorder[customer_id]">
										<?php foreach ($customers as $customer) : ?>
											<option value="<?= $customer->id ?>"><?= $customer->name ?></option>
										<?php endforeach; ?>
									</select>
								</div>
							</div>
						</div>
						<div class="col-lg-6 form-group">
							<div class="form-group row">
								<div class="col-lg-1"></div>
								<label class="col-lg-3 control-label pt-2">Validity</label>
								<div class="col-lg-7">
									<select class="form-control mb-3">
									</select>
								</div>
							</div>
							<div class="form-group row">
								<div class="col-lg-1"></div>
								<label class="col-lg-3 control-label pt-2">Payment Terms</label>
								<div class="col-lg-7">
									<textarea class="form-control mb-3" name="saleorder[payment_terms]"></textarea>
								</div>
							</div>
						</div>
					</div>
					<div class="row col-lg-12 form-group">
						<div class="col-lg-6 form-group">
							<div class="form-group row">
								<div class="col-lg-2"></div>
								<h4 style="margin-top: 0px; margin-bottom: 0px;">Shipping Information</h4>
							</div>
							<div class="form-group row">
								<div class="col-lg-2"></div>
								<label class="col-lg-3 control-label pt-2">Warehouse</label>
								<div class="col-lg-7">
									<select class="form-control mb-3" name="saleorder[warehouse_id]">
										<?php foreach ($warehouses as $warehouse) : ?>
											<option value="<?= $warehouse->id ?>"><?= $warehouse->name ?></option>
										<?php endforeach; ?>
									</select>
								</div>
							</div>
							<div class="form-group row">
								<div class="col-lg-2"></div>
								<label class="col-lg-3 control-label pt-2">Shipping Policy</label>
								<div class="col-lg-7">
									<textarea class="form-control mb-3" name="saleorder[shipping_policy]"></textarea>
								</div>
							</div>
						</div>
						<div class="col-lg-6 form-group">
							<div class="form-group row">
								<div class="col-lg-1"></div>
								<h4 style="margin-top: 0px; margin-bottom: 0px;">Sales Information</h4>
							</div>
							<div class="form-group row">
								<div class="col-lg-1"></div>
								<label class="col-lg-3 control-label pt-2">Salesperson</label>
								<div class="col-lg-7">
									<select class="form-control mb-3" name="saleorder[employee_id]">
										<?php foreach ($employees as $employee) : ?>
											<option value="<?= $employee->employee_id ?>"><?= $employee->employee_name ?></option>
										<?php endforeach; ?>
									</select>
								</div>
							</div>
							<div class="form-group row">
								<div class="col-lg-1"></div>
								<label class="col-lg-3 control-label pt-2">Sales Team</label>
								<div class="col-lg-7">
									<textarea class="form-control mb-3" name="saleorder[sales_team]"></textarea>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-lg-4 control-label pt-2">Customer Reference</label>
								<div class="col-lg-7">
									<input class="form-control mb-3" name="saleorder[customer_ref]">
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="row col-lg-12 form-group">
					<div class="col-sm-12" style="padding-right: 30px;">
						<div class="tabbable">
							<ul class="nav nav-tabs nav-tabs-top top-divided">
								<li class="active"><a href="#tab1" data-toggle="tab">Order Lines</a></li>
							</ul>
							<div class="tab-content">
								<div id="tab1" class="tab-pane active">
									<div class="col-lg-12">
										<div class="row">
											<div class="table-responsive">
												<button type="button" class="btn bg-blue btn-xs" style="margin: 5px 0;" onclick="javascrit:onAddProduct();">Add a product <i class="fa fa-plus"></i></button>
												<table class="table datatable-basic">
													<thead>
														<tr style="background-color: #e8f5e9;">
															<th width="15%">Product</th>
															<th width="20%">Description</th>
															<th width="12%">Ordered Qty</th>
															<th width="11%">Unit Price</th>
															<th width="8%">Taxes</th>
															<th width="8%">Discount(%)</th>
															<th width="8%">Subtotal</th>
															<th width="5%">Action</th>
														</tr>
													</thead>
													<tbody>

													</tbody>
												</table>
												<hr style="margin-top: 0px; margin-bottom: 0px;"/>
											</div>
										</div>
										<div class="row">
											<div class="col-sm-6">
												<div class="content-group">
													<h5>Define your terms and conditions</h5>
													<textarea class="form-control" name="saleorder[description]" rows="10" cols="5" style="height: 120px;"></textarea>
												</div>
											</div>
											<div class="col-sm-3"></div>
											<div class="col-sm-3" style="margin-top: 35px;padding-right: 0px;">
												<div class="content-group" style="margin-bottom: 0px !important;">
													<div class="table-responsive no-border">
														<table class="table">
															<tbody>
																<tr>
																	<th class="text-right">Untaxed Amount:&nbsp;</th>
																	<td class="text-right">$&nbsp;<span class="subtotal_span"></span></td>
																	<input type="hidden" value="0" name="saleorder[untaxes]" value="">
																</tr>
																<tr>
																	<th class="text-right">Taxes:&nbsp;<span class="text-regular"></span></th>
																	<td class="text-right">$&nbsp;<span class="taxable_span"></span></td>
																	<input type="hidden" value="0" name="saleorder[taxes]" value="">
																</tr>
																<tr>
																	<th class="text-bold text-right">Total:&nbsp;</th>
																	<td class="text-right text-primary">
																		<h5 class="text-semibold">
																			$&nbsp;<span class="total_span"></span>
																		</h5>
																		<input type="hidden" value="0" name="saleorder[total]" value="">
																	</td>
																</tr>
															</tbody>
														</table>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>

<script type="text/javascript" src="<?= base_url(JS_URL . 'jquery.dataTables.min.js') ?>"></script>

<script>
	var products = '';
	$(function(){
		<?php foreach ($products as $product) : ?>
			products += '<option value="<?= $product->id ?>"><?= $product->name ?></option>';
		<?php endforeach; ?>
	});
</script>
<script type="text/javascript" src="<?= base_url(JS_URL . 'user/sales/order/create.js') ?>"></script>