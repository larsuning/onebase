<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:69:"D:\PHPTutorial\WWW\geek\public/../app/admin\view\exelog\api_list.html";i:1533087617;}*/ ?>
<div class="box">
  <div class="box-body table-responsive">
    <table  class="table table-bordered table-hover">
      <thead>
      <tr>
          <th>执行路径</th>
          <th>执行时间（单位：秒）</th>
          <th>占用内存（单位：KB）</th>
          <th>操作系统</th>
          <th>ip</th>
          <th>记录时间</th>
      </tr>
      </thead>
      
      <?php if(!(empty($list) || (($list instanceof \think\Collection || $list instanceof \think\Paginator ) && $list->isEmpty()))): ?>
        <tbody>
            <?php if(is_array($list) || $list instanceof \think\Collection || $list instanceof \think\Paginator): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                <tr>
                  <td><?php echo $vo['exe_url']; ?></td>
                  <td><?php echo $vo['exe_time']; ?></td>
                  <td><?php echo $vo['exe_memory']; ?></td>
                  <td><?php echo $vo['exe_os']; ?></td>
                  <td><?php echo $vo['ip']; ?></td>
                  <td><?php echo $vo['create_time']; ?></td>
                </tr>
            <?php endforeach; endif; else: echo "" ;endif; ?>
        </tbody>
        <?php else: ?>
        <tbody><tr class="odd"><td colspan="6" class="text-center" valign="top"><?php echo config('empty_list_describe'); ?></td></tr></tbody>
      <?php endif; ?>
    </table>
  </div>

  <div class="box-footer clearfix text-center">
      <?php echo $list->render(); ?>
  </div>

</div>