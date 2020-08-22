<?php
$results = array();
$results['pageTitle'] = "Submit a Map | CTM Map Repository";
?>

<?php include ($_SERVER['DOCUMENT_ROOT'] . "/templates/include/header.php") ?>

<?php
require($_SERVER['DOCUMENT_ROOT'] . "/config.php");
$action = isset($_GET['action']) ? $_GET['action'] : "";

switch ($action) {
	case 'submit':
		submit();
		break;
	default:
		showForm();
}

function submit() {
	$map = new Map();
	$map->storeSubmitFormValues($_POST);
    $imageId = upload();
    if ($imageId == 0) {
        include ($_SERVER['DOCUMENT_ROOT'] . "/templates/include/footer.php");
	    header("Location: submitMap.php?error=true");
        return;
    }
    $map->imageURL = "/map_img/" . $imageId;
	$map->insert();
	header("Location: submitMap.php?submitted=true");
}

function showForm() {
    if (isset($_GET["submitted"])) echo "<h2>Map submitted successfully.</h2><br><br>";
    if (isset($_GET["error"])) echo "<h2>Error submitting map.</h2><br><br>";
	echo "<h3>Help add maps! Any CTM/RFW maps you can find are welcome!</h3>";
    include ($_SERVER['DOCUMENT_ROOT'] . "/templates/submitMap.php");
}

function upload() {
    $target_dir = "map_img/";
    $imageId = rand(1000000000000000, 9999999999999999);
    $target_file = $target_dir . $imageId;
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    $ext = "";
    // Check if image file is a actual image or fake image
    if(isset($_POST["submit"])) {
        $check = getimagesize($_FILES["imageFile"]["tmp_name"]);
        $ext = pathinfo($_FILES['imageFile']['name'], PATHINFO_EXTENSION);
        if($check !== false) {
            $uploadOk = 1;
        } else {
            echo "err1";
            $uploadOk = 0;
        }
    }
    $target_file = $target_file . "." . $ext;
    // Check if file already exists
    if (file_exists($target_file)) {
        echo "err2";
        $uploadOk = 0;
    }
    // Check file size
    if ($_FILES["imageFile"]["size"] > 5000000) {
        echo "err3";
        $uploadOk = 0;
    }
    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        return 0;
    // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["imageFile"]["tmp_name"], $target_file)) {
            return $imageId . "." . $ext;
        } else {
            echo "err4";
            return 0;
        }
    }
}

?>

<?php include ($_SERVER['DOCUMENT_ROOT'] . "/templates/include/footer.php") ?>
