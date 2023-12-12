<?php

    $db = new Database();
    $category = new Category($db);
    $all_categories = $category -> get_all_categories();
?>

<div class="modal fade" id="submitArticleModal" tabindex="-1" role="dialog" aria-labelledby="submitArticleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="submitArticleModalLabel">Submit Article</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="../scripts/update_article.php" method="post">
                    <div class="form-group">
                        <label for="title">Title:</label>
                        <input id="update_title" type="text" class="form-control" name="title" required>
                    </div>
                    <div class="form-group">
                        <label for="update_content">Content:</label>
                        <textarea id="update_content" class="form-control" name="content" rows="4" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="update_category_id">Category:</label>
                        <select id="update_category_id" class="form-control" name="category_id">
                            <?php foreach ($all_categories as $category): ?>
                                <option value="<?php echo $category["id"]; ?>">
                                    <?php echo $category["name"]; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="hidden" id="update_article_id" name="article_id" value="">
                        <input type="hidden" id="update_amendment_id" name="amendment_id" value="">
                        <button type="submit" class="btn btn-primary btn-block">Submit Article</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>