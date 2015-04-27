<!doctype html>
<html>
<head>
<meta charset="gb2312">
<title>修改读者信息</title>
</head>

<body>
	<?php
		$rID = $rName = $rSex = $rDept = $rGrade = '';
		$rIDErr = $rNameErr = $rSexErr = $rDeptErr = $rGradeErr = '';
		if(empty($_POST['rID']))
		{
			$rIDErr = "证号没有填写";
		}
		else
		{
			if(strlen($_POST['rID'])>8)
			{
				$rIDErr = '所填证号大于8个字符';
			}
			else
			{
				$rID = $_POST['rID'];
			}
		}

		if(empty($_POST['rName']))
		{
			$rNameErr = "姓名没有填写";
		}
		else
		{
			if(strlen($_POST['rName'])>20)
			{
				$rNameErr = "所填姓名大于10个字";
			}
			else
			{
				$rName = $_POST['rName'];
			}
		}

		if(empty($_POST['rSex']))
		{
			$rSexErr = "性别没有填写";
		}
		else
		{
			if(strcmp($_POST['rSex'],"男")&&strcmp($_POST['rSex'],"女"))
			{
				$rSexErr = "性别应该填写'男'或'女'";
			}
			else
			{
				$rSex = $_POST['rSex'];
			}
		}

		if(empty($_POST['rDept']))
		{
			$rDeptErr = "系名没有填写";
		}
		else
		{
			if(strlen($_POST['rDept'])>20)
			{
				$rDeptErr = "所填系名大于10个字";
			}
			else
			{
				$rDept = $_POST['rDept'];
			}
		}

		if(empty($_POST['rGrade']))
		{
			$rGradeErr = "年级没有填写";
		}
		else
		{
			$grade = (string)$_POST['rGrade'];
			$isnum = true;
			for($i=0;$i<strlen($grade);$i++)
			{
				if($grade[$i]<'0'||$grade[$i]>'9')
				{
					$isnum = false;
				}
			}
			if($isnum)
			{
				$grade = (int)$grade;
				if($grade>0)
				{
					$rGrade = $_POST['rGrade'];
				}
				else
				{
					$rGradeErr = "所填年级应该是个正整数";
				}
			}
			else
			{
				$rGradeErr = "所填年级应该是个正整数";
			}
		}

	?>
    <?php
		$conn=odbc_connect('DBSTestAccess','','');
		$isexist = false;
		if (!$conn)
 		{
			echo "Connection Failed";
			die();
		}
		if($rIDErr==''&&$rNameErr==''&&$rSexErr==''&&$rDeptErr==''&&$rGradeErr=='')
		{
			$sql0 = "SELECT rID FROM readerinfo WHERE rID='$rID'";
			$rs0 = odbc_exec($conn,$sql0);
			$id = odbc_result($rs0,"rID");
			if($id=='') $isexist = false;
			if($id!='')
			{
				$isexist = true;
				$sql = "UPDATE readerinfo
					SET rName='$rName',rSex='$rSex',rDept='$rDept',rGrade=$rGrade
					WHERE rID='$rID'";
				$rs = odbc_exec($conn,$sql);
			}
		}
	?>
    
    <?php
		if($isexist&&$rs)
		{
			echo "<div id='result' style='display:none'>0</div>";
			echo "修改读者信息成功";
		}
	?>
    
    <?php
		if(!$isexist&&!$rs&&$rIDErr==''&&$rNameErr==''&&$rSexErr==''&&$rDeptErr==''&&$rGradeErr=='')
		{
			echo "<div id='result' style='display:none'>1</div>";
			echo "该证号不存在";
		}
    ?>
    
    <?php
    if($rIDErr!=''||$rNameErr!=''||$rSexErr!=''||$rDeptErr!=''||$rGradeErr!=''){
    	echo "<div id='result' style='display:none'>2</div>";
    	}
		if($rIDErr!='') {echo "$rIDErr";echo "</br>";}
		if($rNameErr!='') {echo "$rNameErr";echo "</br>";}
		if($rSexErr!='') {echo "$rSexErr";echo "</br>";}
		if($rDeptErr!='') {echo "$rDeptErr";echo "</br>";}
		if($rGradeErr!='') {echo "$rGradeErr";echo "</br>";}
	?>
    <?php
		odbc_close($conn);
	?>
</body>
</html>
