<!doctype html>
<html>
<head>
<meta charset="gb2312">
<title>查询书籍</title>
</head>

<body>
	<?PHP
	$rID = $bID = '';
	$rIDErr = $bIDErr = '';
	if (empty($_POST['rID'])) {
	 	$rIDErr = "还未填写证号";
	} 
	else {
	 	if (strlen($_POST['rID'])>8) {
	 	 	$rIDErr = '所填证号大于8个字符';
	 	}
	 	else {
	 	 	$rID = $_POST['rID'];
	 	}
	}
	
	if (empty($_POST['bID'])) {
	 	$bIDErr = "还未填写书号";
	} 
	else {
	 	if (strlen($_POST['bID'])>30) {
	 	 	$bIDErr = '所填书号大于30个字符';
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
		if($rid == '') $exist_rid = false; //rID不存在
		else $exist_rid = true;            //rID存在
	
		$sql1 = "SELECT bID FROM bookinfo WHERE bID = '$bID'";
		$rs1 = odbc_exec($conn,$sql1);
		$bid = odbc_result($rs1,"bID");
		if($bid == '') $exist_bid = false; //bID不存在
		else $exist_bid = true;            //bID存在	
		
		if ($exist_rid&&$exist_bid) {
		 	$sql2 = "SELECT bID FROM borrow WHERE rID = '$rID'";
		 	$rs2 = odbc_exec($conn,$sql2);
		 	while(odbc_fetch_row($rs2)){
		 		$bid = odbc_result($rs2,"bID");
		 		if($bid == $bID) {$borrowed = true;break;}//借有该书;
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
		echo "还书成功";echo "</br>";
	}
	?>
	
	<?PHP
	if($rIDErr==''&&$bIDErr==''&&!$exist_rid){
		echo "<div id='result' style='display:none'>1</div>";
		echo "证号不存在";echo "</br>";
	}
	?>
	
	<?PHP
	if($rIDErr==''&&$bIDErr==''&&!$exist_bid){
		echo "<div id='result' style='display:none'>2</div>";
		echo "书号不存在";echo "</br>";
	}
	?>
	
	<?PHP
	if($rIDErr==''&&$bIDErr==''&&$exist_rid&&$exist_bid&&!$borrowed){
		echo "<div id='result' style='display:none'>3</div>";
		echo "该读者并未借阅该书";
	}
	?>
	<?php
		odbc_close($conn);
	?>
</body>
</html>