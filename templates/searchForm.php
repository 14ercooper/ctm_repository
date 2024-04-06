<?php include $_SERVER['DOCUMENT_ROOT'] . "/templates/include/header.php" ?>

<form action="search.php?action=results" method="post">
	<input type="hidden" name="searchDone" value="true" />

	<ul>
		<li>
			<label for="name">Map Name</label>
			<input type="text" name="name" id="name" maxLength="255" value="">
		</li>

		<li>
			<label for="author">Map Author</label>
			<input type="text" name="author" id="author" maxLength="255" value="">
		</li>

		<li>
			<label for="series">Map Series</label>
			<input type="text" name="series" id="series" maxLength="255" value="">
		</li>

		<li>
			<label for="objectives">Number of Objectives</label>
			<input type="number" name="objectives" id="objectives" value="">
		</li>

		<li>
			<label for="length" id="length">Map Length</label>
			<select name="length" id="length">
				<option value="">Any</option>
				<option value="VeryShort">Very Short</option>
				<option value="Short">Short</option>
				<option value="Medium">Medium</option>
				<option value="Long">Long</option>
				<option value="VeryLong">Very Long</option>
			</select>
		</li>

		<li>
			<label for="difficulty" id="difficulty">Map Difficulty</label>
			<select name="difficulty" id="difficulty">
				<option value="">Any</option>
				<option value="VeryEasy">Very Easy</option>
				<option value="Easy">Easy</option>
				<option value="Medium">Medium</option>
				<option value="Hard">Hard</option>
				<option value="VeryHard">Very Hard</option>
			</select>
		</li>

		<li>
			<label for="type" id="type">Map Type</label>
			<select name="type" id="type">
				<option value="">Any</option>
				<option value="Branching">Branching</option>
				<option value="Linear">Linear</option>
				<option value="OpenWorld">Open World</option>
				<option value="SemiOpenWorld">Semi-Open World</option>
				<option value="Adventure">Adventure</option>
				<option value="CentralHub">Central Hub</option>
				<option value="RFW">RFW</option>
				<option value="Other">Other</option>
			</select>
		</li>

		<li>
			<label for="numRows">Maps to Return</label>
			<input type="number" name="numRows" id="numRows" max="100" value="">
		</li>
	</ul>

	<div class="buttons">
		<input type="submit" name="search" value="Search" />
	</div>
</form>

<?php include $_SERVER['DOCUMENT_ROOT'] . "/templates/include/footer.php" ?>
