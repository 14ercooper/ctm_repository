<?php
	
	require($_SERVER['DOCUMENT_ROOT'] . "/config.php");
	$id = $_GET['id'];
	Map::incrementDownloadCounter($id);
	$DL_LINK = Map::getDownloadLink($id);
	header('Location: ' . $DL_LINK);
?>

<body>
	<a href="<?php echo $DL_LINK; ?>" download id="downloadLink">If your download doesn't start automatically, please click here.</a>
</body>
<script type="text/javascript">
    var downloadTimeout = setTimeout(function () {
        window.location = document.getElementById('downloadLink').href;
    }, 250);
</script>
