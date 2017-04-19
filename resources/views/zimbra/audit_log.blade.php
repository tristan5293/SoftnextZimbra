<!DOCTYPE html>
<html>
    <head>
        @include('header')
        <style>
            table, td {
                border-collapse: collapse;
            }
            td {
                padding: 5px;
                text-align: left;
            }
        </style>
        <script type="text/javascript">
    	      $(function(){
		        });

            function submitCheckAuditLog(){
                $('#btnSubmit').linkbutton('disable');
                $('#audit_log_form').form('submit', {
                    url:'/checkAuditLog',
                    success:function(data){
                        $('#result').textbox('setText', data);
                        $('#btnSubmit').linkbutton('enable');
                    }
                });
            }
        </script>
    </head>
    <body>
		    <div id="inner_layout" class="easyui-layout" style="width:100%;height:565px;">
            <form class="easyui-form" id="audit_log_form" name="audit_log_form" method="post">
            {{ csrf_field() }}
            <table>
                <tr>
                    <td>
                        audit log
                    </td>
                    <td>
                        <input class="easyui-textbox" id="keyword" name="keyword"
                               style="width:300px;height:32px" data-options="">
                        <a href="javascript:void(0)" class="easyui-linkbutton" id="btnSubmit"
                           style="width:75px;height:32px" onclick="submitCheckAuditLog()">
                           送出
                        </a>
                    </td>
                </tr>
            </table>
            </form>
            <input class="easyui-textbox" id="result" name="result" style="width:100%;height:500px"
                   data-options="multiline:true,readonly:true"/>
		    </div>
    </body>
</html>
