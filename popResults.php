<?php include $_SERVER['DOCUMENT_ROOT'] . "/templates/include/header.php" ?>

<h1>Search Results</h1>
<hr>

<?php $i = 0; foreach ($results['maps'] as $dispMap) { ?>
	<?php if ($i < 10) include $_SERVER['DOCUMENT_ROOT'] . "/templates/inlineMap.php"; $i += 1;?>
<?php } ?>

<p>End of search.</p>

<?php include $_SERVER['DOCUMENT_ROOT'] . "/templates/include/footer.php" ?>