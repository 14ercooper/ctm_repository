<?php include $_SERVER['DOCUMENT_ROOT'] . "/templates/include/header.php" ?>

<?php
	if (!is_object($dispMap)) {
		echo("<h2>Map not found.</h2>");
		include $_SERVER['DOCUMENT_ROOT'] . "/templates/include/footer.php";
		exit();
	}
?>

<?php 
	$status = isset($_GET['status']) ? $_GET['status'] : "";
	if ($status == "commentReported") {
		$comment = MapComment::getById($_GET['commentId']);
		if ($comment->flagCount >= AMNT_FLAGS_BEFORE_REMOVE) {
?>
	<div class="statusMessage">Thank you for reporting this comment. It has gone under review and will be reviewed by a moderator. Please continue to keep our community safe!</div>
<?php } else { ?>
	<div class="statusMessage">Thank you for reporting this comment. We will continue to monitor this comment for more reports. Please continue to keep our community safe!</div>
<?php } } ?>

<script type="text/javascript">
    function confirmReport(id) {
        if (confirm('Would you like to report this comment?')) {
            window.location.href = "index.php?action=reportComment&id=<?php echo $dispMap->id ?>&commentId=" + id;
        }
        else {
            window.location.href = "index.php?action=viewMap&id=<?php echo $dispMap->id ?>";
        }
    }
</script>

<div class="mapView">
	<img src="<?php echo $dispMap->imageURL ?>" alt="Map thumbnail" style="float:left;width:100%;"/><hr style="height:15pt; visibility:hidden;" />
	<br><br>
	<h1 style="font-size: 48px;"><?php echo $dispMap->name ?></h1><br>
	<h2><?php echo "By " . $dispMap->author ?></h2><br>
	<h3><?php echo $dispMap->series ?></h3><br>
	<h3><?php echo "Length: " . $dispMap->length ?></h3><br>
	<h3><?php echo "Objectives: " . $dispMap->objectives . " required + " . $dispMap->bonusObjectives . " bonus" ?></h3><br>
	<h3><?php echo "Difficulty: " . $dispMap->difficulty ?></h3><br>
	<h3><?php echo "For Minecraft " . $dispMap->minecraftVersion ?></h3><br>
	<h3><?php echo "Rating: " . $dispMap->avgRating ?></h3><br>
	<h3><?php echo "Map Type: " . $dispMap->mapType ?></h3><hr>
	<p class="longBlurb"><?php echo $dispMap->longDescription ?></p><br>
	<a href="/download.php?id=<?php echo $dispMap->id ?>" target="_blank"><button class="download">Download Now!</button></a><br><hr>
	<h3>Recent Comments</h3><br>
	<div class="reviewContainer">
		<?php if (!is_null($dispMap->comments)) foreach ($dispMap->comments as $comment) { ?>
			<?php include $_SERVER['DOCUMENT_ROOT'] . "/templates/comment.php" ?>
		<?php } ?>
	</div>
	<a href="/index.php?action=viewComments&id=<?php echo $dispMap->id ?>"><button class="download">Browse All Comments</button></a>
	<a href="/index.php?action=comment&id=<?php echo $dispMap->id ?>" target="_blank"><button class="download">Post A Comment!</button></a><br>
</div>
<hr>

<?php include $_SERVER['DOCUMENT_ROOT'] . "/templates/include/footer.php" ?>
