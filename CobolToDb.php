<?php


class CobolToDb {
	
	private $importArray = []; //Declaration of vaiables
	private $importFile; //Declaration of vaiables
	

	function openFile($filename){ 
		$this->importFile = fopen($filename, "r"); //Open the given filename for read only
	}
	
	public function readFile(){
		if ($this -> importFile) {
    		while (($line = fgets($this -> importFile)) !== false) { //Loop through the lines of the file
				$currentEntry = preg_split("/  +/", $line); //Split content by two or more spaces and add to array

				array_push($this -> importArray, $currentEntry); //Push current entry to the array
		
			}
		} else {
    		// error opening the file.
		} 
	}
	
	public function saveToDb($db, $dbName){
		//TBA
	}
	
	public function printFile(){
		//Test funciton to print. Will be removed
		echo("<pre>");
		print_r ($this -> importArray);
		echo("</pre>");
	}
	
}





?>