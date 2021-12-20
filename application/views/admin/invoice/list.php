<style>
	.select2-container{
		display:none;
	}
</style>

<!-- Page header -->
<div class="page-header page-header-default">
	<div class="page-header-content">
		<div class="page-title">
			<h4>
				<i class="icon-lan2 position-left"></i>
				<span class="text-semibold"><?= $title ?></span>
				<button type="button" class="btn btn-primary btn-sm pull-right" onclick="add()">New&nbsp;Payment&nbsp;<i class="icon-lan2 position-right"></i></button>
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
		<div class="panel-body text-left" style="padding-bottom: 0px;">
    		<form name="filter_form"　action="<?= base_url('admin/invoice/list')?>" method="get">
				<div class="col-md-2">
					<div class="form-group">
						<div class="input-group">
							<span class="input-group-addon"><i class="icon-calendar22"></i></span>
							<input type="text" class="form-control daterange-single" name="start"　value="<?= $start_date ?>">
						</div>
					</div>
				</div>
				<div class="col-md-2">
					<div class="form-group">
						<div class="input-group">
							<span class="input-group-addon"><i class="icon-calendar22"></i></span>
							<input type="text" class="form-control daterange-single1" name="end"　value="<?= $end_date ?>">
						</div>
					</div>
				</div>
				<div class="col-md-2">
					<div class="form-group">
						<button type="submit" class="btn btn-primary">Filter</button>
					</div>
				</div>
			</form>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-6 col-md-4">
			<div class="panel panel-body panel-body-accent">
				<div class="media no-margin">
					<div class="media-left media-middle">
						<i class="icon-coin-euro icon-3x text-orange-400"></i>
					</div>

					<div class="media-body text-right">
						<h3 class="no-margin text-semibold">$<?= $total_amount?></h3>
						<span class="text-uppercase text-size-mini text-muted">Total Invoice Amount</span>
					</div>
				</div>
			</div>
		</div>
    	<div class="col-sm-6 col-md-4">
			<div class="panel panel-body panel-body-accent">
				<div class="media no-margin">
					<div class="media-left media-middle">
						<i class="icon-coin-euro icon-3x text-danger-400"></i>
					</div>

					<div class="media-body text-right">
						<h3 class="no-margin text-semibold">$<?= $total_open_amount?></h3>
						<span class="text-uppercase text-size-mini text-muted">Total Open Amount</span>
					</div>
				</div>
			</div>
		</div>
		<div class="col-sm-6 col-md-4">
			<div class="panel panel-body panel-body-accent">
				<div class="media no-margin">
					<div class="media-left media-middle">
						<i class="icon-coin-euro icon-3x text-success-400"></i>
					</div>

					<div class="media-body text-right">
						<h3 class="no-margin text-semibold">$<?= $total_paid_amount?></h3>
						<span class="text-uppercase text-size-mini text-muted">Total Paid Amount</span>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- Basic datatable -->
	<div class="panel panel-flat" style="overflow: auto;">
		<table class="table datatable-basic">
			<thead>
				<tr>
					<th>No</th>
					<th>Invoice Date</th>
					<th>Customer Name</th>
					<th>Company Name</th>
					<th>Invoie#</th>
					<th>Due Date</th>
					<th>Amount</th>
					<th>Status</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				<?php $cnt = 1; ?>
				<?php foreach ($invoices as $item) : ?>
					<tr>
						<td><?= $cnt ++ ?></td>
						<td><?= $item->create_date ?></td>
						<td><?= $item->username ?></td>
						<td><?= $item->consultant_name ?></td>
						<td><?= $item->invoice_num ?></td>
						<td><?= $item->due_date ?></td>
						<td><?= $item->amount ?></td>
						<td>
							<span class="label <?= $item->status == 'pending' ? 'label-info' : 'label-success' ?>"><?= $item->status ?></span>
						</td>
						<td>
							<ul class="icons-list">
								<li>
									<button type="button" onclick="view(<?= $item->id ?>);" class="btn btn-primary btn-xs">View</button></li>
								<?php if($item->status != 'paid') : ?>
								<li>
									<button type="button" onclick="edit(<?= $item->id ?>);" class="btn btn-primary btn-xs">Edit<a href="#"></a></button></li>
								<?php endif; ?>
								<li>
									<button type="button" onclick="invoice_delete(<?= $item->id ?>);" class="btn btn-primary btn-xs">Delete<a href="#"></a></button>
								</li>
								<?php if($item->status == 'pending') : ?>
								<li>
									<button type="button" onclick="pay(<?= $item->id ?>);" class="btn btn-primary btn-xs">Pay<a href="#"></a></button></li>
								<?php endif; ?>
							</ul>
						</td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>
