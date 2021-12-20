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
		<form id="add_form" class="form-horizontal" action="<?= base_url('admin/invoice/add') ?>" method="post">
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
										<input type="text" class="form-control" id="anytime-month-numeric" name="add[create_date]" 
											value="<?= date('Y-m-d')?>" style="min-width: 95px;">
										<span class="input-group-addon"><i class="icon-calendar3"></i></span>
									</div>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-md-2 col-md-offset-5" style="text-align: right;">INVOICE:&nbsp;</label>
								<div class="col-md-5">
									<input class="form-control"　type="text" name="add[invoice_num]" value="<?= 'INV-' . rand() ?>" style="min-width: 135px;">
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6 col-lg-9 content-group">
						<span class="text-muted" style="font-size:20px">Bill&nbsp;To:</span>
						<div class="form-group">
							<label class="control-label col-md-2">Consultant&nbsp;Name:&nbsp;</label>
							<div class="col-md-4" style="padding: 0;">
								<div class="col-md-12 btn-group bootstrap-select dropdown" style="padding-left: 0; padding-right: 0;">
									<select data-width="100%" id="consultant_id" name="add[consultant_id]" class="bootstrap-select" onchange="onChangeConsultant(this.value);">
										<?php foreach ($consultants as $item) : ?>
											<option value="<?= $item->consultant_id ?>"><?= $item->consultant_name ?></option>
										<?php endforeach; ?>
									</select>
								</div>
							</div>
						</div>
						<div class="col-md-4 col-md-offset-2" style="padding-left: 0;">
							<ul id="consultant_info" class="list-condensed list-unstyled" style="text-align: center; background-color: #FCFBFB;">
								<li><h5 style="margin: 0px;"></h5></li>
								<li></li>
								<li></li>
								<li></li>
							</ul>
						</div>
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
						<tr>
							<td><input type="text" class="form-control" name="description[0]" required></td>
							<td>
								<div class="checkbox checkbox-switchery switchery-xs">
									<label><input type="checkbox" class="switchery tax_switch" name="tax[0]" onclick="javascript:add_amount();"></label>
								</div>
							</td>
							<td>
								<input type="number" class="form-control" style="min-width: 70px;" name="amount[0]" min="0" onchange="javascript:add_amount(this);" value="0" required>
							</td>
							<td>
								<ul class="icons-list">
									<li class="text-danger-600"><a title="Remove" href="#"><i class="icon-trash"></i></a></li>
								</ul>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
			<div class="panel-body">
				<div class="row invoice-payment">
					<div class="col-sm-4">
						<div class="content-group">
							<h6>Other&nbsp;Comments</h6>
							<textarea name="add[comment]" rows="10" cols="5" class="form-control" placeholder="" style="width: 200px; height: 180px;"></textarea>
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
												<input type="number" class="form-control" name="add[tax_rate]" value="0" min="0" max="100" onchange="javascript:add_amount();">
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
													<input type="hidden" value="0" name="add[total_amount]">
												</h5>
											</td>
										</tr>
									</tbody>
								</table>
							</div>
							<div class="text-right">
								<button type="submit" class="btn btn-primary btn-labeled"><b><i class="icon-paperplane"></i></b>&nbsp;Send&nbsp;invoice</button>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-4 col-md-offset-4">
						<textarea name="add[footer_comment]"　rows="10" cols="10" class="form-control" placeholder="" style="height:100px"></textarea>
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
			datas[3] = "<ul class='icons-list'>" + "<li class='text-danger-600'>" + "<a title='Remove'　href='#'><i class='icon-trash'></i></a></li>" + "</ul>";

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

		$('.datatable-scroll-y').DataTable({
			autoWidth: true,
			scrollY: 300
		});

		oTable.on("click", "a[title='Remove']", function (){
			var nRow = $(this).parents('tr')[0];
			oTable.row(nRow).remove().draw();
			add_amount();
		});

		$("#consultant_id").selectpicker('val', <?= $consultants[0]->consultant_id ?>);
		onChangeConsultant(<?= $consultants[0]->consultant_id ?>);
	});

	function onChangeConsultant(value) {
		$.post('<?= base_url('consultant/get') ?>/' + value, {}, function(resp){
			$("#consultant_info li:eq(0) h5").text(resp.consultant_name);
			$("#consultant_info li:eq(1)").text(resp.address);
			$("#consultant_info li:eq(2)").text(resp.city);
			$("#consultant_info li:eq(3)").text(resp.phone);
		});
	}

	function add_amount() {
		var len = oTable.data().length;
		var rowamount = 0, subtotal = 0, taxable = 0, taxrate = 0, taxdue = 0, total_amount;

		for (var i = 0; i < len; i ++) {
			rowamount = Number($('#add_form input[name="amount[' + i + ']"]').val());
			subtotal = subtotal + rowamount;
			tax = $('#add_form input[name="tax[' + i + ']"]')[0].checked;
			if(tax)
				taxable = taxable + rowamount;
		}

		taxrate = $("#add_form input[name='add[tax_rate]']").val();

		$(".taxable_span").text(taxable);
		$(".taxdue_span").text(taxable * taxrate/100);
		$(".subtotal_span").text(subtotal);
		$(".total_span").text(subtotal + taxable * taxrate / 100);

		$('#add_form input[name="add[total_amount]"]').val(subtotal + taxable * taxrate / 100);
	}
</script>