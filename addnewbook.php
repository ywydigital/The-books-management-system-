<!doctype html>
<html>
<head>
<meta charset="gb2312">
<title>������鼮</title>
</head>

<body>
	<?php
		$bID = $bName = $bPub = $bDate = $bAuthor = $bMem = $bCnt = '';
		$bIDErr = $bNameErr = $bPubErr = $bDateErr = $bAuthorErr = $bMemErr = $bCntErr = '';
		if(empty($_POST['bID']))
		{
			$bIDErr = "���û����д";
		}
		else
		{
			if(strlen($_POST['bID'])>30)
			{
				$bIDErr = '������Ŵ���30���ַ�';
			}
			else
			{
				$bID = $_POST['bID'];
			}
		}
		
		if(empty($_POST['bName']))
		{
			$bNameErr = "����û����д";
		}
		else
		{
			if(strlen($_POST['bName'])>30)
			{
				$bNameErr = "������������30���ַ�";
			}
			else
			{
				$bName = $_POST['bName'];
			}
		}
		
		if(empty($_POST['bPub']))
		{
			$bPubErr = "������û����д";
		}
		else
		{
			if(strlen($_POST['bPub'])>30)
			{
				$bPubErr = "������������30���ַ�";
			}
			else
			{
				$bPub = $_POST['bPub'];
			}
		}
		
		if(empty($_POST['bDate']))
		{
			$bDateErr = "��������û����д";
		}
		else
		{
			$date = $_POST['bDate'];
			$date = (string)$date;
			$len = strlen($date);
			$ischeck = true;
			for($i=0;$i<$len;$i++)
			{
				if(($i==4||$i==7))
				{
					if($date[$i]!='-')
					{
						$ischeck = false;
					}
				} 
				else
				{
					if($date[$i]<'0'||$date[$i]>'9')
					{
						$ischeck = false;
					}
				}
			}
			if($len!=10)
			{
				$ischeck = false;	
			}
			if($ischeck)
			{
				$bDate = $_POST['bDate'];
			}
			else
			{
				$bDateErr = "��������ڸ�ʽ����";
			}
		}
		
		if(empty($_POST['bAuthor']))
		{
			$bAuthorErr = "����û����д";
		}
		else
		{
			if(strlen($_POST['bAuthor'])>20)
			{
				$bAuthorErr = "�������ߴ���20���ַ�";
			}
			else
			{
				$bAuthor = $_POST['bAuthor'];
			}
		}
		
		if(empty($_POST['bMem']))
		{
			$bMemErr = "����ժҪû����д";
		}
		else
		{
			if(strlen($_POST['bMem'])>30)
			{
				$bAuthorErr = "��������ժҪ����30���ַ�";
			}
			else
			{
				$bMem = $_POST['bMem'];
			}
		}
		
		if(empty($_POST['bCnt']))
		{
			$bCntErr = "�鼮����û����д";
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
					$bCntErr = "�����鼮����������Ҫ��";
				}
			}
			else
			{
				$bCntErr = "�����鼮����������Ҫ��";	
			}
		}
	?>
    <?php
		$conn=odbc_connect('DBSTestAccess','','');
		$isrepeat = true;
		if (!$conn)
 		{
			echo "Connection Failed";
			die();
		}
		if($bIDErr==''&&$bNameErr==''&&$bPubErr==''&&$bAuthorErr==''&&$bDateErr==''&&$bMemErr==''&&$bCntErr=='')
		{
			$sql0 = "SELECT bID FROM bookinfo WHERE bID='$bID'";
			$rs0 = odbc_exec($conn,$sql0);
			$id = odbc_result($rs0,"bID");
			if($id!='') $isrepeat = true;
			if($id=='')
			{
				$isrepeat = false;
				$sql = "INSERT INTO bookinfo
						VALUES 
						('$bID','$bName','$bPub','$bDate','$bAuthor','$bMem',$bCnt,$bCnt)";
				$rs = odbc_exec($conn,$sql);
			}
		}
	?>

    <?php
		if(!$isrepeat&&$rs)
		{
			echo "<div id='result' style='display:none'>0</div>";
			echo "����鼮�ɹ�";
		}
	?>
    
    <?php
		if($isrepeat&&!$rs&&$bIDErr==''&&$bNameErr==''&&$bPubErr==''&&$bAuthorErr==''&&$bDateErr==''&&$bMemErr==''&&$bCntErr=='')
		{
			echo "<div id='result' style='display:none'>1</div>";
			echo "�����Ѿ�����";
		}
    ?>
    <?php
    if($bIDErr!=''||$bNameErr!=''||$bPubErr!=''||$bDateErr!=''||$bAuthorErr!=''||$bMemErr!=''||$bCntErr!=''){
    	echo "<div id='result' style='display:none'>2</div>";
    }
		if($bIDErr!='') { echo "$bIDErr";echo "</br>";}
		if($bNameErr!='') {echo "$bNameErr";echo "</br>";}
		if($bPubErr!='') {echo "$bPubErr";echo "</br>";}
		if($bDateErr!='') {echo "$bDateErr";echo "</br>";}
		if($bAuthorErr!='') {echo "$bAuthorErr";echo "</br>";}
		if($bMemErr!='')  {echo "$bMemErr";echo "</br>";}
		if($bCntErr!='') {echo "$bCntErr";}
	?>
</body>
</html>