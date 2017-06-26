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
            <div id="zimbra" data-options="region:'west',split:true" title="E-Tool 郵件工具包"
                  style="width:330px;padding:0px;overflow:hidden;height:100%">
                <div id="gttPanels" class="easyui-accordion" fit="true" border="false" style="height:100%;">
                    <div title="帳號同步" style="padding:8px;overflow:auto;height:100%">
                        <div style="padding:10px;cursor:pointer;"
                             onClick="addTab('zmexternalsync', '立即同步', '/zmexternalsync');">
                            <li style="font-size:16px;">立即同步</li>
                        </div>
                        <div style="padding:10px;cursor:pointer;"
                             onClick="addTab('ldapsync', '同步設定', '/ldapsync');">
                            <li style="font-size:16px;">同步設定</li>
                        </div>
                    </div>
                    <div title="事件紀錄檢視" style="padding:8px;overflow:auto;height:100%">
                        <div style="padding:10px;cursor:pointer;"
                             onClick="addTab('zimbra_log', '外部信件傳送紀錄', '/zimbra_log');">
                            <li style="font-size:16px;">外部信件傳送紀錄</li>
                        </div>
                        <div style="padding:10px;cursor:pointer;"
                             onClick="addTab('mailbox_log', '內部信件收發紀錄', '/mailbox_log');">
                            <li style="font-size:16px;">內部信件收發紀錄</li>
                        </div>
                        <div style="padding:10px;cursor:pointer;"
                             onClick="addTab('audit_log', 'POP3認證紀錄', '/audit_log');">
                            <li style="font-size:16px;">POP3認證紀錄</li>
                        </div>
                        <div style="padding:10px;cursor:pointer;"
                             onClick="addTab('access_log', 'WebMail及手持裝置紀錄', '/access_log');">
                            <li style="font-size:16px;">WebMail及手持裝置紀錄</li>
                        </div>
                        <div style="padding:10px;cursor:pointer;"
                             onClick="addTab('sys_log', '作業系統紀錄', '/sys_log');">
                            <li style="font-size:16px;">作業系統紀錄</li>
                        </div>
                    </div>
                    <div title="系統資訊" style="padding:8px;overflow:auto;height:100%">
                        <div style="padding:10px;cursor:pointer;"
                             onClick="addTab('mount_check', '檔案系統掛載檢查', '/mount_check');">
                            <li style="font-size:16px;">檔案系統掛載檢查</li>
                        </div>
                    </div>
                    <div title="網路介面設定" style="padding:8px;overflow:auto;height:100%">
                        <div style="padding:10px;cursor:pointer;"
                             onClick="addTab('tcp_ipv4', 'TCP/IPv4', '/tcp_ipv4');">
                            <li style="font-size:16px;">TCP/IPv4</li>
                        </div>
                    </div>
                    <div title="日期時間" style="padding:8px;overflow:auto;height:100%">
                        <div style="padding:10px;cursor:pointer;"
                             onClick="addTab('localtime', '立即校時', '/localtime');">
                            <li style="font-size:16px;">立即校時</li>
                        </div>
                        <div style="padding:10px;cursor:pointer;"
                             onClick="addTab('tzselect', '時區', '/timezone');">
                            <li style="font-size:16px;">時區</li>
                        </div>
                        <div style="padding:10px;cursor:pointer;"
                             onClick="addTab('time_server_list', '校時伺服器清單', '/time_server_list');">
                            <li style="font-size:16px;">校時伺服器清單</li>
                        </div>
                    </div>
                    <div title="重新啟動系統" style="padding:8px;overflow:auto;height:100%">
                        <div style="padding:10px;cursor:pointer;"
                             onClick="addTab('reboot', '重新啟動系統', '/reboot');">
                            <li style="font-size:16px;">重新啟動系統</li>
                        </div>
                        <div style="padding:10px;cursor:pointer;"
                             onClick="addTab('service', '重新啟動服務', '/service');">
                            <li style="font-size:16px;">重新啟動服務</li>
                        </div>
                    </div>
                    <div title="系統設定" style="padding:8px;overflow:auto;height:100%">
                        <div style="padding:8px;cursor:pointer;" onClick="addTab('admin_pwd_change',
                             '更改管理者密碼', '/admin_pwd_change');">
                            <li style="font-size:16px;">更改管理者密碼</li>
                        </div>
                    </div>
                    <div title="產品資訊" style="padding:8px;overflow:auto;height:100%">
                        <div style="padding:8px;cursor:pointer;" onClick="addTab('product_info',
                             '產品資訊', '/product_info');">
                            <li style="font-size:16px;">產品資訊</li>
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
