<style>
	.dropzone {
		min-height: 175px;
	}
	.dropzone .dz-default.dz-message {
	    height: 175px;
	}
	.mb-3, .my-3 {
		margin-bottom: 0px !important;
	}

    button {
        margin-right: 15px;
    }
</style>

<div class="content">
	<div class="panel panel-flat">
		<div class="panel-heading" style="border-bottom: 1px solid #eee;">
            <h5 class="panel-title" style="display: inline-block;">Delivery Create</h5>
            <button type="submit" class="btn btn-primary pull-right" onclick="">Cancel</button>
			<button type="submit" class="btn btn-primary pull-right" onclick="">Save</button>
		</div>
		<div class="container-fluid">
			<form id="add_form" action="<?= base_url('sales/order/add_delivery') ?>" method="post" enctype="multipart/form-data">
				<div class="form-group">
					<div class="row">
						<div class="col-sm-6">
                            <div class="form-group">
                                <div class="row">
                                    <label class="control-label col-lg-3">Customer</label>
                                    <div class="col-lg-9">
                                        <select name="customer" class="form-control">
                                            <option value="opt1">Customer1</option>
                                            <option value="opt2">Customer2</option>
                                            <option value="opt3">Customer3</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="control-label col-lg-3">Operation Type</label>
                                    <div class="col-lg-9">
                                        <select name="operation" class="form-control">
                                            <option value="opt1">operation1</option>
                                            <option value="opt2">operation2</option>
                                            <option value="opt3">operation3</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="control-label col-lg-3">Source Location</label>
                                    <div class="col-lg-9">
                                        <select name="source_location" class="form-control">
                                            <option value="opt1">Source Location1</option>
                                            <option value="opt2">Source Location2</option>
                                            <option value="opt3">Source Location3</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="control-label col-lg-3">Destination Location</label>
                                    <div class="col-lg-9">
                                        <select name="destination_location" class="form-control">
                                            <option value="opt1">Destination Location1</option>
                                            <option value="opt2">Destination Location2</option>
                                            <option value="opt3">Destination Location3</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

					</div>

					<div class="row">
						<div class="col-sm-12">
							<div class="tabbable">
								<ul class="nav nav-tabs nav-tabs-top top-divided">
									<li class="active">
										<a href="#tab1" data-toggle="tab">Operation</a>
									</li>
								</ul>
								<div class="tab-content">
									<div id="tab1" class="tab-pane active">
										<div class="row">
                                            <table class="table table-operation">
                                                <thead>
                                                <tr>
                                                    <th>Product</th>
                                                    <th>Initial Demand</th>
                                                    <th>Reserved</th>
                                                    <th>Done</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <td>component1</td>
                                                    <td>10.000</td>
                                                    <td>0.000</td>
                                                    <td>0.000</td>
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
			</form>
		</div>
	</div>
</div>

<script type="text/javascript" src="<?= base_url(PLUGINS_URL . 'forms/styling/uniform.min.js') ?>"></script>
<script type="text/javascript" src="<?= base_url(PLUGINS_URL . 'uploaders/dropzone.min.js') ?>"></script>

<script type="text/javascript" src="<?= base_url(JS_URL . 'user/sales/order/delivery_create.js') ?>"></script>