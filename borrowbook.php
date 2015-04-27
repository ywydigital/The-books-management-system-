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
	$overdate = false;
	$borrow = false;
	$exist_book = false;
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
	
		if($exist_bid&&$exist_rid){
			$sql2 = "SELECT sDateR FROM borrow WHERE rID = '$rID'";
			$rs2 = odbc_exec($conn,$sql2);
			while(odbc_fetch_row($rs2)){
				$sdater = odbc_result($rs2,"sDateR");
				$date = time();
				if($sdater < $date) {$overdate = true; break;} //������δ��
				else $overdate = false;              //�޳�����
			}
		
			$sql3 = "SELECT bID FROM borrow WHERE rID = '$rID'";
			$rs3 = odbc_exec($conn,$sql3);
			while (odbc_fetch_row($rs3)){
				$bid = odbc_result($rs3,"bID");
				if(strcmp($bid,$bID)) $borrow = false;  //�ö���δ���ĸ���
				else {$borrow = true;break;}            //�ö����ѽ��ĸ���
			}
			 	 
			$sql4 = "SELECT bcnt1 FROM bookinfo WHERE bID = '$bID'";
			$rs4 = odbc_exec($conn,$sql4);
			$cnt = odbc_result($rs4,"bcnt1");
			if($cnt > 0) $exist_book = true;  //���黹���ڹ�����
			else $exist_book = false;            //����ȫ�����
		}
	}
	?>
	<?PHP
	if ($exist_bid&&$exist_rid&&!$overdate&&!$borrow&&$exist_book) {
		$btime = time();
		$rtime = $btime + (30*24*60*60);
		$sql = "INSERT INTO borrow VALUES('$bID','$rID',$btime,$rtime)";
		$rs = odbc_exec($conn,$sql);
		$sql5 = "UPDATE bookinfo SET bcnt1 = $cnt-1 WHERE bID = '$bID'";
		$rs5 = odbc_exec($conn,$sql5); 
	}
	?>
	<?PHP
	if ($exist_bid&&$exist_rid&&!$overdate&&!$borrow&&$exist_book&&$rIDErr==''&&$bIDErr==''&&$rs) {
		echo "<div id='result' style='display:none'>0</div>";
	 	echo '����ɹ�';
	 	echo '</br>';
	}
	?>
	
	<?PHP
	if ($rIDErr==''&&$bIDErr==''&&!$exist_rid) {
		echo "<div id='result' style='display:none'>1</div>";
	 	echo '֤�Ų�����';
	 	echo '</br>';
	}
	?>
	
	<?PHP
	if ($rIDErr==''&&$bIDErr==''&&!$exist_bid) {
		echo "<div id='result' style='display:none'>2</div>";
	 	echo '��Ų�����';
	 	echo '</br>';
	}
	?>
	
	<?PHP
	if ($rIDErr==''&&$bIDErr==''&&$overdate&&$exist_bid&&$exist_rid) {
		echo "<div id='result' style='display:none'>3</div>";
	 	echo '�ö����г�����δ��';
	 	echo '</br>';
	}
	?>
	
	<?PHP
	if ($rIDErr==''&&$bIDErr==''&&$borrow&&$exist_bid&&$exist_rid) {
		echo "<div id='result' style='display:none'>4</div>";
	 	echo '�ö����ѽ��ĸ���';
	 	echo '</br>';
	}
	?>
	
	<?PHP
	if ($rIDErr==''&&$bIDErr==''&&!$exist_book&&$exist_bid&&$exist_rid) {
		echo "<div id='result' style='display:none'>5</div>";
		echo '������ȫ�����';
		echo '</br>';
	}
	?>
	<?PHP
	if($bIDErr!=''||$rIDErr!=''){
		echo "<div id='result' style='display:none'>6</div>";
		}
	if ($bIDErr!='') {
	 	echo "$bIDErr";
	 	echo '</br>';
	}
	if ($rIDErr!='') {
	 	echo "$rIDErr";
	}
	?>
	<?php
		odbc_close($conn);
	?>
</body>
</html>