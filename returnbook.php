<!doctype html>
<html>
<head>
<meta charset="gb2312">
<title>��ѯ�鼮</title>
</head>

<body>
	<?PHP
	$rID = $bID = '';
	$rIDErr = $bIDErr = '';
	if (empty($_POST['rID'])) {
	 	$rIDErr = "��δ��д֤��";
	} 
	else {
	 	if (strlen($_POST['rID'])>8) {
	 	 	$rIDErr = '����֤�Ŵ���8���ַ�';
	 	}
	 	else {
	 	 	$rID = $_POST['rID'];
	 	}
	}
	
	if (empty($_POST['bID'])) {
	 	$bIDErr = "��δ��д���";
	} 
	else {
	 	if (strlen($_POST['bID'])>30) {
	 	 	$bIDErr = '������Ŵ���30���ַ�';
	 	}
	 	else {
	 	 	$bID = $_POST['bID'];
	 	}
	}
	?>
	<?PHP
	$conn = odbc_connect('DBSTestAccess','','');
	$exist_rid = $exist_bid = false;
	$borrowed = false;
	if (!$conn) {
	 	echo 'Connection Failed';
	 	die();
	}
	
	if ($rIDErr==''&&$bIDErr=='') {
	 	$sql0 = "SELECT rID FROM readerinfo WHERE rID = '$rID'";
		$rs0 = odbc_exec($conn,$sql0);
		$rid = odbc_result($rs0,"rID");
		if($rid == '') $exist_rid = false; //rID������
		else $exist_rid = true;            //rID����
	
		$sql1 = "SELECT bID FROM bookinfo WHERE bID = '$bID'";
		$rs1 = odbc_exec($conn,$sql1);
		$bid = odbc_result($rs1,"bID");
		if($bid == '') $exist_bid = false; //bID������
		else $exist_bid = true;            //bID����	
		
		if ($exist_rid&&$exist_bid) {
		 	$sql2 = "SELECT bID FROM borrow WHERE rID = '$rID'";
		 	$rs2 = odbc_exec($conn,$sql2);
		 	while(odbc_fetch_row($rs2)){
		 		$bid = odbc_result($rs2,"bID");
		 		if($bid == $bID) {$borrowed = true;break;}//���и���;
		 		else $borrowed = false;
		 	}
		}
	}
	?>
	<?PHP
	if($exist_rid&&$exist_bid&&$borrowed){
		$sql3 = "DELETE * FROM borrow WHERE rID = '$rID' AND bID = '$bID'";
		$rs3 = odbc_exec($conn,$sql3);
		$sql4 = "SELECT bCnt1 FROM bookinfo WHERE bID = '$bID'";
		$rs4 = odbc_exec($conn,$sql4);
		$cnt = odbc_result($rs4,"bCnt1");
		$sql4 = "UPDATE bookinfo SET bCnt1 = $cnt+1 WHERE bID = '$bID'";
		$rs4 = odbc_exec($conn,$sql4);
	}
	?>
	
	<?PHP
	if($rIDErr==''&&$bIDErr==''&&$exist_rid&&$exist_bid&&$borrowed&&$rs3){
		echo "<div id='result' style='display:none'>0</div>";
		echo "����ɹ�";echo "</br>";
	}
	?>
	
	<?PHP
	if($rIDErr==''&&$bIDErr==''&&!$exist_rid){
		echo "<div id='result' style='display:none'>1</div>";
		echo "֤�Ų�����";echo "</br>";
	}
	?>
	
	<?PHP
	if($rIDErr==''&&$bIDErr==''&&!$exist_bid){
		echo "<div id='result' style='display:none'>2</div>";
		echo "��Ų�����";echo "</br>";
	}
	?>
	
	<?PHP
	if($rIDErr==''&&$bIDErr==''&&$exist_rid&&$exist_bid&&!$borrowed){
		echo "<div id='result' style='display:none'>3</div>";
		echo "�ö��߲�δ���ĸ���";
	}
	?>
	<?php
		odbc_close($conn);
	?>
</body>
</html>