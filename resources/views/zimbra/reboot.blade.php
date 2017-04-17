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

            function submitShutdown(){
                $.messager.confirm('Ubuntu Shutdown', 'Shutdown Yes or No?', function(r){
                    if (r){
                        $('#btnSubmit').linkbutton('disable');
                        $('#pre_config').form('submit', {
                            url:'/shutdown',
                            success:function(data){
                              /*
                                $.messager.alert('', data, '', function(){
                                    $('#btnSubmit').linkbutton('enable');
                                });
                              */
                            }
                        });
                        $.messager.alert('', '系統關閉中，請手動關閉目前頁面', '', function(){
                            window.open('', '_self', '');
                            window.close();
                        });
                    }
                });
            }

            function submitReboot(){
                $.messager.confirm('Ubuntu Reboot', 'Reboot Yes or No?', function(r){
                    if (r){
                        $('#btnSubmit3').linkbutton('disable');
                        $('#pre_config').form('submit', {
                            url:'/reboot',
                            success:function(data){
                              /*
                                $.messager.alert('', data, '', function(){
                                    $('#btnSubmit3').linkbutton('enable');
                                });
                              */
                            }
                        });
                        $.messager.alert('', '系統重啟中，請手動關閉目前頁面', '', function(){
                            window.open('', '_self', '');
                            window.close();
                        });
                    }
                });
            }
        </script>
    </head>
    <body>
		    <div id="inner_layout" class="easyui-layout" style="width:100%;height:565px;">
            <form class="easyui-form" id="pre_config" name="pre_config" method="post">
            {{ csrf_field() }}
            <table>
                <tr>
                    <td>
                        Ubuntu Shutdown
                    </td>
                    <td>
                        <a href="javascript:void(0)" class="easyui-linkbutton" id="btnSubmit"
                           style="width:75px;height:32px" onclick="submitShutdown()">
                           Shutdown
                        </a>
                    </td>
                </tr>
                <tr>
                    <td>
                        Ubuntu Reboot
                    </td>
                    <td>
                        <a href="javascript:void(0)" class="easyui-linkbutton" id="btnSubmit3"
                           style="width:75px;height:32px" onclick="submitReboot()">
                           Reboot
                        </a>
                    </td>
                </tr>
            </table>
            </form>
		    </div>
    </body>
</html>
