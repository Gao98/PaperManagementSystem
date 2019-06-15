<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

    <title>学生论文管理系统</title>

    <!-- Bootstrap core CSS -->
    <link href="bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="dashboard.css" rel="stylesheet">
	<script language="JavaScript">
		function check(){
         <?php
			session_start();
			$userid=$_SESSION['userid'];
			$usertype=$_SESSION['usertype'];
			require_once('include/config.inc.php');
			require_once('include/db.inc.php');
			$db=new DBSQL();
			$result=$db->select("SELECT * FROM $usertype WHERE id=$userid");
			$password=$result[0]['password'];
			echo "var pwd=".$password.";";
		 ?>
		 var cds1=window.frm.oldpassword.value;
         var cds2=window.frm.newpassword.value;
         var cds3=window.frm.passwordagagin.value;
         if (cds1==""){
            window.alert("旧密码不能为空");
            window.frm.oldpassword.focus();
			return false;			
         }
         else if (cds2==""){
            window.alert("新密码不能为空");
            window.frm.newpassword.focus();
			return false;
         }
         else if (cds3==""){
            window.alert("必须再次输入新密码");
            window.frm.passwordagagin.focus();
			return false;
         }
		 else if (cds2!=cds3){
            window.alert("两次输入密码不一致");
            window.frm.newpassword.focus();
			return false;
         }
		 else if (cds1!=pwd){
            window.alert("输入旧密码错误");
            window.frm.oldpassword.focus();
			return false;
         }
	  }
    </script>
  </head>

  <body>

    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container-fluid">
        <div class="navbar-header">
          <a class="navbar-brand">学生论文管理系统</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
		  <?php 
			$id=$result[0]['id'];
			$name=$result[0]['name'];
			echo "<li><a href='$usertype"."info.php'>$name($id)</a></li>";
		  ?>
            <li><a href="modifypassword.php">修改密码</a></li>
            <li><a href="logout.php">注销</a></li>
          </ul>
          
        </div>
      </div>
    </nav>

    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-3 col-md-2 sidebar">
		<?php
		if($usertype=='student'){
		?>
          <ul class="nav nav-sidebar">
            <li><a href="student.php">论文列表</a></li>
            <li><a href="createpaper.php">创建论文</a></li>
			<li><a href="uploadpaper.php">上传论文</a></li>
          </ul>
          <ul class="nav nav-sidebar">
			<li><a href="addguidance.php">指导教师</a></li>
            <li><a href="guidanceinfo.php">指导信息</a></li>
          </ul>
          <ul class="nav nav-sidebar">
            <li><a href="modifyauthor.php">作者管理</a></li>
			<li><a href="publish.php">发表登记</a></li>
          </ul>
		<?php
		}else if($usertype=='instructor'){	
		?>
		  <ul class="nav nav-sidebar">
            <li><a href="instructor.php">邀请信息</a></li>
            <li><a href="guidancepaper.php">指导论文</a></li>
          </ul>
		<?php
		}else{
		?>
		  <ul class="nav nav-sidebar">
            <li><a href="admin.php">发表审核</a></li>
            <li><a href="paper.php">论文管理</a></li>
           </ul>
         <ul class="nav nav-sidebar">
            <li><a href="modifystudent.php">学生管理</a></li>
			<li><a href="addstudent.php">添加学生</a></li>
          </ul>
          <ul class="nav nav-sidebar">
			<li><a href="modifyinstructor.php">教师管理</a></li>
            <li><a href="addinstructor.php">添加教师</a></li>
          </ul>
		<?php
		}
		?>
        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h1 class="page-header">修改登录密码</h1>
		  <form name="frm"action="changepassword.php" method="post" onsubmit="return check()">
		  <table align="center" style="width:30%"  cellpadding="0" cellspacing="0">
		  <tr>
            <td>旧&nbsp;&nbsp;&nbsp;&nbsp;密&nbsp;&nbsp;&nbsp码</td>
			<td><input type="password" name="oldpassword" class="form-control"></td>
		  </tr>	
		  <tr>
            <td>新&nbsp;&nbsp;&nbsp;&nbsp;密&nbsp;&nbsp;&nbsp;码</td>
			<td><input type="password" name="newpassword" class="form-control"></td>
		  </tr>
		  <tr>
            <td>确认新密码</td>
			<td><input type="password" name="passwordagagin" class="form-control"></td>
		  </tr>			  
		  <tr>
		      <td colspan="2" align="center"><br /><input type="submit" class="btn btn-lg btn-primary" value="提交"></td>
		  </tr>
		  </table
          </form>
		  
          
        </div>
      </div>
    </div>
  </body>
</html>