</div>

<script type="text/javascript" src="<?= base_url(PLUGINS_URL . 'ui/moment/moment.min.js') ?>"></script>
<script type="text/javascript" src="<?= base_url(PLUGINS_URL . 'pickers/daterangepicker.js') ?>"></script>
<script type="text/javascript" src="<?= base_url(PLUGINS_URL . 'forms/selects/select2.min.js') ?>"></script>
<script type="text/javascript" src="<?= base_url(JS_URL . 'core/app.js') ?>"></script>
<script type="text/javascript" src="<?= base_url(JS_URL . 'bootbox.min.js') ?>"></script>

<script>
	$(function(){
		$('.daterange-single').daterangepicker({ 
			singleDatePicker: true,
			locale: {
				format: 'YYYY-MM-DD'
			}
		});

		$('.daterange-single1').daterangepicker({ 
			singleDatePicker: true,
			locale: {
				format: 'YYYY-MM-DD'
			}
		});

		// Setting datatable defaults
		$.extend( $.fn.dataTable.defaults, {
			autoWidth: false,
			dom: '<"datatable-header"fl><"datatable-scroll"t><"datatable-footer"ip>',
			language: {
				search: '<span>Filter:</span> _INPUT_',
				searchPlaceholder: 'Type to filter...',
				lengthMenu: '<span>Show:</span> _MENU_',
				paginate: { 'first': 'First', 'last': 'Last', 'next': '&rarr;', 'previous': '&larr;' }
			},
			drawCallback: function () {
				$(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').addClass('dropup');
            },
			preDrawCallback: function() {
				$(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').removeClass('dropup');
			}
        });
        // Basic datatable
		$('.datatable-basic').DataTable({
			buttons: {
				dom: {
					button: { className: 'btn btn-primary' }
				},
				buttons: [
					{ extend: 'csv' }
				]
			}
		});

		// Alternative pagination
		$('.datatable-pagination').DataTable({
			pagingType: "simple",
			language: {
				paginate: {'next': 'Next &rarr;', 'previous': '&larr; Prev'}
			}
		});

		// Datatable with saving state
		$('.datatable-save-state').DataTable({
			stateSave: true
		});

		// Scrollable datatable
		$('.datatable-scroll-y').DataTable({
			autoWidth: true,
			scrollY: 300
		});

		// External table additions
		// ------------------------------

		// Enable Select2 select for the length option
		$('.dataTables_length select').select2({
			minimumResultsForSearch: Infinity,
			width: 'auto'
		});

		$('.daterange-single').val("<?= $start_date?>");
		$('.daterange-single1').val("<?= $end_date?>");
	});

	function add() {
		location.href = '<?= base_url('admin/invoice/add')?>';
	}

	function view(id) {
		location.href = "<?= base_url('admin/invoice_view/')?>" + id;
	}

	function edit(id) {
		location.href = "<?= base_url('admin/invoice_edit/')?>" + id;
	}

	function invoice_delete(val){
		var dialog = bootbox.dialog({
			title: 'Confirmation',
			message: "<h4>Are You Sure want to delete ?</h4> <br><p>Warning ! you will be loss All records..</p>",
			size: 'small',
			buttons: {
				cancel: {
					label: "Cancel",
					className: 'btn-danger',
					callback: function(){
						dialog.modal('hide');
					}
				},
				ok: {
					label: "OK",
					className: 'btn-success',
					callback: function(){
						window.location.href= "<?php echo base_url('admin/invoice_delete/')?>"+val;
					}
				}
			}
		});
	}

	function pay(id) {
		location.href = "<?php echo base_url('admin/invoice_pay/')?>" + id;
	}
</script>