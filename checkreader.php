<!doctype html>
<html>
<head>
<meta charset="gb2312">
<title>�鿴����δ������Ϣ</title>
</head>

<body>
	<?PHP
	$rID = $rIDErr = '';
	if(empty($_POST['rID'])){
		$rIDErr = "��δ��д֤��";
	}
	else {
		if (strlen($_POST['rID'])>8) {
		 	$rIDErr = "����֤�Ŵ���8���ַ�";
		}	 	
		else {
		 	$rID = $_POST['rID'];
		}
	}
	?>
	<?PHP
	$conn = odbc_connect('DBSTestAccess','','');
	if (!$conn) {
	 	echo 'Connection Failed';
	 	die();
	}
	$sql = "SELECT borrow.bID,bookinfo.bName,sDateB,sDateR
					FROM bookinfo,borrow
					WHERE rID = '$rID' AND borrow.bID = bookinfo.bID";
	$rs = odbc_exec($conn,$sql);
	?>
	<table border=1 id='result'>
		<?PHP
		$time = time();
		while(odbc_fetch_row($rs)){
			echo '<tr>';
			$rid = odbc_result($rs,"bID");
			$bname = odbc_result($rs,"bName");
			$btime = odbc_result($rs,"sDateB");
			$rtime = odbc_result($rs,"sDateR");
			echo '<td>';echo "$rid";echo '</td>';
			echo '<td>';echo "$bname";echo '</td>';
			echo '<td>';echo (date('Y-m-d',$btime));echo '</td>';
			echo '<td>';echo (date('Y-m-d',$rtime));echo '</td>';
			echo '<td>';
			if($time>$rtime) echo "��";
			else echo "��";
			echo '</td>';
			echo '</tr>';
		}
		?>
	</table>
	<?PHP
	odbc_close($conn);
	?>
</body>
</html>
