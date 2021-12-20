<style>
    td, th {
        text-align: center;
        word-break: keep-all !important;
    }
</style>
<input type="hidden" id="base_url" name="base_url" value="<?php echo base_url()?>">
<div class="content">
    <div class="panel panel-flat">
        <div class="panel-heading">
            <h5 class="panel-title" style="display: inline-block;">Delivery Manage</h5>
            <button type="button" class="btn bg-blue pull-right" onclick="create()">Create</button>
        </div>
        <table class="table table-delivery">
            <thead>
            <tr>
                <th>Reference</th>
                <th>Destination Location</th>
                <th>Partner</th>
                <th>Scheduled Date</th>
                <th>Source Document</th>
                <th>Status</th>
            </tr>
            </thead>
            <tbody>
            <tr style="color:lightgrey">
                <td>WH/OUT/00001</td>
                <td>Partner Locations/Customers</td>
                <td>customer1</td>
                <td>11/24/2018 04:10:52</td>
                <td>SO001</td>
                <td>Cancelled</td>
            </tr>
            <tr onclick="viewData(1)">
                <td>WH/OUT/00002</td>
                <td>Partner Locations/Customers</td>
                <td>customer1</td>
                <td>11/24/2018 04:13:18/td>
                <td>SO001</td>
                <td>Waiting Another Operation</td>
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

<script type="text/javascript" src="<?= base_url(JS_URL . 'user/sales/order/delivery_list.js') ?>"></script>