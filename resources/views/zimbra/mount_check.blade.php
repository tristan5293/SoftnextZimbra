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

            function submitZimbraMountCheck(){
                $('#btnSubmit').linkbutton('disable');
                $('#mount_check_form').form('submit', {
                    url:'/zimbraMountCheck',
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
            <form class="easyui-form" id="mount_check_form" name="mount_check_form" method="post">
            {{ csrf_field() }}
            <table>
                <tr>
                    <td>
                        <a href="javascript:void(0)" class="easyui-linkbutton" id="btnSubmit"
                           style="width:150px;height:32px" onclick="submitZimbraMountCheck()">
                           Zimbra掛載檢查
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
