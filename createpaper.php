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
			$result=$db->select("SELECT * FROM student WHERE id=$userid");
			$id=$result[0]['id'];
			$name=$result[0]['name'];
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
            <li class="active"><a href="createpaper.php">创建论文</a></li>
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
          <h1 class="page-header">开题报告</h1>
          <h4 class="sub-header"><br/>*第一作者填写</h4>
		  <form name="frm"action="create.php" method="post">
		  <table style="width:100%;margin:5px;"  cellpadding="0" cellspacing="0">
		  <tbody>
		  <tr>
            <td>论文题目</td>
		  </tr>
		  <tr>
			<td><input type="text" name="title" class="form-control"></td>
		  </tr>
		  <tr>
            <td><br/>选题来源</td>
		  </tr>
		  <tr>
			<td><input type="text" name="origin" class="form-control"></td>
		  </tr>
		  <tr>
            <td><br/>依托的实验室或机构</td>
		  </tr>
		  <tr>
			<td><input type="text" name="lab" class="form-control"></td>
		  </tr>
		  <tr>
            <td><br/>选题背景与意义</td>
		  </tr>		  
		  <tr>
		  <td><textarea name="background" class="form-control" rows="5"   style="OVERFLOW: hidden"></textarea></td>
		  </tr>
		  <tr>
            <td><br/>主要内容和预期目标</td>
		  </tr>		  
		  <tr>
		  <td><textarea name="content" class="form-control" rows="5"   style="OVERFLOW: hidden"></textarea></td>
		  </tr>
		  <tr>
            <td><br/>拟采用的研究方法、步骤</td>
		  </tr>	
		  <tr>
		  <td><textarea name="method" class="form-control" rows="5"   style="OVERFLOW: hidden"></textarea></td>
		  </tr>		  
		  <tr>
            <td><br/>研究总体安排与进度</td>
		  </tr>	
		  <tr>
		  <td><textarea name="plan" class="form-control" rows="5"   style="OVERFLOW: hidden"></textarea></td>
		  </tr>	
		  <tr>
		      <td  align="center"><br /><input type="submit" class="btn btn-lg btn-primary" value="提交"></td>
		  </tr>
		  </tbody>
		  </table>
          </form>
		  
          
        </div>
      </div>
    </div>
  </body>
</html>
