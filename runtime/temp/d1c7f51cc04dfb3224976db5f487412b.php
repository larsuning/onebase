<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:71:"D:\PHPTutorial\WWW\geek\public/../app/admin\view\member\member_add.html";i:1533087617;s:75:"D:\PHPTutorial\WWW\geek\public/../app/admin\view\layout\edit_btn_group.html";i:1533087617;}*/ ?>
<form action="<?php echo url(); ?>" method="post" class="form_single">
    <div class="box">
      <div class="box-body">
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label>用户名</label>
              <span>（用户名会作为默认的昵称）</span>
              <input class="form-control" name="username" placeholder="请输入用户名" type="text">
            </div>
          </div>
 
          <div class="col-md-6">
            <div class="form-group">
              <label>密码</label>
              <span>（用户密码不能少于6位）</span>
              <input class="form-control" name="password" placeholder="请输入密码" type="password">
            </div>
          </div>
 
          <div class="col-md-6">
            <div class="form-group">
              <label>确认密码</label>
              <span>（确认密码需要和密码一致）</span>
              <input class="form-control" name="password_confirm" placeholder="请输入确认密码" type="password">
            </div>
          </div>
 
          <div class="col-md-6">
            <div class="form-group">
              <label>邮箱</label>
              <span>（用户邮箱，用于找回密码等安全操作）</span>
              <input class="form-control" name="email" placeholder="请输入邮箱" type="text">
            </div>
          </div>
    
            
          <div class="col-md-6">
            <div class="form-group">
                <label>是否共享会员</label>
                <span>（若选择共享会员自己的会员则会继承给添加的会员）</span>
                <div>
                    <label class="margin-r-5"><input type="radio" name="is_share_member" value="1"> 是</label>
                    <label><input type="radio" checked="checked" name="is_share_member"  value="0"> 否</label>
                </div>
            </div>
          </div>
            
        </div>
      </div>
      <div class="box-footer">
        
        <button  type="submit" class="btn ladda-button ajax-post" data-style="slide-up" target-form="form_single">
    <span class="ladda-label"><i class="fa fa-send"></i> 确 定</span>
</button>

<a class="btn" onclick="javascript:history.back(-1);return false;"><i class="fa fa-history"></i> 返 回</a>
      </div>
    </div>
</form>
