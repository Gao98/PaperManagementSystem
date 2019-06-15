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
            <li><a href="createpaper.php">创建论文</a></li>
			<li  class="active"><a href="uploadpaper.php">上传论文</a></li>
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
          <h1 class="page-header">上传提交</h1>
		  <h2 class="sub-header"><br/>选择要上传的论文</h2>
          <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>编号</th>
                  <th>标题</th>
                  <th>状态</th>
                  <th>上次上传文件</th>
                  <th>上次上传时间</th>
                </tr>
              </thead>
              <tbody>
				<?php 
					if(is_array($_GET)&&count($_GET)==0){
						$result=$db->select("SELECT id, title, state, getLast_version(id) as last_version, getLast_time(id) as last_time FROM paper WHERE author1_id =$userid");
						$i=0;
						while(isset($result[$i])){
							echo "<tr><td>".$result[$i]['id']."</td>";
							echo "<td><a href=\"uploadpaper.php?paperid=".$result[$i]['id']."\">".$result[$i]['title']."</a></td>";
							echo "<td>".$result[$i]['state']."</td>";
							echo "<td>".$result[$i]['last_version']."</td>";	
							echo "<td>".$result[$i]['last_time']."</td></tr>";
							$i=$i+1;
						}	
					}
					else{
						$paperid=$_GET['paperid'];
						$result=$db->select("SELECT id, title, state, getLast_version(id) as last_version, getLast_time(id) as last_time FROM paper WHERE id=$paperid");
						echo "<tr><td>".$result[0]['id']."</td>";
						echo "<td>".$result[0]['title']."</td>";
						echo "<td>".$result[0]['state']."</td>";
						echo "<td>".$result[0]['last_version']."</td>";	
						echo "<td>".$result[0]['last_time']."</td></tr>";					}
						
				?>               
              </tbody>
            </table>
          </div>
		  <?php
		  if(is_array($_GET)&&count($_GET)>0){
		  ?>
		  <h2 class="sub-header">上传论文文件</h2>
		  <div class="table-responsive">
            <form action="upload.php?paperid=<?php echo $paperid;?>" method="post" enctype="multipart/form-data">
			<input type="file" name="file" id="file" style="width:100%;height:34px;" /> 
			<h3>文件说明</h3><input type="text" name="version" class="form-control"/> 
			<br />
			<input type="submit" class="btn btn-lg btn-primary" value="提交">
			</form>
          </div>
		  <?php }?>
        </div>
      </div>
    </div>
  </body>
</html>
