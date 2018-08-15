<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:73:"D:\PHPTutorial\WWW\geek\public/../app/ps\view\inspection\record_list.html";i:1534323203;}*/ ?>
<div class="box">
    <div class="box-header" style="margin: 15px 0;">

    

        <div class="box-tools" >
            <div class="input-group input-group-sm search-form">
                <select class="pull-left search-input "  name="search_table" placeholder="选择日期" style="margin-left: -280px!important;padding: 3px 2px;">
                    <option value="0" >选择表类型</option>  
                    <option value="1" <?php if(!(empty($_GET['search_table']) || (($_GET['search_table'] instanceof \think\Collection || $_GET['search_table'] instanceof \think\Paginator ) && $_GET['search_table']->isEmpty()))): if($_GET['search_table'] == '1'): ?>selected<?php endif; endif; ?>>农残检测</option>  
                    <option value="2" <?php if(!(empty($_GET['search_table']) || (($_GET['search_table'] instanceof \think\Collection || $_GET['search_table'] instanceof \think\Paginator ) && $_GET['search_table']->isEmpty()))): if($_GET['search_table'] == '2'): ?>selected<?php endif; endif; ?>>标品收货</option>  
                    <option value="3" <?php if(!(empty($_GET['search_table']) || (($_GET['search_table'] instanceof \think\Collection || $_GET['search_table'] instanceof \think\Paginator ) && $_GET['search_table']->isEmpty()))): if($_GET['search_table'] == '3'): ?>selected<?php endif; endif; ?>>生鲜收货</option>  
                    <option value="4" <?php if(!(empty($_GET['search_table']) || (($_GET['search_table'] instanceof \think\Collection || $_GET['search_table'] instanceof \think\Paginator ) && $_GET['search_table']->isEmpty()))): if($_GET['search_table'] == '4'): ?>selected<?php endif; endif; ?>>易耗品收货</option>  
                    <option value="5" <?php if(!(empty($_GET['search_table']) || (($_GET['search_table'] instanceof \think\Collection || $_GET['search_table'] instanceof \think\Paginator ) && $_GET['search_table']->isEmpty()))): if($_GET['search_table'] == '5'): ?>selected<?php endif; endif; ?>>分拣巡查</option>  
                    <option value="6" <?php if(!(empty($_GET['search_table']) || (($_GET['search_table'] instanceof \think\Collection || $_GET['search_table'] instanceof \think\Paginator ) && $_GET['search_table']->isEmpty()))): if($_GET['search_table'] == '6'): ?>selected<?php endif; endif; ?>>存储区巡查</option>  
                </select>
                <input type="text" class="pull-left search-input date" name="search_date" value="<?php echo input('search_date'); ?>"  placeholder="选择日期" style="margin-left: -50px!important;">
                <input name="search_data" class="pull-right search-input" value="<?php echo input('search_data'); ?>" placeholder="支持名称" type="text">
                <div class="input-group-btn">
                    <button type="button" id="search"  class="btn btn-default"><i class="fa fa-search"></i></button>
                </div>
            </div>
        </div>
    </div>

    <div class="box-body table-responsive">
        <table  class="table table-bordered table-hover">
            <thead>
            <tr>
                <th>名称</th>
                <th>商品批次/巡查班次</th>
                <th>巡检品管</th>
                <th>品质主管</th>
                <th>状态更新时间</th>
                <th>状态</th>
                <th>操作</th>
            </tr>
            </thead>

            <?php if(!(empty($list) || (($list instanceof \think\Collection || $list instanceof \think\Paginator ) && $list->isEmpty()))): ?>
                <tbody>
                <?php if(is_array($list) || $list instanceof \think\Collection || $list instanceof \think\Paginator): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                    <tr data-id='<?php echo $vo['id']; ?>' data-type='<?php echo $vo['record_type']; ?>'>
                        <td><?php echo $vo['name']; ?></td>
                        <td><?php echo $vo['goods_batch']; if($vo['shift'] != '0'): if($vo['shift'] == '1'): ?>早班<?php endif; if($vo['shift'] == '2'): ?>中班<?php endif; if($vo['shift'] == '3'): ?>晚班<?php endif; endif; ?></td>
                        <td><?php echo $vo['member']; ?></td>
                        <td><?php echo $vo['reviewer']; ?></td>
                        <td><?php echo $vo['update_time']; ?></td>
                        <td><?php switch($vo['check_status']): case "0": ?><span class='badge bg-red'>未完成</span><?php break; case "1": ?><span class='badge bg-yellow'>待审核</span><?php break; case "2": ?><span class='badge bg-green'>审核完成</span><?php break; default: ?>default
                        <?php endswitch; ?></td>
                        <td class="col-md-2 text-center">
                            <?php switch($vo['check_status']): case "0": if($vo['record_type'] == 5 || $vo['record_type'] == 6): ?>
                            <ob_link><a  class="btn edit"><i class="fa fa-edit"></i>编 辑 </a></ob_link>
                            <?php else: ?>
                            <ob_link><a  class="btn review"><i class="fa fa-edit"></i> 审 核 </a></ob_link>
                            <?php endif; break; case "1": ?> <ob_link><a  class="btn review"><i class="fa fa-edit"></i> 审 核 </a></ob_link><?php break; case "2": ?> <ob_link><a  class="btn watch" style="background: #337ab7" ><i class="fa fa-eye"></i> 查 看 </a></ob_link><?php break; default: ?>default
                        <?php endswitch; ?>
                           
                            &nbsp;
                            <button class="btn delete" ><i class="fa fa-trash-o "></i> 删 除</button>
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

