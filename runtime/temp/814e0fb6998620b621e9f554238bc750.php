<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:75:"D:\PHPTutorial\WWW\geek\public/../app/ps\view\attribute\attribute_edit.html";i:1527318980;s:72:"D:\PHPTutorial\WWW\geek\public/../app/ps\view\layout\edit_btn_group.html";i:1533087617;}*/ ?>
<form action="<?php echo url(); ?>" method="post" class="form_single">
    <div class="box">
        <div class="box-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>字段名</label>
                        <span>（请输入字段名 英文字母开头，长度不超过25）</span>
                        <input class="form-control" name="name" placeholder="请输入名称" value="<?php echo (isset($info['name']) && ($info['name'] !== '')?$info['name']:''); ?>" type="text">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>字段备注</label>
                        <span>（请输入字段备注，用于表单显示）</span>
                        <input class="form-control" name="title" placeholder="请输入名称" value="<?php echo (isset($info['title']) && ($info['title'] !== '')?$info['title']:''); ?>" type="text">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>字段类型</label>
                        <span>（用于表单中的展示方式）</span>
                        <select name="type"  id="data-type" class="form-control">
                            <option value="">----请选择----</option>
                            <?php $_result=app\common\logic\Common::get_attribute_type();if(is_array($_result) || $_result instanceof \think\Collection || $_result instanceof \think\Paginator): $i = 0; $__LIST__ = $_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$type): $mod = ($i % 2 );++$i;?>
                            <option value="<?php echo $key; ?>" rule="<?php echo $type[1]; ?>" <?php if(!(empty($info) || (($info instanceof \think\Collection || $info instanceof \think\Paginator ) && $info->isEmpty()))): if($info['type'] == $key): ?>selected<?php endif; endif; ?> ><?php echo $type[0]; ?></option>
                            <?php endforeach; endif; else: echo "" ;endif; ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>字段属性</label>
                        <span>（字段属性的sql表示）</span>
                        <input class="form-control" id="data-field" name="field" placeholder="请输入名称" value="<?php echo (isset($info['field']) && ($info['field'] !== '')?$info['field']:''); ?>" type="text">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>参数</label>
                        <span>（布尔、枚举、单选、多选字段类型的定义数据）</span>
                        <textarea class="form-control" name="extra" rows="3" placeholder="例子：
-1:删除
0:禁用
1:正常
2:待审核
3:草稿"><?php echo (isset($info['extra']) && ($info['extra'] !== '')?$info['extra']:''); ?></textarea>
                    </div>
                </div>
                <!--<div class="col-md-6">
                    <div class="form-group">
                    <label>字段备注</label>
                    <span>(用于表单中的提示)</span>
                    <input class="form-control" name="remark" placeholder="请输入名称" value="<?php echo (isset($info['remark']) && ($info['remark'] !== '')?$info['remark']:''); ?>" type="text">
                    </div>
                </div>-->
                <!--<div class="col-md-6">
                    <div class="form-group">
                        <label>是否显示</label>
                        <span>（是否显示在表单中(COMMENT)）</span>

                        <select name="is_show" class="form-control">
                            <option value="1">始终显示</option>
                            <option value="2">新增显示</option>
                            <option value="3">编辑显示</option>
                            <option value="0">不显示</option>
                        </select>

                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>是否必填</label>
                        <span>（用于自动验证）</span>
                        <select name="is_must" class="form-control">
                            <option value="0">否</option>
                            <option value="1">是</option>
                        </select>
                    </div>
                </div>-->
                <div class="col-md-6">
                    <div class="form-group">
                        <label>字段默认值</label>
                        <span>（字段的默认值(DEFAULT)）</span>
                        <input class="form-control" name="value" id="value" placeholder="请输入名称" value="<?php echo (isset($info['value']) && ($info['value'] !== '')?$info['value']:'0'); ?>" type="text">
                    </div>
                </div>
            </div>
        </div>

        <div class="box-footer">

            <input type="hidden" name="id" value="<?php echo (isset($info['id']) && ($info['id'] !== '')?$info['id']:'0'); ?>"/>
            <input type="hidden" name="model_id" value="<?php echo input('model_id'); ?>"/>

            <button  type="submit" class="btn ladda-button ajax-post" data-style="slide-up" target-form="form_single">
    <span class="ladda-label"><i class="fa fa-send"></i> 确 定</span>
</button>

<a class="btn" onclick="javascript:history.back(-1);return false;"><i class="fa fa-history"></i> 返 回</a>
        </div>

    </div>

</form>
<script type="text/javascript">
    ob.setValue("is_must", <?php echo (isset($info['is_must']) && ($info['is_must'] !== '')?$info['is_must']:0); ?>);
    ob.setValue("is_show", <?php echo (isset($info['is_show']) && ($info['is_show'] !== '')?$info['is_show']:0); ?>);


    $(function(){
        $option_val = $("option[selected]").val();
        if($option_val == 'editor' || $option_val == 'textarea')
        {
            $('#value').val(' ');
            $('#value').prop('disabled',true);
        }
        $('#data-type').change(function(){
            $('#data-field').val($(this).find('option:selected').attr('rule'));
        });
        $("option").click(function(){
           var val = $(this).val();
           if(val == "textarea"){
                $('#value').prop('disabled',true);
                $('#value').val(' ');
           }else if(val =="editor"){
                $('#value').prop('disabled',true);
                $('#value').val(' ');
           }else{
                $('#value').val(0);
                $('#value').prop('disabled',false);
           }
        });
    })
</script>