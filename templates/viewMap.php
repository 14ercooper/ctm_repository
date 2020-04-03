<?php include $_SERVER['DOCUMENT_ROOT'] . "/templates/include/header.php" ?>

<div class="mapView">
	<img src="<?php echo $dispMap->imageURL ?>" alt="Map thumbnail" style="float:left;width:100%;"/><hr style="height:15pt; visibility:hidden;" />
	<h1 style="font-size: 48px;"><?php echo $dispMap->name ?></h1><br>
	<h2><?php echo "By " . $dispMap->author ?></h2><br>
	<h3><?php echo $dispMap->series ?></h3><br>
	<h3><?php echo "Length: " . $dispMap->length ?></h3><br>
	<h3><?php echo "Objectives: " . $dispMap->objectives . " required + " . $dispMap->bonusObjectives . " bonus" ?></h3><br>
	<h3><?php echo "Difficulty: " . $dispMap->difficulty ?></h3><br>
	<h3><?php echo "For Minecraft " . $dispMap->minecraftVersion ?></h3><br>
	<h3><?php echo "Map Type: " . $dispMap->mapType ?></h3><hr>
	<p class="longBlurb"><?php echo $dispMap->longDescription ?></p><br>
	<a href="/download.php?id=<?php echo $dispMap->id ?>" target="_blank"><button class="download">Download Now!</button></a><br>
</div>
<hr>

<?php include $_SERVER['DOCUMENT_ROOT'] . "/templates/include/footer.php" ?>
