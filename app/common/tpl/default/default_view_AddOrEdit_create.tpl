<form action="{:url()}" method="post" class="form_single">
    <div class="box">
        <div class="box-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>名称</label>
                        <span>（name字段的名称）</span>
                        <input class="form-control" name="name" placeholder="请输入名称" value="{$info['name']|default=''}" type="text">
                    </div>
                </div>

{$data}

            </div>
        </div>
    </div>



    <div class="box-footer">

        <input type="hidden" name="id" value="{$info['id']|default='0'}"/>

        {include file="layout/edit_btn_group"/}
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