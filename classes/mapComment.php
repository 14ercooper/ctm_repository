<?php 

class MapComment {
    public $id = null;
    public $parentMapId = null;
    public $addedDate = null;
    public $author = null;
    public $rating = null;
    public $comment = null;
    public $screenshotLink = null;
    public $flagCount = null;

    public function __construct($data = array()) {
        if (isset($data['id'])) $this->id = (int) $data['id'];
        if (isset($data['mapId'])) $this->parentMapId = (int) $data['mapId'];
        if (isset($data['addedDate'])) $this->addedDate = (int) $data['addedDate'];
        $this->getDataFromArray($data);

        if (isset($data['addedDate'])) {
            $yearAdded = $this->addedDate - ($this->addedDate % 10000000000);
			$monthAdded = $this->addedDate - $yearAdded - ($this->addedDate % 100000000);
			$dayAdded = $this->addedDate - $yearAdded - $monthAdded - ($this->addedDate % 1000000);
			$hourAdded = $this->addedDate - $yearAdded - $monthAdded - $dayAdded - ($this->addedDate % 10000);
            $minuteAdded = $this->addedDate - $yearAdded - $monthAdded - $dayAdded - $hourAdded - ($this->addedDate % 100);
            $secondAdded = $this->addedDate - $yearAdded - $monthAdded - $dayAdded - $hourAdded - $minuteAdded;
            $yearAdded = $yearAdded / 10000000000;
			$monthAdded = $monthAdded / 100000000;
            $dayAdded = $dayAdded / 1000000;
            $hourAdded = $hourAdded / 10000;
            $minuteAdded = $minuteAdded / 100;

			$this->addedDate = $yearAdded . "-" . $monthAdded . "-" . $dayAdded . "T" . $hourAdded . ":" . $minuteAdded . ":" . $secondAdded;
        }
    }

    public function storeFormValues($params) {
        $this->__construct($params);
    }

    public static function getById($id) {
        $conn = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
        $sql = "SELECT * FROM mapComments WHERE id = :id";
        $st = $conn->prepare($sql);
        $st->bindValue(":id", $id, PDO::PARAM_INT);
        $st->execute();

        $row = $st->fetch();
        if ($row) return new MapComment($row);
        return true;
    }

    public static function getAllApprovedByMapId($id, $numResults=0) {
        $conn = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
        $sql = "SELECT * FROM mapComments WHERE mapId = :mapId AND flagCount < :flagCount ORDER BY addedDate DESC ";
        if ($numResults > 0)
            $sql = $sql . "LIMIT :numResults";
        $sql = $sql . ";";
        $st = $conn->prepare($sql);
        $st->bindValue(":mapId", $id, PDO::PARAM_INT);
        $st->bindValue(":flagCount", AMNT_FLAGS_BEFORE_REMOVE, PDO::PARAM_INT);
        if ($numResults > 0)
            $st->bindValue(":numResults", $numResults, PDO::PARAM_INT);
        $st->execute();
        
        $list = array();
        while ($row = $st->fetch()) {
            $comment = new MapComment($row);
            $list[] = $comment;
        }

        $conn = null;
        return (array("results" => $list));
    }

    public static function getAllFlagged() {
        $conn = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
        $sql = "SELECT * FROM mapComments WHERE flagCount >= :flagCount ORDER BY addedDate DESC;";
        $st = $conn->prepare($sql);
        $st->bindValue(":flagCount", AMNT_FLAGS_BEFORE_REMOVE, PDO::PARAM_INT);
        $st->execute();
        
        $list = array();
        while ($row = $st->fetch()) {
            $comment = new MapComment($row);
            $list[] = $comment;
        }

        $conn = null;
        return (array("results" => $list));
    }

    public static function getAvgRatingByMapId($id) {
        $conn = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
        $sql = "SELECT AVG(rating) FROM mapComments WHERE mapId = :mapId AND flagCount < :flagCount AND rating IS NOT NULL";
        $st = $conn->prepare($sql);
        $st->bindValue(":mapId", $id, PDO::PARAM_INT);
        $st->bindValue(":flagCount", AMNT_FLAGS_BEFORE_REMOVE, PDO::PARAM_INT);
        $st->execute();

        $rating = $st->fetch();
        $conn = null;
        if ($rating) return $rating[0];
        return false;
    }
    
    public function insert() {
        $conn = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
        $sql = "INSERT INTO mapComments (mapId, addedDate, author, rating, comment, screenshotLink, flagCount)" .
        "VALUES (:mapId, " . date("YmdHis") . ", :author, :rating, :comment, :screenshotLink, 0)";
        $st = $conn->prepare($sql);
        $this->bindValues($st);
        $st->execute();
        $this->id = $conn->lastInsertId();
        $conn = null;
    }

    public function update() {
        if (is_null($this->id)) trigger_error("MapComment::update(): This comment object does not have an id", E_USER_ERROR);
        $conn = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
        $sql = "UPDATE mapComments SET mapId = :mapId, author = :author, rating = :rating, comment = :comment, screenshotLink = :screenshotLink, flagCount = :flagCount " .
        "WHERE id = :id";
        $st = $conn->prepare($sql);
        $this->bindValues($st);
        $st->bindValue(":id", $this->id, PDO::PARAM_INT);
        $st->bindValue(":flagCount", $this->flagCount, PDO::PARAM_INT);
        $st->execute();
        $conn = null;
    }

    public function delete() {
        if (is_null($this->id)) trigger_error("MapComment::delete(): This comment object does not have an id", E_USER_ERROR);
        $conn = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
        $sql = "DELETE FROM mapComments WHERE id = :id";
        $st = $conn->prepare($sql);
        $st->bindValue(":id", $this->id, PDO::PARAM_INT);
        $st->execute();
        $conn = null;
    }

    public function getDataFromArray($data) : void {
        if (isset($data['author'])) $this->author = $data['author'];
        if (isset($data['rating'])) $this->rating = (int) $data['rating'];
        if (isset($data['comment'])) $this->comment = $data['comment'];
        if (isset($data['screenshotLink'])) $this->screenshotLink = $data['screenshotLink'];
        if (isset($data['flagCount'])) $this->flagCount = $data['flagCount'];
    }

    public function bindValues($st) : void {
        $st->bindValue(":mapId", $this->parentMapId, PDO::PARAM_INT);
        $st->bindValue(":author", $this->author);
        $st->bindValue(":rating", $this->rating, PDO::PARAM_INT);
        $st->bindValue(":comment", $this->comment);
        $st->bindValue(":screenshotLink", $this->screenshotLink);
    }
}

?>