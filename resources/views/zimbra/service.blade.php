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
                $.messager.defaults.ok = 'Yes';
                $.messager.defaults.cancel = 'No';
		        });

            function submitAllSrvRestart(){
                $.messager.confirm('Restart', 'Zimbra 全部服務重啟 Yes or No?', function(r){
                    if (r){
                        $('#btnAllSrvRestart').linkbutton('disable');
                        $('#service_restart').form('submit', {
                            url:'/all_srv_restart',
                            success:function(data){
                                $.messager.alert('', data, 'info');
                                $('#btnAllSrvRestart').linkbutton('enable');
                            }
                        });
                    }
                });
            }
        </script>
    </head>
    <body>
		    <div id="inner_layout" class="easyui-layout" style="width:100%;height:565px;">
            <form class="easyui-form" id="service_restart" name="service_restart" method="post">
            {{ csrf_field() }}
            <table>
                <tr>
                    <td>
                        Zimbra 全部服務重啟
                    </td>
                    <td>
                        <a href="javascript:void(0)" class="easyui-linkbutton" id="btnAllSrvRestart"
                           name="btnAllSrvRestart" style="width:75px;height:32px" onclick="submitAllSrvRestart()">
                           Restart
                        </a>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <hr/>
                    </td>
                </tr>
            </table>
            </form>
		    </div>
    </body>
</html>
