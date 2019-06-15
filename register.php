<?php
	header("Content-type:text/html;charset=utf-8");
	$back=$_SERVER['HTTP_REFERER'];
	$fileInfo=$_FILES['file'];
	$arrExt=array('png','jpg','jpeg','pdf');
	$Ext=pathinfo($fileInfo['name'],PATHINFO_EXTENSION);
	if(!in_array($Ext,$arrExt)){
		echo "<script>alert('请上传png、jpg、jpeg或pdf格式的文件！')</script>";
		echo "<meta http-equiv='Refresh' content='0;url=$back'>";
	}else{
		
		$path='./registerfile';
		if(!file_exists($path)){
			mkdir($path, 0777, true);
			chmod($path, 0777);
		}

		$uniname=md5(uniqid(microtime(true), true));
		$destination=$path.'./'.$uniname.'.'.$Ext;
		$filename=$uniname.'.'.$Ext;
		
		session_start();
		$paperid=$_GET['paperid'];
		$publication=$_POST['publication'];
		include_once("include/sys_conf.inc");
		$connection=mysql_connect($DBHOST,$DBUSER,$DBPWD) or die("无法连接数据库！");
		mysql_query("set names utf8");   //设置字符集
		mysql_select_db("PMS") or die("无法选择数据库！");   //选择数据库
		$query="INSERT INTO publication VALUES(null, '$paperid','$filename', '$publication', '待审核')";
		if(@move_uploaded_file($fileInfo['tmp_name'], $destination)){
			
			$result=mysql_query($query,$connection) or die("存入数据库失败");
			mysql_close($connection) or die("无法断开与数据库的连接");
			
			echo "<script>alert('文件上传成功！')</script>";
			echo "<meta http-equiv='Refresh' content='0;url=$back'>";
		}
	}
?>