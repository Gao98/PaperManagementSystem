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
			$result=$db->select("SELECT * FROM student NATURAL JOIN student_info WHERE id=$userid");
			$id=$result[0]['id'];
			$name=$result[0]['name'];
			$sex=$result[0]['sex'];
			$school=$result[0]['school'];
			$major=$result[0]['major'];
			$year=$result[0]['year'];
			$phone=$result[0]['phone'];
			$email=$result[0]['email'];
			echo "<li><a href='studentinfo.php'>$name($id)</a></li>";
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
        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h1 class="page-header">修改个人信息</h1>
		  <form name="frm" action="changestudentinfo.php" method="post">
		  <table align="center" style="width:30%"  cellpadding="0" cellspacing="0">
		  <tr>
            <td>学&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;号</td>
			<td><input type="text" name="id" class="form-control" readonly="true" value="<?php echo $id;?>"></td>
		  </tr>
		  <tr>
            <td>姓&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;名</td>
			<td><input type="text" name="name" class="form-control" readonly="true" value="<?php echo $name;?>"></td>
		  </tr>
		  <tr>
            <td>性&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;别</td>
			<td><input type="text" name="sex" class="form-control" readonly="true" value="<?php echo $sex;?>"></td>
		  </tr>
		  <tr>
            <td>学&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;院</td>
			<td><input type="text" name="school" class="form-control" readonly="true" value="<?php echo $school;?>"></td>
		  </tr>
		  <tr>
            <td>专&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;业</td>
			<td><input type="text" name="major" class="form-control" readonly="true" value="<?php echo $major;?>"></td>
		  </tr>	
		  <tr>
            <td>入学年份</td>
			<td><input type="text" name="year" class="form-control" readonly="true" value="<?php echo $year;?>"></td>
		  </tr>	
		  <tr>
            <td>联系电话</td>
			<td><input type="text" name="phone" class="form-control" value="<?php echo $phone;?>"></td>
		  </tr>	
		  <tr>
            <td>电子邮箱</td>
			<td><input type="text" name="email" class="form-control" value="<?php echo $email;?>"></td>
		  </tr>		
		  <tr>
		      <td colspan="2" align="center"><br /><input type="submit" class="btn btn-lg btn-primary" value="提交"></td>
		  </tr>
		  </table>
          </form>
		  
          
        </div>
      </div>
    </div>
  </body>
</html>
