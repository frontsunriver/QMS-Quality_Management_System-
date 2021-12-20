<style>
	.mb-3, .my-3 {
		margin-bottom: 0px !important;
	}
	sup {
		font-size: 12px;
    	color: green;
	}
</style>

<div class="content">
	<div class="panel panel-flat">
		<div class="panel-heading">
			<h5 class="panel-title" style="display: inline-block;">Customer</h5>
			<button type="submit" class="btn btn-primary pull-right" onclick="javascript:onSave();">Save</button>
		</div>
		<div class="container-fluid">
			<form id="add_form" action="<?= base_url('manufacture/work/create') ?>" method="post">
				<div class="form-group">
					<div class="row">
						<div class="col-lg-6 form-group">
							<div class="form-group row">
								<label class="col-lg-4 control-label text-lg-right pt-2">Name</label>
								<div class="col-lg-6">
									<input type="text" class="form-control" name="create[name]">
								</div>
							</div>
							<div class="form-group row">
								<label class="col-lg-4 control-label text-lg-right pt-2">Resource Type</label>
								<div class="col-lg-6">
									<select class="form-control mb-3">
										<option>Material</option>
									</select>
								</div>
							</div>
						</div>
						<div class="col-lg-6 form-group">
							<div class="form-group row">
								<label class="col-lg-4 control-label text-lg-right pt-2">Code</label>
								<div class="col-lg-6">
									<input type="text" class="form-control">
								</div>
							</div>
							<div class="form-group row">
								<label class="col-lg-4 control-label text-lg-right pt-2">Working Period&nbsp;<sup>?</sup></label>
								<div class="col-lg-6">
									<select class="form-control mb-3">
										<option>Material</option>
									</select>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-lg-4 control-label text-lg-right pt-2">Active</label>
								<div class="col-lg-6">
									<input type="checkbox" data-on-color="danger" data-off-color="primary" data-on-text="Active" data-off-text="Deactive" class="switch" checked="checked">
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12">
							<div class="tabbable">
								<ul class="nav nav-tabs nav-tabs-top top-divided">
									<li class="active">
										<a href="#tab1" data-toggle="tab">General Information</a>
									</li>
								</ul>
								<div class="tab-content">
									<div id="tab1" class="tab-pane active">
										<div class="row">
											<div class="col-lg-6 form-group">
												<label class="text-bold">
													Capacity Information
												</label>
												<hr style="margin: 0 0 10px 0;" />
												<div class="form-group row">
													<label class="col-lg-5 control-label text-lg-right pt-2">Efficiency factor&nbsp;<sup>?</sup>&nbsp;:</label>
													<div class="col-lg-6">
														<input type="number" class="form-control">
													</div>
												</div>
												<div class="form-group row">
													<label class="col-lg-5 control-label text-lg-right pt-2">Capacity per Cycle&nbsp;<sup>?</sup>&nbsp;:</label>
													<div class="col-lg-6">
														<input type="number" class="form-control">
													</div>
												</div>
												<div class="form-group row">
													<label class="col-lg-5 control-label text-lg-right pt-2">Time for 1 cycle (hour)&nbsp;<sup>?</sup>&nbsp;:</label>
													<div class="col-lg-6">
														<input type="number" class="form-control">
													</div>
												</div>
												<div class="form-group row">
													<label class="col-lg-5 control-label text-lg-right pt-2">Time before prod.&nbsp;<sup>?</sup>&nbsp;:</label>
													<div class="col-lg-6">
														<input type="number" class="form-control">
													</div>
												</div>
												<div class="form-group row">
													<label class="col-lg-5 control-label text-lg-right pt-2">Time after prod.&nbsp;<sup>?</sup>&nbsp;:</label>
													<div class="col-lg-6">
														<input type="number" class="form-control">
													</div>
												</div>
											</div>
											<div class="col-lg-6 form-group">
												<label class="text-bold">
													Costing Information
												</label>
												<hr style="margin: 0 0 10px 0;" />
												<div class="form-group row">
													<label class="col-lg-5 control-label text-lg-right pt-2">Work Center Product&nbsp;<sup>?</sup>&nbsp;:</label>
													<div class="col-lg-6">
														<div class="form-group has-feedback" style="position: relative;">
															<input type="text" class="form-control" placeholder="">
															<div class="form-control-feedback">
																<i class="icon-search4 text-size-base"></i>
															</div>
														</div>
													</div>
												</div>
												<div class="form-group row">
													<label class="col-lg-5 control-label text-lg-right pt-2">Cost per hour&nbsp;<sup>?</sup>&nbsp;:</label>
													<div class="col-lg-6">
														<input type="number" class="form-control">
													</div>
												</div>
												<div class="form-group row">
													<label class="col-lg-5 control-label text-lg-right pt-2">Cost per cycle&nbsp;<sup>?</sup>&nbsp;:</label>
													<div class="col-lg-6">
														<input type="number" class="form-control">
													</div>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-lg-12 form-group">
												<label class="text-bold">
													Description
												</label>
												<hr style="margin: 0 0 10px 0;" />
												<div class="form-group row">
													<div class="col-lg-12">
														<textarea class="form-control"></textarea>
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

<script type="text/javascript" src="<?= base_url(PLUGINS_URL . 'forms/styling/uniform.min.js') ?>"></script>
<script type="text/javascript" src="<?= base_url(PLUGINS_URL . 'forms/styling/switch.min.js') ?>"></script>

<script type="text/javascript" src="<?= base_url(JS_URL . 'user/manufacture/work/create.js') ?>"></script>