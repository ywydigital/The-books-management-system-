<!doctype html>
<html>
<head>
<meta charset="gb2312">
<title>查询书籍</title>
</head>

<body>
	<?php
		$bID = $bName = $bPub = $bDate0 = $bDate1 = $bAuthor = $bMem = '';
		if(empty($_POST['bID']))
		{
			$bID = "%";
		}
		else
		{
			$bID = $_POST['bID'];
			$bID = "%$bID%";
		}

		if(empty($_POST['bName']))
		{
			$bName = "%";
		}
		else
		{
			$bName = $_POST['bName'];
			$bName = "%$bName%";
		}

		if(empty($_POST['bPub']))
		{
			$bPub = "%";
		}
		else
		{
			$bPub = $_POST['bPub'];
			$bPub = "%$bPub%";
		}

		if(empty($_POST['bDate0']))
		{
			$bDate0 = "0000-00-00";
		}
		else
		{
			$bDate0 = $_POST['bDate0'];
		}

		if(empty($_POST['bDate1']))
		{
			$bDate1 = "9999-99-99";
		}
		else
		{
			$bDate1 = $_POST['bDate1'];
		}

		if(empty($_POST['bAuthor']))
		{
			$bAuthor = "%";
		}
		else
		{
			$bAuthor = $_POST['bAuthor'];
			$bAuthor = "%$bAuthor%";
		}

		if(empty($_POST['bMem']))
		{
			$bMem = "%";
		}
		else
		{
			$bMem = $_POST['bAuthor'];
			$bMem = "%$bAuthor%";
		}
	?>
    <?php
		$conn=odbc_connect('DBSTestAccess','','');
		if (!$conn)
 		{
			echo "Connection Failed";
			die();
		}
		$sql = "SELECT bID,bName,bCnt,bCnt1,bPub,bDate,bAuthor,bMem
				FROM bookinfo
				WHERE bID LIKE '$bID' AND bName LIKE '$bName' AND bPub LIKE '$bPub'
				AND bDate>='$bDate0' AND bDate<='$bDate1' AND bAuthor LIKE '$bAuthor' AND bMem LIKE '$bMem'";
		$rs = odbc_exec($conn,$sql);
	?>
	<table border=1 id="result">
		<?php
			while(odbc_fetch_row($rs))
			{
				$id = odbc_result($rs,"bID");
				$name = odbc_result($rs,"bName");
				$cnt = odbc_result($rs,"bCnt");
				$cnt1 = odbc_result($rs,"bCnt1");
				$pub = odbc_result($rs,"bPub");
				$date = odbc_result($rs,"bDate");
				$author = odbc_result($rs,"bAuthor");
				$mem = odbc_result($rs,"bMem");

       			echo "<tr>";
                echo "<td>"; echo "$id";     echo "</td>";
                echo "<td>"; echo "$name";   echo "</td>";
                echo "<td>"; echo "$cnt";    echo "</td>";
                echo "<td>"; echo "$cnt1";   echo "</td>";
                echo "<td>"; echo "$pub";    echo "</td>";
                echo "<td>"; echo "$date";   echo "</td>";
                echo "<td>"; echo "$author"; echo "</td>";
                echo "<td>"; echo "$mem";    echo "</td>";
				echo "</tr>";
		 }
		 ?>
	</table>
	<?php
		odbc_close($conn);
	?>
</body>
</html>
