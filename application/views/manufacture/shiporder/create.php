<style>
    .table th, .table td {
        line-height: 10px;
    }
</style>

<div class="content col-md-12" style="margin-left: auto; margin-right: auto;">
    <div class="panel panel-flat">
        <div class="panel-heading" style="border-bottom: 1px solid #eee;">
            <h5 class="panel-title" style="display: inline-block;">New</h5>
            <div class="pull-right">
                <button type="button" class="btn bg-blue" onclick="javascript:onSave();">Save</button>
                <button type="button" class="btn btn-default" onclick="javascript:onBack();">Discard</button>
            </div>
        </div>
        <div class="container-fluid" >
            <div class="row col-md-12" >
                <form id="create_form" class="form-control" action="<?= base_url('manufacture/shiporder/create') . ($order ? "/{$order->id}" : '') ?>" method="post" style="padding: 20px">
                    <div class="row">
                        <label class="col-lg-2 control-label pt-2 text-right"><b>Ship Order Number</b>:</label>
                        <div class="col-lg-2">
                            <input type="text" class="form-control mb-3" name="order[shiporder_num]" value="">
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-lg-2 control-label pt-2 text-right">Partner:</label>
                        <div class="col-lg-2">
                            <select class="form-control mb-3" name="order[partner_id]">
                                <?php foreach ($partners as $partner) : ?>
                                    <option value="<?= $partner->id ?>"><?= $partner->name ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-lg-2 control-label pt-2 text-right">Operation Type:</label>
                        <div class="col-lg-2">
                            <input type="text" class="form-control mb-3" name="order[opt_type]" value="">
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-lg-2 control-label pt-2 text-right">Source Location:</label>
                        <div class="col-lg-2">
                            <select class="form-control mb-3" name="order[src_location]">
                                <?php foreach ($warehouses as $warehouse) : ?>
                                    <option value="<?= $warehouse->id ?>"><?= $warehouse->name ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <!-- <div class="row">
                        <label class="col-lg-2 control-label pt-2 text-right">Destination Location:</label>
                        <div class="col-lg-3">
                            <input type="text" class="form-control mb-3" name="order[dest_location]" value="">
                        </div>
                    </div> -->
                    <div class="row">
                        <div class="col-sm-12" style="padding: 5px 40px;">
                            <div class="tabbable">
                                <ul class="nav nav-tabs nav-tabs-top top-divided">
                                    <li class="active">
                                        <a href="#tab1" data-toggle="tab">Operations</a>
                                    </li>
                                    <li>
                                        <a href="#tab2" data-toggle="tab">Note</a>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    <div id="tab1" class="tab-pane active">
                                        <div class="col-lg-12">
                                            <div class="row">
                                                <div class="table-responsive">
                                                    <button type="button" class="btn bg-blue btn-xs" style="margin: 5px 0;" onclick="javascrit:onAddLine();">
                                                        Add a line <i class="fa fa-plus"></i></button>
                                                    <table class="table datatable-basic">
                                                        <thead>
                                                        <tr style="background-color: #e8f5e9;">
                                                            <th width="15%">Product</th>
                                                            <th width="20%">Initial Demand</th>
                                                            <th width="10%">Reserved</th>
                                                            <th width="10%">Done</th>
                                                            <th width="20%">Action</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <?php for ($i = 0; $i < count($ship_products); $i ++) { ?>
                                                            <tr>

                                                                <td>
                                                                    <input type="text" class="form-control form-control-sm" name="products[<?= $i ?>][product]" value="<?= $ship_products[$i]->product ?>">

                                                                </td>
                                                                <td>
                                                                    <input type="number" class="form-control form-control-sm" name="products[<?= $i ?>][demand]" value="<?= $ship_products[$i]->demand ?>">


                                                                </td>
                                                                <td>
                                                                    <input type="number" class="form-control form-control-sm" name="products[<?= $i ?>][reserved]" value="<?= $ship_products[$i]->reserved ?>">


                                                                </td>
                                                                <td>

                                                                    <?= $ship_products[$i]->reserved - $ship_products[$i]->demand ?>
                                                                </td>
                                                                <td>
                                                                    <ul class="icons-list text-left"><li class="text-danger-400" style="margin-left: 0;"><i class="icon-trash" onclick="onDeleteAddItem(this);"></i></li></ul>
                                                                </td>
                                                            </tr>
                                                        <?php } ?>
                                                        </tbody>
                                                    </table>
                                                    <hr style="margin-top: 0px; margin-bottom: 0px;"/>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div id="tab2" class="tab-pane">
                                        <div class="col-lg-12">
                                            <div class="row">
                                                <div class="content-group col-md-12">
                                                    <h5>Note</h5>
                                                    <textarea class="form-control" name="order[description]" rows="10" cols="5" style="height: 120px;"><?= !$order ? '' : $order->description ?></textarea>
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
</div>

<script type="text/javascript" src="<?= base_url(PLUGINS_URL . 'forms/validation/validate.min.js') ?>"></script>
<script type="text/javascript" src="<?= base_url(PLUGINS_URL . 'pickers/anytime.min.js') ?>"></script>
<script type="text/javascript" src="<?= base_url(JS_URL . 'jquery.dataTables.min.js') ?>"></script>

<script>
    var product_options = '';
    <?php foreach ($products as $product) : ?>
        product_options += '<option value="<?= $product->id ?>"><?= $product->name ?></option>';
    <?php endforeach; ?>

    var material_id = <?= !$ship_products ? 0 :$ship_products[0]->id ?>;
    var materials = '';
    $(function(){
        <?php foreach ($ship_products as $ship_product) : ?>
        materials += '<option value="<?= $ship_product->id ?>"><?= $ship_product->product ?></option>';
        <?php endforeach; ?>
    });
</script>
<script type="text/javascript" src="<?= base_url(JS_URL . 'user/warehouse/shiporder/create.js') ?>"></script>