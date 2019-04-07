<?php
if(isset($_GET["name"]))
{
	$hostname_DB = "127.0.0.1";
	$database_DB = "blober";
	$username_DB = "root";
	$password_DB = "";

	try 
	{
		$CONNPDO = new PDO("mysql:host=".$hostname_DB.";dbname=".$database_DB.";charset=UTF8", $username_DB, $password_DB, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_TIMEOUT => 3));
	} 
	catch (PDOException $e)
	{
		$CONNPDO = null;
	}
	if ($CONNPDO != null) 
	{   
        $namae = $_GET["name"];
		$response = "";
		$getdata_PRST = $CONNPDO->prepare("SELECT * FROM blober WHERE name = :name ");
		$getdata_PRST -> bindValue(":name",$namae);
		$getdata_PRST->execute() or die($CONNPDO->errorInfo());
		
		while($getdata_RSLT = $getdata_PRST->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT))
		{
			$name = $getdata_RSLT["name"];
			$type = $getdata_RSLT["type"];
			$data = $getdata_RSLT["data"];
			$code = base64_encode($data);
			$response = '<img src="data:$type;base64,'.$code.'">' ;
			
		}
	}
	else
	{ 
      $response = "error";
	}
	
}
else
{
	$response = "An error occured,please go back";
}
?>
<!DOCTYPE html>
<html>
<head>
</head>
<body>
<center>
<?php echo $response; ?>
<br>
<br>
<a href="images.php">Go back!</a>
</center>
</body>
</html>
