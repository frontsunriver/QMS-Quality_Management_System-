<div class="page-header page-header-default">
	<div class="page-header-content">
		<div class="page-title">
			<h4>
				<i class="icon-lan2 position-left"></i>
				<span class="text-semibold"><?= $title ?></span>
				<button type="button" class="btn btn-primary btn-sm pull-right" onclick="history.back()">Back</button>
				<a title="Download" type="button" class="btn btn-primary btn-sm pull-right" onclick="printDiv('ptn')" style="margin-right: 5px;">
					<i class="icon-download " aria-hidden="true"></i>Print</a>
				<a title="Download" type="button" class="btn btn-primary btn-sm pull-right" onclick="printPdf('ptn')" style="margin-right: 5px;">
					<i class="icon-download " aria-hidden="true"></i>Pdf</a>
			</h4>
		</div>
	</div>

	<div class="breadcrumb-line">
		<ul class="breadcrumb">
			<li><a href="<?= base_url('welcome/consultantdashboard') ?>"><i class="icon-home2 position-left"></i>Home</a></li>
			<li><a href="#"><?= $title ?></a></li>
		</ul>
	</div>
</div>

<div class="content">
	<div class="panel panel-white" id="ptn">
		<div id="invoice-editable">
			<div class="panel-body no-padding-bottom">
				<div>
					<div class="col-sm-6 content-group">
						<!-- <img src="assets/images/logo_demo.png" class="content-group mt-10" alt="" style="width: 120px;"> -->
						<ul class="list-condensed list-unstyled" style="padding-left: 0; list-style: none;" >
							<li><h5 style="font-size: 25px;"><?= $admin->company_name ?></h5></li>
							<li><?= $admin->address ?></li>
							<li><?= $admin->city ?></li>
							<li><?= $admin->phone ?></li>
							<li><?= $admin->fax ?></li>
						</ul>
						<span class="text-muted" style="font-size:20px">Bill To:</span>
                    	<h6 style="margin: 0; text-align: left;"><?= $consultant->username ?></h6>
						<ul class="list-condensed list-unstyled" style="padding-left: 0; list-style: none;">
							<li><h5 style="margin: 0;" class="admin_com_name"><?= $consultant->consultant_name ?></h5></li>
							<li class="admin_address"><?= $consultant->address ?></li>
							<li class="admin_city"><?= $consultant->city ?></li>
						</ul>
					</div>
					<div class="col-sm-6 content-group">
						<div class="invoice-details">
							<h5 class="text-uppercase text-semibold" style="font-size: 25px; color: #8796C5;">Invoice</h5>
							<ul class="list-condensed list-unstyled" style="padding-left: 0; list-style: none;">
								<li>Invoice Date: <span class="text-semibold"><?= $invoice->create_date ?></span></li>
								<li>INVOICE: <span class="text-semibold"><?= $invoice->invoice_num ?></span></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
			<div class="table-responsive">
				<table class="table datatable-basic">
			        <thead>
						<tr>
							<th>Description</th>
							<th class="col-sm-1">Taxed</th>
							<th class="col-sm-1">Amount</th>
						</tr>
			        </thead>
			        <tbody>
						<?php foreach($items as $item) { ?>
								<tr>
									<td>
					                	<?php echo $item->description?>
					                </td>
					                <td>
										<?php if($item->is_tax == 0):?>
										<i class="text-danger glyphicon glyphicon-remove"></i>
										<?php endif;?>
										<?php if($item->is_tax == 1):?>
										<i class="text-success icon-circle"></i>
										<?php endif;?>
					                </td>
					                <td>
					                	<?php echo $item->amount?>
					                </td>
					            </tr>
			        	<?php } ?>
			        </tbody>
			    </table>
			</div>
			<div class="panel-body">
				<div class="row invoice-payment">
					<div class="col-sm-4">
						<div class="content-group">
							<h6>Other Comments</h6>
							<textarea name="comment" readonly rows="10" cols="10" class="form-control" placeholder=""><?php echo $invoice->comment?></textarea>
						</div>
					</div>

					<div class="col-sm-5 col-sm-offset-3">
						<div class="content-group">
							<h6>Total due</h6>
							<div class="table-responsive no-border">
								<table class="table">
									<tbody>
										<tr>
											<th>Sub Total:</th>
											<td class="text-right">$<span class="subtotal_span"><?php echo $amount_list['subtotal']?></span></td>
										</tr>
										<tr>
											<th>Taxable: <span class="text-regular"></span></th>
											<td class="text-right">$<span class="taxable_span"><?php echo $amount_list['taxable']?></span></td>
										</tr>
										<tr>
											<th>Tax Rate(%): </th>
											<td class="text-right">
												<?php echo $invoice->tax_rate?>
											</td>
										</tr>
										<tr>
											<th>Tax Due:</th>
											<td class="text-right">
												$<span class="taxdue_span"><?php echo $amount_list['taxdue']?></span>
											</td>
										</tr>
										<tr>
											<th><h6>Total:</h6></th>
											<td class="text-right text-primary">
												<h5 class="text-semibold">
													$<span class="total_span"><?php echo $invoice->amount?></span>
												</h5>
											</td>
										</tr>
									</tbody>
								</table>
							</div>

						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-4 col-md-offset-4">
						<textarea name="footer_comment"　rows="10" cols="10" class="form-control" placeholder="" style="height:100px"><?php echo $invoice->footer_comment?></textarea>
					</div>
				</div>
		</div>
	</div>
</div>

<form name="pdf_form"style="display: none;" action="<?php echo base_url('admin/invoice_pdf')?>" method="post">
	<input type="hidden" name="view_invoice_id" id="view_invoice_id" value="<?php echo $invoice->id?>">
</form>

<script>
	function printDiv(divName) {
		var printContents = document.getElementById(divName).innerHTML;
		var originalContents = document.body.innerHTML;
		document.body.innerHTML = printContents;
		window.print();
		document.body.innerHTML = originalContents;
	}

	function printPdf(divName){
		document.forms.pdf_form.submit();
	}
</script>