<?php include $_SERVER['DOCUMENT_ROOT'] . "/templates/include/header.php" ?>

<h1>Search Results</h1>
<hr>

<?php foreach ($results['maps'] as $dispMap) { ?>
	<?php include $_SERVER['DOCUMENT_ROOT'] . "/templates/inlineMap.php" ?>
<?php } ?>

<p>End of search.</p>

<?php include $_SERVER['DOCUMENT_ROOT'] . "/templates/include/footer.php" ?>