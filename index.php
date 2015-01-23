<?php
	require_once('CobolToDb.php');
	require_once('pdoConnect.php');

	$cobolToDb = new CobolToDb;

	$cobolToDb->openFile("input.txt");
	$cobolToDb->dbName = "coboltest";
	$cobolToDb->readFile();
	$cobolToDb->saveToDb($db, "coboltest");
?>