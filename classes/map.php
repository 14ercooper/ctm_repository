<?php
// This class handles maps
class Map {
	// Properties of maps from the database
	public $id = null;
	public $addedDate = null;
	public $name = null;
	public $author = null;
	public $difficulty = null;
	public $length = null;
	public $shortDescription = null;
	public $longDescription = null;
	public $imageURL = null;
	public $minecraftVersion = null;
	public $downloadCount = null;
	public $series = null;
	public $objectives = null;
	public $bonusObjectives = null;
	public $mapType = null;
	public $downloadLink = null;
	public $popScore = null;
	
	public $dateAdded = null;
	public $daysSinceUpload = null;
	
	// Object constructor, using the data passed in
	public function __construct($data = array()) {
		if (isset($data['id'])) $this->id = (int) $data['id'];
		if (isset($data['mapId'])) $this->id = (int) $data['mapId'];
		if (isset($data['addedDate'])) $this->addedDate = (int) $data['addedDate'];
		if (isset($data['downloadCount'])) $this->downloadCount = (int) $data['downloadCount'];
		if (isset($data['objectives'])) $this->objectives = (int) $data['objectives'];
		if (isset($data['bonusObjectives'])) $this->bonusObjectives = (int) $data['bonusObjectives'];
		else $this->bonusObjectives = 0;
		if (isset($data['name'])) $this->name = $data['name'];
		if (isset($data['author'])) $this->author = $data['author'];
		if (isset($data['difficulty'])) $this->difficulty = $data['difficulty'];
		if (isset($data['length'])) $this->length = $data['length'];
		if (isset($data['shortDescription'])) $this->shortDescription = $data['shortDescription'];
		if (isset($data['imageURL'])) $this->imageURL = $data['imageURL'];
		if (isset($data['minecraftVersion'])) $this->minecraftVersion = $data['minecraftVersion'];
		if (isset($data['series'])) $this->series = $data['series'];
		if (isset($data['mapType'])) $this->mapType = $data['mapType'];
		if (isset($data['downloadLink'])) $this->downloadLink = $data['downloadLink'];
		if (isset($data['longDescription'])) $this->longDescription = $data['longDescription'];
		
		if (isset($data['addedDate'])) {
			$yearAdded = $this->addedDate - ($this->addedDate % 10000);
			$monthAdded = $this->addedDate - $yearAdded - ($this->addedDate % 100);
			$dayAdded = $this->addedDate - $yearAdded - $monthAdded;
			$yearAdded = $yearAdded / 10000;
			$monthAdded = $monthAdded / 100;
		
			$this->dateAdded = $yearAdded . "-" . $monthAdded . "-" .$dayAdded;
			$currDate = date('Y-m-d');
			$date1 = date_create($this->dateAdded);
			$date2 = date_create($currDate);
			$interval = date_diff($date1, $date2);
			$this->daysSinceUpload = $interval->format('%a');
			if ($this->daysSinceUpload == 0) $this->daysSinceUpload = 1;
			
			$this->popScore = ($this->downloadCount / $this->daysSinceUpload);
			
			if ($this->daysSinceUpload < 3) {
				$this->popScore *= 1.5;
			}
			else if ($this->daysSinceUpload < 7) {
				$this->popScore *= 1.33;
			}
			else if ($this->daysSinceUpload < 30) {
				$this->popScore *= 1.15;
			}
			else if ($this->daysSinceUpload < 90) {
				$this->popScore *= 1.05;
			}
			
			if ($this->author === "renderXR")
				$this->popScore *= 1.66;
		}
	}
	
	// Stores values from a form/other input into the object
	public function storeFormValues ($params) {
		$this->__construct($params);
	}
	
	// Return map by ID
	public static function getById ($id) {
		$conn = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
		$sql = "SELECT * FROM maplist WHERE id = :id;";
		$st = $conn->prepare($sql);
		$st->bindValue(":id", $id, PDO::PARAM_INT);
		$st->execute();
		$row = $st->fetch();
		$conn = null;
		if ($row) return new Map ($row);
	}
	
