<?php
    include "utils.php";
    include "classes/Database.php";
    include "classes/Auth.php";
    include "classes/Journalist.php";
    include "classes/Article.php";

    session_start();
    $database = new Database();
    $journalists = new Journalist($database);
    $authorization = new Auth($journalists);
    $article = new Article($database);
    $all_articles = $article -> get_approved_articles();
?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="stylesheet" href="css/styles.css">
        <base href="http://localhost:63342/newspaper/">
        <title>Newspaper</title>
    </head>

    <body>
        <?php include "components/header.php"; ?>
        <?php include "components/error_toast.php"; ?>

        <div class="container mt-5 mb-5">
            <div class="row justify-content-center">

                <?php if (empty($all_articles)): ?>
                    <div class="col-md-6 text-center">
                        <p>No articles available</p>
                    </div>
                <?php else: ?>
                    <?php foreach ($all_articles as $article): ?>
                        <div class="col-md-4 mb-4">
                            <div class="card h-100">
                                <div class="card-body text-center d-flex flex-column">
                                    <h5 class="card-title">
                                        <?php echo $article["title"]; ?>
                                    </h5>
                                    <div class="d-flex justify-content-between">
                                        <span class="card-subtitle mb-2 text-muted font-italic py-2">
                                            <?php
                                            $journalist = $journalists -> get_journalist_by_id($article["author_id"]);
                                            echo $journalist["firstname"] . " " . $journalist["lastname"];
                                            ?>
                                        </span>
                                        <span class="card-subtitle mb-2 text-muted font-italic py-2">
                                            <?php
                                                try {
                                                    echo format_timestamp($article["created_at"]);
                                                } catch (Exception $e) {
                                                    echo "Unknown";
                                                }
                                            ?>
                                        </span>
                                    </div>
                                    <p class="card-text flex-grow-1 text-justify">
                                        <?php echo get_substring($article["content"]); ?>
                                    </p>

                                    <?php
                                        $_SESSION["article_id"] = $article["id"];
                                        $is_logged_in = isset($_SESSION["user"]);
                                        $modal_attributes = $is_logged_in ? "" : "data-toggle='modal' data-target='#readMoreModal'";
                                        $button_action = $is_logged_in ? "location.href='article.php?id={$article['id']}'" : "setArticleId('{$article['id']}')";
                                    ?>
                                    <button type="button" class="btn btn-primary mt-auto" <?php echo $modal_attributes; ?> onclick="<?php echo $button_action; ?>">
                                        Read More
                                    </button>

                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>

        <?php include "components/footer.php"; ?>
        <?php include "components/modal.php"; ?>

        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
        <script src="js/script.js"></script>

    </body>
</html>
