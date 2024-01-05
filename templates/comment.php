<div class="review">
    <div class="review-header">
        <div class="review-author">
            <h3><?php echo htmlspecialchars($comment->author) ?></h3>
            <p><?php echo date("Y-m-d H:i:s", strtotime($comment->addedDate)) ?></p>
        </div>
        <div class="review-rating">
            <?php $i = $comment->rating; while ($i > 0) { ?>
                <span class="rating-star">★</span>
            <?php $i--; } ?>
        </div>
    </div>
    <div class="review-content-container">
        <div class="review-comment">
        <?php if (!empty($comment->screenshotLink)) { ?>
                <img src="<?php echo htmlspecialchars($comment->screenshotLink) ?>" alt="Screenshot"/>
            <?php } ?>
        <p><?php echo htmlspecialchars($comment->comment) ?></p>
        </div>
    </div>
    <div>
        <?php if (!isset($_GET['status']) && !isset($_GET['commentId']) || isset($_GET['commentId']) && $_GET['commentId'] != $comment->id) { ?>
            <a href="index.php?action=reportComment&id=<?php echo $comment->parentMapId ?>&commentId=<?php echo $comment->id ?>"><p class="report">Report Comment</p></a>
        <?php } ?>
    </div>
</div>