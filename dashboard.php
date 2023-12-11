<?php
    include "classes/Database.php";
    include "classes/Article.php";
    include "classes/Category.php";
    session_start();

    $database = new Database();
    $article = new Article($database);
    $category = new Category($database);

    if (!isset($_SESSION["user"])) {
        header("Location: login.php");
        exit();
    }

    $user = $_SESSION["user"];
    $declined_articles = $article -> get_declined_articles();
    $writer_articles = $article -> get_articles_by_author_id($user["id"]);
    $all_categories = $category -> get_all_categories();
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha384-b8PDDdPBdlHH38LY47D3l9pL+g0TCrxI3RxXUE1V8zIfoPKge+PnNQhT9CGCDaLR" crossorigin="anonymous">
        <link rel="stylesheet" href="css/styles.css">
        <base href="http://localhost:63342/newspaper/">
        <title>Newspaper | Dashboard</title>
    </head>
    <body>

    <?php include "includes/header.php"; ?>

    <div class="container mt-4">
        <div class="row">
            <div class="col-md-12">
                <h2>Dashboard</h2>
                <h5 class="text-muted">Welcome, <?php echo $user["firstname"]; ?></h5>
            </div>
        </div>

        <?php if ($user["role_id"] == 3): // Editor Role ?>
            <div class="row mt-4">
                <?php
                foreach ($declined_articles as $article): ?>
                    <div class="col-md-6">
                        <div class="card mb-4">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $article["title"]; ?></h5>
                                <p class="card-text"><?php echo $article["content"]; ?></p>
                                <button class="btn btn-success">Approve</button>
                                <button class="btn btn-danger">Decline</button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php elseif ($user["role_id"] == 2): // Writer Role ?>
            <div class="row mt-4">
                <div class="col-md-6 offset-md-3">
                    <form action="scripts/submit_article.php" method="post">
                        <div class="form-group">
                            <label for="title">Title:</label>
                            <input id="title" type="text" class="form-control" name="title" required>
                        </div>
                        <div class="form-group">
                            <label for="content">Content:</label>
                            <textarea id="content" class="form-control" name="content" rows="4" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="category_id">Category:</label>
                            <select id="category_id" class="form-control" name="category_id">
                                <?php foreach ($all_categories as $category): ?>
                                    <option value="<?php echo $category["id"]; ?>">
                                        <?php echo $category["name"]; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Submit Article</button>
                    </form>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-md-6 offset-md-3">
                    <div id="articleCarousel" class="carousel slide" data-ride="carousel">
                        <div class="carousel-inner">
                            <?php
                            foreach ($writer_articles as $index => $writer_article): ?>
                                <div class="carousel-item <?php echo $index === 0 ? "active" : ""; ?>">
                                    <div class="card">
                                        <div class="card-body">
                                            <h5 class="card-title"><?php echo $writer_article["title"]; ?></h5>
                                            <p class="card-text">Status: <?php echo $writer_article["status"]; ?></p>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <a class="carousel-control-prev" href="#articleCarousel" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#articleCarousel" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>
                </div>
            </div>
        <?php endif; ?>

    </div>

    <?php include "includes/footer.php"; ?>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

    </body>
</html>
