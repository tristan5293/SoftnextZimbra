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

        function submitForm(){
            $('#btnSubmit').linkbutton('disable');
            $('#form_ldap_sync').form('submit', {
                url:'/ldapsync_data',
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
        <form class="easyui-form" id="form_ldap_sync" name="form_ldap_sync" method="post">
        {{ csrf_field() }}
        <table>
            <tr>
                <td>
                     伺服器及通訊埠 :
                </td>
                <td>
                    <input class="easyui-textbox" id="master_url" name="master_url" value="{{ $master_url }}"
                           style="width:350px;height:32px" prompt="ldap://192.168.1.1:389" data-options="">
                </td>
            </tr>
            <tr>
                <td>
                    過濾條件 :
                </td>
                <td>
                    <input class="easyui-textbox" id="master_filter" name="master_filter" value="{{ $master_filter }}"
                           style="width:350px;height:32px" prompt="objectClass=Person" data-options="">
                </td>
            </tr>
            <tr>
                <td>
                    搜尋路徑 :
                </td>
                <td>
                    <input class="easyui-textbox" id="master_search_base" name="master_search_base" value="{{ $master_search_base }}"
                           style="width:350px;height:32px" prompt="dc=softnext,dc=com,dc=tw" data-options="">
                </td>
            </tr>
            <tr>
                <td>
                    帳號 :
                </td>
                <td>
                    <input class="easyui-textbox" id="master_bind_user" name="master_bind_user" value="{{ $master_bind_user }}"
                           style="width:350px;height:32px" prompt="administrator" data-options="">
                </td>
            </tr>
            <tr>
                <td>
                    密碼 :
                </td>
                <td>
                    <input class="easyui-textbox" id="master_bind_password" name="master_bind_password" value="{{ $master_bind_password }}"
                           style="width:350px;height:32px" type="password" prompt="123456" data-options="">
                </td>
            </tr>
            <tr>
                <td>
                    LDAP Timeout :
                </td>
                <td>
                    <input class="easyui-textbox" id="master_bind_timeout" name="master_bind_timeout" value="{{ $master_bind_timeout }}"
                           style="width:350px;height:32px" prompt="200" data-options="">
                </td>
            </tr>
            <tr>
                <td>
                    LogLevel :
                </td>
                <td>
                    <input class="easyui-textbox" id="log_level" name="log_level" value="{{ $log_level }}"
                           style="width:350px;height:32px" prompt="2" data-options="">
                </td>
            </tr>
            <tr>
                <td>
                    本機例外帳號 :
                </td>
                <td>
                    <input class="easyui-textbox" id="local_ignore" name="local_ignore" value="{{ $local_ignore }}"
                           style="width:350px;height:32px" prompt="user1@softnext.com.tw,user2@softnext.com.tw" data-options="">
                </td>
            </tr>
            <tr>
                <td>
                    AD例外帳號 :
                </td>
                <td>
                    <input class="easyui-textbox" id="master_ignore" name="master_ignore" value="{{ $master_ignore }}"
                           style="width:350px;height:32px" prompt="user1@softnext.com.tw,user2@softnext.com.tw" data-options="">
                </td>
            </tr>
            <tr>
                <td>
                    人員姓名欄位 :
                </td>
                <td>
                    <input class="easyui-textbox" id="attribute_map_attr_displayName" value="{{ $attribute_map_attr_displayName }}"
                           name="attribute_map_attr_displayName" prompt="cn"
                           style="width:350px;height:32px" data-options="">
                </td>
            </tr>
            <tr>
                <td>
                    <a href="javascript:void(0)" class="easyui-linkbutton" id="btnSubmit"
                       style="width:75px;height:32px" onclick="submitForm()">
                       確定
                    </a>
                </td>
            </tr>
        </table>
        </form>
    </body>
</html>
