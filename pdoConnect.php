<?php
	global $db;
    try{
       	$db = new PDO("mysql:dbname=jensenOnline;host=localhost", "root", "");
		
		$db->exec("SET NAMES 'utf8'");      
		//sätt på exception. Default av.
		$db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    }
    catch(Exception $exception){
        echo("error <br><br>" . $exception);
    }
?>

