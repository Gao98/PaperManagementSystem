<?php
	session_start();  //启动session变量，注意一定要放在首行
	$title=$_POST["title"]; //获取表单变量的值
	$origin=$_POST["origin"];
	$lab=$_POST["lab"];
	$background=$_POST["background"];
	$content=$_POST["content"];
	$method=$_POST["method"];
	$plan=$_POST["plan"];
    $userid=$_SESSION['userid'];
	include_once("include/sys_conf.inc");
    //建立与MySQL数据库的连接
    $connection=mysql_connect($DBHOST,$DBUSER,$DBPWD) or die("无法连接数据库！");
    mysql_query("set names utf8");   //设置字符集
    mysql_select_db("PMS") or die("无法选择数据库！");   //选择数据库
    //向服务器发送查询请求
    $query="INSERT INTO paper VALUES(null, '$title','$origin', '$lab', '$background', '$content', '$method', '$plan', '$userid', null, null, null, null, null, now(), '未上传', null)";
    $result=mysql_query($query,$connection) or die("存入数据库失败");
    mysql_close($connection) or die("无法断开与数据库的连接");
    echo "<script>alert('创建论文成功!')</script>";
	echo "<meta http-equiv='Refresh' content='0;url=student.php'>";
?>