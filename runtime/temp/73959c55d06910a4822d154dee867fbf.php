<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:84:"D:\PHPTutorial\WWW\geek\public/../app/ps\view\inspection\inspection_agricultrue.html";i:1533283245;}*/ ?>
<form action="<?php echo url(); ?>" method="post" class="form_single">
    <div class="box">
        <div class="box-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>产品名称</label>
                        <span></span>
                        <input class="form-control" name="name" placeholder="请输入名称" value="<?php echo (isset($info['name']) && ($info['name'] !== '')?$info['name']:''); ?>" type="text" autocomplete="off" id="selectGoods">
                    </div>
                </div>
                <div class="col-md-6">
                        <div class="form-group">
                            <label>供应商</label>
                            <input type="text" class="form-control" name="provider_id" value="<?php echo (isset($info['provider_id']) && ($info['provider_id'] !== '')?$info['provider_id']:''); ?>" id="selectProvider">
                        </div>
                </div>
                <div class="col-md-6">
                        <div class="form-group">
                            <label>产品批次</label>
                            <input type="text" class="form-control" name="goods_batch" value="<?php echo (isset($info['good_batch']) && ($info['good_batch'] !== '')?$info['good_batch']:''); ?>" >
                        </div>
                </div>
                
                 <div class="col-md-6">
                        <div class="form-group">
                            <label>检测时间 </label>
                            <input type="text" name="inspect_time"  class="form-control time"   value="<?php echo !empty($info['insepection_time'])?date('Y-m-d',$info[$field['name']]) : date('H:i',time()); ?>" placeholder="请选择日期" />
                        </div>
                </div>

                <div class="col-md-6">
                        <div class="form-group">
                            <label>产品基数（KG） </label>
                            <input type="text" name="product_total"  class="form-control"   value="<?php echo (isset($info['product_total']) && ($info['product_total'] !== '')?$info['product_total']:''); ?>" placeholder="请输入产品基数" />
                        </div>
                    </div>

                 <div class="col-md-6">
                        <div class="form-group">
                            <label>抽检基数（KG） </label>
                            <input type="text" name="product_select"  class="form-control"   value="<?php echo (isset($info['product_select']) && ($info['product_select'] !== '')?$info['product_select']:''); ?>" placeholder="请输入抽检基数" />
                        </div>
                </div>
                <div class="col-md-6">
                        <div clas="form-group">
                            <label>检测是否合格</label>
                            <select name="is_qualified" class="form-control">
                                   <option value="0">不合格</option>
                                   <option value="1">合格</option>
                            </select>
                        </div>
                    </div>

                <div class="col-md-6">
                        <div clas="form-group">
                            <label>备注</label>
                            <div><textarea name="remark" class="form-control"><?php echo (isset($info['remark']) && ($info['remark'] !== '')?$info['remark']:''); ?></textarea></div>
                        </div>
                </div>
                
                <input type="hidden" name="id" value="<?php echo (isset($info['id']) && ($info['id'] !== '')?$info['id']:'0'); ?>"/>
            
                
            </div>
        </div>
    </div>
    
    <div class='plus_box'>
        
    </div>
    
    <div class="box-footer">

        <button type="" class="btn ladda-button addNew " data-style="slide-up"   >
            <span class="ladda-label"><i class="fa fa-plus"></i> 添 加</span>
        </button>
        <a class="btn finish" ><i class="fa fa-history"></i> 完 成</a>

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




    //选择商品，解决js生成HTML文件无法选中的问题
    $('body').on('mouseover','#selectGoods',function(){
        $(this).selectPage({
                showField: 'name',
                keyField: 'id',
                data: '/ps/inspection/getGoodsInfo',
                pageSize: 8,
                formatItem : function(data){
                    return  data.name;
                },
                eAjaxSuccess: function (data) {
                    var result;
                    if (data) result = data;
                    else result = undefined;
                    return result;
                },
                // 选中商品自动完成后;执行事件
                eSelect : function(data){

                    // 清除搜索框内容
                    //$(this).val(data.name)

                },
            });
    })

    //选择供货商，解决js生成HTML文件无法选中的问题
    $('body').on('mouseover','#selectProvider',function(){
        $(this).selectPage({
                showField: 'name',
                keyField: 'id',
                data: '/ps/inspection/getProvidersInfo',
                pageSize: 8,
                formatItem : function(data){
                    return  data.name;
                },
                eAjaxSuccess: function (data) {
                    var result;
                    if (data) result = data;
                    else result = undefined;
                    return result;
                },
                // 选中商品自动完成后;执行事件
                eSelect : function(data){

                    // 清除搜索框内容
                    // $('#selectGoods').selectPageClear();
                    //$(this).val(data.name)

                },
            });
    })


    //完成按钮事件监控
    $('.finish').click(function(){
        _sure = confirm('当前表单信息填写完毕？');
        if(_sure){
            window.location.href='inspectionlist.html';
        }
    })

    //添加新的表数据
     var content = $('body form .box-body').html();

     $('.addNew').click(function(e){
        e.preventDefault();
        formData = $('form').serialize();
        $.post('',formData,function(d){
            d.stop = true;
            obalert(d);
            //前一条数据提交成功之后，锁定之前表单字段，生成新的表单
            if(d.code === 1){
                $('form input').attr('disabled','disabled');
                $('form textarea').attr('disabled','disabled');
                $('form select').attr('disabled','disabled');
                $('input[name="inspect_time"]').attr('name','old_time')
                $('.plus_box').append("<div class='box-footer'>"+content+'</div><br/>');
                var mydate = new Date();
                h = mydate.getHours();
                i = mydate.getMinutes();
                //将隐藏id更改为RECORD_ID,即将所有当前数据关联起来
                $('input[name="id"]').attr('name','record_id')
                $('input[name="inspect_time"]').val(h+':'+i);
                $('input[name="record_id"]').val(d.data);
            }
        })


      
     })

     //表单INPUT不为空判断
     function basicCheck(name){
        names = name.split(',');
        console.log(names);
        for (var i = names.length - 1; i >= 0; i--) {
            if($('input[name="'+names[i]+'"]').val() == ''){
                return false
            }
        }
   
        return true;
     }
</script>