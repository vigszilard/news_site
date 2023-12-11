<?php
    include "classes/Database.php";
    include "classes/Article.php";
    include "classes/Journalist.php";
    include "classes/Category.php";
    include "utils.php";
    session_start();

    $database = new Database();
    $article = new Article($database);
    $category = new Category($database);
    $journalist = new Journalist($database);

    if (!isset($_SESSION["user"])) {
        header("Location: login.php");
        exit();
    }

    $article_id = $_GET["id"] ?? null;
    $article_data = $article -> get_article_by_id($article_id);

    if (!$article_data) {
        $_SESSION["no_article_found_error"] = "Article not found";
        header("Location: index.php?error=" . urlencode($_SESSION["no_article_found_error"]));
        exit();
    }
    $journalist_data = $journalist -> get_journalist_by_id($article_data["author_id"]);
    $category_data = $category -> get_category_by_id($article_data["category_id"]);

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
        <title>Newspaper | <?php echo $article_data["title"]; ?></title>
    </head>
    <body>

        <?php include "components/header.php"; ?>

        <a class="ml-5 mt-5 btn-link" href="index.php">
            <i class="fas fa-chevron-left"></i> Back
        </a>
        <div class="container mt-5 mb-5">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <h2 class="text-center mb-4"><?php echo $article_data["title"]; ?></h2>
                    <div class="justify-content-between">
                        <h4 class="text-muted">Category - <?php echo $category_data["name"]?></h4>
                        <p class="text-muted justify-content-between">
                            <?php echo $journalist_data["firstname"] . " " . $journalist_data["lastname"]; ?> |
                            <?php
                            try {
                                echo format_timestamp($article_data["created_at"]);
                            } catch (Exception $e) {
                                echo "Unknown";
                            }
                            ?>
                        </p>
                    </div>
                    <p class="text-justify">
                        <?php echo $article_data["content"]; ?>
                    </p>
                </div>
            </div>
        </div>

        <?php include "components/footer.php"; ?>

        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
        <script src="js/script.js"></script>

    </body>
</html>

