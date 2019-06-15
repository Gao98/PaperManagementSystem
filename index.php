<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<title>
	论文管理系统
</title>
    <script src="js/jquery-1.4.2.min.js" type="text/javascript"></script>
    <script language="JavaScript">
        $(function () {
            $('#studenttype').change(function () {
				$("#loginimg").attr("src", "images/1.png");
            });
            $('#instructortype').change(function () {
				$("#loginimg").attr("src", "images/2.png");
            });
            $('#admintype').change(function () {
				$("#loginimg").attr("src", "images/1.png");
            });
            
        });
	
		function jcud(){
         var cds1=window.frm.username.value;
         var cds2=window.frm.password.value;
         var cds3=window.frm.verify.value;
         if (cds1==""){
            window.alert("用户名不能为空");
            window.frm.username.focus();
			return false;			
         }
         else if (cds2==""){
            window.alert("密码不能为空");
            window.frm.password.focus();
			return false;
         }
         else if (cds3==""){
            window.alert("必须输入验证码");
            window.frm.verify.focus();
			return false;
        }
	  }
    </script>
</head>
<body bgcolor="#282828">
<form method="POST" name="frm" action="login.php" onsubmit="return jcud()">

<div style="width:auto;height:auto;margin:0px;padding:0px;">
  <div style=" background-image:url(images/loginbg.jpg);width:900px;height:585px;margin-top:150px;margin-left:auto;margin-right:auto;">
    <div style="padding-left:240px;padding-top:215px;width:410px;height:210px;">
      <table style="width:410px;height:220px;"  cellpadding="0" cellspacing="0">
        <tbody>
          <tr>

            <td style="font-size:20px; padding-left:60px;"><input name="usertype" type="radio" id="studenttype" value="student" checked="checked" />学生端</td>
            <td style="font-size:20px; "><input name="usertype" type="radio" id="instructortype" value="instructor"/>教师端</td>
            <td style="font-size:20px;"><input name="usertype" type="radio" id="admintype" value="admin"/>管理端</td>			
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td rowspan="3"><img src="images/1.png" id="loginimg" /></td>
            <td>用户名:</td>
            <td><input name="username" type="text" id="username" style="height:19px;width:170px;" /></td>
          </tr>
          <tr>
            <td>密&nbsp;码:</td>
            <td><input name="password" type="password" id="password" style="height:19px;width:170px;" /></td>
          </tr>
		  <tr>
            <td>验证码:</td>
			<td><input name="verify" type="text" id="act" value="" size="8" />&nbsp;<img id="yzm" src="yzm.php" align="absmiddle" /></td>
          </tr>
</select>
            </td>
          </tr>
          <tr>
            <td colspan="2" style=" text-align:center;"><input align="right" type="image" src="images/login.png"/></td>
			<td align="right"><input name="submit" type="button" value="看不清,换一张" onClick="document.frm.yzm.src = 'yzm.php?'+Math.random();" /></td>
          </tr>
        </tbody>
      </table>
   
    </div>
       
  </div>
  
</div>
</form>
</body>
</html>
