<!DOCTYPE html>
<html>
    <head>
        @include('header')
        <script type="text/javascript">
        $(function(){
            $('#main_layout').layout('resize', {
	              height:parseInt(window.innerHeight*0.9)
            });
        });

        function addTab(id, name, src){
            if ($('#tabs_zimbra').tabs('exists', name)){
                $('#tabs_zimbra').tabs('select', name);
            } else {
                var content = "<iframe id='"+id+"' src='"+src+"' style='width:100%;height:99%;' scrolling='no' frameborder='0'></iframe>";
                if(id == "dashboard" || id == "dashboard_ad"){
                    $('#tabs_zimbra').tabs('add',{
                        title:name,
                        content:content,
                        closable:false
                    });
                }else{
                    $('#tabs_zimbra').tabs('add',{
                        title:name,
                        content:content,
                        closable:true
                    });
                }
            }
        }

        function proc_link(action){
            switch (action) {
                case 'inactivity':
                    addTab('ad_inactivity_list', '{{ trans('lang.ad_log_inactivity_query') }}', 'netwrix/adLog/rankingsList/inactivity');
                    break;
                default:
            }
        }
        </script>
    </head>
    <body>
        <div id="main_layout" class="easyui-layout" style="width:100%;height:615px;">
            <div id="zimbra" data-options="region:'west',split:true" title="zimbra"
                  style="width:330px;padding:0px;overflow:hidden;height:100%">
                <div id="gttPanels" class="easyui-accordion" fit="true" border="false" style="height:100%;">
                    <div title="連線設定" style="padding:8px;overflow:auto;height:100%">
                        <div style="padding:10px;cursor:pointer;"
                             onClick="addTab('tcp_ipv4', 'TCP/IPv4', '/tcp_ipv4');">
                            <li style="font-size:16px;">TCP/IPv4</li>
                        </div>
                    </div>
                    <div title="日期時間" style="padding:8px;overflow:auto;height:100%">
                        <div style="padding:10px;cursor:pointer;"
                             onClick="addTab('tzselect', '時區', '/timezone');">
                            <li style="font-size:16px;">時區</li>
                        </div>
                        <div style="padding:10px;cursor:pointer;"
                             onClick="addTab('localtime', '網際網路時間', '/localtime');">
                            <li style="font-size:16px;">網際網路時間</li>
                        </div>
                        <div style="padding:10px;cursor:pointer;"
                             onClick="addTab('time_server_list', '校時伺服器清單', '/time_server_list');">
                            <li style="font-size:16px;">校時伺服器清單</li>
                        </div>
                    </div>
                    <div title="系統設定" style="padding:8px;overflow:auto;height:100%">
                        <div style="padding:10px;cursor:pointer;"
                             onClick="addTab('check_log', '查看Log', '/check_log');">
                            <li style="font-size:16px;">查看Log</li>
                        </div>
                        <div style="padding:10px;cursor:pointer;"
                             onClick="addTab('reboot', '系統設定', '/reboot');">
                            <li style="font-size:16px;">系統重啟</li>
                        </div>
                    </div>
                </div>
            </div>
            <div data-options="region:'center'" title="">
                <div class="easyui-tabs" fit="true" border="false" id="tabs_zimbra"></div>
            </div>
        </div>
    </body>
</html>
