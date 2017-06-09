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
                currentLocalTime();
		        });

            function currentLocalTime(){
                var param1 = new Date();
                var param2 = param1.getFullYear() + '-' +
                             (param1.getMonth() + 1) + '-' +
                             param1.getDate() + ' ' +
                             addZero(param1.getHours()) + ':' +
                             addZero(param1.getMinutes()) + ':' +
                             addZero(param1.getSeconds());
                $('#lbltxtdate').text(param2)
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
    </body>
</html>
