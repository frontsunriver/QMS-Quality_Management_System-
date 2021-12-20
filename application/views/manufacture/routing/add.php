<style>
    .mb-3, .my-3 {
        margin-bottom: 0px !important;
    }
    .no-border {
        border: none !important;
        background-color: white !important;
    }
</style>

<div class="content col-md-8" style="margin-left: auto; margin-right: auto;">
    <div class="panel panel-flat">
        <div class="panel-heading" style="border-bottom: 1px solid #eee;">
            <h5 class="panel-title" style="display: inline-block;">Add Routing</h5>
            <div class="pull-right">
                <button type="button" class="btn bg-blue" onclick="javascript:onSave();">Save</button>
                <a class="btn btn-default" href="<?= base_url('manufacture/routing') ?>">Back</a>
            </div>
        </div>
        <div class="container-fluid">
            <form id="add_form" action="<?= base_url("manufacture/routing/add") ?>/<?= !$routing ? -1 : $routing->id ?>" method="post">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group row">
                            <label class="col-lg-3 control-label pt-2 text-right">Name</label>
                            <div class="col-lg-9">
                                <input type="text" class="form-control mb-3 col-lg-10" name="routing[name]" value="<?= !$routing ? '' : $routing->name ?>" autofocus>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 control-label pt-2 text-right">Code</label>
                            <div class="col-lg-9">
                                <input type="text" class="form-control mb-3 col-lg-10" name="routing[code]" value="<?= !$routing ? '' : $routing->code ?>">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group row">
                            <label class="col-lg-4 control-label pt-2 text-right">Production Location</label>
                            <div class="col-lg-8">
                                <select class="form-control mb-3 col-lg-10" name="routing[warehouse_id]">
                                    <?php foreach ($warehouses as $warehouse) : ?>
                                        <option value="<?= $warehouse->id ?>" <?= $routing && $routing->warehouse_id == $warehouse->id ? 'selected' : '' ?>><?= $warehouse->name ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-4 control-label pt-2 text-right">Active</label>
                            <div class="col-lg-8">
                                <input type="checkbox" name="routing[active]" data-on-color="danger" data-off-color="primary" data-on-text="Active" data-off-text="Deactive" class="switch" <?= $routing && $routing->active == '1' || !$routing ? 'checked="checked"' : '' ?>>
                            </div>
                        </div>
                    </div>
                </div>
                <p></p>
                <div class="row">
                    <div class="col-sm-11" style="margin-left: auto; margin-right: auto;">
                        <div class="tabbable">
                            <ul class="nav nav-tabs nav-tabs-top top-divided">
                                <li class="active">
                                    <a href="#tab1" data-toggle="tab">Work Center Operations</a>
                                </li>
                                <!-- <li>
                                    <a href="#tab2" data-toggle="tab">Notes</a>
                                </li> -->
                            </ul>
                            <div class="tab-content">
                                <div id="tab1" class="tab-pane active">
                                    <div class="col-lg-12">
                                        <div class="row">
                                            <div class="table-responsive">
                                                <button type="button" class="btn bg-blue btn-xs" style="margin: 5px 0;" onclick="javascript:onAddItem();">
                                                            Add an item <i class="fa fa-plus"></i></button>
                                                <table class="table datatable-basic">
                                                    <thead>
                                                        <tr style="background-color: #e8f5e9;">
                                                            <th width="13%">Sequence</th>
                                                            <th width="8%">Name</th>
                                                            <th width="13%">Work Center</th>
                                                            <th width="18%">Number of Cycles</th>
                                                            <th width="18%">Number of Hours</th>
                                                            <th width="10%">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $i = 0; ?>
                                                        <?php foreach ($operations as $operation) : ?>
                                                            <tr>
                                                                <td>
                                                                    <label><?= $operation->sequence ?></label>
                                                                    <input type="hidden" name="operation[<?= $i ?>][sequence]" value="<?= $operation->sequence ?>">
                                                                </td>
                                                                <td>
                                                                    <label><?= $operation->name ?></label>
                                                                    <input type="hidden" name="operation[<?= $i ?>][name]" value="<?= $operation->name ?>">
                                                                </td>
                                                                <td>
                                                                    <label><?= $operation->workcenter_name ?></label>
                                                                    <input type="hidden" name="operation[<?= $i ?>][workcenter_id]" value="<?= $operation->workcenter_id ?>">
                                                                    <input type="hidden" name="operation[<?= $i ?>][description]" value="<?= $operation->description ?>">
                                                                </td>
                                                                <td>
                                                                    <label><?= $operation->number_of_cycles ?></label>
                                                                    <input type="hidden" name="operation[<?= $i ?>][number_of_cycles]" value="<?= $operation->number_of_cycles ?>">
                                                                </td>
                                                                <td>
                                                                    <label><?= $operation->number_of_hours ?></label>
                                                                    <input type="hidden" name="operation[<?= $i ++ ?>][number_of_hours]" value="<?= $operation->number_of_hours ?>">
                                                                </td>
                                                                <td>
                                                                    <ul class="icons-list">
                                                                        <li class="text-danger-600"><i class="icon-trash" onclick="javascript:onDeleteItem(this);"></i></li>
                                                                    </ul>
                                                                </td>
                                                            </tr>
                                                        <?php endforeach; ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- <div id="tab2" class="tab-pane">
                                    
                                </div> -->
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Basic modal -->
<div id="modal_item" class="modal fade">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="add_item_form" action="#" method="post">
                <div class="modal-header">
                    <h5 class="modal-title">Create: Operation</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="row form-group">
                        <label class="col-lg-3 control-label pt-2" style="flex: 0 0 166px;">&nbsp;&nbsp;&nbsp;Name</label>
                        <div class="col-lg-9">
                            <input type="text" class="form-control mb-3 col-lg-12" name="name">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="row form-group">
                                <label class="col-lg-5 control-label pt-2">&nbsp;&nbsp;&nbsp;Sequence</label>
                                <div class="col-lg-7">
                                    <input type="text" class="form-control mb-3 col-lg-4" name="sequence" value="0">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-5 control-label pt-2">&nbsp;&nbsp;&nbsp;Number of Cycles</label>
                                <div class="col-lg-7">
                                    <input type="number" class="form-control mb-3 col-lg-4" name="number_of_cycles" value="1">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="row form-group">
                                <label class="col-lg-5 control-label pt-2">&nbsp;&nbsp;&nbsp;Work Center</label>
                                <div class="col-lg-7">
                                    <select class="form-control mb-3 col-lg-10" name="workcenter">
                                        <?php foreach ($workcenters as $workcenter) : ?>
                                            <option value="<?= $workcenter->id ?>"><?= $workcenter->name ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-5 control-label pt-2">&nbsp;&nbsp;&nbsp;Number of Hours</label>
                                <div class="col-lg-7">
                                    <input type="text" id="number_of_hours" class="form-control mb-3 col-lg-4" style="background-color: white;" name="number_of_hours" value="00:00">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row" style="margin-left: -3px; margin-right: -3px;">
                        <div class="col-sm-12">
                            <div class="content-group">
                                <h5>Description</h5>
                                <textarea class="form-control" name="description" rows="10" cols="5" style="height: 120px;"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn bg-blue">Save & Close</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- /basic modal -->

<script type="text/javascript" src="<?= base_url(JS_URL . 'jquery.dataTables.min.js') ?>"></script>
<script type="text/javascript" src="<?= base_url(PLUGINS_URL . 'forms/validation/validate.min.js') ?>"></script>
<script type="text/javascript" src="<?= base_url(PLUGINS_URL . 'forms/styling/uniform.min.js') ?>"></script>
<script type="text/javascript" src="<?= base_url(PLUGINS_URL . 'forms/styling/switch.min.js') ?>"></script>
<script type="text/javascript" src="<?= base_url(PLUGINS_URL . 'pickers/anytime.min.js') ?>"></script>

<script type="text/javascript" src="<?= base_url(JS_URL . 'user/manufacture/routing/add.js') ?>"></script>