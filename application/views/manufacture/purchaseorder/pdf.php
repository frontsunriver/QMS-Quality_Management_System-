<link rel="stylesheet" href="<?= base_url(PORTO_URL . 'css/custom.css') ?>">

<style>
	.text-bold {
		font-weight: bold;
	}
	.text-light {
		font-weight: lighter;
	}
	.text-left {
		text-align: left !important;
	}
	.text-center {
		text-align: center;
	}
	.text-right {
		text-align: right !important;
	}
	.full-width {
		width: 100%;
	}
	.tab_li {
		width: 90px;
	    color: #0088cc;
		text-align: center;
		border-left: 1px solid #ddd;
		border-right: 1px solid #ddd;
    	border-top: 2px solid #2196f3;
    	padding: 10px 0 10px 0;
	}
	.datatable-basic th {
	    line-height: 30px;
	    padding-top: 5px;
	    background-color: #e8f5e9;
	}
	.datatable-basic td {
		text-align: center;
		line-height: 25px;
	}
</style>

<div class="full-width" style="margin-bottom: 10px;">
	<h2 class="text-center">Purchase Order</h2>
</div>
<div class="full-width" style="border: 1px solid black; margin-bottom: 10px;">
	<table class="full-width" style="margin-top: 10px;">
		<tr>
			<td class="text-right text-bold">Purchase Number:&nbsp;&nbsp;&nbsp;</td>
			<td class="text-light"><?= $order->purchase_num ?></td>
			<td class="text-right text-bold">Order Date:&nbsp;&nbsp;&nbsp;</td>
			<td class="text-light"><?= $order->order_date ?></td>
		</tr>
		<tr>
			<td class="text-right text-bold">Deliver To:&nbsp;&nbsp;&nbsp;</td>
			<td class="text-light"><?= $order->warehouse_name ?></td>
			<td></td>
			<td></td>
		</tr>
	</table>
	<div style="margin: 10px 40px 0 40px;">
		<div class="tab_li">Materials</div>
	</div>
	<div style="border: 1px solid #ddd; margin: 0px 40px 20px 40px;">
		<table class="table datatable-basic" style="width: 94%; border: 1px solid #eee; margin-top: 10px; margin-left: auto; margin-right: auto;">
			<thead>
				<tr>
					<th width="17%">Material</th>
					<th width="17%">Supplier</th>
					<th width="17%">Scheduled Date</th>
					<th width="11%">Quantity</th>
					<th width="11%">Unit Price</th>
					<th width="11%">Taxes(%)</th>
					<th width="11%">Subtotal</th>
				</tr>
			</thead>
			<tbody>
				<?php if (isset($purchase_materials)) { ?>
					<?php for ($i = 0; $i < count($purchase_materials); $i ++) { ?>
						<tr>
							<td>
								<?= $purchase_materials[$i]->material_name ?>
							</td>
							<td>
								<?= $purchase_materials[$i]->supplier_name ?>
							</td>
							<td>
								<?= $purchase_materials[$i]->scheduled_date ?>
							</td>
							<td>
								<?= $purchase_materials[$i]->quantity ?>
							</td>
							<td>
								<?= $purchase_materials[$i]->unit_price ?>
							</td>
							<td>
								<?= $purchase_materials[$i]->tax ?>
							</td>
							<td>
								<?= $purchase_materials[$i]->quantity * $purchase_materials[$i]->unit_price ?>
							</td>
						</tr>
					<?php } ?>
				<?php } ?>
			</tbody>
		</table>
		<table class="table datatable-basic" style="width: 94%; margin-top: 10px; margin-left: auto; margin-right: auto;">
			<tr>
				<td class="text-left">
					<table class="table">
						<tr>
							<td class="text-left">Define your terms and conditions</td>
						</tr>
						<tr>
							<td class="text-left" style="font-size: 15px;"><?= $order->description ?></td>
						</tr>
						<tr><td>&nbsp;</td></tr>
					</table>
				</td>
				<td>
					<table class="table full-width">
						<tbody>
							<tr>
								<td class="text-right">Untaxed Amount:&nbsp;</td>
								<td class="text-right" width="110">$&nbsp;<?= $order->untaxes ?></td>
							</tr>
							<tr>
								<td class="text-right">Taxes:&nbsp;</td>
								<td class="text-right">$&nbsp;<?= $order->taxes ?></td>
							</tr>
							<tr>
								<td class="text-bold text-right">Total:&nbsp;</td>
								<td class="text-right" style="color: #0088cc !important; font-size: 17px;">
									$&nbsp;<?= $order->total ?>
								</td>
							</tr>
						</tbody>
					</table>
				</td>
			</tr>
		</table>
	</div>
</div>