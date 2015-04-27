<!doctype html>
<html>
<head>
<meta charset="gb2312">
<title>删除读者</title>
</head>

<body>
	<?php
		$rIDErr = '';
		$rID = '';
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
	?>
	<?php
		$conn = odbc_connect('DBSTestAccess','','');
		$exist = false;
		$return = true;
		if(!$conn)
		{
			echo "Connection Faild";
			die();
		}
		if($rIDErr=='')
		{
            $sql0 = "SELECT rID FROM readerinfo WHERE rID = '$rID'";
            $rs0 = odbc_exec($conn,$sql0);
            $id0 = odbc_result($rs0,"rID");
            $sql1 = "SELECT rID FROM borrow WHERE rID = '$rID'";
            $rs1 = odbc_exec($conn,$sql1);
            $id1 = odbc_result($rs1,"rID");
            if($id0 != '') $exist = true;
            if($id1 == '') $return = false;
            if($exist&&!$return)
            {
                $sql = "DELETE * FROM readerinfo WHERE rID = '$rID'";
                $rs = odbc_exec($conn,$sql);
            }
        }
	?>
	
	<?php
        if($exist&&!$return&&$rs){
        	echo "<div id='result' style='display:none'>0</div>";
        	echo "删除读者成功";
        }
	?>
	
	<?php
        if(!$exist){
        		echo "<div id='result' style='display:none'>1</div>";
        	 echo "该证号不存在";
        }
	?>
	<?php
        if($exist&&$return){
						echo "<div id='result' style='display:none'>2</div>" ;       	
        	 echo "该读者尚有书籍未归还";
        	}
	?>
	<?php
		odbc_close($conn);
	?>
</body>
</html>
