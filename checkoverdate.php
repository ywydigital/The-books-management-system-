<!doctype html>
<html>
<head>
<meta charset="gb2312">
<title>查看超期读者列表</title>
</head>

<body>
	<?PHP
	$conn = odbc_connect('DBSTestAccess','','');
	if (!$conn) {
	 	echo 'Connection Failed';
	 	die();
	}
	$time = time();
	$sql = "SELECT readerinfo.rID,rName,rSex,rDept,rGrade
	 				FROM readerinfo,borrow
	 				WHERE readerinfo.rID = borrow.rID AND borrow.sDateR<$time";
	$rs = odbc_exec($conn,$sql);
	?>
	<table border=1 id='result'>
		<?PHP
		while(odbc_fetch_row($rs)){
			echo '<tr>';
			$rid = odbc_result($rs,"rID");
			$rname = odbc_result($rs,"rName");
			$rsex = odbc_result($rs,"rSex");
			$rdept = odbc_result($rs,"rDept");
			$rgrade = odbc_result($rs,"rGrade");
			echo '<td>';echo "$rid";echo '</td>';
			echo '<td>';echo "$rname";echo '</td>';
			echo '<td>';echo "$rsex";echo '</td>';
			echo '<td>';echo "$rdept";echo '</td>';
			echo '<td>';echo "$rgrade";echo '</td>';
			echo '</tr>';
		}
		?>
	</table>
	<?PHP
	odbc_close($conn);
	?>
</body>
</html>
