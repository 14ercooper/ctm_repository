<?php include $_SERVER['DOCUMENT_ROOT'] . "/templates/include/header.php" ?>

<h1>Post A Comment For <?php echo $dispMap->name ?></h1>
<hr>

<form action=<?php echo "index.php?action=submitComment&id=" . $_GET['id'] ?> method="post">
    <input type="hidden" name="mapId" id="mapId" value=<?php echo $_GET['id'] ?>>
    <ul>
        <li>
            <label for="author">Author</label>
            <input type="text" name="author" id="author" required autofocus placeholder="Review Author" maxLength="255">
        </li>
        <li>
            <label for="rating">Rating</label>
            <select name="rating" id="rating">
                <option value="0">No Rating</option>
                <option value="1">One Star</option>
                <option value="2">Two Stars</option>
                <option value="3">Three Stars</option>
                <option value="4">Four Stars</option>
                <option value="5">Five Stars</option>
            </select>
        </li>
        <li>
            <label for="screenshotLink">Screenshot Link</label>
            <input type="text" name="screenshotLink" id="screenshotLink" placeholder="Screenshot Link (Use Direct Link)" maxLength="255">
        </li>
        <li>
            <label for="comment">Comment</label>
            <textarea name="comment" id="comment" required placeholder="Comment" style="height: 15em;" minLength="32" maxLength="1024"></textarea>
        </li>
    </ul>

    <div class="buttons">
        <input type="submit" name="postComment" value="Post Comment" />
    </div>
</form>

<?php include $_SERVER['DOCUMENT_ROOT'] . "/templates/include/footer.php" ?>