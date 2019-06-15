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
	var students = new Array();
	<?php
		$i=0;
		$result=$db->select("SELECT * FROM student_info");
		while(isset($result[$i])){
			echo "students[".$i."] = new Array('".$result[$i]['id']."','".$result[$i]['name']."','".$result[$i]['sex']."','".$result[$i]['school']."','".$result[$i]['major']."','".$result[$i]['year']."级');\n";
			$i=$i+1;
		}
	?>
	function search(idvalue, no)
	{
		for (i=0; i<students.length; i++)
		{
			if (students[i][0] == idvalue){
             document.getElementById("name"+no).innerHTML = students[i][1];
             document.getElementById("sex"+no).innerHTML = students[i][2];
             document.getElementById("school"+no).innerHTML = students[i][3];
             document.getElementById("major"+no).innerHTML = students[i][4];
             document.getElementById("year"+no).innerHTML = students[i][5];
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
			$result=$db->select("SELECT * FROM student_info WHERE id=$userid");
			$id=$result[0]['id'];
			$name=$result[0]['name'];
			$sex=$result[0]['sex'];
			$school=$result[0]['school'];
			$major=$result[0]['major'];
			$year=$result[0]['year'];
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
            <li class="active"><a href="modifyauthor.php">作者管理</a></li>
			<li><a href="publish.php">发表登记</a></li>
          </ul>
        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h1 class="page-header">修改作者</h1>
		  <h2 class="sub-header"><br/>选择要修改作者的论文</h2>
          <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>编号</th>
                  <th>标题</th>
                  <th>作者</th>
                  <th>状态</th>
                  <th>备注</th>
                </tr>
              </thead>
              <tbody>
				<?php 
					if(is_array($_GET)&&count($_GET)==0){
						$result=$db->select("SELECT id, title, author1, author2, author3, author4, author5, author6, state, remark FROM paper_author NATURAL JOIN paper WHERE author1_id =$userid");
						$i=0;
						while(isset($result[$i])){
							echo "<tr><td>".$result[$i]['id']."</td>";
							echo "<td><a href=\"modifyauthor.php?paperid=".$result[$i]['id']."\">".$result[$i]['title']."</a></td>";
							echo "<td>".$result[$i]['author1']."\t".$result[$i]['author2']."\t".$result[$i]['author3']."\t".$result[$i]['author4']."\t".$result[$i]['author5']."\t".$result[$i]['author6']."</td>";
							echo "<td>".$result[$i]['state']."</td>";
							echo "<td>".$result[$i]['remark']."</td>";							
							$i=$i+1;
						}	
					}
					else{
						$paperid=$_GET['paperid'];
						$result=$db->select("SELECT id, title, author1, author2, author3, author4, author5, author6, state, remark FROM paper_author NATURAL JOIN paper WHERE id=$paperid");
						echo "<tr><td>".$result[0]['id']."</td>";
						echo "<td>".$result[0]['title']."</td>";
						echo "<td>".$result[0]['author1']."\t".$result[0]['author2']."\t".$result[0]['author3']."\t".$result[0]['author4']."\t".$result[0]['author5']."\t".$result[0]['author6']."</td>";
						echo "<td>".$result[0]['state']."</td>";
						echo "<td>".$result[0]['remark']."</td>";					}
				?>               
              </tbody>
            </table>
          </div>
		  <?php
		  if(is_array($_GET)&&count($_GET)>0){
			  
		  ?>
		  <h2 class="sub-header">作者列表</h2>
		  <div class="table-responsive">
            <form action="changeauthor.php?paperid=<?php echo $paperid;?>" method="post" name="selectform">
			<table width="100%">
			<?php
				$paperid=$_GET['paperid'];
				$result=$db->select("SELECT author1_id, author2_id, author3_id, author4_id, author5_id, author6_id FROM paper WHERE id=$paperid");
				$author1_id=$result[0]['author1_id'];
				$author2_id=$result[0]['author2_id'];
				$author3_id=$result[0]['author3_id'];
				$author4_id=$result[0]['author4_id'];
				$author5_id=$result[0]['author5_id'];
				$author6_id=$result[0]['author6_id'];					
			?>
			
			<tr><td><h4>第一作者</h4></td>
			<?php
				$result=$db->select("SELECT * FROM student_info WHERE id=$author1_id");
				$id=$result[0]['id'];
				$name=$result[0]['name'];
				$sex=$result[0]['sex'];
				$school=$result[0]['school'];
				$major=$result[0]['major'];
				$year=$result[0]['year'];
			?>
			<td  style="width:100px;" ><input type="text" name="author1" placeholder="请输入学号" value="<?php echo $id;?>" class="form-control" onkeyup="search(this.value, 1);"/></td>
			<td><h4 id="name1" align="center"><?php echo $name;?></h4></td>
			<td><h4 id="sex1" align="center"><?php echo $sex;?></h4></td>
			<td><h4 id="school1" align="center"><?php echo $school;?></h4></td>
			<td><h4 id="major1" align="center"><?php echo $major;?></h4></td>
			<td><h4 id="year1" align="center"><?php echo $year."级";?></h4></td>
			
			<tr><td><h4>第二作者</h4></td>
			<?php
				$result=$db->select("SELECT * FROM student_info WHERE id=$author2_id");
				$id=$result[0]['id'];
				$name=$result[0]['name'];
				$sex=$result[0]['sex'];
				$school=$result[0]['school'];
				$major=$result[0]['major'];
				$year=$result[0]['year'];
			?>
			<td  style="width:100px;" ><input type="text" name="author2" placeholder="请输入学号" value="<?php echo $id;?>" class="form-control" onkeyup="search(this.value, 2);"/></td>
			<td><h4 id="name2" align="center"><?php echo $name;?></h4></td>
			<td><h4 id="sex2" align="center"><?php echo $sex;?></h4></td>
			<td><h4 id="school2" align="center"><?php echo $school;?></h4></td>
			<td><h4 id="major2" align="center"><?php echo $major;?></h4></td>
			<td><h4 id="year2" align="center"><?php echo $year==null?"":$year."级";?></h4></td>
			
			<tr><td><h4>第三作者</h4></td>
			<?php
				$result=$db->select("SELECT * FROM student_info WHERE id=$author3_id");
				$id=$result[0]['id'];
				$name=$result[0]['name'];
				$sex=$result[0]['sex'];
				$school=$result[0]['school'];
				$major=$result[0]['major'];
				$year=$result[0]['year'];
			?>
			<td  style="width:100px;" ><input type="text" name="author3" placeholder="请输入学号" value="<?php echo $id;?>" class="form-control" onkeyup="search(this.value, 3);"/></td>
			<td><h4 id="name3" align="center"><?php echo $name;?></h4></td>
			<td><h4 id="sex3" align="center"><?php echo $sex;?></h4></td>
			<td><h4 id="school3" align="center"><?php echo $school;?></h4></td>
			<td><h4 id="major3" align="center"><?php echo $major;?></h4></td>
			<td><h4 id="year3" align="center"><?php echo $year==null?"":$year."级";?></h4></td>
			
			<tr><td><h4>第四作者</h4></td>
			<?php
				$result=$db->select("SELECT * FROM student_info WHERE id=$author4_id");
				$id=$result[0]['id'];
				$name=$result[0]['name'];
				$sex=$result[0]['sex'];
				$school=$result[0]['school'];
				$major=$result[0]['major'];
				$year=$result[0]['year'];
			?>
			<td  style="width:100px;" ><input type="text" name="author4" placeholder="请输入学号" value="<?php echo $id;?>" class="form-control" onkeyup="search(this.value, 4);"/></td>
			<td><h4 id="name4" align="center"><?php echo $name;?></h4></td>
			<td><h4 id="sex4" align="center"><?php echo $sex;?></h4></td>
			<td><h4 id="school4" align="center"><?php echo $school;?></h4></td>
			<td><h4 id="major4" align="center"><?php echo $major;?></h4></td>
			<td><h4 id="year4" align="center"><?php echo $year==null?"":$year."级";?></h4></td>
			
			<tr><td><h4>第五作者</h4></td>
			<?php
				$result=$db->select("SELECT * FROM student_info WHERE id=$author5_id");
				$id=$result[0]['id'];
				$name=$result[0]['name'];
				$sex=$result[0]['sex'];
				$school=$result[0]['school'];
				$major=$result[0]['major'];
				$year=$result[0]['year'];
			?>
			<td  style="width:100px;" ><input type="text" name="author5" placeholder="请输入学号" value="<?php echo $id;?>" class="form-control" onkeyup="search(this.value, 5);"/></td>
			<td><h4 id="name5" align="center"><?php echo $name;?></h4></td>
			<td><h4 id="sex5" align="center"><?php echo $sex;?></h4></td>
			<td><h4 id="school5" align="center"><?php echo $school;?></h4></td>
			<td><h4 id="major5" align="center"><?php echo $major;?></h4></td>
			<td><h4 id="year5" align="center"><?php echo $year==null?"":$year."级";?></h4></td>
			
			<tr><td><h4>第六作者</h4></td>
			<?php
				$result=$db->select("SELECT * FROM student_info WHERE id=$author6_id");
				$id=$result[0]['id'];
				$name=$result[0]['name'];
				$sex=$result[0]['sex'];
				$school=$result[0]['school'];
				$major=$result[0]['major'];
				$year=$result[0]['year'];
			?>
			<td  style="width:100px;" ><input type="text" name="author6" placeholder="请输入学号" value="<?php echo $id;?>" class="form-control" onkeyup="search(this.value, 6);"/></td>
			<td><h4 id="name6" align="center"><?php echo $name;?></h4></td>
			<td><h4 id="sex6" align="center"><?php echo $sex;?></h4></td>
			<td><h4 id="school6" align="center"><?php echo $school;?></h4></td>
			<td><h4 id="major6" align="center"><?php echo $major;?></h4></td>
			<td><h4 id="year6" align="center"><?php echo $year==null?"":$year."级";?></h4></td>
			<tr><td/>&nbsp;</td></tr>
			<tr><td colspan="7" align="center"><input type="submit" class="btn btn-lg btn-primary" value="提交"></td></tr>
			</form>
          </div>
		  <?php }?>
        </div>
      </div>
    </div>
  </body>
</html>
