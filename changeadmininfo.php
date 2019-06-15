<?php
	session_start();
	$id=$_POST['id'];
	$name=$_POST['name'];
	$back=$_SERVER['HTTP_REFERER'];
	include_once("include/sys_conf.inc");
    //建立与MySQL数据库的连接
    $connection=mysql_connect($DBHOST,$DBUSER,$DBPWD) or die("无法连接数据库！");
    mysql_query("set names utf8");   //设置字符集
    mysql_select_db("PMS") or die("无法选择数据库！");   //选择数据库
    //向服务器发送查询请求
	$query="UPDATE admin SET name = '$name' WHERE id = $id ";
	$result=mysql_query($query,$connection) or die("更新数据库失败");
    mysql_close($connection) or die("无法断开与数据库的连接");
    echo "<script>alert('修改成功!')</script>";
	echo "<meta http-equiv='Refresh' content='0;url=$back'>";
?>