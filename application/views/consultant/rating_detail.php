<div class="col-md-12">
    <table class="table table-bordered">
        <th></th>
        <?php foreach ($consequence as $row): ?>
            <th style="cursor: pointer;" onclick = "set_value(<?=$row->id?>,'<?=$row->name?>',1)"><?=$row->name?></th>
        <?php endforeach; ?>
        <?php foreach ($likelihood as $row): ?>
            <tr>
                <td style="cursor: pointer;" onclick = "set_value(<?=$row->id?>,'<?=$row->name?>',0)"><?=$row->name?></td>
                <?php foreach ($consequence as $items): ?>
                    <?php $count = 0;?>
                        <?php foreach ($values as $value): ?>
                            <?php if ($value->like_id == $row->id && $value->conse_id == $items->id): ?>
                                <?php $count++;?>
                                <td onclick="set_rating_matrix(<?=$value->id?>,<?=$row->id?>,<?=$items->id?>,<?=$value->value?>,'<?=$type?>')" style="background-color: <?php foreach ($risk_values as $item): ?><?php if ($value->value>=$item->start && $value->value<=$item->end): ?><?php echo $item->color;break;?><?php endif;?><?php endforeach; ?>">
                                    <?=$value->value?>
                                </td>
                            <?php endif;?>
                        <?php endforeach; ?>
                    <?php if ($count == 0): ?>
                        <td onclick="set_rating_matrix(0,<?=$row->id?>,<?=$items->id?>,0,'<?=$type?>')"></td>
                    <?php endif;?>
                <?php endforeach; ?>
            </tr>
        <?php endforeach; ?>
    </table>
</div>
<div class="col-md-12" style="margin-top:30px;width:50%;">
    <table class="table table-bordered">
        <th>Values</th>
        <th>Risk Level</th>
        <th>Color</th>
        <?php foreach ($risk_values as $row): ?>
            <tr>
                <td><?=$row->start?> to <?=$row->end?></td>
                <td><?=$row->level?></td>
                <td style="background-color: <?=$row->color?>"><?=$row->color?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>
<script type="text/javascript">
    function set_value(temp_id,temp_name,temp_type){
        id = temp_id;
        name = temp_name;
        type = temp_type;
        $('#name').val(name);
        $('#modal_edit').modal();
    }
    function set_rating_matrix(temp_id,temp_row,temp_column,value,type){
        value_id = temp_id;
        row = temp_row;
        column = temp_column;
        $('#rating_value').val(value);
        $('#type').val(type);
        $('#modal_value').modal();
    }
</script>
