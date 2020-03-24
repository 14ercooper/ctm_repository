<?php

require($_SERVER['DOCUMENT_ROOT'] . "/config.php");
$action = isset($_GET['action']) ? $_GET['action'] : "";

switch ($action) {
	case 'results':
		browseResults();
		break;
	default:
		serveBrowse();
}

function cmp ($a, $b) {
	if ($a->popScore == $b->popScore)
		return 0;
	return ($a->popScore > $b->popScore) ? -1 : 1;
}

function browseResults () {
	// Parse search form return
	$mapObjectivesMax = !empty($_POST['objectivesMax']) ? (int) $_POST['objectivesMax'] : "";
	$mapObjectivesMin = !empty($_POST['objectivesMin']) ? (int) $_POST['objectivesMin'] : "";
	$mcVer = "";
	if ($_POST['minecraftVersion'] === "1.13") {$mcVer = "('1.13.2', '1.13.1', '1.13', '1.14', '1.14.1', '1.14.2', '1.14.3', '1.14.4', '1.14.5')";}
	else if ($_POST['minecraftVersion'] === "1.9") {$mcVer = "('1.12.2', '1.12.1', '1.12', '1.11.2', '1.11.1', '1.11', '1.10.2', '1.10.1', '1.10', '1.9.4', '1.9.3', '1.9.2', '1.9.1', '1.9')";}
	else if ($_POST['minecraftVersion'] === "1.7") {$mcVer = "('1.8.9', '1.8.8', '1.8.7', '1.8.6', '1.8.5', '1.8.4', '1.8.3', '1.8.2', '1.8.1', '1.8', '1.7.10', '1.7.9', '1.7.8', '1.7.7', '1.7.6', '1.7.5', '1.7.4', '1.7.2')";}
	else if ($_POST['minecraftVersion'] === "1.3") {$mcVer = "('1.6.4', '1.6.2', '1.6.1', '1.5.2', '1.5.1', '1.5', '1.4.7', '1.4.6', '1.4.5', '1.4.4', '1.4.2', '1.3.2', '1.3.1')";}
	else if ($_POST['minecraftVersion'] === "1.0") {$mcVer = "('1.2.5', '1.2.4', '1.2.3', '1.2.2', '1.2.1', '1.1', '1.0.0', '1.0.1', '1.0')";}
	else if ($_POST['minecraftVersion'] === "Beta") {$mcVer = "('Beta')";}
	$order = "";
	if ($_POST['sortOrder'] === "Popularity") { $order="downloadCount DESC"; }
	else if ($_POST['sortOrder'] === "PopScore") { $order="RAND()"; }
	else if ($_POST['sortOrder'] === "Random") { $order = "RAND()"; }
	$mapDifficulty = "";
	if ($_POST['difficulty'] === "Easy") { $mapDifficulty="Easy"; }
	else if ($_POST['difficulty'] === "Medium") { $mapDifficulty="Medium"; }
	else if ($_POST['difficulty'] === "Hard"){ $mapDifficulty = "Hard"; }
	$mapLength = "";
	if ($_POST['length'] === "Short") { $mapLength="Short"; }
	else if ($_POST['length'] === "Medium") { $mapLength="Medium"; }
	elseif ($_POST['length'] === "Long") { $mapLength = "Long"; }
	$mapType = "";
	if ($_POST['type'] === "Branching") { $mapType="Branching"; }
	else if ($_POST['type'] === "Linear") { $mapType="Linear"; }
	else if ($_POST['type'] === "OpenWorld") { $mapType="Open World"; }
	else if ($_POST['type'] === "Adventure") { $mapType="Adventure"; }
	elseif ($_POST['type'] === "Other") { $mapType = "Other"; }
	
	// Load maps
	$data = Map::getBrowseList($mapObjectivesMax, $mapObjectivesMin, $mcVer, $order, $mapDifficulty, $mapLength, $mapType);
	$results['maps'] = $data['results'];
	$results['pageTitle'] = "Browse | CTM Map Repository";
	
	// Sort by popularity
	if ($_POST['sortOrder'] === "PopScore") {
		$mapsToSort = $results['maps'];
		usort($mapsToSort, "cmp");
		$results['maps'] = $mapsToSort;
	}
	
	// Display maps
	require($_SERVER['DOCUMENT_ROOT'] . "/browseResults.php");
}

function serveBrowse () {
	$results = array();
	$results['pageTitle'] = "Browse | CTM Map Repository";
	if (isset($_POST['searchDone'])) {
		header("Location: browse.php?action=results");
	}
	else {
		$results['map'] = new Map();
		require($_SERVER['DOCUMENT_ROOT'] . TEMPLATE_PATH . "/browseForm.php");
	}
}

?>
