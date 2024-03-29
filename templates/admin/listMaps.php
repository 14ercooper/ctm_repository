<?php include $_SERVER['DOCUMENT_ROOT'] . "/templates/include/header.php" ?>

<br>
<div id="adminHeader">
	<h2>CTM Map Repository Admin</h2>
	<p>You are currently logged in as <b><?php echo htmlspecialchars($_SESSION['username']) ?></b>. <a href="admin.php?action=logout">Log out</a></p>
</div>

<?php
	if (isset($_GET['unpublished']))
		echo "<h1>Unpublished Maps</h1>";
	else
		echo "<h1>Published Maps</h1>";
?>

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
		<th>Author</th>
		<th>Download Count</th>
	<tr>

	<?php
		$results = array();
		if (isset($_GET['unpublished'])) {
			$data = Map::adminGetList(1);
		}
		else {
			$data = Map::adminGetList(0);
		}
		$results['maps'] = $data['results'];

		foreach ($results['maps'] as $map) {
	?>

		<tr onclick="location='admin.php?action=editMap&amp;mapId=<?php echo $map->id ?>'">
			<td><?php echo $map->name ?></td>
			<td><?php echo $map->author ?></td>
			<td><?php echo $map->downloadCount ?></td>
		</tr>

	<?php } ?>
</table>

<br>
<p><a href="admin.php?action=newMap">Add a map</a></p>

<?php include $_SERVER['DOCUMENT_ROOT'] . "/templates/include/footer.php" ?>
