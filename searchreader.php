<!doctype html>
<html>
<head>
<meta charset="gb2312">
<title>查询读者</title>
</head>

<body>
	<?php
		$rID = $rName = $rSex = $rDept = $rGrade0 = $rGrade1 = '';
		if(empty($_POST['rID']))
		{
			$rID = "%";
		}
		else
		{
			$rID = $_POST['rID'];
			$rID = "%$rID%";
		}

		if(empty($_POST['rName']))
		{
			$rName = "%";
		}
		else
		{
			$rName = $_POST['rName'];
			$rName = "%$rName%";
		}

		if(empty($_POST['rSex']))
		{
			$rSex = "%";
		}
		else
		{
			$rSex = $_POST['rSex'];
		}

		if(empty($_POST['rDept']))
		{
			$rDept = "%";
		}
		else {
		 	$rDept = $_POST['rDept'];
		 	$rDept = "%$rDept%";
		}
		
		if(empty($_POST['rGrade0'])){
			$rGrade0 = 0;	
			$rGrade1 = (int)$rGrade0;
		}
		else {
		 	$rGrade0 = $_POST['rGrade0'];
		 	$rGrade1 = (int)$rGrade0;
		}
		
		if(empty($_POST['rGrade1'])){
			$rGrade1 = 99999;	
			$rGrade1 = (int)$rGrade1;
		}
		else {
		 	$rGrade1 = $_POST['rGrade1'];
		 	$rGrade1 = (int)$rGrade1;
		}
	?>
    <?php
    $conn=odbc_connect('DBSTestAccess','','');
		if (!$conn)
 		{
			echo "Connection Failed";
			die();
		}
		$sql = "SELECT rID,rName,rSex,rDept,rGrade
						FROM readerinfo
						WHERE rID LIKE '$rID' AND rName LIKE '$rName' AND rSex LIKE '$rSex'
						AND rDept LIKE '$rDept' AND rGrade >= $rGrade0 AND rGrade <= $rGrade1";
		$rs = odbc_exec($conn,$sql);
    ?>
	 
	<table border=1 id="result">
		<?php
			while(odbc_fetch_row($rs))
			{
				$id = odbc_result($rs,"rID");
				$name = odbc_result($rs,"rName");
				$sex = odbc_result($rs,"rSex");
				$dept = odbc_result($rs,"rDept");
				$grade = odbc_result($rs,"rGrade");

       	echo "<tr>";
        echo "<td>"; echo "$id";     echo "</td>";
        echo "<td>"; echo "$name";   echo "</td>";
        echo "<td>"; echo "$sex";    echo "</td>";
        echo "<td>"; echo "$dept";   echo "</td>";
        echo "<td>"; echo "$grade";   echo "</td>";
				echo "</tr>";
		 }
		 ?>
	</table>
	<?php
		odbc_close($conn);
	?>
</body>
</html>
