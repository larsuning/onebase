<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:63:"D:\PHPTutorial\WWW\geek\public/../app/ps\view\aaa\aaa_edit.html";i:1533356140;s:72:"D:\PHPTutorial\WWW\geek\public/../app/ps\view\layout\edit_btn_group.html";i:1533087617;}*/ ?>
<form action="<?php echo url(); ?>" method="post" class="form_single">
    <div class="box">
        <div class="box-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>名称</label>
                        <span>（name字段的名称）</span>
                        <input class="form-control" name="name" placeholder="请输入名称" value="<?php echo (isset($info['name']) && ($info['name'] !== '')?$info['name']:''); ?>" type="text">
                    </div>
                </div>

                <?php if(is_array($fields) || $fields instanceof \think\Collection || $fields instanceof \think\Paginator): $i = 0; $__LIST__ = $fields;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$field): $mod = ($i % 2 );++$i;switch($field['type']): case "num": ?>

                    <div class="col-md-6">
                        <div clas="form-group">
                            <label><?php echo $field['title']; ?></label>
                            <input type="text" class="form-control" name="<?php echo $field['name']; ?>" value="<?php echo (isset($info[$field['name']]) && ($info[$field['name']] !== '')?$info[$field['name']]:''); ?>">
                        </div>
                    </div>
                <?php break; case "string": ?>

                    <div class="col-md-6">
                        <div clas="form-group">
                            <label><?php echo $field['title']; ?></label>
                            <input type="text" class="form-control" name="<?php echo $field['name']; ?>" value="<?php echo (isset($info[$field['name']]) && ($info[$field['name']] !== '')?$info[$field['name']]:''); ?>">
                        </div>
                    </div>
                <?php break; case "textarea": ?>

                    <div class="col-md-6">
                        <div clas="form-group">
                            <label><?php echo $field['title']; ?></label>
                            <div><textarea name="<?php echo $field['name']; ?>" class="form-control"><?php echo (isset($info[$field['name']]) && ($info[$field['name']] !== '')?$info[$field['name']]:''); ?></textarea></div>
                        </div>
                    </div>

                <?php break; case "date": ?>

                    <div class="col-md-6">
                        <div clas="form-group">
                            <label><?php echo $field['title']; ?></label>
                            <input type="text" name="<?php echo $field['name']; ?>"  class="form-control date"   value="<?php echo !empty($info[$field['name']])?date('Y-m-d',$info[$field['name']]) : date('Y-m-d',time()); ?>" placeholder="请选择日期" />
                        </div>
                    </div>
                <?php break; case "datetime": ?>

                    <div class="col-md-6">
                        <div clas="form-group">
                            <label><?php echo $field['title']; ?></label>
                            <input type="text" name="<?php echo $field['name']; ?>"  class="form-control datetime"   value="<?php echo !empty($info[$field['name']])?date('Y-m-d H:i',$info[$field['name']]) : date('Y-m-d H:i',time()); ?>" placeholder="请选择日期" />
                        </div>
                    </div>

                <?php break; case "bool": ?>

                    <div class="col-md-6">
                        <div clas="form-group">
                            <label><?php echo $field['title']; ?></label>
                            <select name="<?php echo $field['name']; ?>" class="form-control">
                                <?php $_result=app\common\logic\common::parse_field_attr($field['extra']);if(is_array($_result) || $_result instanceof \think\Collection || $_result instanceof \think\Paginator): $i = 0; $__LIST__ = $_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                                    <option value="<?php echo $key; ?>" <?php if(!(empty($info) || (($info instanceof \think\Collection || $info instanceof \think\Paginator ) && $info->isEmpty()))): if($info[$field['name']] == $key): ?>selected<?php endif; else: if($field['value'] == $key): ?>selected<?php endif; endif; ?>><?php echo $vo; ?></option>
                                <?php endforeach; endif; else: echo "" ;endif; ?>
                            </select>
                        </div>
                    </div>

                <?php break; case "select": ?>

                    <div class="col-md-6">
                        <div clas="form-group">
                            <label><?php echo $field['title']; ?></label>
                            <select name="<?php echo $field['name']; ?>" class="form-control">
                                <?php $_result=app\common\logic\common::parse_field_attr($field['extra']);if(is_array($_result) || $_result instanceof \think\Collection || $_result instanceof \think\Paginator): $i = 0; $__LIST__ = $_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                                    <option value="<?php echo $key; ?>" <?php if(!(empty($info) || (($info instanceof \think\Collection || $info instanceof \think\Paginator ) && $info->isEmpty()))): if($info[$field['name']] == $key): ?>selected<?php endif; else: if($field['value'] == $key): ?>selected<?php endif; endif; ?>><?php echo $vo; ?></option>
                                <?php endforeach; endif; else: echo "" ;endif; ?>
                            </select>
                        </div>
                    </div>

                <?php break; case "radio": ?>

                    <div class="col-md-6">
                        <div clas="form-group">
                            <label><?php echo $field['title']; ?></label>
                            <?php $_result=app\common\logic\common::parse_field_attr($field['extra']);if(is_array($_result) || $_result instanceof \think\Collection || $_result instanceof \think\Paginator): $i = 0; $__LIST__ = $_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                                <label class="margin-r-5">
                                    <input type="radio" value="<?php echo $key; ?>" name="<?php echo $field['name']; ?>"<?php if(!(empty($info) || (($info instanceof \think\Collection || $info instanceof \think\Paginator ) && $info->isEmpty()))): if($info[$field['name']] == $key): ?>checked<?php endif; else: if($field['value'] == $key): ?>checked<?php endif; endif; ?> ><?php echo $vo; ?>
                                </label>
                            <?php endforeach; endif; else: echo "" ;endif; ?>
                        </div>
                    </div>

                <?php break; case "checkbox": ?>

                    <div class="col-md-6">
                        <div clas="form-group">
                            <label><?php echo $field['title']; ?></label>
                            <?php $_result=app\common\logic\common::parse_field_attr($field['extra']);if(is_array($_result) || $_result instanceof \think\Collection || $_result instanceof \think\Paginator): $i = 0; $__LIST__ = $_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                                <label class="margin-r-5" >
                                    <input type="checkbox" value="<?php echo $key; ?>" name="<?php echo $field['name']; ?>[]" <?php if(!(empty($info) || (($info instanceof \think\Collection || $info instanceof \think\Paginator ) && $info->isEmpty()))): if(in_array(($key), is_array($info[$field['name']])?$info[$field['name']]:explode(',',$info[$field['name']]))): ?>checked<?php endif; else: if(in_array(($key), is_array($field['value'])?$field['value']:explode(',',$field['value']))): ?>checked<?php endif; endif; ?> ><?php echo $vo; ?>
                                </label>
                            <?php endforeach; endif; else: echo "" ;endif; ?>
                        </div>
                    </div>

                <?php break; case "editor": ?>

                    <div class="col-md-12">
                        <div clas="form-group">
                            <label><?php echo $field['title']; ?></label>
                            <label>文章内容</label>
                            <textarea class="form-control textarea_editor" name="<?php echo $field['name']; ?>" placeholder="请输入文章内容"><?php echo (isset($info[$field['name']]) && ($info[$field['name']] !== '')?$info[$field['name']]:''); ?></textarea>
                            <?php echo widget('editor/index', array('name'=> $field['name'],'value'=> '')); ?>
                        </div>
                    </div>
                <?php break; case "picture": ?>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>上传图片</label>
                            <span class="">（请上传单张图片）</span>
                            <br/>
                            <?php $cover_id = (isset($info[$field['name']]) && ($info[$field['name']] !== '')?$info[$field['name']]:''); ?>
                            <?php echo widget('file/index', ['name' => $field['name'], 'value' => $cover_id, 'type' => 'img']); ?>
                        </div>
                    </div>
                <?php break; case "file": ?>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>附件</label>
                            <span class="">（文章可下载附件）</span>
                            <br/>
                            <?php $file_id = (isset($info[$field['name']]) && ($info[$field['name']] !== '')?$info[$field['name']]:'0'); ?>
                            <?php echo widget('file/index', ['name' => $field['name'], 'value' => $file_id, 'type' => 'file']); ?>
                        </div>
                    </div>
                <?php break; endswitch; endforeach; endif; else: echo "" ;endif; ?>
            </div>
        </div>
    </div>

    <div class="box-footer">

        <input type="hidden" name="id" value="<?php echo (isset($info['id']) && ($info['id'] !== '')?$info['id']:'0'); ?>"/>

        <button  type="submit" class="btn ladda-button ajax-post" data-style="slide-up" target-form="form_single">
    <span class="ladda-label"><i class="fa fa-send"></i> 确 定</span>
</button>

<a class="btn" onclick="javascript:history.back(-1);return false;"><i class="fa fa-history"></i> 返 回</a>
    </div>

</form>
<script type="text/javascript">
    $('.date').datetimepicker({
        language:"zh-CN",
        todayHighlight:true,
        todayBtn:true,
        format:'yyyy-mm-dd',
        minView:1,
        autoclose:true,
        minView:'3'

    });
    $('.datetime').datetimepicker({
        language:"zh-CN",
        todayHighlight:true,
        todayBtn:true,
        format:'yyyy-mm-dd hh:ii',
        minView:1,
        autoclose:true,

    });
</script>