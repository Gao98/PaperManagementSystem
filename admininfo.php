<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

    <title>学生论文管理系统</title>

    <!-- Bootstrap core CSS -->
    <link href="bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="dashboard.css" rel="stylesheet">
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
		    session_start();
			$userid=$_SESSION['userid'];
			require_once('include/config.inc.php');
			require_once('include/db.inc.php');
			$db=new DBSQL();
			$result=$db->select("SELECT * FROM admin WHERE id=$userid");
			$id=$result[0]['id'];
			$name=$result[0]['name'];
			echo "<li><a href='admininfo.php'>$name($id)</a></li>";
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
        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h1 class="page-header">修改个人信息</h1>
		  <form name="frm"action="changeadmininfo.php" method="post">
		  <table align="center" style="width:30%"  cellpadding="0" cellspacing="0">
		  <tr>
            <td>工&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;号</td>
			<td><input type="text" name="id" class="form-control" readonly="true" value="<?php echo $id;?>"></td>
		  </tr>	
		  <tr>
            <td>名&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;称</td>
			<td><input type="text" name="name" class="form-control" value="<?php echo $name;?>"></td>
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
