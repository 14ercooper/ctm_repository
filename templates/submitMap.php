<br>
<form action="submitMap.php?action=submit" method="post"  enctype="multipart/form-data">
	<ul>
		<li>
			<label for="name">Name</label>
			<input type="text" name="name" id="name" placeholder="Map Name" required autofocus maxLength="255" value="None">
		</li>

		<li>
			<label for="series">Series</label>
			<input type="text" name="series" id="series" placeholder="Series" required maxLength="255" value="None">
		</li>

		<li>
			<label for="author">Author</label>
			<input type="text" name="author" id="author" placeholder="Map Author" required maxLength="255" value="None">
		</li>

		<li>
			<label for="length">Length</label>
			<input type="text" name="length" id="length" placeholder="Map Length" required maxLength="255" value="None">
		</li>

		<li>
			<label for="objectives">Objectives</label>
			<input type="number" name="objectives" id="objectives" placeholder="Objectives" required maxLength="255" value="0">
		</li>

		<li>
			<label for="bonusObjectives">Bonus Objectives</label>
			<input type="number" name="bonusObjectives" id="bonusObjectives" placeholder="Bonus Objectives" required maxLength="255" value="0">
		</li>

		<li>
			<label for="difficulty">Difficulty</label>
			<input type="text" name="difficulty" id="difficulty" placeholder="Map Difficulty" required maxLength="255" value="None">
		</li>

		<li>
			<label for="mapType">Map Type</label>
			<input type="text" name="mapType" id="mapType" placeholder="Map Type" required maxLength="255" value="None">
		</li>

		<li>
			<label for="minecraftVersion">Minecraft Version</label>
			<input type="text" name="minecraftVersion" id="minecraftVersion" placeholder="Minecraft Version" required maxLength="255" value="None">
		</li>

		<li>
			<label for="shortDescription">Short Description</label>
			<textarea name="shortDescription" id="shortDescription" placeholder="Short map description." required maxlength="350" minlength="100" style="height: 5em;">None</textarea>
		</li>

		<li>
			<label for="longDescription">Long Description</label>
			<textarea name="longDescription" id="longDescription" placeholder="Long map description." required minlength="100" style="height: 30em;">None</textarea>
		</li>

		<li>
			<label for="downloadLink">Download Link</label>
			<input type="text" name="downloadLink" id="downloadLink" placeholder="Download Link" required maxLength="255" value="None">
		</li>

		<li>
			<label for="imageFile">Image</label>
			<input type="file" name="imageFile" id="imageFile">
		</li>
	</ul>

	<div class="buttons">
		<input type="submit" name="submit" value="Submit Map" />
	</div>
</form>
