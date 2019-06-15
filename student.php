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
            <li class="active"><a href="student.php">论文列表</a></li>
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
          <h1 class="page-header">欢迎使用论文管理系统（学生端）</h1>
		  <p>&nbsp;</p>
		  <?php
		  	if(is_array($_GET)&&count($_GET)==0){
		  ?>
          <h2 class="sub-header">我的一作论文</h2>
          <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>编号</th>
                  <th>标题</th>
                  <th>作者</th>
                  <th>状态</th>
				  <th>备注</th>
                  <th>下载链接</th>
				  <th>操作</th>
                </tr>
              </thead>
              <tbody>
				<?php 
					$result=$db->select("SELECT paper.id as paperid, title, author1, author2, author3, author4, author5, author6, state, remark, version, name FROM paper_author NATURAL JOIN paper LEFT OUTER JOIN file ON paper.id = file.paper_id WHERE author1_id = $userid AND (time=getLast_time(paper.id) OR time IS NULL)");
					$i=0;
					while(isset($result[$i])){
						echo "<tr><td>".$result[$i]['paperid']."</td>";
						echo "<td><a href=\"student.php?paperid=".$result[$i]['paperid']."\">".$result[$i]['title']."</td>";
						echo "<td>".$result[$i]['author1']."\t".$result[$i]['author2']."\t".$result[$i]['author3']."\t".$result[$i]['author4']."\t".$result[$i]['author5']."\t".$result[$i]['author6']."</td>";
						echo "<td>".$result[$i]['state']."</td>";
						echo "<td>".$result[$i]['remark']."</td>";
						echo "<td><a href=\"paperfile/".$result[$i]['name']."\">".$result[$i]['version']."</a></td>";
						if($result[$i]['state']=='未上传')
							echo "<td><a href=\"delete.php?paperid=".$result[$i]['paperid']."\" onclick=\"return confirm('确定删除吗?');\">删除</a></td>";
						else
							echo "<td />";							
						$i=$i+1;
					}						
				?>               
              </tbody>
            </table>
          </div>
		  <h2 class="sub-header">我参与的论文</h2>
          <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>编号</th>
                  <th>标题</th>
                  <th>作者</th>
                  <th>状态</th>
				  <th>备注</th>
                  <th>下载链接</th>
                </tr>
              </thead>
              <tbody>
                <?php 
					$result=$db->select("SELECT paper.id as paperid, title, author1, author2, author3, author4, author5, author6, state, remark, version, name FROM paper_author NATURAL JOIN paper LEFT OUTER JOIN file ON paper.id = file.paper_id WHERE isAuthor($userid, paper.id) and author1_id != $userid AND (time=getLast_time(paper.id) OR time IS NULL)");
					$i=0;
					while(isset($result[$i])){
						echo "<tr><td>".$result[$i]['paperid']."</td>";
						echo "<td>".$result[$i]['title']."</td>";
						echo "<td>".$result[$i]['author1']."\t".$result[$i]['author2']."\t".$result[$i]['author3']."\t".$result[$i]['author4']."\t".$result[$i]['author5']."\t".$result[$i]['author6']."</td>";
						echo "<td>".$result[$i]['state']."</td>";
						echo "<td>".$result[$i]['remark']."</td>";
						echo "<td><a href=\"paperfile/".$result[$i]['name']."\">".$result[$i]['version']."</a></td>";
						$i=$i+1;
					}						
				?>
              </tbody>
            </table>
          </div>
		  <?php
			}else{
			  $paperid=$_GET['paperid'];
			  $result=$db->select("SELECT * FROM paper_author NATURAL JOIN paper WHERE id=$paperid");
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
		  <form name="frm"action="changereport.php?paperid=<?php echo $paperid;?>" method="post">
			<table width="100%">
			<tbody>
		  <tr>
            <td>论文题目</td>
		  </tr>
		  <tr>
			<td><input type="text" name="title" class="form-control" value="<?php echo $title;?>"></td>
		  </tr>
		  <tr>
            <td><br/>选题来源</td>
		  </tr>
		  <tr>
			<td><input type="text" name="origin" class="form-control" value="<?php echo $origin;?>"></td>
		  </tr>
		  <tr>
            <td><br/>依托的实验室或机构</td>
		  </tr>
		  <tr>
			<td><input type="text" name="lab" class="form-control" value="<?php echo $lab;?>"></td>
		  </tr>
		  <tr>
            <td><br/>选题背景与意义</td>
		  </tr>		  
		  <tr>
		  <td><textarea name="background" class="form-control" rows="5"  style="OVERFLOW: scroll" ><?php echo $background;?></textarea></td>
		  </tr>
		  <tr>
            <td><br/>主要内容和预期目标</td>
		  </tr>		  
		  <tr>
		  <td><textarea name="content" class="form-control" rows="5"   style="OVERFLOW: scroll" ><?php echo $content;?></textarea></td>
		  </tr>
		  <tr>
            <td><br/>拟采用的研究方法、步骤</td>
		  </tr>	
		  <tr>
		  <td><textarea name="method" class="form-control" rows="5"   style="OVERFLOW: scroll" ><?php echo $method;?></textarea></td>
		  </tr>		  
		  <tr>
            <td><br/>研究总体安排与进度</td>
		  </tr>	
		  <tr>
		  <td><textarea name="plan" class="form-control" rows="5"   style="OVERFLOW: scroll"><?php echo $plan;?></textarea></td>
		  </tr>
		  <tr>
		      <td  align="center"><br /><input type="submit" class="btn btn-lg btn-primary" value="保存"></td>
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
