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
<input type="hidden" id="base_url" name="base_url" value="<?php echo base_url()?>">
<div class="content">
	<div class="panel panel-flat">
		<div class="panel-heading" style="border-bottom: 1px solid #eee;">
			<h5 class="panel-title" style="display: inline-block;">&nbsp;</h5>

            <button type="submit" class="btn btn-primary pull-right" onclick="">Cancel</button>
			<button type="submit" class="btn btn-primary pull-right" onclick=""><?php if($id ==0) echo 'Save'; else echo 'Update';?></button>
            <?php if($id != 0){?>
            <button type="submit" class="btn btn-primary pull-right" onclick="">Create Invoice</button>
            <button type="submit" class="btn btn-primary pull-right" onclick="">Confirm Order</button>
            <button type="submit" class="btn btn-primary pull-right" onclick="">Print</button>
            <button type="submit" class="btn btn-primary pull-right" onclick="delivery();">Delivery</button>
            <?php }?>
		</div>
		<div class="container-fluid">
			<form id="add_form" action="<?= base_url('sales/order/add') ?>" method="post" enctype="multipart/form-data">
				<div class="form-group">
					<div class="row">
						<div class="col-sm-6">
                            <div class="form-group">
                                <div class="row">
                                    <label class="control-label col-lg-2">Customer</label>
                                    <div class="col-lg-10">
                                        <select name="customer" class="form-control">
                                            <option value="opt1">Customer1</option>
                                            <option value="opt2">Customer2</option>
                                            <option value="opt3">Customer3</option>
                                        </select>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <div class="row">
                                    <label class="control-label col-lg-2">Validity</label>
                                    <div class="col-lg-10">
                                        <select name="validity" class="form-control">
                                            <option value="opt1">validity1</option>
                                            <option value="opt2">validity2</option>
                                            <option value="opt3">validity3</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="control-label col-lg-2">Payment Terms</label>
                                    <div class="col-lg-10">
                                        <select name="payment_term" class="form-control">
                                            <option value="opt1">Payment Terms1</option>
                                            <option value="opt2">Payment Terms2</option>
                                            <option value="opt3">Payment Terms3</option>
                                        </select>
                                    </div>
                                </div>

                            </div>
                        </div>
					</div>
                    <div class="row">

                        <div class="col-sm-6">
                            <h5>Shipping Information</h5>
                            <div class="form-group">
                                <div class="row">
                                    <label class="control-label col-lg-2">Warehouse</label>
                                    <div class="col-lg-10">
                                        <select name="warehouse" class="form-control">
                                            <option value="opt1">Warehouse1</option>
                                            <option value="opt2">Warehouse2</option>
                                            <option value="opt3">Warehouse3</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="control-label col-lg-2">Shipping Policy</label>
                                    <div class="col-lg-10">
                                        <select name="shipping_policy" class="form-control">
                                            <option value="opt1">Shipping Policy1</option>
                                            <option value="opt2">Shipping Policy2</option>
                                            <option value="opt3">Shipping Policy3</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <h5>Sales Information</h5>
                            <div class="form-group">
                                <div class="row">
                                    <label class="control-label col-lg-2">Salesperson</label>
                                    <div class="col-lg-10">
                                        <select name="salesperson" class="form-control">
                                            <option value="opt1">Salesperson1</option>
                                            <option value="opt2">Salesperson2</option>
                                            <option value="opt3">Salesperson3</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="control-label col-lg-2">Sales Terms</label>
                                    <div class="col-lg-10">
                                        <select name="sales_terms" class="form-control">
                                            <option value="opt1">Sales Terms1</option>
                                            <option value="opt2">Sales Terms2</option>
                                            <option value="opt3">Sales Terms3</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="control-label col-lg-2">Customer Reference</label>
                                    <div class="col-lg-10">
                                        <select name="customer_reference" class="form-control">
                                            <option value="opt1">Customer Reference1</option>
                                            <option value="opt2">Customer Reference2</option>
                                            <option value="opt3">Customer Reference3</option>
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
										<a href="#tab1" data-toggle="tab">Order Lines</a>
									</li>
								</ul>
								<div class="tab-content">
									<div id="tab1" class="tab-pane active">
										<div class="row">
                                            <table class="table table-order">
                                                <thead>
                                                <tr>
                                                    <th>Product</th>
                                                    <th>Description</th>
                                                    <th>Ordered Qty</th>
                                                    <th>Unit Price</th>
                                                    <th>Taxes</th>
                                                    <th>Discount(%)</th>
                                                    <th>Subtotal</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <td>component1</td>
                                                    <td>component1 decripition</td>
                                                    <td>1.000</td>
                                                    <td>10.00</td>
                                                    <td>Tax 15.00%</td>
                                                    <td>10.00</td>
                                                    <td>9.00</td>
                                                </tr>
                                                </tbody>
                                            </table>
										</div>
                                        <div class="row">
                                            <div class="col-lg-6" style="color: lightgrey">
                                                Term and Conditions..(note:you can setup default ones in the Configuration menu)
                                            </div>
                                            <div class="col-lg-3"></div>
                                            <div class="col-lg-3">
                                                <table>
                                                    <tr>
                                                        <td>
                                                            Untaxed Amount:
                                                        </td>
                                                        <td>
                                                            0.00
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            Taxes:
                                                        </td>
                                                        <td>
                                                            0.00
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            Total:
                                                        </td>
                                                        <td>
                                                            10.35
                                                        </td>
                                                    </tr>
                                                </table>
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
<script type="text/javascript" src="<?= base_url(PLUGINS_URL . 'uploaders/dropzone.min.js') ?>"></script>

<script type="text/javascript" src="<?= base_url(JS_URL . 'user/sales/order/view.js') ?>"></script>