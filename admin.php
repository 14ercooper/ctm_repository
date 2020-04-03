<?php

require($_SERVER['DOCUMENT_ROOT'] . "/config.php");
session_start();
$action = isset($_GET['action']) ? $_GET['action'] : "";
$username = isset($_SESSION['username']) ? $_SESSION['username'] : "";

if ($action != "login" && $action !="logout" && !$username) {
	login();
	exit;
}
switch ($action) {
	case 'login':
		login();
		break;
	case 'logout':
		logout();
		break;
	case 'newMap':
		newMap();
		break;
	case 'editMap':
		editMap();
		break;
	case 'deleteMap':
		deleteMap();
		break;
	default:
		listMaps();
}

function login () {
	$results = array();
	$results['pageTitle'] = "Admin Login | CTM Map Repository";

	if (isset($_POST['login'])) {
		if ($_POST['username'] == ADMIN_USERNAME && $_POST['password'] == ADMIN_PASSWORD) {
			$_SESSION['username'] = ADMIN_USERNAME;
			header("Location: admin.php");
		} else {
			$results['errorMessage'] = "Incorrect username or password. Please try again.";
			require ($_SERVER['DOCUMENT_ROOT'] . TEMPLATE_PATH . "/admin/loginForm.php");
		}
	} else {
		require ($_SERVER['DOCUMENT_ROOT'] . TEMPLATE_PATH . "/admin/loginForm.php");
	}
}

function logout () {
	unset($_SESSION['username']);
	header("Location: admin.php");
}

function newMap () {
	$results = array();
	$results['pageTitle'] = "New Map | CTM Map Repository";
	$results['formAction'] = "newMap";
	if (isset($_POST['saveChanges'])) {
		$map = new Map();
		$map->storeFormValues($_POST);
		$map->insert();
		header("Location: admin.php?status=changesSaved");
	}
	if (isset($_POST['saveChangesPublish'])) {
		$map = new Map();
		$map->storeFormValues($_POST);
		$map->insert();
		$map->makePublished(true);
		header("Location: admin.php?status=changesSaved");
	}
	if (isset($_POST['saveChangesUnpublsih'])) {
		$map = new Map();
		$map->storeFormValues($_POST);
		$map->insert();
		$map->makePublished(false);
		header("Location: admin.php?status=changesSaved");
	}
	elseif (isset($_POST['cancel'])) {
		header("Location: admin.php");
	}
	else {
		$results['map'] = new Map();
		require($_SERVER['DOCUMENT_ROOT'] . TEMPLATE_PATH . "/admin/editMap.php");
	}
}

function editMap () {
	$results = array();
	$results['pageTitle'] = "Edit Map | CTM Map Repository";
	$results['formAction'] = "editMap";
	if (isset($_POST['saveChanges'])) {
		if (!$map = Map::getById((int)$_POST['mapId'])) {
			header("Location: admin.php?error=mapNotFound");
		}

		$map = new Map();
		$map->storeFormValues($_POST);
		$map->update();
		header("Location: admin.php?status=changesSaved");
	}
	if (isset($_POST['saveChangesPublish'])) {
		if (!$map = Map::getById((int)$_POST['mapId'])) {
			header("Location: admin.php?error=mapNotFound");
		}

		$map = new Map();
		$map->storeFormValues($_POST);
		$map->update();
		$map->makePublished(true);
		header("Location: admin.php?status=changesSaved");
	}
	if (isset($_POST['saveChangesUnpublish'])) {
		if (!$map = Map::getById((int)$_POST['mapId'])) {
			header("Location: admin.php?error=mapNotFound");
		}

		$map = new Map();
		$map->storeFormValues($_POST);
		$map->update();
		$map->makePublished(false);
		header("Location: admin.php?status=changesSaved");
	}
	elseif (isset($_POST['cancel'])) {
		header("Location: admin.php");
	}
	else {
		$results['map'] = Map::getById((int)$_GET['mapId']);
		require($_SERVER['DOCUMENT_ROOT'] . TEMPLATE_PATH . "/admin/editMap.php");
	}
}

function deleteMap () {
	$map = Map::getById((int)$_GET['mapId']);
	if (!$map) {
		header("Location: admin.php?error=mapNotFound");
		return;
	}

	$map->deleteMap();
	header("Location: admin.php?status=mapDeleted");
}

function listMaps() {
	$results = array();
	if (isset($_GET['unpublished'])) {
		$data = Map::adminGetList(1);
	}
	else {
		$data = Map::adminGetList(0);
	}
	$results['maps'] = $data['results'];
	$results['pageTitle'] = "Maps | CTM Map Repository";

	if (isset( $_GET['error'])) {
		if ($_GET['error'] == "mapNotFound") $results['errorMessage'] = "Error: Map not found.";
	}

	if (isset($_GET['status'])) {
		if ($_GET['status'] == "changesSaved") $results['statusMessage'] = "Your changes have been saved.";
		if ($_GET['status'] == "mapDeleted") $results['statusMessage'] = "Map deleted.";
	}

	require($_SERVER['DOCUMENT_ROOT'] . TEMPLATE_PATH . "/admin/listMaps.php");
}
?>
