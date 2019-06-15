<?php
	session_start();
	$author1_id=$_POST['author1'];
	$author2_id=$_POST['author2'];
	$author3_id=$_POST['author3'];
	$author4_id=$_POST['author4'];
	$author5_id=$_POST['author5'];
	$author6_id=$_POST['author6'];
	if($author2_id=="") $author2_id="null";	
	if($author3_id=="") $author3_id="null";	
	if($author4_id=="") $author4_id="null";	
	if($author5_id=="") $author5_id="null";	
	if($author6_id=="") $author6_id="null";	
	$paperid=$_GET['paperid'];
	include_once("include/sys_conf.inc");
    //建立与MySQL数据库的连接
    $connection=mysql_connect($DBHOST,$DBUSER,$DBPWD) or die("无法连接数据库！");
    mysql_query("set names utf8");   //设置字符集
    mysql_select_db("PMS") or die("无法选择数据库！");   //选择数据库
    //向服务器发送查询请求
    $query="UPDATE paper SET author1_id = ".$author1_id.", author2_id = ".$author2_id.", author3_id = ".$author3_id.", author4_id = ".$author4_id.", author5_id = ".$author5_id.", author6_id = ".$author6_id." WHERE id = $paperid ";
    $result=mysql_query($query,$connection) or die("更新数据库失败");
    mysql_close($connection) or die("无法断开与数据库的连接");
    echo "<script>alert('修改成功!')</script>";
	echo "<meta http-equiv='Refresh' content='0;url=modifyauthor.php'>";
?>