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
                $('#result').textbox({
                    height: $(window).height() - 50,
                });

                $('#send_date_form').datebox().datebox('calendar').calendar({
                    validator: function(date){
                        var now = new Date();
                        var d1 = new Date(now.getFullYear(), now.getMonth(), now.getDate());
                        return d1>=date;
                    }
                });
                $('#send_date_to').datebox().datebox('calendar').calendar({
                    validator: function(date){
                        var now = new Date();
                        var d1 = new Date(now.getFullYear(), now.getMonth(), now.getDate());
                        return d1>=date;
                    }
                });
                $('#send_date_form').datebox({
                    editable:false,
                    showSeconds:false,
                    //formatter 是在顯示時如何選擇日期後將其格式化為所需的格式.
                    formatter:function(date){ return date.getFullYear()+'-'+(date.getMonth()+1)+'-'+date.getDate(); },
                    //parser 是在選擇好日期後告訴控件如何去解析自定義的格式.
                    parser:function(date){ return new Date(Date.parse(date.replace(/-/g,"/"))); }
                });
                $('#send_date_to').datebox({
                    editable:false,
                    showSeconds:false,
                    //formatter 是在顯示時如何選擇日期後將其格式化為所需的格式.
                    formatter:function(date){ return date.getFullYear()+'-'+(date.getMonth()+1)+'-'+date.getDate(); },
                    //parser 是在選擇好日期後告訴控件如何去解析自定義的格式.
                    parser:function(date){ return new Date(Date.parse(date.replace(/-/g,"/"))); }
                });
                var d = new Date();
                $('#send_date_form').datebox('setValue', d.getFullYear()+'-'+(d.getMonth()+1)+'-'+d.getDate());
                $('#send_date_to').datebox('setValue', d.getFullYear()+'-'+(d.getMonth()+1)+'-'+d.getDate());
		        });

            function submitCheckSysLog(){
                $('#btnSubmit').linkbutton('disable');
                $('#sys_log_form').form('submit', {
                    url:'/checkSysLog',
                    success:function(data){
                        $('#result').textbox('setText', data);
                        $('#btnSubmit').linkbutton('enable');
                    }
                });
            }
        </script>
    </head>
    <body>
        <form class="easyui-form" id="sys_log_form" name="sys_log_form" method="post">
        {{ csrf_field() }}
        <table>
            <tr>
                <td>
                    作業系統紀錄
                </td>
                <td>
                    <input class="easyui-textbox" id="keyword" name="keyword"
                           style="width:300px;height:32px" data-options="prompt:'請輸入欲查詢之關鍵字'">
                    <a href="javascript:void(0)" class="easyui-linkbutton" id="btnSubmit"
                       style="width:75px;height:32px" onclick="submitCheckSysLog()">
                       送出
                    </a>
                </td>
            </tr>
        </table>
        </form>
        <input class="easyui-textbox" id="result" name="result" style="width:100%;"
               data-options="multiline:true,readonly:true"/>
    </body>
</html>
