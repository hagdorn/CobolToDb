<?php
class CobolToDb {

	private $importArray = []; //Declaration of vaiables
	private $importFile; //Declaration of vaiables
	public $dbName;
	
	public function openFile($filename){ 
		$this->importFile = fopen($filename, "r"); //Open the given filename for read only
	}
	
	public function readFile(){
		if ($this->importFile) {
    		while (($line = fgets($this->importFile)) !== false) { //Loop through the lines of the file
				$currentEntry = preg_split("/  +/", $line); //Split content by two or more spaces
				array_push($this->importArray, $currentEntry); //Push current entry to the array		
			}
		} 
		else {
    		// error opening the file.
		} 
	}
	
	public function saveToDb($db, $dbName){
			$dbHeadersQueryString = ""; //used for headers in query
			$dbVariablesQueryString = ""; //user for variables in query
			
			for($i=0;$i<sizeof($this->importArray[0]);$i++){ //loop through importArray headers and set variables		
				if($i<1){
					if (!$this->columnExists(trim($this->importArray[0][$i]))){ //Check if column exists in current table before moving forward
						return false;
					}
					$dbHeadersQueryString = trim($this->importArray[0][$i]);
					$dbVariablesQueryString = ":" . trim($this->importArray[0][$i]);
				}
				else{
					$dbHeadersQueryString .= "," . trim($this->importArray[0][$i]);
					$dbVariablesQueryString .= ",:" . trim($this->importArray[0][$i]);
				}
			}
		
				try{
					$query = "INSERT INTO " .$dbName ." (" .$dbHeadersQueryString .") "; //query using variabels
					$query .= "VALUES (" . $dbVariablesQueryString . ")";

					$ps = $db->prepare($query);  //Prepare statement

					for($r=1;$r<sizeof($this->importArray);$r++){ //Loop through entire importArray to set execute array
						$dbVariablesValuesArray = [];
						for($i=0;$i<sizeof($this->importArray[0]);$i++){
							$dbVariablesValuesArray[trim($this->importArray[0][$i])] = trim($this->importArray[$r][$i]); //set execute array value with named key
						}
						$ps->execute($dbVariablesValuesArray);  //execute 
					}
				}
				catch(Exception $e){
					//error code
				}
			
		}
	
	private function columnExists($column){ //returns true if column exists in table. False if not.
			global $db;
			$query = "SHOW COLUMNS FROM " .$this->dbName . " LIKE :column";
		
			try{
				$ps = $db->prepare($query);
				$ps->execute(array(
					'column'=>$column
				));
				$result=$ps->fetch(PDO::FETCH_ASSOC);
				if($result){return true;};
			}
			catch(Exception $e){
			}
			return false;
		}
		
	
	public function printFile(){
		//Test funciton to print. Will be removed
		echo("<pre>");
		print_r ($this->importArray);
		echo("</pre>");
	}
}
?>