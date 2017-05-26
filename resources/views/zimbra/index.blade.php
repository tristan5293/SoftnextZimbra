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
            <div id="zimbra" data-options="region:'west',split:true" title="eTool"
                  style="width:330px;padding:0px;overflow:hidden;height:100%">
                <div id="gttPanels" class="easyui-accordion" fit="true" border="false" style="height:100%;">
                    <div title="帳號同步" style="padding:8px;overflow:auto;height:100%">
                        <div style="padding:10px;cursor:pointer;"
                             onClick="addTab('zmexternalsync', '帳號同步', '/zmexternalsync');">
                            <li style="font-size:16px;">帳號同步</li>
                        </div>
                        <!--
                        <div style="padding:10px;cursor:pointer;"
                             onClick="addTab('ldapsync', '同步設定', '/ldapsync');">
                            <li style="font-size:16px;">同步設定</li>
                        </div>
                      -->
                    </div>
                    <div title="Log查詢" style="padding:8px;overflow:auto;height:100%">
                        <div style="padding:10px;cursor:pointer;"
                             onClick="addTab('zimbra_log', 'zimbra.log', '/zimbra_log');">
                            <li style="font-size:16px;">zimbra.log&nbsp;(外部信件記錄)</li>
                        </div>
                        <div style="padding:10px;cursor:pointer;"
                             onClick="addTab('mailbox_log', 'mailbox.log', '/mailbox_log');">
                            <li style="font-size:16px;">mailbox.log&nbsp;(內部信件記錄)</li>
                        </div>
                        <div style="padding:10px;cursor:pointer;"
                             onClick="addTab('audit_log', 'audit.log', '/audit_log');">
                            <li style="font-size:16px;">audit.log&nbsp;(POP3 log)</li>
                        </div>
                        <div style="padding:10px;cursor:pointer;"
                             onClick="addTab('access_log', 'access.log', '/access_log');">
                            <li style="font-size:16px;">access.log&nbsp;(ActiveSync Log)</li>
                        </div>
                    </div>
                    <div title="硬碟空間及掛載檢查" style="padding:8px;overflow:auto;height:100%">
                        <div style="padding:10px;cursor:pointer;"
                             onClick="addTab('mount_check', 'Zimbra掛載檢查', '/mount_check');">
                            <li style="font-size:16px;">Zimbra掛載檢查</li>
                        </div>
                    </div>
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
                    <div title="系統重啟" style="padding:8px;overflow:auto;height:100%">
                        <div style="padding:10px;cursor:pointer;"
                             onClick="addTab('reboot', '系統重啟', '/reboot');">
                            <li style="font-size:16px;">系統重啟</li>
                        </div>
                        <div style="padding:10px;cursor:pointer;"
                             onClick="addTab('service', '服務重啟', '/service');">
                            <li style="font-size:16px;">服務重啟</li>
                        </div>
                    </div>
                    <div title="系統設定" style="padding:8px;overflow:auto;height:100%">
                        <div style="padding:8px;cursor:pointer;" onClick="addTab('admin_pwd_change',
                             '更改管理者密碼', '/admin_pwd_change');">
                            <li style="font-size:16px;">更改管理者密碼</li>
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
