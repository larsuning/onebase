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

                {volist name='fields' id='field'}

                {switch name="field.type"}
                {case value="num"}

                    <div class="col-md-6">
                        <div clas="form-group">
                            <label>{$field.title}</label>
                            <input type="text" class="form-control" name="{$field.name}" value="{$info[$field['name']]|default=''}">
                        </div>
                    </div>
                {/case}
                {case value="string"}

                    <div class="col-md-6">
                        <div clas="form-group">
                            <label>{$field.title}</label>
                            <input type="text" class="form-control" name="{$field.name}" value="{$info[$field['name']]|default=''}">
                        </div>
                    </div>
                {/case}
                {case value="textarea"}

                    <div class="col-md-6">
                        <div clas="form-group">
                            <label>{$field.title}</label>
                            <div><textarea name="{$field.name}" class="form-control">{$info[$field['name']]|default=''}</textarea></div>
                        </div>
                    </div>

                {/case}
                {case value="date"}

                    <div class="col-md-6">
                        <div clas="form-group">
                            <label>{$field.title}</label>
                            <input type="text" name="{$field.name}"  class="form-control date"   value="{$info[$field['name']] ? date('Y-m-d',$info[$field['name']]) : date('Y-m-d',time())}" placeholder="请选择日期" />
                        </div>
                    </div>
                {/case}
                {case value="datetime"}

                    <div class="col-md-6">
                        <div clas="form-group">
                            <label>{$field.title}</label>
                            <input type="text" name="{$field.name}"  class="form-control datetime"   value="{$info[$field['name']] ? date('Y-m-d H:i',$info[$field['name']]) : date('Y-m-d H:i',time())}" placeholder="请选择日期" />
                        </div>
                    </div>

                {/case}
                {case value="bool"}

                    <div class="col-md-6">
                        <div clas="form-group">
                            <label>{$field.title}</label>
                            <select name="{$field.name}" class="form-control">
                                {volist name=":app\common\logic\common::parse_field_attr($field['extra'])" id="vo"}
                                    <option value="{$key}" {notempty name="info"}{eq name="$info[$field['name']]" value="$key"}selected{/eq}{else/}{eq name="field.value" value="$key"}selected{/eq}{/notempty}>{$vo}</option>
                                {/volist}
                            </select>
                        </div>
                    </div>

                {/case}
                {case value="select"}

                    <div class="col-md-6">
                        <div clas="form-group">
                            <label>{$field.title}</label>
                            <select name="{$field.name}" class="form-control">
                                {volist name=":app\common\logic\common::parse_field_attr($field['extra'])" id="vo"}
                                    <option value="{$key}" {notempty name="info"}{eq name="$info[$field['name']]" value="$key"}selected{/eq}{else/}{eq name="field.value" value="$key"}selected{/eq}{/notempty}>{$vo}</option>
                                {/volist}
                            </select>
                        </div>
                    </div>

                {/case}
                {case value="radio"}

                    <div class="col-md-6">
                        <div clas="form-group">
                            <label>{$field.title}</label>
                            {volist name=":app\common\logic\common::parse_field_attr($field['extra'])" id="vo"}
                                <label class="margin-r-5">
                                    <input type="radio" value="{$key}" name="{$field.name}"{notempty name="info"}{eq name="$info[$field['name']]" value="$key"}checked{/eq}{else/}{eq name="field.value" value="$key"}checked{/eq}{/notempty} >{$vo}
                                </label>
                            {/volist}
                        </div>
                    </div>

                {/case}
                {case value="checkbox"}

                    <div class="col-md-6">
                        <div clas="form-group">
                            <label>{$field.title}</label>
                            {volist name=":app\common\logic\common::parse_field_attr($field['extra'])" id="vo"}
                                <label class="margin-r-5" >
                                    <input type="checkbox" value="{$key}" name="{$field.name}[]" {notempty name="info"}{in name="$key" value="$info[$field['name']]"}checked{/in}{else/}{in name="$key" value="$field['value']"}checked{/in}{/notempty} >{$vo}
                                </label>
                            {/volist}
                        </div>
                    </div>

                {/case}

                {case value="editor"}

                    <div class="col-md-12">
                        <div clas="form-group">
                            <label>{$field.title}</label>
                            <label>文章内容</label>
                            <textarea class="form-control textarea_editor" name="{$field.name}" placeholder="请输入文章内容">{$info[$field['name']]|default=''}</textarea>
                            {:widget('editor/index', array('name'=> $field.name,'value'=> ''))}
                        </div>
                    </div>
                {/case}

                {case value="picture"}
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>上传图片</label>
                            <span class="">（请上传单张图片）</span>
                            <br/>
                            {assign name="cover_id" value="$info[$field['name']]|default=''" /}
                            {:widget('file/index', ['name' => $field.name, 'value' => $cover_id, 'type' => 'img'])}
                        </div>
                    </div>
                {/case}

                {case value="file"}
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>附件</label>
                            <span class="">（文章可下载附件）</span>
                            <br/>
                            {assign name="file_id" value="$info[$field['name']]|default='0'" /}
                            {:widget('file/index', ['name' => $field.name, 'value' => $file_id, 'type' => 'file'])}
                        </div>
                    </div>
                {/case}
                {/switch}
                {/volist}
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