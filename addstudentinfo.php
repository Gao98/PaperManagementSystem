<?php
	session_start();
	$id=$_POST['id'];
	$password=$_POST['password'];
	$name=$_POST['name'];
	$sex=$_POST['sex'];
	$major=$_POST['major'];
	$year=$_POST['year'];
	$phone=$_POST['phone'];
	$email=$_POST['email'];
	include_once("include/sys_conf.inc");
    //建立与MySQL数据库的连接
    $connection=mysql_connect($DBHOST,$DBUSER,$DBPWD) or die("无法连接数据库！");
    mysql_query("set names utf8");   //设置字符集
    mysql_select_db("PMS") or die("无法选择数据库！");   //选择数据库
    //向服务器发送查询请求
	$query="INSERT INTO student VALUES('$id', '$password', '$name', '$major', '$sex', '$year', '$phone', '$email')";
	$result=mysql_query($query,$connection) or die("插入数据库失败");
    mysql_close($connection) or die("无法断开与数据库的连接");
    echo "<script>alert('添加成功!')</script>";
	echo "<meta http-equiv='Refresh' content='0;url=addstudent.php'>";
?>