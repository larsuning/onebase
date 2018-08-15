<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:69:"D:\PHPTutorial\WWW\geek\public/../app/ps\view\member\member_list.html";i:1533087617;}*/ ?>
<div class="box">
  <div class="box-header ">
    
    <ob_link><a class="btn" href="<?php echo url('memberAdd'); ?>"><i class="fa fa-plus"></i> 新 增</a></ob_link>
    &nbsp;
    <ob_link><a class="btn export" url="<?php echo url('exportMemberList'); ?>"><i class="fa fa-download"></i> 导 出</a></ob_link>
    
    <div class="box-tools ">
        <div class="input-group input-group-sm search-form">
            <input name="search_data" class="pull-right search-input" value="<?php echo input('search_data'); ?>" placeholder="支持昵称|用户名|邮箱|手机" type="text">
            <div class="input-group-btn">
              <button type="button" id="search" url="<?php echo url('memberlist'); ?>" class="btn btn-default"><i class="fa fa-search"></i></button>
            </div>
        </div>
    </div>
    <br/>
  </div>
    
  <div class="box-body table-responsive">
    <table  class="table table-bordered table-hover">
      <thead>
      <tr>
          <th>昵称</th>
          <th>用户名</th>
          <th>邮箱</th>
          <th>手机</th>
          <th>注册时间</th>
          <th>上级</th>
          <th>状态</th>
          <th>操作</th>
      </tr>
      </thead>
      
      <?php if(!(empty($list) || (($list instanceof \think\Collection || $list instanceof \think\Paginator ) && $list->isEmpty()))): ?>
        <tbody>
            <?php if(is_array($list) || $list instanceof \think\Collection || $list instanceof \think\Paginator): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                <tr>
                  <td><?php echo $vo['nickname']; ?></td>
                  <td><?php echo $vo['username']; ?></td>
                  <td><?php echo (isset($vo['email']) && ($vo['email'] !== '')?$vo['email']:'未绑定'); ?></td>
                  <td><?php echo (isset($vo['mobile']) && ($vo['mobile'] !== '')?$vo['mobile']:'未绑定'); ?></td>
                  <td><?php echo $vo['create_time']; ?></td>
                  <td><?php echo $vo['leader_nickname']; ?></td>
                  <td><?php echo $vo['status_text']; ?></td>
                  <td class="col-md-3 text-center">
                      <ob_link><a href="<?php echo url('memberEdit', array('id' => $vo['id'])); ?>" class="btn"><i class="fa fa-edit"></i> 编 辑</a></ob_link>
                      &nbsp;
                      <ob_link><a class="btn"  href="<?php echo url('memberAuth', array('id' => $vo['id'])); ?>"><i class="fa fa-user-plus"></i> 授 权</a></ob_link>
                      &nbsp;
                      <ob_link><a class="btn confirm ajax-get"  href="<?php echo url('memberDel', array('id' => $vo['id'])); ?>"><i class="fa fa-trash-o"></i> 删 除</a></ob_link>
                  </td>
                </tr>
            <?php endforeach; endif; else: echo "" ;endif; ?>
        </tbody>
        <?php else: ?>
        <tbody><tr class="odd"><td colspan="8" class="text-center" valign="top"><?php echo config('empty_list_describe'); ?></td></tr></tbody>
      <?php endif; ?>
    </table>
  </div>

  <div class="box-footer clearfix text-center">
      <?php echo $list->render(); ?>
  </div>

</div>

<script>
    //导出功能
    $(".export").click(function(){
        
        window.location.href = searchFormUrl($(".export"));
    });
</script>