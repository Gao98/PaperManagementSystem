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
            <li class="active"><a href="admin.php">发表审核</a></li>
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
          <h1 class="page-header">欢迎使用论文管理系统（管理端）</h1>
		  <p>&nbsp;</p>
          <h2 class="sub-header">待处理的审核信息</h2>
          <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>编号</th>
                  <th>标题</th>
                  <th>作者</th>
                  <th>下载链接</th>
                  <th>发表刊物</th>
				  <th>证明材料</th>
				  <th>审核选项</th>
                </tr>
              </thead>
              <tbody>
				<?php 
					$result=$db->select("SELECT publication.id as publicationid, paper.id as paperid, title, author1, author2, author3, author4, author5, author6, getLast_version(paper_id) as version, getLast_file(paper_id) as file, publication, filename FROM paper_author NATURAL JOIN paper JOIN publication ON paper.id = publication.paper_id WHERE publication.state = '待审核'");
					$i=0;
					while(isset($result[$i])){
						echo "<tr><td>".$result[$i]['paperid']."</td>";
						echo "<td>".$result[$i]['title']."</td>";
						echo "<td>".$result[$i]['author1']."\t".$result[$i]['author2']."\t".$result[$i]['author3']."\t".$result[$i]['author4']."\t".$result[$i]['author5']."\t".$result[$i]['author6']."</td>";
						echo "<td><a href=\"paperfile/".$result[$i]['file']."\">".$result[$i]['version']."</a></td>";
						echo "<td>".$result[$i]['publication']."</td>";
						echo "<td><a href=\"registerfile/".$result[$i]['filename']."\">查看</a></td>";
						echo "<td><a href=\"success.php?id=".$result[$i]['publicationid']."\">通过</a>&nbsp;<a href=\"fail.php?id=".$result[$i]['publicationid']."\">不通过</a></td>";
						$i=$i+1;
					}
					if($i==0)
						echo "<tr><td colspan=\"7\"><h4 width=\"100%\" align=\"center\">没有待处理的审核信息！</h4></td></tr>";
				?>               
              </tbody>
            </table>
          </div>		  
        </div>
      </div>
    </div>
  </body>
</html>
