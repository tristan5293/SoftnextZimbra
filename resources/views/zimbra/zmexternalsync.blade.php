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

            function submitSync(){
                $('#btnSubmitSync').linkbutton('disable');
                $('#sync_form').form('submit', {
                    url:'/sync_submit',
                    success:function(data){
                        $('#sync_result').textbox('setText', data);
                        $('#btnSubmitSync').linkbutton('enable');
                    }
                });
            }
        </script>
    </head>
    <body>
		    <div id="inner_layout" class="easyui-layout" style="width:100%;height:565px;">
            <form class="easyui-form" id="sync_form" name="sync_form" method="post">
            {{ csrf_field() }}
            <table>
                <tr>
                    <td>
                        <a href="javascript:void(0)" class="easyui-linkbutton" id="btnSubmitSync"
                           style="width:75px;height:32px" onclick="submitSync()">
                           帳號同步
                        </a>
                    </td>
                </tr>
            </table>
            </form>
            <input class="easyui-textbox" id="sync_result" name="sync_result" style="width:100%;height:500px"
                   data-options="multiline:true,readonly:true"/>
		    </div>
    </body>
</html>
