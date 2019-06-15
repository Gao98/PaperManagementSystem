<?php
	session_start();  //启动session变量，注意一定要放在首行
	$username=$_POST["username"]; //获取表单变量的值
	$password=$_POST["password"];
	$yzm_chars=$_POST["verify"];
	$usertype=$_POST["usertype"];
	include("include/sys_conf.inc");
   	//建立与SQL数据库的连接
	if($yzm_chars!=$_SESSION['chars']){
		 echo "<script>alert('验证码输入错误!')</script>";
		 echo "<meta http-equiv='Refresh' content='0;url=index.php'>";	
		 exit();
	}
    $connection=@mysql_connect($DBHOST,$DBUSER,$DBPWD) or die("无法连接数据库！");
	@mysql_query("set names utf8") ;  //设置字符集，防止中文显示乱码
	@mysql_select_db("PMS") or die("无法选择数据库！");
	$query="SELECT * FROM $usertype WHERE id='$username'";   //查询用户信息
	$result=@mysql_query($query,$connection) or die("数据请求失败1！");
	if($row=mysql_fetch_array($result)){
	  	if($row['password']==$password){   //身份认证成功			
			$_SESSION['userid']=$username;
			$_SESSION['usertype']=$usertype;
			echo "<meta http-equiv='Refresh' content='0;url=$usertype.php'>";
		}
		else{
			echo "<script>alert('密码不正确，请重新输入!')</script>";
			echo "<meta http-equiv='Refresh' content='0;url=index.php'>";
		}
	}
	else{
		echo "<script>alert('不存在的用户名，请联系管理员!')</script>";
		echo "<meta http-equiv='Refresh' content='0;url=index.php'>";	
	}
?>