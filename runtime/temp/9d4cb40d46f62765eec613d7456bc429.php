<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:74:"D:\PHPTutorial\WWW\geek\public/../app/ps\view\inspection\storage_area.html";i:1533728036;}*/ ?>
<style>
    .addA {
    width: 100vw;
    height: 100vh; 
    background: rgba(0, 4, 8, 0.6); 
    z-index: 999900; 
    position: fixed; 
    top: 0px !important;left: 0;
    z-index: 10;
    overflow: auto; 
}

 .addform{
    width: 50vw;
    top:10vh;
    left:25vw;
    background: whitesmoke;
    padding: 20px;
    border-radius:5px;
}



#myTable tbody .selected{
    background-color: #acbad4;
    border-bottom: 1px #ccc solid;
}

 #dataTables-example tbody .selected{
    background-color: #acbad4;
    border-bottom: 1px #ccc solid;
}

.modal-backdrop.in {
    display: none:!important;
}   
</style>
<div class="box">
    <div class="box-header">

        <a class="btn add" href="javascript:;"><i class="fa fa-plus"></i> 新 增</a>

        <div class="box-tools">
            <div class="input-group input-group-sm search-form">
                <input name="search_data" class="pull-right search-input" value="<?php echo input('search_data'); ?>" placeholder="支持名称" type="text">
                <div class="input-group-btn">
                    <button type="button" id="search" url="<?php echo url('storagearea'); ?>" class="btn btn-default"><i class="fa fa-search"></i></button>
                </div>
            </div>
        </div>
    </div>

    <div class="box-body table-responsive">
        <table  class="table table-bordered table-hover">
            <thead>
            <tr>
                <th>名称</th>
                <th>创建时间</th>
                <th>状态</th>
                <th>操作</th>
            </tr>
            </thead>

            <?php if(!(empty($list) || (($list instanceof \think\Collection || $list instanceof \think\Paginator ) && $list->isEmpty()))): ?>
                <tbody>
                <?php if(is_array($list) || $list instanceof \think\Collection || $list instanceof \think\Paginator): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                    <tr>
                        <td><?php echo $vo['name']; ?></td>
                        <td><?php echo $vo['create_time']; ?></td>
                        <td><ob_link><a class="ajax-get" href="<?php echo url('areaStatus', array('ids' => $vo['id'], 'status' => (int)!$vo['status'])); ?>"><?php echo $vo['status_text']; ?></a></ob_link></td>
                        <td class="col-md-2 text-center">
                            <ob_link><a  class="btn edit" data-id="<?php echo $vo['id']; ?>"><i class="fa fa-edit " ></i> 编 辑</a></ob_link>
                            &nbsp;
                            <ob_link><a class="btn confirm ajax-get"  href="<?php echo url('areaDel', array('id' => $vo['id'])); ?>"><i class="fa fa-trash-o"></i> 删 除</a></ob_link>
                        </td>
                    </tr>
                <?php endforeach; endif; else: echo "" ;endif; ?>
                </tbody>
            <?php else: ?>
                <tbody><tr class="odd"><td colspan="7" class="text-center" valign="top"><?php echo config('empty_list_describe'); ?></td></tr></tbody>
            <?php endif; ?>
        </table>
    </div>

    <div class="box-footer clearfix text-center">
        <?php echo $list->render(); ?>
    </div>
    <div class="addA" style="display: none">
        <div class="row">
            <div class="col-lg-12 addform">
                <form role="form" id="postForm">
                    
                    <div class="hidden_id">
                        
                    </div>
                    <button style="display: block;float:right" class="close"><i class="fa fa-close"></i></button>
                    <h3 class='panel-heading'>添加区域</h3>

                     <div class="form-group col-lg-12">
                        <label>区域名称 </label>
                        <input class="form-control" placeholder="" name="name" value=""  autocomplete="off">
                    </div>
                    <div class="form-group col-lg-12">
                        <label>巡查次数/每班次</label>
                        <select name="times" id="" class="form-control">
                            <option value="1">1</option>    
                            <option value="2">2</option>    
                            <option value="3">3</option>    
                            <option value="4">4</option>    
                            <option value="5">5</option>    
                        </select>
                        
                        
                    </div>
                    <input type="hidden" name='area_type' value='1'>
                    <div class="form-group col-lg-12">
                        <label>排序 </label>
                        <input class="form-control" placeholder="" name="sort" value="" autocomplete="off" >
                        
                    </div>

                  
                    <div class="form-group col-lg-12">
                  
                    <button type="submit" name="submit"  class="btn btn-default submit">添加</button>
                    <button type="reset" name="reset"  class="btn btn-default reset">重置</button>
                    </div>
                </form>
            </div>
            <!-- /.col-lg-6 (nested) -->
   
            <!-- /.col-lg-6 (nested) -->
        </div>

    </div>
</div>

<script>
    //显示表单
    $('.add').click(function(){
        $('.panel-heading').text('添加区域');
        $('.addA').slideDown(300);
    })

    //隐藏表单
    $('.close').click(function(e){
        e.preventDefault();
        $('form input').val('');
        $('form select').val('');
        $('.hidden_id').html('');
        $('.addA').slideUp(300);
    })

    $('.edit').click(function(){
        _id = $(this).attr('data-id');
        $('.panel-heading').text('编辑区域');
        $.post('',{id:_id},function(d){
            console.log(d);
            $('.addA').slideDown(300);
            content = "<input type = 'hidden' name='id' value='"+d.data.id+"''>";
            $('.hidden_id').append(content);
            $('input[name="name"]').val(d.data.name);
            $('input[name="sort"]').val(d.data.sort);
            $('select[name="times"]').val(d.data.times);

        })
        // alert(_id);
    })

    $('.submit').click(function(e){
        e.preventDefault();
        formdata = $('.addA form').serialize();
        $.post('',formdata,function(d){
            // d.stop = true;
            obalert(d);
        })
    })

</script>