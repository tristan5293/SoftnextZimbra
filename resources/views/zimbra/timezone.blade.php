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
                $('#zone').combobox({
                    onSelect: function(rec){
                        var url = '/country/'+rec.val;
                        $('#country').combobox('reload', url);
                    }
                });
		        });

            function submitForm(){
                var zone = $('#zone').combobox('getValue');
                var country = $('#country').combobox('getValue');
                $.messager.confirm('Change Zone', zone+'/'+country+' Change?', function(r){
                    if (r){
                        $('#btnSubmit').linkbutton('disable');
                        $('#zone_change_config').form('submit', {
                            url:'/zonechange',
                            onSubmit:function(){
                                if(!$(this).form('validate')){
                                    $('#btnSubmit').linkbutton('enable');
                                }
                                return $(this).form('validate');
                            },
                            success:function(data){
                                $.messager.alert('', data, '', function(){
                                    //location.reload();
                                    parent.location.href='/logout';
                                });
                            }
                        });
                    }
                });
            }
        </script>
    </head>
    <body>
        <form class="easyui-form" id="zone_change_config" name="zone_change_config" method="post">
        {{ csrf_field() }}
        <table>
            <tr>
                <td>
                    洲 :
                </td>
                <td>
                    <input class="easyui-combobox" id="zone" name="zone"
                            style="width:200px;height:32px;"
                            data-options="editable:false, method:'get',
                            valueField:'val', textField:'text',
                            url:'/location/zone'"/>
                </td>
            </tr>
            <tr>
                <td>
                    國家 :
                </td>
                <td>
                    <input class="easyui-combobox" id="country" name="country"
                            style="width:500px;height:32px;"
                            data-options="editable:false,
                                          valueField:'val',
                                          textField:'text',
                                          method:'get',
                                          url:'/location/Africa'"/>
                </td>
            </tr>
            <tr>
                <td>
                    目前位置 :
                </td>
                <td>
                    {{ $location }}
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <div style='color:#ff0000;'>注意 : 更動時區系統將會重新啟動</div>
                </td>
            </tr>
            <tr>
                <td>
                    <a href="javascript:void(0)" class="easyui-linkbutton" id="btnSubmit"
                       style="width:75px;height:32px" onclick="submitForm()">
                       確定
                    </a>
                </td>
                <td>
                </td>
            </tr>
        </table>
        </form>
    </body>
</html>
