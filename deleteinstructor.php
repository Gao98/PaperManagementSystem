<?php
	session_start();  //启动session变量，注意一定要放在首行
	$id=$_GET['id'];
	include_once("include/sys_conf.inc");
    //建立与MySQL数据库的连接
    $connection=mysql_connect($DBHOST,$DBUSER,$DBPWD) or die("无法连接数据库！");
    mysql_query("set names utf8");   //设置字符集
    mysql_select_db("PMS") or die("无法选择数据库！");   //选择数据库
    //向服务器发送查询请求
    $query="DELETE FROM instructor WHERE id=$id";
    $result=mysql_query($query,$connection) or die("删除数据失败");
    mysql_close($connection) or die("无法断开与数据库的连接");
    echo "<script>alert('删除成功!')</script>";
	echo "<meta http-equiv='Refresh' content='0;url=modifyinstructor.php'>";
?>