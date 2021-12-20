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
		line-height: 25px;
	}
</style>

<div class="full-width" style="margin-bottom: 10px;">
	<h2 class="text-center">Transfer</h2>
</div>
<div class="full-width" style="border: 1px solid black; margin-bottom: 10px;">
	<table class="full-width" style="margin-top: 10px;">
		<tr>
			<td class="text-right text-bold">Purchase Number:&nbsp;&nbsp;&nbsp;</td>
			<td class="text-light"><?= $transfer->purchase_num ?></td>
			<td class="text-right text-bold">Order Date:&nbsp;&nbsp;&nbsp;</td>
			<td class="text-light"><?= $transfer->order_date ?></td>
		</tr>
		<tr>
			<td class="text-right text-bold">Destination Location:&nbsp;&nbsp;&nbsp;</td>
			<td class="text-light"><?= $transfer->warehouse_name ?></td>
			<td></td>
			<td></td>
		</tr>
	</table>
	<div style="margin: 10px 40px 0 40px;">
		<div class="tab_li">Operations</div>
	</div>
	<div style="border: 1px solid #ddd; margin: 0px 40px 20px 40px;">
		<table class="table datatable-basic" style="width: 94%; border: 1px solid #eee; margin-top: 10px; margin-bottom: 10px; margin-left: auto; margin-right: auto;">
			<thead>
				<tr style="background-color: #e8f5e9;">
					<th width="75%">Materials</th>
					<th width="12%">Initial Demand</th>
					<th width="10%">Done</th>
				</tr>
			</thead>
			<tbody>
				<?php if (isset($transfer_materials)) { ?>
					<?php foreach ($transfer_materials as $item) : ?>
						<tr>
							<td><?= $item->material_name ?></td>
							<td><?= $item->quantity ?></td>
							<td><?= $item->quantity ?></td>
						</tr>
					<?php endforeach; ?>
				<?php } ?>
			</tbody>
		</table>
	</div>
</div>