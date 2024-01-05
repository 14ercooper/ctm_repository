<?php include $_SERVER['DOCUMENT_ROOT'] . "/templates/include/header.php" ?>

<h1>Comments For <?php echo $dispMap->name ?></h1>

<div class="reviewContainer">
    <?php if (!is_null($dispMap->comments)) foreach ($dispMap->comments as $comment) { ?>
        <?php include $_SERVER['DOCUMENT_ROOT'] . "/templates/comment.php" ?>
    <?php } else { ?>
        <h3>No comments for <?php echo $dispMap->name ?>.</h3>
    <?php } ?>
</div>

<a href="/index.php?action=viewMap&id=<?php echo $dispMap->id ?>"><button class="download">Return To Map</button></a>

<?php include $_SERVER['DOCUMENT_ROOT'] . "/templates/include/footer.php" ?>