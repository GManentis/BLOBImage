<?php 
if (isset($_POST["submit"]))
{		
		$hostname_DB = "127.0.0.1";
		$database_DB = "blober";
		$username_DB = "root";
		$password_DB = "";

		try {
			$CONNPDO = new PDO("mysql:host=".$hostname_DB.";dbname=".$database_DB.";charset=UTF8", $username_DB, $password_DB, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_TIMEOUT => 3));
		} catch (PDOException $e) {
			$CONNPDO = null;
		}
		if ($CONNPDO != null) 
		{
			$name = $_FILES["file"]["name"];
			$name2 = explode(".",$name);    
			$Name = $name2[0];
			$type = $_FILES["file"]["type"];
			$data = file_get_contents($_FILES["file"]["tmp_name"]);
			$hash = md5($data);
			$status = 1;
			
			$getdata_PRST = $CONNPDO->prepare("SELECT * FROM blober WHERE name = :name ");
			$getdata_PRST -> bindValue(":name",$Name);
			$getdata_PRST->execute() or die($CONNPDO->errorInfo());
			$count = $getdata_PRST->rowCount();
			
			if($count != 0)
			{   
		        $Name = $Name.($count + 1);
			}
				$getdata_PRST = $CONNPDO->prepare("SELECT * FROM blober WHERE hash = :hash ");
				$getdata_PRST -> bindValue(":hash",$hash);
				$getdata_PRST->execute() or die($CONNPDO->errorInfo());
				$count2 = $getdata_PRST->rowCount();
				
				if($count2 == 0)
				{
					$adddata_PRST = $CONNPDO->prepare("INSERT INTO blober(name, type, data, hash) VALUES (:name, :type, :data, :hash) ");
				    $adddata_PRST -> bindValue(":name",$Name);
					$adddata_PRST -> bindValue(":type",$type);
					$adddata_PRST -> bindValue(":data",$data);
					$adddata_PRST -> bindValue(":hash",$hash);
				    $adddata_PRST->execute() or die($CONNPDO->errorInfo());
					$status = 1;
				}
				else
				{
				    $status = 0;	
				}
			
		 if($status == 0)
		 {
			$response = "An Error occured,probably image already exists";
		 }
		 else
	     {
			 $response = "File successfully uploaded"; 
		 }
			
			
		} 
		else 
		{
			$response = "no pdo connection";

		}
}
else
{
	$response = "";
}
?>
<!DOCTYPE html>
<html>
<head>
</head>
<body>
<form action="<?php echo $_SERVER["PHP_SELF"];?>" method="post" enctype="multipart/form-data">
    Select image to upload:
    <input type="file" name="file" id="fileToUpload" accept="image/x-png,image/gif,image/jpeg">
    <input type="submit" value="Upload Image" name="submit">
</form>
<br>
<br>
<?php echo $response; ?>
<br>
<br>
<center>
<a href="images.php">Click here to see uploaded images!</a>
</center>
</body>
</html>