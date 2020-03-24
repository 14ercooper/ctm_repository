<?php include $_SERVER['DOCUMENT_ROOT'] . "/templates/include/header.php" ?>

<p>Note: Do not use this form over a metered (data limited) internet connection.</p>

<form action="browse.php?action=results" method="post">
	<input type="hidden" name="searchDone" value="true" />
	
	<ul>
		<li>
			<label for="objectivesMin">Number of Objectives (Min)</label>
			<input type="number" name="objectivesMin" id="objectivesMin" value="">
		</li>
		
		<li>
			<label for="objectivesMax">Number of Objectives (Max)</label>
			<input type="number" name="objectivesMax" id="objectivesMax" value="">
		</li>
		
		<li>
			<label for="minecraftVersion" id="minecraftVersion">Minecraft Version</label>
			<select name="minecraftVersion" id="minecraftVersion">
				<option value="">Any</option>
				<option value="1.13">1.13 - Present</option>
				<option value="1.9">1.9 - 1.12</option>
				<option value="1.7">1.7 - 1.8</option>
				<option value="1.3">1.3 - 1.6</option>
				<option value="1.0">1.0 - 1.2</option>
				<option value="Beta">Beta</option>
			</select>
		</li>
		
		<li>
			<label for="length" id="length">Map Length</label>
			<select name="length" id="length">
				<option value="">Any</option>
				<option value="Short">Short</option>
				<option value="Medium">Medium</option>
				<option value="Long">Long</option>
			</select>
		</li>
		
		<li>
			<label for="difficulty" id="difficulty">Map Difficulty</label>
			<select name="difficulty" id="difficulty">
				<option value="">Any</option>
				<option value="Easy">Easy</option>
				<option value="Medium">Medium</option>
				<option value="Hard">Hard</option>
			</select>
		</li>
		
		<li>
			<label for="type" id="type">Map Type</label>
			<select name="type" id="type">
				<option value="">Any</option>
				<option value="Branching">Branching</option>
				<option value="Linear">Linear</option>
				<option value="OpenWorld">Open World</option>
				<option value="Adventure">Adventure</option>
				<option value="Other">Other</option>
			</select>
		</li>
		
		<li>
			<label for="sortOrder" id="sortOrder">Sort By</label>
			<select name="sortOrder" id="sortOrder">
				<option value="PopScore">Popularity</option>
				<option value="Popularity">Download Count</option>
				<option value="Random">Random</option>
			</select>
		</li>
	</ul>
	
	<div class="buttons">
		<input type="submit" name="search" value="Search" />
	</div>
</form>

<?php include $_SERVER['DOCUMENT_ROOT'] . "/templates/include/footer.php" ?>