<!doctype html>
<html>
<head>
<meta charset="gb2312">
<title>初始化数据库</title>
</head>

<body>
<?php
	$conn=odbc_connect('DBSTestAccess','','');
	if (!$conn)
 	{
		echo "Connection Failed";
		die();
	}
	$sql1 = "create table bookinfo
			(
				bID varchar(30) primary key,
				bName varchar(30),
				bPub varchar(30),
				bDate varchar(10),
				bAuthor varchar(20),
				bMem varchar(30),  
				bCnt int,
				bCnt1 int  
			);";
	$rs1 = odbc_exec($conn,$sql1);
	
	$sql2 = "create table readerinfo
			(
				rID varchar(8) primary key,
				rName varchar(20),
				rSex varchar(2),
				rDept varchar(20),
				rGrade int
			);";
	$rs2 = odbc_exec($conn,$sql2);
	
	$sql3 = "create table borrow
			(
				bID varchar(30),
				rID varchar(8),
				sDateB int,
				sDateR int,
				foreign key (bID) references bookinfo(bID),
				foreign key (rID) references readerinfo(rID) 
			);";
	$rs3 = odbc_exec($conn,$sql3);
?>	
	<?php
		if($rs1&&$rs2&&$rs3)
		{
			echo "<div id='result' style='display:none'>0</div>";
			echo "数据库初始化成功";
		}
	?>
	<?php
    	if (!$rs1||!$rs2||!$rs3)
 		{
 			echo "<div id='result' style='display:none'>1</div>";
			echo "数据库初始化失败";
			die();
		}
	?>
    <?php
		odbc_close($conn);
	?>
</body>
</html>