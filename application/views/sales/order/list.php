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
			<h5 class="panel-title" style="display: inline-block;">Sales Order</h5>
            <button type="button" class="btn bg-blue pull-right" onclick="javascript:onCreate();">Create</button>
		</div>
		<table class="table table-manage">
            <thead>
                <tr>
                    <th>Order Number</th>
                    <th>Confirmation Date</th>
                    <th>Customer</th>
                    <th>Salesperson</th>
                    <th>Total</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><a href="<?php echo base_url('sales/order/viewData/1')?>">SO001</a></td>
                    <td>11/24/2018 04:10:52</td>
                    <td>customer1</td>
                    <td>user1@outlook.com</td>
                    <td>$ 5.18</td>
                    <td>Sales Order</td>
                </tr>

            </tbody>
        </table>
	</div>
</div>

<script type="text/javascript" src="<?= base_url(PLUGINS_URL . 'forms/selects/bootstrap_select.min.js') ?>"></script>
<script type="text/javascript" src="<?= base_url(PLUGINS_URL . 'forms/validation/validate.min.js') ?>"></script>
<script type="text/javascript" src="<?= base_url(PLUGINS_URL . 'tables/datatables/datatables.min.js') ?>"></script>
<script type="text/javascript" src="<?= base_url(PLUGINS_URL . 'tables/datatables/extensions/fixed_columns.min.js') ?>"></script>
<script type="text/javascript" src="<?= base_url(PLUGINS_URL . 'tables/datatables/extensions/col_reorder.min.js') ?>"></script>
<script type="text/javascript" src="<?= base_url(PLUGINS_URL . 'tables/datatables/extensions/buttons.min.js') ?>"></script>

<script type="text/javascript" src="<?= base_url(JS_URL . 'user/sales/order/list.js') ?>"></script>