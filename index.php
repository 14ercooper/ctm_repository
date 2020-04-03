<?php

require($_SERVER['DOCUMENT_ROOT'] . "/config.php");
$action = isset ($_GET['action']) ? $_GET['action'] : "";

switch ($action) {
	case 'popular':
		popular();
		break;
	case 'search':
		search();
		break;
	case 'browse':
		browse();
		break;
	case 'viewMap':
		viewMap();
		break;
	default:
		homepage();
}

function cmp ($a, $b) {
	if ($a->popScore == $b->popScore)
		return 0;
	return ($a->popScore > $b->popScore) ? -1 : 1;
}

function popular () {
	$results = array();
	$data = Map::getList(-1);
	$results['maps'] = $data['results'];

	// Sort by popularity
	$mapsToSort = $results['maps'];
	usort($mapsToSort, "cmp");
	$results['maps'] = $mapsToSort;

	$results['pageTitle'] = "Popular CTM Maps | CTM Map Repository";
	require($_SERVER['DOCUMENT_ROOT'] . "/popResults.php");
}

function search () {
	header("Location: search.php");
}

function browse () {
	header("Location: browse.php");
}

function viewMap () {
	if (!isset($_GET["id"]) || !$_GET["id"]) {
		homepage();
		return;
	}

	$results = array();
	$dispMap = Map::getById((int) $_GET["id"]);
	$results['pageTitle'] =$dispMap->name . " | CTM Map Repository";
	require($_SERVER['DOCUMENT_ROOT'] . TEMPLATE_PATH . "/viewMap.php");
}

function homepage () {
	$results = array();
	$results['featured'] = Map::getById(66);
	$results['random'] = Map::getRandomMap();
	$results['pageTitle'] = "CTM Maps Repository";
	require($_SERVER['DOCUMENT_ROOT'] . TEMPLATE_PATH . "/homepage.php");
}
?>
