<?php
	
	require($_SERVER['DOCUMENT_ROOT'] . "/config.php");
	$id = $_GET['id'];
	Map::incrementDownloadCounter($id);

?>

<body>
	<a href="<?php Map::getDownloadLink($id) ?>" download id="downloadLink">If your download doesn't start automatically, please click here.</a>
</body>
<script type="text/javascript">
    var downloadTimeout = setTimeout(function () {
        window.location = document.getElementById('downloadLink').href;
    }, 2000);
</script>