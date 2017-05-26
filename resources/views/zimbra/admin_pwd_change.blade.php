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
            $('#form_admin_pwd_change').form('submit', {
                url:'/pwdChange',
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

        function resetForm(){
            $('#btnReset').linkbutton('disable');
            $.ajaxSetup({
                headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.get("/pwdReset",
                function(data){
                    $.messager.alert('', data, '', function(){
                        location.reload();
                    });
                }
            );
        }

        </script>
    </head>
    <body>
        <form class="easyui-form" id="form_admin_pwd_change" name="form_admin_pwd_change" method="post">
        {{ csrf_field() }}
        <table>
            <tr>
                <td>
                    舊密碼 :
                </td>
                <td>
                    <input class="easyui-textbox" data-options="required:true, prompt:'Password'"
                           missingMessage="請輸入資料"
                           type="password" id="old_pwd" name="old_pwd" style="width:150px;height:32px"/>
                </td>
            </tr>
            <tr>
                <td>
                    新密碼 :
                </td>
                <td>
                    <input class="easyui-textbox" data-options="required:true, prompt:'Password'"
                           missingMessage="請輸入資料"
                           type="password" id="new_pwd" name="new_pwd" style="width:150px;height:32px"/>
                </td>
            </tr>
            <tr>
                <td>
                    確認密碼 :
                </td>
                <td>
                    <input class="easyui-textbox" data-options="required:true, prompt:'Password'"
                           missingMessage="請輸入資料"
                           type="password" id="new_pwd_again" name="new_pwd_again"
                           style="width:150px;height:32px"/>
                </td>
            </tr>
            <tr>
                <td>
                    <a href="javascript:void(0)" class="easyui-linkbutton" id="btnSubmit"
                       style="width:75px;height:32px" onclick="submitForm()">
                       變更密碼
                    </a>
                </td>
                <td>
                    <a href="javascript:void(0)" class="easyui-linkbutton" id="btnReset"
                       style="width:75px;height:32px" onclick="resetForm()">
                       重設密碼
                    </a>
                </td>
            </tr>
        </table>
        </form>
    </body>
</html>
