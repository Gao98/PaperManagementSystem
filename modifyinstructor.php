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
	<?php
		$i=0;
		$result=$db->select("SELECT * FROM dept");
		while(isset($result[$i])){
			echo "majors[".$i."] = new Array('".$result[$i]['id']."','".$result[$i]['name']."','".$result[$i]['father_id']."');\n";
			$i=$i+1;
		}
	?>
	function changeschool(schoolvalue)
	{
		document.frm.major.length = 0;
		document.frm.major.options[0] = new Option('请选择专业','');
		for (i=0; i<majors.length; i++)
		{
			if (majors[i][2] == schoolvalue){
				document.frm.major.options[document.frm.major.length] = new Option(majors[i][1], majors[i][0]);
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
			$result=$db->select("SELECT * FROM admin WHERE id=$userid");
			$id=$result[0]['id'];
			$name=$result[0]['name'];
			echo "<li><a href=\"admininfo.php\">$name($id)</a></li>";
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
			<li class="active"><a href="modifyinstructor.php">教师管理</a></li>
            <li><a href="addinstructor.php">添加教师</a></li>
          </ul>

        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h1 class="page-header">教师信息管理</h1>
		<div class="table-responsive">
		<?php
			if(is_array($_GET)&&count($_GET)==0){
		?>
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>工号</th>
                  <th>姓名</th>
                  <th>性别</th>
                  <th>学院</th>
                  <th>专业</th>
				  <th>职称</th>
				  <th>操作</th>
                </tr>
              </thead>
              <tbody>
				<?php 
					$result=$db->select("SELECT * FROM instructor NATURAL JOIN instructor_info");
					$i=0;
					while(isset($result[$i])){
						echo "<tr><td>".$result[$i]['id']."</td>";
						echo "<td>".$result[$i]['name']."</td>";
						echo "<td>".$result[$i]['sex']."</td>";
						echo "<td>".$result[$i]['school']."</td>";
						echo "<td>".$result[$i]['major']."</td>";
						echo "<td>".$result[$i]['title']."</td>";
						echo "<td><a href=\"modifyinstructor.php?id=".$result[$i]['id']."\">编辑</a>&nbsp;<a href=\"deleteinstructor.php?id=".$result[$i]['id']."\" onclick=\"return confirm('确定删除吗?');\">删除</a></td>";
						$i=$i+1;
					}
				?>               
              </tbody>
            </table>
			<?php
			}else{
				$instructorid=$_GET['id'];
				$result=$db->select("SELECT * FROM instructor NATURAL JOIN instructor_info WHERE id = $instructorid");
				$id=$result[0]['id'];
				$password=$result[0]['password'];
				$name=$result[0]['name'];
				$sex=$result[0]['sex'];
				$dept=$result[0]['dept'];
				$year=$result[0]['year'];
				$title=$result[0]['title'];
				$address=$result[0]['address'];
				$email=$result[0]['email'];						
			?>
			<form name="frm"action="changeinstructorinfo.php" method="post">
		  <table align="center" style="width:30%"  cellpadding="0" cellspacing="0">
		  <tr>
            <td>工&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;号</td>
			<td><input type="text" name="id" class="form-control" value="<?php echo $id;?>" readonly="true"></td>
		  </tr>
		  <tr>
            <td>密&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;码</td>
			<td><input type="password" name="password" class="form-control"  value="<?php echo $password;?>"></td>
		  </tr>
		  <tr>
            <td>姓&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;名</td>
			<td><input type="text" name="name" class="form-control"  value="<?php echo $name;?>"></td>
		  </tr>
		  <tr>
            <td>性&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;别</td>
			<td><input type="text" name="sex" class="form-control"  value="<?php echo $sex;?>"></td>
		  </tr>
		  <tr>
            <td>学&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;院</td>
			<td><select class="form-control" name="school" onchange="changeschool(this.value)">
			<?php
				$result=$db->select("SELECT * FROM dept WHERE father_id=0");
				$result2=$db->select("SELECT * FROM dept WHERE id=".$dept);
				$i=0;
				while(isset($result[$i])){
					if($result[$i]['id']==$result2[0]['father_id'])
						echo "<option value=\"".$result[$i]['id']."\" selected>".$result[$i]['name']."</option>";
					else						
						echo "<option value=\"".$result[$i]['id']."\">".$result[$i]['name']."</option>";
					$i=$i+1;
				}		
			?></td>
		  </tr>
		  <tr>
            <td>专&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;业</td>
			<td><select class="form-control" name="major">
			<?php
				$result=$db->select("SELECT * FROM dept WHERE father_id=".$result2[0]['father_id']);
				$i=0;
				while(isset($result[$i])){
					if($result[$i]['id']==$dept)
						echo "<option value=\"".$result[$i]['id']."\" selected>".$result[$i]['name']."</option>";
					else						
						echo "<option value=\"".$result[$i]['id']."\">".$result[$i]['name']."</option>";
					$i=$i+1;
				}		
			?></td>
		  </tr>	
		  <tr>
            <td>入职年份</td>
			<td><input type="text" name="year" class="form-control"  value="<?php echo $year;?>"></td>
		  </tr>
			<tr>
            <td>职&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;称</td>
			<td><input type="text" name="title" class="form-control"  value="<?php echo $title;?>"></td>
		  </tr>		  
		  <tr>
            <td>办公地址</td>
			<td><input type="text" name="address" class="form-control" value="<?php echo $address;?>"></td>
		  </tr>	
		  <tr>
            <td>电子邮箱</td>
			<td><input type="text" name="email" class="form-control" value="<?php echo $email;?>"></td>
		  </tr>		
		  <tr>
		      <td colspan="2" align="center"><br /><input type="submit" class="btn btn-lg btn-primary" value="保存"></td>
		  </tr>
		  </table
          </form>
		  <?php
		  }
		  ?>
          </div>		  
        </div>
      </div>
    </div>
  </body>
</html>
