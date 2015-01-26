<?php
if( isset($_POST['upload']) ){
	if(is_uploaded_file($_FILES['upfile']['tmp_name'])){
		$fileTempName = $_FILES['upfile']['tmp_name'];	
		$fileName = $_FILES['upfile']['name'];	
		
		$path = "imports/";							
		
		$path_parts = pathinfo($fileName);
		$backup = $path . $path_parts['filename'].'_'.time().'.'.$path_parts['extension'];
		

		require_once('CobolToDb.php');
		require_once('pdoConnect.php');

		$cobolToDb = new CobolToDb;

		$cobolToDb->openFile($fileName);
		$cobolToDb->dbName = "coboltest";	
		$cobolToDb->readFile();
		$cobolToDb->saveToDb($db, "coboltest");

		if(move_uploaded_file($fileTempName, $backup)){
			
		}
	}
}
?>



<!DOCTYPE html>
<html lang="">
<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title></title>
</head>

<body>
	<form action="form.php" method="post" enctype="multipart/form-data">
		input-file: <input type="file" name="upfile" value=""/><br />
		<input type="submit" name="upload" value="Importera"/>
	</form>
</body>
</html>
