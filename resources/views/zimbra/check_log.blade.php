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

            function submitCheckLog(){
                $('#btnSubmit2').linkbutton('disable');
                $('#pre_config').form('submit', {
                    url:'/checkLog',
                    success:function(data){
                        $('#checkLog').textbox('setText', data);
                        $('#btnSubmit2').linkbutton('enable');
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
                        Test Check log
                    </td>
                    <td>
                        <input class="easyui-textbox" id="keyword" name="keyword"
                               style="width:300px;height:32px" data-options="">
                        <a href="javascript:void(0)" class="easyui-linkbutton" id="btnSubmit2"
                           style="width:75px;height:32px" onclick="submitCheckLog()">
                           CheckLog
                        </a>
                    </td>
                </tr>
            </table>
            </form>
            <input class="easyui-textbox" id="checkLog" name="checkLog" style="width:100%;height:500px"
                   data-options="multiline:true,readonly:true"/>
		    </div>
    </body>
</html>
