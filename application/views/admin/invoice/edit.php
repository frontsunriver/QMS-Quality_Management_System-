<!-- Page header -->
<div class="page-header page-header-default">
	<div class="page-header-content">
		<div class="page-title">
			<h4>
				<i class="icon-lan2 position-left"></i>
				<span class="text-semibold"><?= $title ?></span>
				<button type="button" class="btn btn-primary btn-sm pull-right" onclick="history.back();">Back</button>
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
<!-- /page header -->
<!-- Content area -->
<div class="content">
	<div class="panel panel-white">
		<form id="edit_form" class="form-horizontal" action="<?= base_url("admin/invoice_edit/{$invoice->id}") ?>" method="post">
			<div class="panel-body no-padding-bottom">
				<div class="row">
					<div class="col-sm-6 content-group">
						<ul class="list-condensed list-unstyled">
							<li style="margin-bottom: 20px;"><h5 style="font-size: 25px;"><?= $admin->company_name ?></h5></li>
							<li><?= $admin->address ?></li>
							<li><?= $admin->city ?></li>
							<li><?= $admin->phone ?></li>
							<li><?= $admin->fax ?></li>
						</ul>
					</div>
					<div class="col-md-6 content-group">
						<div class="invoice-details">
							<div class="form-group" style="margin-bottom: 5px !important;">
								<div class="col-md-7 col-md-offset-5">
									<h5 class="text-uppercase text-semibold" style="font-size: 25px; color: #8796C5;">Invoice</h5>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-md-3 col-md-offset-4" style="text-align: right;">Invoice&nbsp;Date:&nbsp;</label>
								<div class="col-md-5">
									<div class="input-group">
										<input type="text" class="form-control" id="anytime-month-numeric" name="edit[create_date]" 
											value="<?= date('Y-m-d')?>" style="min-width: 95px;">
										<span class="input-group-addon"><i class="icon-calendar3"></i></span>
									</div>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-md-2 col-md-offset-5" style="text-align: right;">INVOICE:&nbsp;</label>
								<div class="col-md-5">
									<input class="form-control"　type="text" name="edit[invoice_num]" value="<?php echo $invoice->invoice_num?>" style="min-width: 135px;" disabled>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6 col-lg-9 content-group">
						<span class="text-muted" style="font-size:20px">Bill To:</span>
                    	<h6 style="text-align:left"><?php echo $customer_admin->username?></h6>
							<ul class="list-condensed list-unstyled">
								<li style="margin-bottom:20px"><h5 class="admin_com_name"><?php echo $customer_admin->consultant_name?></h5></li>
							<li class="admin_address"><?php echo $customer_admin->address?></li>
							<li class="admin_city"><?php echo $customer_admin->city?></li>
						</ul>
					</div>
				</div>
			</div>
			<div class="table-responsive">
				<div class="col-md-2" >
					<button id="new_item" class="btn btn-primary" style="margin: 20px 0;">Add&nbsp;New&nbsp;<i class="fa fa-plus"></i></button>
				</div>
				<table class="table datatable-basic">
					<thead>
			            <tr>
			                <th>Description</th>
			                <th class="col-sm-1">Tax</th>
			                <th class="col-sm-1">Amount</th>
			                <th class="col-sm-1">Action</th>
			            </tr>
			        </thead>
			        <tbody>
						<?php $index=0;
			        		foreach($items as $item){ ?>
					            <tr>
					                <td>
					                	<input type='text' class='form-control' name='description[<?php echo $index?>]' value="<?php echo $item->description?>" required>
					                </td>
					                <td>
					                	<div class="checkbox checkbox-switchery switchery-xs">
											<label>
												<?php if($item->is_tax == 0):?>
												<input type="checkbox" class="switchery tax_switch" name="tax[<?php echo $index?>]" onclick="add_amount()">
												<?php endif;?>
												<?php if($item->is_tax == 1):?>
												<input type="checkbox" class="switchery tax_switch" name="tax[<?php echo $index?>]" checked="checked" onclick="add_amount()">
												<?php endif;?>
											</label>
										</div>
					                </td>
					                <td>
					                	<input type='number' class='form-control' style="min-width: 70px;" name='amount[<?php echo $index?>]' min="0" onchange="add_amount()" value="<?php echo $item->amount?>" required>
					                </td>
					                <td>
				                		<ul class="icons-list">
											<li class="text-danger-600"><a title="Remove" href="#"><i class="icon-trash"></i></a></li>
										</ul>
					                </td>
					            </tr>
			        	<?php $index++; }?>
			        </tbody>
				</table>
			</div>
			<div class="panel-body">
				<div class="row invoice-payment">
					<div class="col-sm-4">
						<div class="content-group">
							<h6>Other&nbsp;Comments</h6>
							<textarea name="edit[comment]" rows="10" cols="5" class="form-control" placeholder="" style="width: 200px; height: 180px;"></textarea>
						</div>
					</div>
					<div class="col-sm-5 col-sm-offset-3">
						<div class="content-group">
							<h6>Total due</h6>
							<div class="table-responsive no-border">
								<table class="table">
									<tbody>
										<tr>
											<th>Sub&nbsp;Total:</th>
											<td class="text-right">$<span class="subtotal_span"></span></td>
										</tr>
										<tr>
											<th>Taxable:&nbsp;<span class="text-regular"></span></th>
											<td class="text-right">$<span class="taxable_span"></span></td>
										</tr>
										<tr>
											<th>Tax&nbsp;Rate<span class="text-regular">(%)</span>: </th>
											<td class="text-right">
												<input type="number" class="form-control" name="edit[tax_rate]" value="<?php echo $invoice->tax_rate?>" min="0" max="100" onchange="">
											</td>
										</tr>
										<tr>
											<th>Tax&nbsp;Due:</th>
											<td class="text-right">
												$<span class="taxdue_span"></span>
											</td>
										</tr>
										<tr>
											<th><h6>Total:</h6></th>
											<td class="text-right text-primary">
												<h5 class="text-semibold">
													$<span class="total_span"></span>
													<input type="hidden" value="0" name="edit[total_amount]">
												</h5>
											</td>
										</tr>
									</tbody>
								</table>
							</div>
							<div class="text-right">
								<button type="submit" class="btn btn-primary btn-labeled"><b><i class="icon-paperplane"></i></b>&nbsp;Save&nbsp;invoice</button>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-4 col-md-offset-4">
						<textarea name="edit[footer_comment]"　rows="10" cols="10" class="form-control" placeholder="" style="height:100px"></textarea>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>

