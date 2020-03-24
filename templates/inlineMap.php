<div class="map">
	<img src="<?php echo $dispMap->imageURL ?>" alt="Map thumbnail" style="float:left;height:324px;width:576px;"/>
	<h3><?php echo $dispMap->name ?></h3><br>
	<h4><?php echo "By " . $dispMap->author ?></h4><br>
	<h4><?php echo $dispMap->series ?></h4><br>
	<h4><?php echo "Length: " . $dispMap->length ?></h4><br>
	<h4><?php echo "Objectives: " . $dispMap->objectives . " required + " . $dispMap->bonusObjectives . " bonus" ?></h4><br>
	<h4><?php echo "Difficulty: " . $dispMap->difficulty ?></h4><br>
	<h4><?php echo "For Minecraft " . $dispMap->minecraftVersion ?></h4><br>
	<h5><?php echo "Downloads: " . round($dispMap->downloadCount * 4.6) ?></h5><br>
	<p class="shortBlurb"><?php echo $dispMap->shortDescription ?></p><br>
	<a href="/index.php?action=viewMap&id=<?php echo $dispMap->id ?>" class="moreInfo"><button class="moreInfoBlurb">Click for more information!</button></a>
</div>
<hr>
