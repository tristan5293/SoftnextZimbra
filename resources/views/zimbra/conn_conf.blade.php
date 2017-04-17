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
                $.extend($.fn.validatebox.defaults.rules, {
                    ip: {
                        validator: function (value) {
                          var reg = /^((1?\d?\d|(2([0-4]\d|5[0-5])))\.){3}(1?\d?\d|(2([0-4]\d|5[0-5])))$/;
                          return reg.test(value);
                        },
                        message: 'IP地址格式不正確'
                    },
                });
		        });

            function submitConnData(){
                $('#btnSubmit').linkbutton('disable');
                $('#conn_config').form('submit', {
                    url:'/update_network_config',
                    onSubmit:function(){
                        if(!$(this).form('validate')){
                            $('#btnSubmit').linkbutton('enable');
                        }
                        return $(this).form('validate');
                    },
                    success:function(data){
                      /*
                        $.messager.alert('', data, '', function(){
                            location.reload();
                        });
                      */
                    }
                });
                $.messager.alert('', '系統重啟中，請稍後使用', '', function(){
                    window.open('', '_self', '');
                    window.close();
                });
            }
        </script>
    </head>
    <body>
		    <div id="inner_layout" class="easyui-layout" style="width:100%;height:565px;">
            <form class="easyui-form" id="conn_config" name="conn_config" method="post">
            {{ csrf_field() }}
            <table>
                <tr>
                    <td>
                        IP :
                    </td>
                    <td>
                        <input class="easyui-validatebox textbox" id="ip" name="ip" missingMessage="{{ trans('lang.required') }}"
                               style="width:150px;height:32px" data-options="required:true,validType:'ip'" value="{{ $address }}">
                    </td>
                </tr>
                <tr>
                    <td>
                        Netmask :
                    </td>
                    <td>
                        <input class="easyui-validatebox textbox" id="netmask" name="netmask" missingMessage="{{ trans('lang.required') }}"
                               style="width:150px;height:32px" data-options="required:true,validType:'ip'" value="{{ $netmask }}">
                    </td>
                </tr>
                <tr>
                    <td>
                        Gateway :
                    </td>
                    <td>
                        <input class="easyui-validatebox textbox" id="gateway" name="gateway" missingMessage="{{ trans('lang.required') }}"
                               style="width:150px;height:32px" data-options="required:true,validType:'ip'" value="{{ $gateway }}">
                    </td>
                </tr>
                <tr>
                    <td>
                        慣用 DNS :
                    </td>
                    <td>
                        <input class="easyui-validatebox textbox" id="master_dns" name="master_dns" missingMessage="{{ trans('lang.required') }}"
                               style="width:150px;height:32px" data-options="required:true,validType:'ip'" value="{{ $dns1 }}">
                    </td>
                </tr>
                <tr>
                    <td>
                        其他 DNS :
                    </td>
                    <td>
                        <input class="easyui-validatebox textbox" id="slave_dns" name="slave_dns" missingMessage="{{ trans('lang.required') }}"
                               style="width:150px;height:32px" data-options="validType:'ip'" value="{{ $dns2 }}">
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <div id="warning" name="warning" style='padding:5px;color:#ff0000;'>
                            {{ $msg }}
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <div style='color:#ff0000;'>注意 : 更動網路設定系統將會重新啟動</div>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <a href="javascript:void(0)" class="easyui-linkbutton" id="btnSubmit"
                           style="width:75px;height:32px" onclick="submitConnData()">
                           確定
                        </a>
                    </td>
                </tr>
            </table>
            </form>
		    </div>
    </body>
</html>
