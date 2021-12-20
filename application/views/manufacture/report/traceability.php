<link href="<?= base_url(PLUGINS_URL . 'tabelizer/tabelizer.min.css') ?>" media="all" rel="stylesheet" type="text/css" />
<link href="<?= base_url(PLUGINS_URL . 'tabelizer/jquerysctipttop.css') ?>" rel="stylesheet" type="text/css">

<style>
	#tbl_trace .label {
		color: black;
	}
	#tbl_trace tr {
		cursor: pointer;
	}
</style>

<div class="content col-md-10" style="margin-left: auto; margin-right: auto;">
	<div class="panel panel-flat">
		<div class="panel-heading">
			<h5 class="panel-title">Traceability</h5>
		</div>
		<div class="container-fluid" style="margin-top: 0px;">
			<hr style="margin-top: 0px; margin-bottom: 0px;" />
			<div class="form-group">
				<table id="tbl_trace" class="controller" style="margin:0 auto; width: 95%;">
					<tr data-level="header" class="header" style="position: inherit; border: none;">
						<td>Finished Products</td>
						<td align="center">LOT/SERIAL NUMBER</td>
						<td align="center">DATE</td>
						<td align="center">QUANTITY</td>
						<td align="center">LOCATION</td>
						<td align="center"></td>
					</tr>
					<?php if (!empty($products)) { ?>
						<?php foreach ($products as $key => $product) : ?>
							<tr data-level="1" id="level_1_<?= $key ?>">
								<td><?= $product['name'] ?>&nbsp;<?= empty($product['variant']) ? '' : "({$product['variant']})" ?></td>
								<td class="data"><?= $product['lot_code'] ?></td>
								<td class="data"><?= $product['create_at'] ?></td>
								<td class="data"><?= $product['quantity'] ?> Units(s)</td>
								<td class="data"><?= $product['warehouse'] ?></td>
							</tr>
							<?php $manuorder = $product['manuorder']; ?>
							<tr data-level="2" id="level_2_<?= $key ?>">
								<td><?= $manuorder->manuorder_num ?></td>
								<td class="data"><?= $manuorder->lot_code ?></td>
								<td class="data"><?= $manuorder->transfer_at ?></td>
								<td class="data"><?= $manuorder->quantity ?> Units(s)</td>
								<td class="data"><?= empty($manuorder->variant) ? $manuorder->product_name : $manuorder->variant ?> -> <?= $product['warehouse'] ?></td>
							</tr>
							<?php $salesorder = $product['salesorder']; ?>
							<tr data-level="3" id="level_3_<?= $key ?>">
								<td>SALESORDER&nbsp;(<?= $salesorder->salesorder_num ?>)</td>
								<td class="data"><?= $manuorder->lot_code ?></td>
								<td class="data"><?= $salesorder->confirm_at ?></td>
								<td class="data"><?= $product['quantity'] ?> Units(s)</td>
								<td class="data"><?= $product['warehouse'] ?> -> <?= empty($manuorder->variant) ? $manuorder->product_name : $manuorder->variant ?> -> <?= $salesorder->customer ?></td>
							</tr>
							<?php foreach ($manuorder->materials as $mKey => $material) : ?>
								<tr data-level="4" id="level_4_<?= $mKey ?>">
									<td><?= $material->name ?>&nbsp;(<?= $material->reference ?>)</td>
									<td class="data"><?= $material->trace_code ?></td>
									<td class="data"><?= $material->stocked_date ?></td>
									<td class="data"><?= $material->quantity ?> Units(s)</td>
									<td class="data"><?= $material->warehouse_name ?> -> <?= $material->name ?> -> <?= $material->supplier_name ?></td>
								</tr>
							<?php endforeach; ?>
						<?php endforeach; ?>
					<?php } else { ?>
						<tr>
							<td colspan="5" style="text-align: center;">No data !!!</td>
						</tr>
					<?php } ?>
				</table>
			</div>
		</div>
	</div>
</div>

<script src="<?= base_url(PLUGINS_URL . 'tabelizer/jquery.tabelizer.min.js') ?>"></script>

<script>
	$(document).ready(function(){
		var table1 = $('#tbl_trace').tabelize({
			/*onRowClick : function(){
				alert('test');
			}*/
			fullRowClickable : true,
			onReady : function(){
				console.log('ready');
			},
			onBeforeRowClick :  function(){
				console.log('onBeforeRowClick');
			},
			onAfterRowClick :  function(){
				console.log('onAfterRowClick');
			},
		});
	});
</script>