<?php include $_SERVER['DOCUMENT_ROOT'] . "/templates/include/header.php" ?>

<br>
<div id="adminHeader">
	<h2>CTM Map Repository Admin</h2>
	<p>You are currently logged in as <b><?php echo htmlspecialchars($_SESSION['username']) ?></b>. <a href="admin.php?action=logout">Log out</a></p>
</div>

<h1><?php echo $results['pageTitle'] ?></h1>
<hr>

<form action="admin.php?action=<?php echo $results['formAction'] ?>" method="post">
	<input type="hidden" name="mapId" value="<?php echo $results['map']->id ?>" />
	
	<?php if ( isset( $results['errorMessage'] ) ) { ?>
		<div class="errorMessage"><?php echo $results['errorMessage'] ?></div>
	<?php } ?>
	
	<ul>
		<li>
			<label for="addedDate">Added Date</label>
			<input type="number" name="addedDate" id="addedDate" placeholder="YYYY-MM-DD" required autofocus maxlength="10" value="<?php echo $results['map']->addedDate ?>" />
				
		</li>
		
		<li>
			<label for="name">Name</label>
			<input type="text" name="name" id="name" placeholder="Map Name" required maxLength="255" value="<?php echo $results['map']->name ?>">
		</li>
		
		<li>
			<label for="series">Series</label>
			<input type="text" name="series" id="series" placeholder="Series" required maxLength="255" value="<?php echo $results['map']->series ?>">
		</li>
		
		<li>
			<label for="author">Author</label>
			<input type="text" name="author" id="author" placeholder="Map Author" required maxLength="255" value="<?php echo $results['map']->author ?>">
		</li>
		
		<li>
			<label for="length">Length</label>
			<input type="text" name="length" id="length" placeholder="Map Length" required maxLength="255" value="<?php echo $results['map']->length ?>">
		</li>
		
		<li>
			<label for="objectives">Objectives</label>
			<input type="number" name="objectives" id="objectives" placeholder="Objectives" required maxLength="255" value="<?php echo $results['map']->objectives ?>">
		</li>
		
		<li>
			<label for="bonusObjectives">Bonus Objectives</label>
			<input type="number" name="bonusObjectives" id="bonusObjectives" placeholder="Bonus Objectives" required maxLength="255" value="<?php echo $results['map']->bonusObjectives ?>">
		</li>
		
		<li>
			<label for="difficulty">Difficulty</label>
			<input type="text" name="difficulty" id="difficulty" placeholder="Map Difficulty" required maxLength="255" value="<?php echo $results['map']->difficulty ?>">
		</li>
		
		<li>
			<label for="mapType">Map Type</label>
			<input type="text" name="mapType" id="mapType" placeholder="Map Type" required maxLength="255" value="<?php echo $results['map']->mapType ?>">
		</li>
		
		<li>
			<label for="minecraftVersion">Minecraft Version</label>
			<input type="text" name="minecraftVersion" id="minecraftVersion" placeholder="Minecraft Version" required maxLength="255" value="<?php echo $results['map']->minecraftVersion ?>">
		</li>
		
		<li>
			<label for="shortDescription">Short Description</label>
			<textarea name="shortDescription" id="shortDescription" placeholder="Short map description." required maxlength="350" style="height: 5em;"><?php echo htmlspecialchars($results['map']->shortDescription) ?></textarea>
		</li>
		
		<li>
			<label for="longDescription">Long Description</label>
			<textarea name="longDescription" id="longDescription" placeholder="Long map description." required style="height: 30em;"><?php echo htmlspecialchars($results['map']->longDescription) ?></textarea>
		</li>
		
		<li>
			<label for="downloadLink">Download Link</label>
			<input type="text" name="downloadLink" id="downloadLink" placeholder="Download Link" required maxLength="255" value="<?php echo $results['map']->downloadLink ?>">
		</li>
		
		<li>
			<label for="imageURL">Image URL</label>
			<input type="text" name="imageURL" id="imageURL" placeholder="Image URL" required maxLength="255" value="<?php echo $results['map']->imageURL ?>">
		</li>
		
		<li>
			<label for="downloadCount">Download Count</label>
			<input type="number" name="downloadCount" id="downloadCount" placeholder="Download Count" required maxLength="255" value="<?php echo $results['map']->downloadCount ?>">
		</li>
	</ul>
	
	<div class="buttons">
		<input type="submit" name="saveChanges" value="Save Changes" />
		<input type="submit" formnovalidate name="cancel" value="Cancel" />
	</div>
</form>

<?php if ( $results['map']->id ) { ?>
	<p><a href="admin.php?action=deleteMap&amp;mapId=<?php echo $results['map']->id ?>" onclick="return confirm('Delete This Map?')">Delete This Map</a></p>
<?php } ?>

<?php include $_SERVER['DOCUMENT_ROOT'] . "/templates/include/footer.php" ?>