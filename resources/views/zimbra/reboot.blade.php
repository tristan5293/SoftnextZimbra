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

                $('#shutdown_date').datebox().datebox('calendar').calendar({
                    validator: function(date){
                        var now = new Date();
                        var d1 = new Date(now.getFullYear(), now.getMonth(), now.getDate());
                        return d1<=date;
                    }
                });

                $('#shutdown_date').datebox({
                    editable:false,
                    showSeconds:false,
                    //formatter 是在顯示時如何選擇日期後將其格式化為所需的格式.
                    formatter:function(date){ return date.getFullYear()+'-'+(date.getMonth()+1)+'-'+date.getDate(); },
                    //parser 是在選擇好日期後告訴控件如何去解析自定義的格式.
                    parser:function(date){ return new Date(Date.parse(date.replace(/-/g,"/"))); }
                });

                var d = new Date();
                $('#shutdown_date').datebox('setValue', d.getFullYear()+'-'+(d.getMonth()+1)+'-'+d.getDate());
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

            function submitShutdownSpecific(){
                var sd = $('#shutdown_date').datebox('getValue');
                var st = $('#shutdown_time').timespinner('getValue');
                $.messager.confirm('', '指定關機日期：'+sd+' '+st, function(r){
                    if (r){
                        $('#btnSubmit2').linkbutton('disable');
                        $('#pre_config').form('submit', {
                            url:'/shutdown_specific',
                            success:function(data){
                                $.messager.alert('', data);
                            }
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
                        系統關機
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
                        系統重開機
                    </td>
                    <td>
                        <a href="javascript:void(0)" class="easyui-linkbutton" id="btnSubmit3"
                           style="width:75px;height:32px" onclick="submitReboot()">
                           Reboot
                        </a>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <hr/>
                    </td>
                </tr>
                <tr>
                    <td>
                        指定關機日期時間
                    </td>
                    <td>
                        <input id="shutdown_date" name="shutdown_date"  class="easyui-datebox"
                               style="width:120px;height:32px"></input>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <input id="shutdown_time" name="shutdown_time" class="easyui-timespinner"
                               value="00:00" style="width:75px;height:32px"></input>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <a href="javascript:void(0)" class="easyui-linkbutton" id="btnSubmit2"
                           style="width:75px;height:32px" onclick="submitShutdownSpecific()">
                           確定
                        </a>
                    </td>
                </tr>
                <tr>
                    <td>
                        下次關機時間
                    </td>
                    <td>
                    </td>
                </tr>
            </table>
            </form>
		    </div>
    </body>
</html>