</div>
<script>
    $('.date').datetimepicker({
        language:"zh-CN",
        todayHighlight:true,
        todayBtn:true,
        format:'yyyy-mm-dd',
        minView:1,
        autoclose:true,
        minView:'3'

    });
</script>
<script>   

    //搜索按钮整理 
    $('#search').click(function(){
        url = window.location.href;
        _index =  url.indexOf('?');
        if(_index > -1){
            url = url.substr(0,_index);
        }
        _data = $('input[name="search_data"]').val();
        _date = $('input[name="search_date"]').val();
        _table = $('select[name="search_table"]').val();
        if( _data =='' && _date == '' && _table =='0'){
            if(_index == -1){
                return false;
            }else{
                window.location.href=url;
            }
        }else{
            url = url+'?search_data='+_data+'&search_date='+_date+'&search_table='+_table;
            window.location.href=url;
        }


    })

    //点击删除
    $('table').on('click','.delete',function(){
        _sure = confirm('确认删除？');
        if (!_sure) return false;
        _id   = $(this).parents('tr').attr('data-id');
        _index = $(this).parents('tr').index();
        $.post('?action=recordDel',{id:_id},function(d){
            if(d.code=='1'){
                $('table tr').eq(_index+1).fadeOut();
            }else{
                obalert(b);
            }
        })
    })

    var links = ['agriculture','mark','fresh','packing','sorting','storage'];


    $('.review').click(function(){
        _type = $(this).parents('tr').attr('data-type');
        _id = $(this).parents('tr').attr('data-id');
        _checker = $(this).parents('tr').children('td').eq(2).text();
        _param = links[(_type-1)];
        
        if(_checker == ''){
            d = {"code":0,"msg":"此表格尚未完成噢"}
            obalert(d);
            return false;
        }
        url = _param+'.html?review='+_id;
        window.location.href=url;
    })

    $('.edit').click(function(){
        _type = $(this).parents('tr').attr('data-type');
        _id = $(this).parents('tr').attr('data-id');
        _param = links[(_type-1)];
        url = _param+'.html?edit='+_id;
        window.location.href=url;
    })

    $('.watch').click(function(){
         _type = $(this).parents('tr').attr('data-type');
        _id = $(this).parents('tr').attr('data-id');
        _reviewer = $(this).parents('tr').children('td').eq(3).text();


        _param = links[(_type-1)];
        if( _reviewer == ''){
            d = {"code":0,"msg":"此表格尚未审核噢"}
            obalert(d);
            return false;
        }

        url = _param+'.html?review='+_id;
        window.location.href=url;

    })

</script>