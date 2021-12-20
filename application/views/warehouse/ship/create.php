<style>
    .table th, .table td {
        line-height: 10px;
    }
</style>

<div class="content col-md-9" style="margin-left: auto; margin-right: auto;">
    <div class="panel panel-flat">
        <div class="panel-heading" style="border-bottom: 1px solid #eee;">
            <h5 class="panel-title" style="display: inline-block;">New</h5>
            <div class="pull-right">
                <button type="button" class="btn bg-blue" onclick="onSave();">Save</button>
                <button type="button" class="btn bg-blue" onclick="onBack();">Discard</button>
            </div>
        </div>
        <div class="container-fluid" >
            <div class="row col-md-12" >
                <form id="create_form" class="form-control" action="<?= base_url('warehouse/ship/create') . ($order ? "/{$order->id}" : '') ?>" method="post" style="padding: 20px">
                    <div class="row" style="padding: 5px 25px;">
                        <div class="col-lg-8">
                            <div class="form-group row">
                                <label class="col-lg-4 control-label pt-2 text-left">Partner</label>
                                <div class="col-lg-8">
                                    <select class="form-control mb-3 col-lg-10" name="order[partner]">
                                        <?php foreach ($partners as $partner) : ?>
                                            <option value="<?= $partner->id ?>" <?= $order && $order->partner == $partner->id ? 'selected' : '' ?>><?= $partner->name ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                        </div>
                        <div class="col-lg-8">
                            <div class="form-group row">
                                <label class="col-lg-4 control-label pt-2 text-left">Operation Type</label>
                                <div class="col-lg-8">
                                    <input type="text" class="form-control mb-3 col-lg-10" name="order[operation_type]" value="<?= !$order ? '' : $order->operation_type ?>" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                        </div>
                        <div class="col-lg-8">
                            <div class="form-group row">
                                <label class="col-lg-4 control-label pt-2 text-left">Source Location</label>
                                <div class="col-lg-8">
                                    <input type="text" class="form-control mb-3 col-lg-10" name="order[src_location]" value="<?= !$order ? '' : $order->src_location ?>">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                        </div>
                        <div class="col-lg-8">
                            <div class="form-group row">
                                <label class="col-lg-4 control-label pt-2 text-left">Destination Location</label>
                                <div class="col-lg-8">
                                    <input type="text" class="form-control mb-3 col-lg-10" name="order[des_location]" value="<?= !$order ? '' : $order->des_location ?>" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                        </div>
                    </div>
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
                                                            <th width="40%">Product</th>
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
    var material_id = <?= !$ship_products ? 0 :$ship_products[0]->id ?>;
    var materials = '';
    $(function(){
        <?php foreach ($ship_products as $ship_product) : ?>
        materials += '<option value="<?= $ship_product->id ?>"><?= $ship_product->product ?></option>';
        <?php endforeach; ?>
    });
</script>
<script type="text/javascript" src="<?= base_url(JS_URL . 'user/warehouse/ship/create.js') ?>"></script>