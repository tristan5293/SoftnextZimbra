<!DOCTYPE html>
<html>
    <head>
		@include('header')
		<style>
			body {
    			background-image : url({{ asset('image/bg.jpg') }});
    			background-repeat : repeat-x;
    			margin-top:0px;
    			margin-left:0px;
    			font-family:Verdana;
    			-webkit-background-size: cover;
    			-moz-background-size: cover;
    			-o-background-size: cover;
    			background-size: cover;
			}
			#footer{
    			background: #efefef;
    			border: 1px solid #d0ccc9;
    			padding: 5px;
    			color: #7e7e7e;
    			font-size: 11px;
    			text-align: right;
			}
		</style>
		<script type="text/javascript">
		  $(function(){
    			$('#loginform').keyup(function(e) {
        			if(e.keyCode == 13) {
            			$('#ButtonSubmit').linkbutton('disable');
            			$('#loginform').submit();
        			}
    			});

          $('#login_id').textbox('setValue', "{{ Cookie::get('cookie_account') }}");
          $('#cookie_Account').prop("checked", "{{ Cookie::get('cookie_account') ? true : false }}");
			});

			function submitForm() {
				$('#ButtonSubmit').linkbutton('disable');
				var isValid = $('#loginform').form('validate');
				if(isValid){
				    $('#loginform').submit();
				}else{
					$('#ButtonSubmit').linkbutton('enable');
				}
			}
		</script>
    </head>
    <body bgcolor="#ffffff">
		<div style="height:200px;width:100%;"></div>
    	<center>
        	<form id="loginform" name="loginform" method="post" action="/login">
				{{ csrf_field() }}
        		<table cellpadding=10 cellspacing=0 border=0 style="table-layout:fixed;width:600x;">
        			<tr>
            			<td align="center">
                			<h1 style="font-size:26px;color:#3b65b5;">
                          <img src="{{ asset('image/eTool.png') }}">
                      </h1>
            			</td>
        			</tr>
        			<tr>
            			<td align="center">
                    		<div style="padding:5px;color:#3b65b5;">
                        		<div style="text-align:left">
                            		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            		{{ trans('lang.login_account') }}
                        		</div>
                        		<br/>
                        		<input class="easyui-textbox" data-options="required:true, iconCls:'icon-man', prompt:'Username'"
                            		missingMessage="{{ trans('lang.required') }}"
                            		type="text" id="login_id" name="login_id" style="width:150px;height:32px"/>
                    		</div>
                    		<div style="padding:5px;color:#3b65b5;">
                        		<div style="text-align:left">
                            		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            		{{ trans('lang.login_password') }}
                        		</div>
                        		<br/>
                        		<input class="easyui-textbox" data-options="required:true, iconCls:'icon-lock', prompt:'Password'"
                            		missingMessage="{{ trans('lang.required') }}"
                            		type="password" id="login_pwd" name="login_pwd" style="width:150px;height:32px"/>
                    		</div>
                    		<div id="auth_fail" name="auth_fail" style='padding:5px;color:#ff0000;'>
								{{ Session::get('msg') }}
							</div>
							<!-- Cookie Start -->
							<div style="padding:5px; color:#3b65b5; text-align:left">
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								<input type="checkbox" id="cookie_Account" name="cookie_Account">
								<span>{{ trans('lang.cookie_account') }}</span>
							</div>
							<!-- Cookie End -->
            			</td>
        			</tr>
        			<tr>
            			<td align="center">
                			<div style="padding:5px;">
                    			<a href="javascript:void(0)" id="ButtonSubmit" name="ButtonSubmit"
                        			class="easyui-linkbutton" onclick="submitForm();"
                        			style="border:1px #2d4e8e solid;width:150px;
                            		height:40px;background:#3b65b5;color:#ffffff;font-weight:bold;">
                        			{{ trans('lang.login_submit') }}
                    			</a>
                			</div>
            			</td>
        			</tr>
        		</table>
        	</form>
    	</center>
        <div id="footer" style="position:absolute;right:0px;bottom:0px;width:100%">
		  @include('footer')
        </div>
    </body>
</html>
