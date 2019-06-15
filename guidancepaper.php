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
            <li><a href="instructor.php">邀请信息</a></li>
            <li class="active"><a href="guidancepaper.php">指导论文</a></li>
          </ul>
        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h1 class="page-header">指导学生论文</h1>
		  <p>&nbsp;</p>
          <h2 class="sub-header">选择要指导的论文</h2>
          <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>编号</th>
                  <th>标题</th>
                  <th>作者</th>
                  <th>状态</th>
                  <th>备注</th>
				  <th>上次上传文件</th>
				  <th>上次上传时间</th>
                </tr>
              </thead>
              <tbody>
				<?php 
					if(is_array($_GET)&&count($_GET)==0){
						$result=$db->select("SELECT id, title, author1, author2, author3, author4, author5, author6, paper.state, remark, getLast_version(id) as last_version, getLast_time(id) as last_time FROM paper_author NATURAL JOIN paper JOIN guidance on id = paper_id WHERE instructor_id = $userid and guidance.state = '已同意' ORDER BY last_time DESC");
						$i=0;
						while(isset($result[$i])){
							$paperid=$result[$i]['id'];
							echo "<tr><td>".$paperid."</td>";
							echo "<td><a href=\"guidancepaper.php?paperid=".$result[$i]['id']."\">".$result[$i]['title']."</a></td>";
							echo "<td>".$result[$i]['author1']."\t".$result[$i]['author2']."\t".$result[$i]['author3']."\t".$result[$i]['author4']."\t".$result[$i]['author5']."\t".$result[$i]['author6']."</td>";
							echo "<td>".$result[$i]['state']."</td>";
							echo "<td>".$result[$i]['remark']."</td>";							
							echo "<td>".$result[$i]['last_version']."</td>";							
							echo "<td>".$result[$i]['last_time']."</td>";							
							$i=$i+1;
						}	
					}
					else{
						$paperid=$_GET['paperid'];
						$result=$db->select("SELECT id, title, author1, author2, author3, author4, author5, author6, paper.state, remark, getLast_version(id) as last_version, getLast_time(id) as last_time FROM paper_author NATURAL JOIN paper WHERE id =$paperid ORDER BY last_time DESC");
						echo "<tr><td>".$result[0]['id']."</td>";
						echo "<td>".$result[0]['title']."</td>";
						echo "<td>".$result[0]['author1']."\t".$result[0]['author2']."\t".$result[0]['author3']."\t".$result[0]['author4']."\t".$result[0]['author5']."\t".$result[0]['author6']."</td>";
						echo "<td>".$result[0]['state']."</td>";
						echo "<td>".$result[0]['remark']."</td>";					
						echo "<td>".$result[0]['last_version']."</td>";							
						echo "<td>".$result[0]['last_time']."</td>";					}						
				?>               
              </tbody>
            </table>
          </div>
		  <?php
		  if(is_array($_GET)&&count($_GET)>0){
		  ?>
		  <h2 class="sub-header">选择要查看的版本</h2>
          <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>编号</th>
                  <th>标题</th>
                  <th>作者</th>
				  <th>下载链接</th>
				  <th>上传时间</th>
                </tr>
              </thead>
              <tbody>
				<?php 
					if(is_array($_GET)&&count($_GET)==1){
						$result=$db->select("SELECT paper.id as paperid, file.id as fileid, title, author1, author2, author3, author4, author5, author6, version, name, time FROM paper_author NATURAL JOIN paper JOIN file on paper.id = file.paper_id WHERE paper.id = $paperid ORDER BY time DESC");
						$i=0;
						while(isset($result[$i])){
							echo "<tr><td>".$paperid."</td>";
							echo "<td><a href=\"guidancepaper.php?paperid=".$paperid."&fileid=".$result[$i]['fileid']."\">".$result[$i]['title']."</a></td>";
							echo "<td>".$result[$i]['author1']."\t".$result[$i]['author2']."\t".$result[$i]['author3']."\t".$result[$i]['author4']."\t".$result[$i]['author5']."\t".$result[$i]['author6']."</td>";
							echo "<td><a href=\"paperfile/".$result[$i]['name']."\">".$result[$i]['version']."</a></td>";
							echo "<td>".$result[$i]['time']."</td>";							
							$i=$i+1;
						}	
					}
					else if(count($_GET)==2){
						$fileid=$_GET['fileid'];
						$result=$db->select("SELECT paper.id, title, author1, author2, author3, author4, author5, author6, version, name, time FROM paper_author NATURAL JOIN paper JOIN file on paper.id = file.paper_id WHERE file.id = $fileid");
						echo "<tr><td>".$paperid."</td>";
						echo "<td>".$result[0]['title']."</td>";
						echo "<td>".$result[0]['author1']."\t".$result[0]['author2']."\t".$result[0]['author3']."\t".$result[0]['author4']."\t".$result[0]['author5']."\t".$result[0]['author6']."</td>";
						echo "<td><a href=\"paperfile/".$result[0]['name']."\">".$result[0]['version']."</a></td>";
						echo "<td>".$result[0]['time']."</td>";				
						}						
				?>               
              </tbody>
            </table>
          </div>
		  <?php 
		  }
		  if(count($_GET)==2){
			  
		  ?>
		  <h2 class="sub-header">该版本指导信息</h2>
		  <div class="table-responsive">
			<table width="100%">
			<?php
				$result=$db->select("SELECT name, time, content FROM suggestion JOIN instructor ON suggestion.instructor_id = instructor.id WHERE file_id = $fileid");
				$i=0;
				while(isset($result[$i])){
					echo "<tr><td><h4>".$result[$i]['name']."</h4></td>";
					echo "<td><h4 align=\"right\">".$result[$i]['time']."</h4></td><tr>";
					echo "<tr><td colspan=\"2\"><textarea class=\"form-control\" rows=\"5\" style=\"OVERFLOW: scroll\" readonly=\"true\">".$result[$i]['content']."</textarea></td></tr>	";							
					$i=$i+1;
				}
				if($i==0)
					echo "<h3 width=\"100%\" align=\"center\">暂无指导信息</h3>";
			?>
			<table>
          </div>
		  <h2 class="sub-header">新增指导</h2>
		  <div class="table-responsive">
			<form name="frm"action="addsuggestion.php?fileid=<?php echo $fileid;?>" method="post">
		  <table style="width:100%;"  cellpadding="0" cellspacing="0">
		  <tbody>
		  <tr>
		  <td><textarea name="content" class="form-control" rows="10"  style="OVERFLOW: hidden"></textarea></td>
		  </tr>	
		  <tr>
		      <td align="center"><br /><input type="submit" class="btn btn-lg btn-primary" value="提交"></td>
		  </tr>
		  </tbody>
		  </table>
          </form>
          </div>
		  <?php }?>
        </div>
      </div>
    </div>
  </body>
</html>
