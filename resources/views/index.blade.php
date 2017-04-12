<!DOCTYPE html>
<html>
    <head>
        @include('header')
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="stylesheet" type="text/css" href="/css/style_index.css"/>
        <script type="text/javascript">
            function checkAutoLogout() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.get("/checkAutoLogout",
            	        function(data){
                          if(data.indexOf('logout') != -1)
                          {
                              parent.location.href='/logout';
                          }
            	        }
            	    );
        	  }

            $(function(){
                //閒置太久將使用者強迫登出, 每30秒檢查一次
                setInterval(checkAutoLogout,'30000');

                //References
                var sections = $("#menu li");
                var content = $("#content");

                //content default load
                $("#content").load("/zimbra");

                //Manage click events
                sections.click(function(){
                    //load selected section
                    switch(this.id){
                        case "zimbra":
                            //location.reload(); //解決 easyui-menubutton 重新 reload 後載入Bug
                            $("#content").load("/zimbra");
                            break;
                        /*
                        case "snima_policy":
                            $("#content").load("./snima_menu/snima_policy/snima_policy.php", hideLoading);
                            break;
                        case "snima_system_config":
                            $("#content").load("./snima_menu/snima_sysconfig/snima_sysconfig.php", hideLoading);
                            break;
                        */
                        default:
                    }
                });
            });
        </script>
    </head>
    <body>
        <!-- 網站使用一個大的DIV將裡面東西全部包起 -->
        <div id="container" style="border:1px #e7e7e7 solid;width:98%;height:90%">
            <!-- 網站最上層(顯示登入者、同步按鈕、登出) -->
            <table cellpadding="3" cellspacing="0" border="0" class="SNIMAHead">
                <tr>
                    <td style="text-align:right;">
                        <font style='font-size:14px'>
                            <b>{{ Session::get('account') }}</b>
                        </font>
                        &nbsp;&nbsp;|&nbsp;&nbsp;
                        <span style="display: inline-block;">
                            <form method="GET" action="/logout">
                                {{ csrf_field() }}
                                <input type="image" src="{{ asset('image/logout.png') }}"/>
                            </form>
                        </span>
                        &nbsp;&nbsp;
                    </td>
                </tr>
            </table>
            <!-- 各功能選單(點擊後)內容顯示所在地 -->
            <table cellpadding=5 bgcolor=#ffffff style="width:100%;height:90%">
                <tr>
                    <td valign="top" style="height:100%">
                        <div id="content" style="height:100%;">

                        </div>
                    </td>
                </tr>
            </table>
            <!-- 網站頁尾 -->
            <div id="footer" style="width:98.5%;">
                @include('footer')
            </div>
        </div>
    </body>
</html>