	// Search function
	public static function getList ($numRows=10, $order="RAND()", $mapName = null, $mapAuthor = null, $mapDifficulty = null, $mapLength = null, $mapSeries = null, $mapMapType = null, $mapObjectives = null) {
		$conn = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD); // Create a PDO pointing at the database
		$levenshteinTolerance = 5;
		$sqlIntro = " WHERE (";
		$sqlEnding = ")";
		
		// Create the SQL query
		$sql = "SELECT * FROM maplist";
		if (!empty($mapName)) {
			$sql = $sql . $sqlIntro . "levenshtein(:mapName, name)<=:levenshteinTolerance" . $sqlEnding;
			$sqlIntro = " AND (";
		}
		if (!empty($mapAuthor)) {
			$sql = $sql . $sqlIntro . "levenshtein(:mapAuthor, author)<=:levenshteinTolerance" . $sqlEnding;
			$sqlIntro = " AND (";
		}
		if (!empty($mapSeries)) {
			$sql = $sql . $sqlIntro . "levenshtein(:mapSeries, series)<=:levenshteinTolerance" . $sqlEnding;
			$sqlIntro = " AND (";
		}
		if (!empty($mapDifficulty)) {
			$sql = $sql . $sqlIntro . "difficulty = :mapDifficulty" . $sqlEnding;
			$sqlIntro = " AND (";
		}
		if (!empty($mapLength)) {
			$sql = $sql . $sqlIntro . "length = :mapLength" . $sqlEnding;
			$sqlIntro = " AND (";
		}
		if (!empty($mapMapType)) {
			$sql = $sql . $sqlIntro . "mapType = :mapMapType" . $sqlEnding;
			$sqlIntro = " AND (";
		}
		if (!empty($mapObjectives)) {
			$sql = $sql . $sqlIntro . "objectives = :mapObjectives" . $sqlEnding;
			$sqlIntro = " AND (";
		}
		$sql = $sql . " ORDER BY " . $order;
		if ($numRows != -1) $sql = $sql . " LIMIT :numRows;";
		
		// Initialize the SQL query
		$st = $conn->prepare($sql);
		if ($numRows != -1) $st->bindValue(":numRows", $numRows, PDO::PARAM_INT);
		if (!empty($mapName) || !empty($mapAuthor) || !empty($mapSeries)) $st->bindValue(":levenshteinTolerance", $levenshteinTolerance, PDO::PARAM_INT);
		if (!empty($mapName)) $st->bindValue(":mapName", $mapName, PDO::PARAM_STR);
		if (!empty($mapAuthor)) $st->bindValue(":mapAuthor", $mapAuthor, PDO::PARAM_STR);
		if (!empty($mapSeries)) $st->bindValue(":mapSeries", $mapSeries, PDO::PARAM_STR);
		if (!empty($mapDifficulty)) $st->bindValue(":mapDifficulty", $mapDifficulty, PDO::PARAM_STR);
		if (!empty($mapLength)) $st->bindValue(":mapLength", $mapLength, PDO::PARAM_STR);
		if (!empty($mapMapType)) $st->bindValue(":mapMapType", $mapMapType, PDO::PARAM_STR);
		if (!empty($mapObjectives)) $st->bindValue(":mapObjectives", $mapObjectives, PDO::PARAM_INT);
		$st->execute();
		
		// Place returned maps into an array
		$list = array();
		while ($row = $st->fetch()) {
			$map = new Map($row);
			$list[] = $map;
		}
		
