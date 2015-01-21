<?php
	require_once('CobolToDb.php');

	$testRun = new CobolToDb;

	$testRun->openFile("input.txt");
	$testRun->readFile();
	$testRun->printFile();
?>