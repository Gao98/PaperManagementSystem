<?php
	session_start();
	$paperid=$_GET['paperid'];
	$userid=$_SESSION['userid'];
	include_once("include/sys_conf.inc");
    //建立与MySQL数据库的连接
    $connection=mysql_connect($DBHOST,$DBUSER,$DBPWD) or die("无法连接数据库！");
    mysql_query("set names utf8");   //设置字符集
    mysql_select_db("PMS") or die("无法选择数据库！");   //选择数据库
    //向服务器发送查询请求
    $query="UPDATE guidance SET state = '已同意' WHERE paper_id = $paperid and instructor_id = $userid";
    $result=mysql_query($query,$connection) or die("更新数据库失败");
    mysql_close($connection) or die("无法断开与数据库的连接");
    echo "<script>alert('已接受邀请!')</script>";
	echo "<meta http-equiv='Refresh' content='0;url=instructor.php'>";
?>