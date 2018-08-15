<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:63:"D:\PHPTutorial\WWW\geek\public/../app/ps\view\aaa\aaa_list.html";i:1533356140;}*/ ?>
<div class="box">
    <div class="box-header">

        <ob_link><a class="btn" href="<?php echo url('aaaAdd'); ?>"><i class="fa fa-plus"></i> 新 增</a></ob_link>

        <div class="box-tools">
            <div class="input-group input-group-sm search-form">
                <input name="search_data" class="pull-right search-input" value="<?php echo input('search_data'); ?>" placeholder="支持名称" type="text">
                <div class="input-group-btn">
                    <button type="button" id="search" url="<?php echo url('aaaList'); ?>" class="btn btn-default"><i class="fa fa-search"></i></button>
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
                        <td><ob_link><a class="ajax-get" href="<?php echo url('setStatus', array('ids' => $vo['id'], 'status' => (int)!$vo['status'])); ?>"><?php echo $vo['status_text']; ?></a></ob_link></td>
                        <td class="col-md-2 text-center">
                            <ob_link><a href="<?php echo url('aaaEdit', array('id' => $vo['id'])); ?>" class="btn"><i class="fa fa-edit"></i> 编 辑</a></ob_link>
                            &nbsp;
                            <ob_link><a class="btn confirm ajax-get"  href="<?php echo url('aaaDel', array('id' => $vo['id'])); ?>"><i class="fa fa-trash-o"></i> 删 除</a></ob_link>
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