<script type="text/javascript" src="<?= base_url(PLUGINS_URL . 'forms/selects/bootstrap_select.min.js') ?>"></script>
<script type="text/javascript" src="<?= base_url(PLUGINS_URL . 'pickers/anytime.min.js') ?>"></script>
<script type="text/javascript" src="<?= base_url(PLUGINS_URL . 'forms/styling/uniform.min.js') ?>"></script>
<script type="text/javascript" src="<?= base_url(PLUGINS_URL . 'forms/styling/switchery.min.js') ?>"></script>
<script type="text/javascript" src="<?= base_url(PLUGINS_URL . 'forms/styling/switch.min.js') ?>"></script>
<script type="text/javascript" src="<?= base_url(JS_URL . 'core/app.js') ?>"></script>
<script type="text/javascript" src="<?= base_url(JS_URL . 'pages/form_bootstrap_select.js') ?>"></script>
<script type="text/javascript" src="<?= base_url(JS_URL . 'jquery.dataTables.min.js') ?>"></script>
<script type="text/javascript" src="<?= base_url(JS_URL . 'dataTables.bootstrap.js') ?>"></script>

<script>
	$(function(){
		$("#anytime-month-numeric").AnyTime_picker({
			format: "%Z-%m-%d"
		});

		if (Array.prototype.forEach) {
			var elems = Array.prototype.slice.call(document.querySelectorAll('.switchery'));
			elems.forEach(function(html) {
				new Switchery(html);
			});
		}

		$(".switch").bootstrapSwitch();

		//datatable
		$.extend( $.fn.dataTable.defaults, {
			autoWidth: false,
			dom: '<"datatable-scroll"t>',
			drawCallback: function () {
				$(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').addClass('dropup');
			},
			preDrawCallback: function() {
				$(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').removeClass('dropup');
			}
		});
		// Basic datatable
		oTable = $('.datatable-basic').DataTable({
			columnDefs: [{
				orderable: false,
				targets: [0, 1, 2, 3]
			}],
		});

		$("#new_item").click(function(e){
			e.preventDefault();

			var added_index = oTable.data().length;
			var datas = new Array();

			datas[0] = "<input type='text' class='form-control' name='description[" + added_index + "]' required>";
			datas[1] = "<div class='checkbox checkbox-switchery switchery-xs'>"+
				"<label>" + "<input type='checkbox' class='switchery' name='tax[" + added_index + "]' onclick='javascript:add_amount();'>" +
				"</label>" + "</div>";
			datas[2] = "<input type='number' class='form-control' name='amount[" + added_index + "]' onchange='javascript:add_amount();' value='0' required>";
			datas[3] = "<ul class='icons-list'>" + "<li class='text-danger-600'>" + "<a title='Remove' href='#'><i class='icon-trash'></i></a></li>" + "</ul>";

			oTable.row.add(datas);
			oTable.draw();

			if (Array.prototype.forEach) {
				var elems = Array.prototype.slice.call(document.querySelectorAll('.switchery'));
				elems.forEach(function(html) {
					new Switchery(html);
				});
			}

			$(".switch").bootstrapSwitch();
		});

		oTable.on("click", "a[title='Remove']", function (){
			var nRow = $(this).parents('tr')[0];
			oTable.row(nRow).remove().draw();
			add_amount();
		});

		add_amount();
	});

	function add_amount() {
		var len = oTable.data().length;
		var rowamount = 0, subtotal = 0, taxable = 0, taxrate = 0, taxdue = 0, total_amount;

		for (var i = 0; i < len; i ++) {
			rowamount = Number($('#edit_form input[name="amount[' + i + ']"]').val());
			subtotal = subtotal + rowamount;
			tax = $('#edit_form input[name="tax[' + i + ']"]')[0].checked;
			if(tax)
				taxable = taxable + rowamount;
		}

		taxrate = $("#edit_form input[name='edit[tax_rate]']").val();

		$(".taxable_span").text(taxable);
		$(".taxdue_span").text(taxable * taxrate/100);
		$(".subtotal_span").text(subtotal);
		$(".total_span").text(subtotal + taxable * taxrate / 100);

		$('#edit_form input[name="edit[total_amount]"]').val(subtotal + taxable * taxrate / 100);
	}
</script>