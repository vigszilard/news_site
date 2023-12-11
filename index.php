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
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha384-b8PDDdPBdlHH38LY47D3l9pL+g0TCrxI3RxXUE1V8zIfoPKge+PnNQhT9CGCDaLR" crossorigin="anonymous">
        <link rel="stylesheet" href="/css/styles.css">
        <base href="http://localhost:63342/newspaper/">
        <title>Newspaper</title>
    </head>

    <body>
        <?php include "includes/header.php"; ?>

        <div class="container mt-4">
            <div class="row justify-content-center">

                <?php if (empty($all_articles)): ?>
                    <div class="col-md-6 text-center">
                        <p>No articles available</p>
                    </div>
                <?php else: ?>
                    <?php foreach ($all_articles as $article): ?>
                        <div class="col-md-4 mb-4">
                            <div class="card h-100">
                                <div class="card-body text-center">
                                    <h5 class="card-title">
                                        <?php echo $article["title"]; ?>
                                    </h5>

                                    <div class="d-flex justify-content-between">
                                        <span class="card-subtitle mb-2 text-muted">
                                            <?php
                                                $journalist = $journalists -> get_journalist_by_id($article["author_id"]);
                                                echo $journalist["firstname"] . " " . $journalist["lastname"];
                                            ?>
                                        </span>
                                        <span class="card-subtitle mb-2 text-muted">
                                            <?php try {
                                                echo format_timestamp($article["created_at"]);
                                            } catch (Exception $e) {
                                                echo "Unknown";
                                            } ?>
                                        </span>
                                    </div>

                                    <p class="card-text">
                                        <?php echo get_substring($article["content"]); ?>
                                    </p>
                                    <button type="button" class="btn btn-primary mt-auto" data-toggle="modal" data-target="#readMoreModal">Read More</button>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>

        <?php include "includes/footer.php"; ?>
        <?php include "includes/modal.php"; ?>

        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

    </body>
</html>
