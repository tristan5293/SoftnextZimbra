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

            #btnDel, #btnDelCc, #btnDelBcc {
                border-radius: 4px;
                background-color: white;
                border: 2px solid #f44336;
                text-align: center;
                font-size: 12px;
                padding: 5px;
                width: 50px;
                transition: all 0.5s;
                cursor: pointer;
                margin: 5px;
            }

            .divScroll {
                overflow-y:scroll;
            }
        </style>
        <script type="text/javascript">
            var time_server_list_arr = '';
    	      $(function(){
                $('.divScroll').css('height', parseInt(window.innerHeight*0.985));

                var time_server_list = 0;
                    time_server_list_arr = $('#tmpTimeServerList').val().split(",");

                var found = '';

                for($i = 0; $i < time_server_list_arr.length; $i++){
                    if(time_server_list_arr.length == 1){
                        $('.btnTimeServerListDel').attr('disabled', true);
                    }
                    var c = $('.clonedTimeServerList:first').clone(true);
                        c.children('.spanTimeServerList').attr('name','time_server_list'+(++time_server_list));
                        c.children('.spanTimeServerList').text(time_server_list_arr[$i]);
                        c.children('.btnTimeServerListDel').removeAttr('hidden');
                    $('.clonedTimeServerList:last').after(c);
                }

                $('#btnTimeServerListAdd').click(function() {
                    if($('#time_server_list').validatebox('isValid') && $('#time_server_list').val() != ''){
                        found = $.inArray($('#time_server_list').val(), time_server_list_arr);
                        if(found == -1){
                            time_server_list_arr.push($('#time_server_list').val());
                            if($('.clonedTimeServerList').length == 2){
                                $('.btnTimeServerListDel').attr('disabled', false);
                            }
                            var c = $('.clonedTimeServerList:first').clone(true);
                                c.children('.spanTimeServerList').attr('name','time_server_list'+ (++time_server_list) );
                                c.children('.spanTimeServerList').text($('#time_server_list').val());
                                c.children('.btnTimeServerListDel').removeAttr('hidden');
                                $('.clonedTimeServerList:last').after(c);
                        }else{
                            $.messager.alert('', '已加入');
                        }
                    }
                });

                $('.btnTimeServerListDel').click(function() {
                    --time_server_list;
                    var remove_item = $(this).closest('.clonedTimeServerList').children('.spanTimeServerList').text();
                    time_server_list_arr = $.grep(time_server_list_arr, function(value) {
                        return value != remove_item;
                    });
                    $(this).closest('.clonedTimeServerList').remove();
                    $('.btnTimeServerListDel').attr('disabled',($('.clonedTimeServerList').length  == 2));
                });
		        });

            function submitForm(){
                $('#tmpTimeServerList').val(time_server_list_arr.toString());
                $('#btnSubmit').linkbutton('disable');
                $('#time_server_list_config').form('submit', {
                    url:'/time_server_list',
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
        <div class="divScroll">
            <form class="easyui-form" id="time_server_list_config"
                  name="time_server_list_config" method="post">
            {{ csrf_field() }}
            <input type="textbox" id="tmpTimeServerList" name="tmpTimeServerList"
                   value="{{ $time_server_list->server_name }}" hidden="true"/>
            <table>
                <tr>
                    <td>
                        校時伺服器 :
                    </td>
                    <td>
                        <input class="easyui-validatebox textbox" type="text" style="width:200px;height:32px"
                               data-options="" id="time_server_list" name="time_server_list"/>
                        <a id="btnTimeServerListAdd" name="btnTimeServerListAdd" href="#"
                           class="easyui-linkbutton" style="width:75px;height:32px">
                            新增
                        </a>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <div style="margin-bottom:4px;" class="clonedTimeServerList">
                            <input type="button" class="btnTimeServerListDel" id="btnDel"
                                   name="btnDel" value="Delete" hidden="true"/>
                            <span class="spanTimeServerList"/>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <a href="javascript:void(0)" class="easyui-linkbutton" id="btnSubmit"
                           style="width:75px;height:32px" onclick="submitForm()">
                           確定
                        </a>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <div style='color:#ff0000;'>說明：系統會自動於每日的 00:00 與上述主機校時，請自行確認網路是否正常。</div>
                    </td>
                </tr>
            </form>
        </div>
    </body>
</html>
