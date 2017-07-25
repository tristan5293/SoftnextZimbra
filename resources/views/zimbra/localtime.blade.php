<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="expires" content="Fri, 12 Jan 2001 18:18:18 GMT">
        <meta http-equiv="Pragma" content="no-cache">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="stylesheet" type="text/css" href="/css/easyui.css">
        <link rel="stylesheet" type="text/css" href="/css/icon.css">
        <style>
            table, td {
                border-collapse: collapse;
            }

            td {
                padding: 5px;
                text-align: left;
            }
        </style>
        <script type="text/javascript" src="/js/jquery.min.js"></script>
        <script type="text/javascript">
    	      $(function(){
                currentLocalTime();
		        });

            function currentLocalTime(){
                axios.get('/api/get_server_time')
                  .then(function (response) {
                    $('#lbltxtdate').text(response.data);
                  })
                  .catch(function (error) {
                    //console.log(error);
                  });
                setTimeout("currentLocalTime()", 1000);
            }

            function addZero(i) {
                if (i < 10) {
                    i = "0" + i;
                }
                return i;
            }

            function submitForm(){
                $('#btnSubmit').linkbutton('disable');
                $('#local_time_config').form('submit', {
                    url:'/localtime',
                    onSubmit:function(){
                        if(!$(this).form('validate')){
                            $('#btnSubmit').linkbutton('enable');
                        }
                        return $(this).form('validate');
                    },
                    success:function(data){
                        $.messager.alert('', data, '', function(){
                            location.reload();
                        });
                    }
                });
            }
        </script>
    </head>
    <body>
        <form class="easyui-form" id="local_time_config" name="local_time_config" method="post">
        {{ csrf_field() }}
        <table>
            <tr>
                <td>
                    立即校時 :
                </td>
                <td>
                    <select class="easyui-combobox" id="localtime" name="localtime"
                            style="width:200px;height:32px;"
                            data-options="
                                editable:false,
                                url:'/localtime/data',
                                method: 'get',
                                valueField:'id',
                                textField: 'text'">
                    </select>
                    <a href="javascript:void(0)" class="easyui-linkbutton" id="btnSubmit"
                       name="btnSubmit" style="width:75px;height:32px" onclick="submitForm()">
                       確定
                    </a>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    目前系統時間 : <label id="lbltxtdate" style="color:#CC66FF"/>
                </td>
            </tr>
        </table>
        </form>
        <script language="javascript" type="text/javascript">
        $(function(){
            Echo.channel('DelAttention')
                .listen('ReceiveTimeSrvDelAttentionEvent', (e) => {
                     $('#localtime').combobox('reload');
            });
        });
        </script>
        <script>window.Laravel = <?php echo json_encode([ 'csrfToken' => csrf_token() ]); ?></script>
        <script type="text/javascript" src="/js/app.js"></script>
        <script type="text/javascript" src="/js/jquery.easyui.min.js"></script>
        <script type="text/javascript" src="/js/axios.min.js"></script>
    </body>
</html>
