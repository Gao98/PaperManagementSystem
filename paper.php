<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

    <title>学生论文管理系统</title>

    <!-- Bootstrap core CSS -->
    <link href="bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="dashboard.css" rel="stylesheet">
	<script language="javascript">
            function keywordOnkeyDown(){
                var keyWord=document.getElementById("keyWord").value;
                if(keyWord == "输入标题、姓名或院系来查找论文"){
                    document.getElementById("keyWord").value ="";
                }
            }
            function keywordOnkeyUp(){
                var keyWord=document.getElementById("keyWord").value;
                if(keyWord == ""){
                    document.getElementById("keyWord").value ="输入标题、姓名或院系来查找论文";
                }
            }
            function openSearch(){
                var keyWord=document.getElementById("keyWord").value;
                if(keyWord == "输入标题、姓名或院系来查找论文"){
                    alert("请输入搜索的关键词");
                    document.getElementById("keyWord").value ="";
                    document.getElementById("keyWord").focus();
                    return;
                }
                window.location.href = 'paper.php?search='+keyWord;
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
            <li><a href="admin.php">发表审核</a></li>
            <li class="active"><a href="paper.php">论文管理</a></li>
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
          <h1 class="page-header">论文汇总</h1>
		  <?php
		  include_once("include/sys_conf.inc");
		  $connection=@mysql_connect($DBHOST,$DBUSER,$DBPWD) or die("无法连接数据库！");
		  @mysql_query("set names utf8") ;
		  mysql_select_db("PMS") or die("无法选择数据库！");
		  if(isset($_GET['search'])){
			  $search = $_GET['search'];
			  $query="SELECT * FROM paper_author NATURAL JOIN paper JOIN student_info on paper.author1_id = student_info.id	WHERE author1 like '%$search%' OR author2 like '%$search%' OR author3 like '%$search%' OR author4 like '%$search%' OR author5 like '%$search%' OR author6 like '%$search%' OR title like '%$search%' OR school like '%$search%' OR major like '%$search%'";
		  }
		  else $query="SELECT * FROM paper";
		  $result=mysql_query($query,$connection) or die("读取数据失败");   
		  $count=@mysql_num_rows($result);   //统计留言主题信息
		  //制作信息条
		  $infostr="共有".$count." 篇论文。";
		  $numestr="";
		  if(isset($_GET['page'])) $page=$_GET['page'];
		  else $page=0;
		  $msgPerPage=10;   //设置一页中显示的最多记录数
		  $start=$page*$msgPerPage;   //设置每页开始的记录序号-1
		  $end=$start+$msgPerPage;   //设置每页结束的记录序号
		  if($end>$count)
		  	$end=$count;
		  $totalpage=ceil($count/$msgPerPage);
		  if($count>0) $infostr.="本页列出了第".($start+1)." 至 ".$end." 个。";
		  	//制作页导航
		  if($page>0)
		  	$numestr="<a href=$_SERVER[PHP_SELF]?page=".($page-1).">上一页|</a> ".$numestr; 
		  for($i=0;($i<$totalpage);$i++){
		  	if($i==$page) 
		  	$numestr=$numestr.($i+1);
		  	else 
		  	$numestr=$numestr."<a href=$_SERVER[PHP_SELF]?page=$i>".($i+1)."</a> ";
		  	if($i!=($totalpage-1))
		  		$numestr=$numestr." | ";
		  }
		  if($page<($totalpage-1))
		  	$numestr=$numestr."<a href=$_SERVER[PHP_SELF]?page=".($page+1).">|下一页</a>";
		  if(isset($_GET['search']))
			$result=$db->select("SELECT paper.id as paperid, title, author1, author2, author3, author4, author5, author6, school, state, version, file.name as name FROM paper_author NATURAL JOIN paper LEFT OUTER JOIN file ON paper.id = file.paper_id JOIN student_info on paper.author1_id = student_info.id WHERE (time=getLast_time(paper.id) OR time IS NULL) AND (author1 like '%$search%' OR author2 like '%$search%' OR author3 like '%$search%' OR author4 like '%$search%' OR author5 like '%$search%' OR author6 like '%$search%' OR title like '%$search%' OR school like '%$search%' OR major like '%$search%') LIMIT $start,$msgPerPage");		  
		  else $result=$db->select("SELECT paper.id as paperid, title, author1, author2, author3, author4, author5, author6, school, state, version, file.name as name FROM paper_author NATURAL JOIN paper LEFT OUTER JOIN file ON paper.id = file.paper_id JOIN student_info on paper.author1_id = student_info.id WHERE time=getLast_time(paper.id) OR time IS NULL LIMIT $start,$msgPerPage");		  
		  ?>
		  <table width="100%">
		  <tr><td><h4><?php echo $infostr;?></h4><td>
		  <td align="right"><input id='keyWord' type='text' name='keyWord' class="form-control" style="width:300;height:40;" onBlur="keywordOnkeyUp()" onFocus="keywordOnkeyDown()" onKeyUp="keywordOnkeyDown()" value="输入标题、姓名或院系来查找论文" style="-webkit-border-radius:5px;-moz-border-radius:5px;-ms-border-radius:5px;-o-border-radius:5px;border-radius:5px;">
          </td>
          <td align="right"><input name="button" type="button" class="btn btn-lg btn-primary" onClick="openSearch();" value="搜索"/></td></tr>
		  </table>
          <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>编号</th>
                  <th>标题</th>
                  <th>作者</th>
				  <th>学院</th>
                  <th>状态</th>
                  <th>下载链接</th>
                  <th>操作</th>
                </tr>
              </thead>
              <tbody>
                <?php 
					$i=0;
					while(isset($result[$i])){
						echo "<tr><td>".$result[$i]['paperid']."</td>";
						echo "<td>".$result[$i]['title']."</td>";
						echo "<td>".$result[$i]['author1']."\t".$result[$i]['author2']."\t".$result[$i]['author3']."\t".$result[$i]['author4']."\t".$result[$i]['author5']."\t".$result[$i]['author6']."</td>";
						echo "<td>".$result[$i]['school']."</td>";
						echo "<td>".$result[$i]['state']."</td>";
						echo "<td><a href=\"paperfile/".$result[$i]['name']."\">".$result[$i]['version']."</a></td>";
						echo "<td><a href=\"delete.php?paperid=".$result[$i]['paperid']."\" onclick=\"return confirm('确定删除吗?');\">删除</a></td>";
						$i=$i+1;
					}						
				?>
              </tbody>
            </table>
			<h4 width="100%" align="center"><?php echo $numestr;?></h4>
          </div>
		  
			
        </div>
      </div>
    </div>
  </body>
</html>
