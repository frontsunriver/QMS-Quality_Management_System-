<style>
    td, th {
        text-align: center;
        word-break: keep-all !important;
    }
    button {
        margin-right: 15px;
    }
</style>
<div class="content">
	<div class="panel panel-flat">
		<div class="panel-heading">
			<h5 class="panel-title" style="display: inline-block;">WH/OUT/00002</h5>
            <button type="button" class="btn bg-blue pull-right" onclick="">Confirm Order</button>
            <button type="button" class="btn bg-blue pull-right" onclick="">Download Pdf</button>

		</div>
        <div class="panel-body" style="padding: 15px">
            <table class="col-sm-4">
                <tr>
                    <td  style="width: 50%">Partner</td>
                    <td  style="width: 50%; color: seagreen">customer1</td>
                </tr>
                <tr>
                    <td>Operation Type</td>
                    <td style="color: seagreen">My Company:Delivery Orders</td>
                </tr>
                <tr>
                    <td>Source Location</td>
                    <td style="color: seagreen">WH/Stock</td>
                </tr>
            </table>

        </div>
		<div class="container-fluid">
			<div class="row">
				<div class="col-sm-12">
					<div class="tabbable">
						<ul class="nav nav-tabs nav-tabs-top top-divided">
							<li class="active">
								<a href="#tab1" data-toggle="tab">Operations</a>
							</li>
							<li>
								<a href="#tab2" data-toggle="tab">Additional Info</a>
							</li>
                            <li>
                                <a href="#tab2" data-toggle="tab">Note</a>
                            </li>
						</ul>
						<div class="tab-content">
							<div id="tab1" class="tab-pane active">
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
                                        <td>5.000</td>
                                        <td>0.000</td>
                                        <td>0.000</td>
                                    </tr>
                                    </tbody>
                                </table>
							</div>
							<div id="tab2" class="tab-pane">
							</div>
                            <div id="tab3" class="tab-pane">
                            </div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>


<script type="text/javascript" src="<?= base_url(PLUGINS_URL . 'forms/selects/bootstrap_select.min.js') ?>"></script>
<script type="text/javascript" src="<?= base_url(PLUGINS_URL . 'forms/validation/validate.min.js') ?>"></script>
<script type="text/javascript" src="<?= base_url(PLUGINS_URL . 'tables/datatables/datatables.min.js') ?>"></script>
<script type="text/javascript" src="<?= base_url(PLUGINS_URL . 'tables/datatables/extensions/fixed_columns.min.js') ?>"></script>
<script type="text/javascript" src="<?= base_url(PLUGINS_URL . 'tables/datatables/extensions/col_reorder.min.js') ?>"></script>
<script type="text/javascript" src="<?= base_url(PLUGINS_URL . 'tables/datatables/extensions/buttons.min.js') ?>"></script>

<script type="text/javascript" src="<?= base_url(JS_URL . 'user/warehouse/ship/view.js') ?>"></script>