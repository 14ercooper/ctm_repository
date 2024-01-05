<?php include $_SERVER['DOCUMENT_ROOT'] . "/templates/include/header.php" ?>

<br>
<div id="adminHeader">
	<h2>CTM Map Repository Admin</h2>
	<p>You are currently logged in as <b><?php echo htmlspecialchars($_SESSION['username']) ?></b>. <a href="admin.php?action=logout">Log out</a></p>
</div>

<h1>Flagged Comments</h1>

<br>
<a href="/admin.php"><button class="headerButton">Published Maps</button></a>&nbsp;&nbsp;
<a href="/admin.php?unpublished=true"><button class="headerButton">Unpublished Maps</button></a>&nbsp;&nbsp;
<a href="/admin.php?action=flaggedComments"><button class="headerButton">Flagged Comments</button></a>&nbsp;&nbsp;

<?php if ( isset( $results['errorMessage'] ) ) { ?>
	<div class="errorMessage"><?php echo $results['errorMessage'] ?></div>
<?php } ?>


<?php if ( isset( $results['statusMessage'] ) ) { ?>
	<div class="statusMessage"><?php echo $results['statusMessage'] ?></div>
<?php } ?>

<hr>

<table>
	<tr>
		<th>Map Title</th>
		<th>Flagged Author</th>
		<th>Flagged Comment</th>
        <th>Actions</th>
	<tr>

	<?php
		$results = array();
		$data = MapComment::getAllFlagged();
		$results['comments'] = $data['results'];
		foreach ($results['comments'] as $comment) {
	?>

		<tr>
            <td><?php echo Map::getNameById($comment->parentMapId) ?></td>
            <td><?php echo $comment->author ?></td>
            <td><?php echo htmlspecialchars(strlen(substr($comment->comment, 0, 201) > 200) ? substr($comment->comment, 0, 200) . "..." : $comment->comment) ?></td>
            <td>
                <a href="/admin.php?action=deleteComment&id=<?php echo $comment->id ?>">Delete Comment</a><br>
                <a href="/admin.php?action=restoreComment&id=<?php echo $comment->id ?>">Restore Comment</a>
            </td>
        </tr>

	<?php } ?>
</table>

<?php include $_SERVER['DOCUMENT_ROOT'] . "/templates/include/footer.php" ?>