		// Clean everything up
		$conn = null;
		return (array("results" => $list));
	}
	
	public static function getBrowseList ($objMax, $objMin, $minecraftVer, $sortOrder, $mapDiffculty, $mapLength, $mapType) {
		$conn = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD); // Create a PDO pointing at the database
		$sqlIntro = " WHERE (";
		$sqlEnding = ")";
		
		$sql = "SELECT * from maplist";
		if (!empty($objMax)) {
			$sql = $sql . $sqlIntro . "objectives <= :objMax" .$sqlEnding;
			$sqlIntro = " AND (";
		}
		if (!empty($objMin)) {
			$sql = $sql . $sqlIntro . "objectives >= :objMin" .$sqlEnding;
			$sqlIntro = " AND (";
		}
		if (!empty($minecraftVer)) {
			$sql = $sql . $sqlIntro . "minecraftVersion IN " . $minecraftVer .$sqlEnding;
			$sqlIntro = " AND (";
		}
		if (!empty($mapDifficulty)) {
			$sql = $sql . $sqlIntro . "difficulty = :mapDifficulty" .$sqlEnding;
			$sqlIntro = " AND (";
		}
		if (!empty($mapLength)) {
			$sql = $sql . $sqlIntro . "length = :mapLength" .$sqlEnding;
			$sqlIntro = " AND (";
		}
		if (!empty($mapType)) {
			$sql = $sql . $sqlIntro . "mapType = :mapType" .$sqlEnding;
			$sqlIntro = " AND (";
		}
		$sql = $sql . " ORDER BY " . $sortOrder;
		
		$st = $conn->prepare($sql);
		if (!empty($objMax)) $st->bindValue(":objMax", $objMax, PDO::PARAM_INT);
		if (!empty($objMin)) $st->bindValue(":objMin", $objMin, PDO::PARAM_INT);
		if (!empty($mapDifficulty)) $st->bindValue(":mapDifficulty", $mapDiffculty, PDO::PARAM_STR);
		if (!empty($mapLength)) $st->bindValue(":mapLength", $mapLength, PDO::PARAM_STR);
		if (!empty($mapType)) $st->bindValue(":mapType", $mapType, PDO::PARAM_STR);
		$st->execute();
		
		// Place returned maps into an array
		$list = array();
		while ($row = $st->fetch()) {
			$map = new Map($row);
			$list[] = $map;
		}
		
		// Clean everything up
		$conn = null;
		return (array("results" => $list));
	}
	
	// Get a random map from database
	public static function getRandomMap () {
		$conn = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
		$st = $conn->prepare("SELECT * FROM maplist ORDER BY RAND() LIMIT 1;");
		$st->execute();
		$row = $st->fetch();
		$conn = null;
		if ($row) return new Map ($row);
	}
	
	// Add a new map to the database
	public function insert () {
		$downloadCount = 0;
		$conn = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
		$sql = "INSERT INTO maplist (addedDate, name, author, difficulty, length, shortDescription, longDescription, imageURL, minecraftVersion, downloadCount, series, objectives, bonusObjectives, mapType, downloadLink) " . 
		" VALUES (:addedDate, :name, :author, :difficulty, :length, :shortDescription, :longDescription, :imageURL, :minecraftVersion, :downloadCount, :series, :objectives, :bonusObjectives, :mapType, :downloadLink);";
		$st = $conn->prepare ($sql);
		$st->bindValue(":addedDate", $this->addedDate, PDO::PARAM_INT);
		$st->bindValue(":name", $this->name, PDO::PARAM_STR);
		$st->bindValue(":author", $this->author, PDO::PARAM_STR);
		$st->bindValue(":difficulty", $this->difficulty, PDO::PARAM_STR);
		$st->bindValue(":length", $this->length, PDO::PARAM_STR);
		$st->bindValue(":shortDescription", $this->shortDescription, PDO::PARAM_STR);
		$st->bindValue(":longDescription", $this->longDescription, PDO::PARAM_STR);
		$st->bindValue(":imageURL", $this->imageURL, PDO::PARAM_STR);
		$st->bindValue(":minecraftVersion", $this->minecraftVersion, PDO::PARAM_STR);
		$st->bindValue(":downloadCount", $this->downloadCount, PDO::PARAM_INT);
		$st->bindValue(":series", $this->series, PDO::PARAM_STR);
		$st->bindValue(":objectives", $this->objectives, PDO::PARAM_INT);
		$st->bindValue(":bonusObjectives", $this->bonusObjectives, PDO::PARAM_INT);
		$st->bindValue(":mapType", $this->mapType, PDO::PARAM_STR);
		$st->bindValue(":downloadLink", $this->downloadLink, PDO::PARAM_STR);
		$st->execute();
		$this->id = $conn->lastInsertId();
		$conn = null;
	}
	
	// Edit an existing map
	public function update () {
		if (is_null($this->id)) trigger_error ("Map::update(): This map object does not have an ID", E_USER_ERROR);
		$conn = new PDO (DB_DSN, DB_USERNAME, DB_PASSWORD);
		$sql = "UPDATE maplist SET addedDate=:addedDate, name=:name, author=:author, difficulty=:difficulty, length=:length, shortDescription=:shortDescription, longDescription=:longDescription, imageURL=:imageURL" . 
				", minecraftVersion=:minecraftVersion, series=:series, objectives=:objectives, bonusObjectives=:bonusObjectives, mapType=:mapType, downloadLink=:downloadLink, downloadCount=:downloadCount WHERE id=:id;";
		$st = $conn->prepare($sql);
		$st->bindValue(":addedDate", $this->addedDate, PDO::PARAM_INT);
		$st->bindValue(":name", $this->name, PDO::PARAM_STR);
		$st->bindValue(":author", $this->author, PDO::PARAM_STR);
		$st->bindValue(":difficulty", $this->difficulty, PDO::PARAM_STR);
		$st->bindValue(":length", $this->length, PDO::PARAM_STR);
		$st->bindValue(":shortDescription", $this->shortDescription, PDO::PARAM_STR);
		$st->bindValue(":longDescription", $this->longDescription, PDO::PARAM_STR);
		$st->bindValue(":imageURL", $this->imageURL, PDO::PARAM_STR);
		$st->bindValue(":minecraftVersion", $this->minecraftVersion, PDO::PARAM_STR);
		$st->bindValue(":series", $this->series, PDO::PARAM_STR);
		$st->bindValue(":objectives", $this->objectives, PDO::PARAM_INT);
		$st->bindValue(":bonusObjectives", $this->bonusObjectives, PDO::PARAM_INT);
		$st->bindValue(":mapType", $this->mapType, PDO::PARAM_STR);
		$st->bindValue(":downloadLink", $this->downloadLink, PDO::PARAM_STR);
		$st->bindValue(":downloadCount", $this->downloadCount, PDO::PARAM_INT);
		$st->bindValue(":id", $this->id, PDO::PARAM_INT);
		$st->execute();
		$conn = null;
	}
	
	public static function incrementDownloadCounter ($mapId = null) {
		$conn = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
		$sql = "SELECT * FROM maplist WHERE id = :id;";
		$st = $conn->prepare($sql);
		$st->bindValue(":id", $mapId, PDO::PARAM_INT);
		$st->execute();
		$row = $st->fetch();
		$conn = null;
		if ($row) $thisMap = new Map ($row);
		$downloadCounter = $row['downloadCount'];
		$downloadCounter = $downloadCounter + 1;
		$conn = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
		$sql = "UPDATE maplist SET downloadCount=:downloadCount WHERE id=:id;";
		$st = $conn->prepare($sql);
		$st->bindValue(":downloadCount", $downloadCounter, PDO::PARAM_INT);
		$st->bindValue(":id", $mapId, PDO::PARAM_INT);
		$st->execute();
		$conn = null;
	}
	
	public static function getDownloadLink ($mapId = null) {
		$conn = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
		$sql = "SELECT * FROM maplist WHERE id = :id;";
		$st = $conn->prepare($sql);
		$st->bindValue(":id", $mapId, PDO::PARAM_INT);
		$st->execute();
		$row = $st->fetch();
		$conn = null;
		echo $row['downloadLink'];
		return $row['downloadLink'];
	}
	
	// Delete an existing map
	public function deleteMap () {
		$conn = new PDO (DB_DSN, DB_USERNAME, DB_PASSWORD);
		$st = $conn->prepare ("DELETE FROM maplist WHERE id=:id LIMIT 1;");
		$st->bindValue(":id", $this->id, PDO::PARAM_INT);
		$st->execute();
		$conn = null;
	}
}
?>