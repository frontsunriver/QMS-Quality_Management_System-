<style>
	.mb-3, .my-3 {
		margin-bottom: 0px !important;
	}
	.panel .container-fluid {
		margin-top: 0px;
		margin-bottom: 20px;

	}
	hr {
		margin-top: 15px;
		margin-bottom: 15px;
	}
	#createForm .col-lg-6 .row {
		margin-top: 10px;
		margin-bottom: 10px;
	}
</style>

<div class="content col-md-6" style="margin-left: auto; margin-right: auto;">
	<div class="panel panel-flat">
		<div class="panel-heading" style="padding-bottom: 0px;">
			<h5 class="panel-title" style="display: inline-block;">New Transfer</h5>
			<div class="pull-right">
				<button type="button" class="btn bg-blue" onclick="javascript:onSave();">Save</button>
				<button type="button" class="btn btn-default" onclick="javascript:onBack();">Back</button>
			</div>
			<hr/>
		</div>
		<div class="container-fluid">
			<div class="col-lg-12">
				<form id="createForm" class="form-control">
					<div class="row">
						<div class="col-lg-6">
							<div class="row">
								<label class="col-lg-5 control-label text-lg-right pt-2">Transfer Number: </label>
								<input type="text" class="form-control col-lg-6">
							</div>
							<div class="row">
								<label class="col-lg-5 control-label text-lg-right pt-2">Warehouse: </label>
								<select class="form-control col-lg-6">
								</select>
							</div>
						</div>
						<div class="col-lg-6">
							<div class="row">
								<label class="col-lg-4 control-label text-lg-right pt-2">Type: </label>
								<select class="form-control col-lg-6" onchange="javascript:onChangeType(this.value);">
									<option value="material">Material</option>
									<option value="product">Product</option>
								</select>
							</div>
							<div class="row">
								<label id="good_label" class="col-lg-5 control-label text-lg-right pt-2">Material: </label>
								<select id="good_select" class="form-control col-lg-6" onchange="javascript:onChangeGood(this.value);">
								</select>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript" src="<?= base_url(JS_URL . 'user/warehouse/transfer/create.js') ?>"></script>