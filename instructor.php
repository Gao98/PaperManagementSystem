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
			$result=$db->select("SELECT * FROM instructor WHERE id=$userid");
			$id=$result[0]['id'];
			$name=$result[0]['name'];
			echo "<li><a href='instructorinfo.php'>$name($id)</a></li>";
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
            <li class="active"><a href="instructor.php">邀请信息</a></li>
            <li><a href="guidancepaper.php">指导论文</a></li>
          </ul>
        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h1 class="page-header">欢迎使用论文管理系统（教师端）</h1>
		  <p>&nbsp;</p>
          <h2 class="sub-header">待处理的邀请信息</h2>
          <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>编号</th>
                  <th>标题</th>
                  <th>作者</th>
                  <th>状态</th>
                  <th>备注</th>
				  <th>操作</th>
                </tr>
              </thead>
              <tbody>
				<?php 
					if(is_array($_GET)&&count($_GET)==0){
						$result=$db->select("SELECT id, title, author1, author2, author3, author4, author5, author6, paper.state, remark FROM paper_author NATURAL JOIN paper JOIN guidance on id = paper_id WHERE instructor_id = $userid and guidance.state = '待同意'");
						$i=0;
						while(isset($result[$i])){
							$paperid=$result[$i]['id'];
							echo "<tr><td>".$paperid."</td>";
							echo "<td><a href=\"instructor.php?paperid=".$result[$i]['id']."\">".$result[$i]['title']."</a></td>";
							echo "<td>".$result[$i]['author1']."\t".$result[$i]['author2']."\t".$result[$i]['author3']."\t".$result[$i]['author4']."\t".$result[$i]['author5']."\t".$result[$i]['author6']."</td>";
							echo "<td>".$result[$i]['state']."</td>";
							echo "<td>".$result[$i]['remark']."</td>";							
							echo "<td><a href=\"agree.php?paperid=".$paperid."\">同意</a>&nbsp;<a href=\"refuse.php?paperid=".$paperid."\">拒绝</a></td>";							
							$i=$i+1;
						}	
					}
					else{
						$paperid=$_GET['paperid'];
						$result=$db->select("SELECT * FROM paper_author NATURAL JOIN paper WHERE id=$paperid");
						echo "<tr><td>".$result[0]['id']."</td>";
						echo "<td>".$result[0]['title']."</td>";
						echo "<td>".$result[0]['author1']."\t".$result[0]['author2']."\t".$result[0]['author3']."\t".$result[0]['author4']."\t".$result[0]['author5']."\t".$result[0]['author6']."</td>";
						echo "<td>".$result[0]['state']."</td>";
						echo "<td>".$result[0]['remark']."</td>";					
						echo "<td><a href=\"agree.php?paperid=".$paperid."\">同意</a>&nbsp;<a href=\"refuse.php?paperid=".$paperid."\">拒绝</a></td>";							
					}						
				?>               
              </tbody>
            </table>
          </div>
		  <?php
		  if(is_array($_GET)&&count($_GET)>0){
			  $title=$result[0]['title'];
			  $origin=$result[0]['origin'];
			  $lab=$result[0]['lab'];
			  $background=$result[0]['background'];
			  $content=$result[0]['content'];
			  $method=$result[0]['method'];
			  $plan=$result[0]['plan'];
		  ?>
		  <h2 class="sub-header">开题报告</h2>
		  <div class="table-responsive">
			<table width="100%">
			<tbody>
		  <tr>
            <td>论文题目</td>
		  </tr>
		  <tr>
			<td><input type="text" name="title" class="form-control" readonly="true" value="<?php echo $title;?>"></td>
		  </tr>
		  <tr>
            <td><br/>选题来源</td>
		  </tr>
		  <tr>
			<td><input type="text" name="origin" class="form-control" readonly="true" value="<?php echo $origin;?>"></td>
		  </tr>
		  <tr>
            <td><br/>依托的实验室或机构</td>
		  </tr>
		  <tr>
			<td><input type="text" name="lab" class="form-control" readonly="true" value="<?php echo $lab;?>"></td>
		  </tr>
		  <tr>
            <td><br/>选题背景与意义</td>
		  </tr>		  
		  <tr>
		  <td><textarea name="background" class="form-control" rows="5"   style="OVERFLOW: scroll" readonly="true"><?php echo $background;?></textarea></td>
		  </tr>
		  <tr>
            <td><br/>主要内容和预期目标</td>
		  </tr>		  
		  <tr>
		  <td><textarea name="content" class="form-control" rows="5"   style="OVERFLOW: scroll" readonly="true"><?php echo $content;?></textarea></td>
		  </tr>
		  <tr>
            <td><br/>拟采用的研究方法、步骤</td>
		  </tr>	
		  <tr>
		  <td><textarea name="method" class="form-control" rows="5"   style="OVERFLOW: scroll" readonly="true"><?php echo $method;?></textarea></td>
		  </tr>		  
		  <tr>
            <td><br/>研究总体安排与进度</td>
		  </tr>	
		  <tr>
		  <td><textarea name="plan" class="form-control" rows="5"   style="OVERFLOW: scroll" readonly="true"><?php echo $plan;?></textarea></td>
		  </tr>
		  </tbody>
  		  </table>
          </div>
		  <?php }?>
        </div>
      </div>
    </div>
  </body>
</html>
