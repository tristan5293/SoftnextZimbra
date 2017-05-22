<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="expires" content="Fri, 12 Jan 2001 18:18:18 GMT">
        <meta http-equiv="Pragma" content="no-cache">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <style>
            table, td {
                border-collapse: collapse;
            }
            td {
                padding: 5px;
                text-align: left;
            }
        </style>
        <link rel="stylesheet" type="text/css" href="/css/easyui.css">
        <link rel="stylesheet" type="text/css" href="/css/icon.css">
        <script type="text/javascript" src="/js/jquery.min.js"></script>
        <script language="javascript" type="text/javascript">
            $(function(){
                $.messager.defaults.ok = 'Yes';
                $.messager.defaults.cancel = 'No';
            });

            function disableBtn(){
                $('#btnAllSrvRestart').linkbutton('disable');
                $('#btnMtaRestart').linkbutton('disable');
            }

            function EnableBtn(){
                $('#btnAllSrvRestart').linkbutton('enable');
                $('#btnMtaRestart').linkbutton('enable');
            }

            function submitAllSrvRestart(){
                $.messager.confirm('Restart', 'Zimbra 全部服務重啟 Yes or No?', function(r){
                    if (r){
                        disableBtn();
                        $('#service_restart').form('submit', {
                            url:'/all_srv_restart',
                            success:function(data){
                                $.messager.alert('', data);
                                EnableBtn();
                            }
                        });
                    }
                });
            }

            function submitMtaRestart(){
                $.messager.confirm('Restart', 'mta 服務重啟 Yes or No?', function(r){
                    if (r){
                        disableBtn();
                        $('#service_restart').form('submit', {
                            url:'/mta_srv_restart',
                            success:function(data){
                                $.messager.alert('', data);
                                EnableBtn();
                            }
                        });
                    }
                });
            }

        /*
            function submitDetailsForm() {
                $("#service_restart").submit(function(e) {
                    var postData = $(this).serializeArray();
                    var formURL = $(this).attr("action");
                    $.ajax({
                        url : formURL,
                        type: "POST",
                        data : postData,
                        success:function(data, textStatus, jqXHR){
                            $.messager.alert('', data);
                        },
                        error: function(jqXHR, textStatus, errorThrown){
                        }
                     });
                     e.preventDefault();	//STOP default action
                });
                $("#service_restart").submit(); //SUBMIT FORM
            }
        */
        </script>
        <title>Zimbra</title>
    </head>
    <body>
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
                    <td>
                        mta 服務重啟
                    </td>
                    <td>
                        <a href="javascript:void(0)" class="easyui-linkbutton" id="btnMtaRestart"
                           name="btnMtaRestart" style="width:75px;height:32px" onclick="submitMtaRestart()">
                           Restart
                        </a>
                    </td>
                </tr>
            </table>
        </form>
        <div id="app"></div>
        <input class="easyui-textbox" id="srv_restart_result" name="srv_restart_result" style="width:100%;height:300px"
               data-options="multiline:true,readonly:true"/>
        <script language="javascript" type="text/javascript">
        $(function(){
            Echo.channel('SrvRestartMsg')
                .listen('ReceiveProcessMessageEvent', (e) => {
                     var origin_data = $('#srv_restart_result').textbox('getText') + "\n";
                     $('#srv_restart_result').textbox('setText', origin_data + e.message);
            });
        });
        </script>
        <script>window.Laravel = <?php echo json_encode([ 'csrfToken' => csrf_token() ]); ?></script>
        <script type="text/javascript" src="/js/app.js"></script>
        <script type="text/javascript" src="/js/jquery.easyui.min.js"></script>
    </body>
</html>
