<?php
	
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
	        $response = "";
			$getdata_PRST = $CONNPDO->prepare("SELECT * FROM blober");
			$getdata_PRST->execute() or die($CONNPDO->errorInfo());
			
			while($getdata_RSLT = $getdata_PRST->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT))
			{
				$name = $getdata_RSLT["name"];
				$type = $getdata_RSLT["type"];
				$data = $getdata_RSLT["data"];
				$code = base64_encode($data);
				$link = "<a href=view.php?name=".$name.">";
				$response .= $link.'<img width="150" height="150" src="data:$type;base64,'.$code.'"></a>&nbsp;' ;
				
			}
		}
		else
		{ 
	     $response .= "error";
		}
?>
<!DOCTYPE html>
<html>
<head>
</head>
<body>
<?php echo $response; ?>
<br>
<br>
<center>
<a href="index.php">Go back to upload image</a>
</center>
</body>
</html>