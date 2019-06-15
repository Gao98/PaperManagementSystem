<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

    <title>学生论文管理系统</title>

    <!-- Bootstrap core CSS -->
    <link href="bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="dashboard.css" rel="stylesheet">
	<?php
	session_start();
	$userid=$_SESSION['userid'];
	require_once('include/config.inc.php');
	require_once('include/db.inc.php');
	$db=new DBSQL();
	?>
	<script language="JavaScript">
	var majors = new Array();
	var names = new Array();
	<?php
		$i=0;
		$result=$db->select("SELECT * FROM dept");
		while(isset($result[$i])){
			echo "majors[".$i."] = new Array('".$result[$i]['id']."','".$result[$i]['name']."','".$result[$i]['father_id']."');\n";
			$i=$i+1;
		}
		$i=0;
		$result=$db->select("SELECT instructor.id, instructor.name, dept FROM instructor JOIN dept on instructor.dept = dept.id");
		while(isset($result[$i])){
			echo "names[".$i."] = new Array('".$result[$i]['id']."','".$result[$i]['name']."','".$result[$i]['dept']."');\n";
			$i=$i+1;
		}
	?>
	function changeschool(schoolvalue)
	{
		document.selectform.major.length = 0;
		document.selectform.major.options[0] = new Option('请选择专业','');
		for (i=0; i<majors.length; i++)
		{
			if (majors[i][2] == schoolvalue){
				document.selectform.major.options[document.selectform.major.length] = new Option(majors[i][1], majors[i][0]);
			}
		}
	}
	function changemajor(majorvalue)
	{
		document.selectform.name.length = 0;
		document.selectform.name.options[0] = new Option('请选择姓名','');
		for (i=0; i<names.length; i++)
		{
			if (names[i][2] == majorvalue){
				document.selectform.name.options[document.selectform.name.length] = new Option(names[i][1], names[i][0]);
			}
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
			<li><a href="uploadpaper.php">上传论文</a></li>
          </ul>
          <ul class="nav nav-sidebar">
			<li class="active"><a href="addguidance.php">指导教师</a></li>
            <li><a href="guidanceinfo.php">指导信息</a></li>
          </ul>
          <ul class="nav nav-sidebar">
            <li><a href="modifyauthor.php">作者管理</a></li>
			<li><a href="publish.php">发表登记</a></li>
          </ul>
        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h1 class="page-header">添加指导教师</h1>
		  <h2 class="sub-header"><br/>选择要添加指导教师的论文</h2>
          <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>编号</th>
                  <th>标题</th>
                  <th>作者</th>
                  <th>已同意的教师</th>
                  <th>正在邀请的教师</th>
                </tr>
              </thead>
              <tbody>
				<?php 
					if(is_array($_GET)&&count($_GET)==0){
						$result=$db->select("SELECT id, title, author1, author2, author3, author4, author5, author6 FROM paper_author NATURAL JOIN paper WHERE author1_id =$userid");
						$i=0;
						while(isset($result[$i])){
							echo "<tr><td>".$result[$i]['id']."</td>";
							echo "<td><a href=\"addguidance.php?paperid=".$result[$i]['id']."\">".$result[$i]['title']."</a></td>";
							echo "<td>".$result[$i]['author1']."\t".$result[$i]['author2']."\t".$result[$i]['author3']."\t".$result[$i]['author4']."\t".$result[$i]['author5']."\t".$result[$i]['author6']."</td>";
							$result2=$db->select("SELECT name, state FROM instructor JOIN guidance on instructor.id = guidance.instructor_id WHERE paper_id=".$result[$i]['id']);
							$j=0;
							echo "<td>";
							while(isset($result2[$j])){
								if($result2[$j]['state']=='已同意')
									echo $result2[$j][0]."\t";
								$j=$j+1;
							}
							echo "</td>";
							$j=0;
							echo "<td>";
							while(isset($result2[$j])){
								if($result2[$j]['state']=='待同意')
									echo $result2[$j][0]."\t";
								$j=$j+1;
							}
							echo "</td></tr>";
							$i=$i+1;
						}	
					}
					else{
						$paperid=$_GET['paperid'];
						$result=$db->select("SELECT id, title, author1, author2, author3, author4, author5, author6 FROM paper_author NATURAL JOIN paper WHERE id=$paperid");
						echo "<tr><td>".$result[0]['id']."</td>";
						echo "<td>".$result[0]['title']."</td>";
						echo "<td>".$result[0]['author1']."\t".$result[0]['author2']."\t".$result[0]['author3']."\t".$result[0]['author4']."\t".$result[0]['author5']."\t".$result[0]['author6']."</td>";
							$result2=$db->select("SELECT name, state FROM instructor JOIN guidance on instructor.id = guidance.instructor_id WHERE paper_id=".$result[0]['id']);
						$j=0;
						echo "<td>";
						while(isset($result2[$j])){
							if($result2[$j]['state']=='已同意')
								echo $result2[$j][0]."\t";
							$j=$j+1;
						}
						echo "</td>";
						$j=0;
						echo "<td>";
						while(isset($result2[$j])){
							if($result2[$j]['state']=='待同意')
								echo $result2[$j][0]."\t";
							$j=$j+1;
						}
						echo "</td></tr>";					}
				?>               
              </tbody>
            </table>
          </div>
		  <?php
		  if(is_array($_GET)&&count($_GET)>0){
		  ?>
		  <h2 class="sub-header">邀请指导教师</h2>
		  <div class="table-responsive">
            <form action="invite.php?paperid=<?php echo $paperid;?>" method="post" name="selectform">
			<table align="center">
			<tr><td><h4>学&nbsp;&nbsp;&nbsp;院:&nbsp;</h4></td><td>
			<select class="form-control" name="school" onchange="changeschool(this.value)">
				<option>请选择学院</option>
			<?php
				$result=$db->select("SELECT id, name FROM dept WHERE father_id=0");
				$i=0;
				while(isset($result[$i])){
					echo "<option value=\"".$result[$i]['id']."\">".$result[$i]['name']."</option>";
					$i=$i+1;
				}			
			?>
			</select></td></tr>
			<tr><td><h4>专&nbsp;&nbsp;&nbsp;业:&nbsp;</h4></td><td>
			<select class="form-control" name="major" onchange="changemajor(this.value)">
			</select></td></tr>
			<tr><td><h4>姓&nbsp;&nbsp;&nbsp;名:&nbsp;</h4></td><td>
			<select class="form-control" name="name">
			</select></td></tr>
			<tr><td colspan="2" align="center"><input type="submit" class="btn btn-lg btn-primary" value="提交"></td></tr>
			</form>
          </div>
		  <?php }?>
        </div>
      </div>
    </div>
  </body>
</html>
