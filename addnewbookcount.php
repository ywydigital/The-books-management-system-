<!doctype html>
<html>
<head>
<meta charset="gb2312">
<title>添加书籍数量</title>
</head>

<body>
	<?php
		$bIDErr = $bCntErr = '';
		$bID = $bCnt = '';
	 	if(empty($_POST['bID']))
		{
			$bIDErr = "书号没有填写";
		}
		else
		{
			if(strlen($_POST['bID'])>30)
			{
				$bIDErr = '所填书号大于30个字符';
			}
			else
			{
				$bID = $_POST['bID'];
			}
		}

		if(empty($_POST['bCnt']))
		{
			$bCntErr = "书籍数量没有填写";
		}
		else
		{
			$cnt = (string)$_POST['bCnt'];
			$isnum = true;
			for($i=0;$i<strlen($cnt);$i++)
			{
				if($cnt[$i]<'0'||$cnt[$i]>'9')
				{
					$isnum = false;
				}
			}
			if($isnum)
			{
				$cnt = (int)$cnt;
				if($cnt>0)
				{
					$bCnt = $_POST['bCnt'];
				}
				else
				{
					$bCntErr = "所填书籍数量不符合要求";
				}
			}
			else
			{
				$bCntErr = "所填书籍数量不符合要求";	
			}
		}
	?>
	<?php
		$conn = odbc_connect('DBSTestAccess','','');
		$issuccess = false;
		if(!$conn)
		{
			echo "Connection Faild";
			die();
		}
		if($bIDErr==''&&$bCntErr=='')
		{
			$sql0 = "SELECT bID,bCnt,bCnt1 FROM bookinfo WHERE bID='$bID'";
			$rs0 = odbc_exec($conn,$sql0);
			$id = odbc_result($rs0,"bID");
			$count = odbc_result($rs0,"bCnt");
			$count1 = odbc_result($rs0,"bCnt1");
			if($id=='') $issuccess = false;
			else
			{
				$issuccess = true;
				$sql = "UPDATE bookinfo 
					SET bCnt=$count+$bCnt,bCnt1=$count1+$bCnt
					WHERE bID='$bID'";
				$rs = odbc_exec($conn,$sql);
			}
		}
	?>
	
	<?php
		if($issuccess&&$rs)
		{
			echo "<div id='result' style='display:none'>0</div>";
			echo "添加书籍数量成功";
		}
	?>
	
	<?php
		if(!$issuccess&&!$rs&&$bIDErr==''&&$bCntErr=='')
		{
			echo "<div id='result' style='display:none'>1</div>";
			echo "该书不存在";
		}
	?>
	
	<?php
	  if($bIDErr!=''||$bCntErr!=''){
	  	echo "<div id='result' style='display:none'>2</div>";
	  }
		if($bIDErr!='') {echo "$bIDErr";echo "</br>";}
		if($bCntErr!='') {echo "$bCntErr";}
	?>
	<?php
		odbc_close($conn);
	?>
</body>
</html>