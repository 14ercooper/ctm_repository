<?php

require($_SERVER['DOCUMENT_ROOT'] . "/config.php");
$action = isset($_GET['action']) ? $_GET['action'] : "";

switch ($action) {
	case 'results':
		results();
		break;
	default:
		serveSearch();
}

function results () {
	// Parse search form return
	$numRows = !empty($_POST['numRows']) ? (int) $_POST['numRows'] : 10;
	$mapObjectives = !empty($_POST['objectives']) ? (int) $_POST['objectives'] : "";
	$mapName = !empty($_POST['name']) ? htmlspecialchars($_POST['name']) : "";
	$mapAuthor = !empty($_POST['author']) ? htmlspecialchars($_POST['author']) : "";
	$mapSeries = !empty($_POST['series']) ? htmlspecialchars($_POST['series']) : "";
	$order = "downloadCount DESC";
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
	$data = Map::getList($numRows, $order, $mapName, $mapAuthor, $mapDifficulty, $mapLength, $mapSeries, $mapType, $mapObjectives);
	$results['maps'] = $data['results'];
	$results['pageTitle'] = "Search | CTM Map Repository";
	
	// Display maps
	require($_SERVER['DOCUMENT_ROOT'] . "/searchResults.php");
}

function serveSearch () {
	$results = array();
	$results['pageTitle'] = "Search | CTM Map Repository";
	if (isset($_POST['searchDone'])) {
		header("Location: search.php?action=results");
	}
	else {
		$results['map'] = new Map();
		require($_SERVER['DOCUMENT_ROOT'] . TEMPLATE_PATH . "/searchForm.php");
	}
}

?>