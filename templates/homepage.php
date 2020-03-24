<?php include ($_SERVER['DOCUMENT_ROOT'] . "/templates/include/header.php") ?>

<h2>Featured Map</h2><hr style="height:15pt; visibility:hidden;" />
<?php $dispMap = $results['featured'] ?>
	<?php include ($_SERVER['DOCUMENT_ROOT'] . "/templates/inlineMap.php") ?>
<h2>Random Map</h2><hr style="height:15pt; visibility:hidden;" />
<?php $dispMap = $results['random'] ?>
	<?php include ($_SERVER['DOCUMENT_ROOT'] . "/templates/inlineMap.php") ?>
<br>
<a href="/index.php?action=popular"><button class="headerButton">See More Maps</button></a>
<hr>

<?php include ($_SERVER['DOCUMENT_ROOT'] . "/templates/include/footer.php") ?>