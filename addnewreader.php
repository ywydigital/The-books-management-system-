<!doctype html>
<html>
<head>
<meta charset="gb2312">
<title>��Ӷ���</title>
</head>

<body>
	<?php
		$rID = $rName = $rSex = $rDept = $rGrade = '';
		$rIDErr = $rNameErr = $rSexErr = $rDeptErr = $rGradeErr = '';

		if(empty($_POST['rID']))
		{
			$rIDErr = "֤��û����д";
		}
		else
		{
			if(strlen($_POST['rID'])>8)
			{
				$rIDErr = "������Ŵ���8���ַ�";
			}
			else
			{
				$rID = $_POST['rID'];
			}
		}

		if(empty($_POST['rName']))
		{
            $rNameErr = "����û����д";
		}
		else
		{
            if(strlen($_POST['rName'])>20)
            {
                $rNameErr = "����д����������10����";
            }
            else
            {
                $rName = $_POST['rName'];
            }
		}

		if(empty($_POST['rSex']))
		{
            $rSexErr = "�Ա�û����д";
		}
		else
		{
            if(!strcmp($_POST['rSex'],"��")||!strcmp($_POST['rSex'],"Ů"))
            {
                $rSex = $_POST['rSex'];
            }
            else
            {
                $rSex = "�Ա������д���С���Ů��";
            }
		}

		if(empty($_POST['rDept']))
		{
            $rDeptErr = "ϵ��û����д";
		}
		else
		{
            if(strlen($_POST['rDept'])>20)
            {
                $rDeptErr = "����д����������10����";
            }
            else
            {
                $rDept = $_POST['rDept'];
            }
		}

		if(empty($_POST['rGrade']))
		{
			$rGradeErr = "�꼶û����д";
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
					$rGradeErr = "�����꼶Ӧ���Ǹ�������";
				}
			}
			else
			{
				$rGradeErr = "�����꼶Ӧ���Ǹ�������";
			}
		}
    ?>
    <?php
        $conn = odbc_connect('DBSTestAccess','','');
        $isrepeat = true;
        if(!$conn)
        {
            echo "Connection Failed";
			die();
        }
        if($rIDErr==''&&$rNameErr==''&&$rSexErr==''&&$rDeptErr==''&&$rGradeErr=='')
        {
            $sql0 = "SELECT rID FROM readerinfo WHERE rID='$rID'";
			$rs0 = odbc_exec($conn,$sql0);
			$id = odbc_result($rs0,"rID");
			if($id!='') $isrepeat = true;
			if($id=='')
			{
				$isrepeat = false;
				$sql = "INSERT INTO readerinfo
                        VALUES ('$rID','$rName','$rSex','$rDept',$rGrade)";
                $rs = odbc_exec($conn,$sql);
            }
        }
    ?>
    
    <?php
        if(!$isrepeat&&$rs)
        {
        		echo "<div id='result' style='display:none'>0</div>";
            echo "��Ӷ��߳ɹ�";
        }
    ?>
    
    <?php
        if($isrepeat&&!$rs&&$rIDErr==''&&$rNameErr==''&&$rSexErr==''&&$rDeptErr==''&&$rGradeErr=='')
        {
        	  echo "<div id='result' style='display:none'>1</div>";
            echo "��֤���Ѿ�����";
        }
    ?>
    
    <?php
    		if($rIDErr!=''||$rNameErr!=''||$rSexErr!=''||$rDeptErr!=''||$rGradeErr!=''){
    			echo "<div id='result' style='display:none'>2</div>";
    			}
        if($rIDErr!='') {echo "$rIDErr"; echo "</br>";}
        if($rNameErr!='') {echo "$rNameErr"; echo "</br>";}
        if($rSexErr!='') {echo "$rSexErr"; echo "</br>";}
        if($rDeptErr!='') {echo "$rDeptErr"; echo "</br>";}
        if($rGradeErr!='') {echo "$rGradeErr"; echo "</br>";}
    ?>
    <?php
		odbc_close($conn);
		?>
</body>
</html>
