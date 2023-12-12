<?php
    include "classes/Database.php";
    include "classes/Article.php";
    include "classes/Category.php";
    include "classes/Amendment.php";
    include "utils.php";
    session_start();

    $database = new Database();
    $article = new Article($database);
    $category = new Category($database);
    $amendments = new Amendment($database);

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
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="stylesheet" href="css/styles.css">
        <base href="http://localhost:63342/newspaper/">
        <title>Newspaper | Dashboard</title>
    </head>
    <body>

    <?php include "components/header.php"; ?>
    <?php include "components/error_toast.php"; ?>

    <a class="ml-5 mt-5 btn-link" href="index.php">
        <i class="fas fa-chevron-left"></i> Back
    </a>
    <div class="container mt-5 mb-5">
        <div class="row">
            <div class="col-md-12">
                <h2>Dashboard</h2>
                <h5 class="text-muted">Welcome, <?php echo $user["firstname"]; ?></h5>
            </div>
        </div>

        <?php if ($user["role_id"] == 3): // Editor Role ?>
            <div class="row mt-4">
                <?php foreach ($declined_articles as $article): ?>
                    <?php $amendment = $amendments -> get_amendment_by_article_id($article["id"]);
                    if (!$amendment) : ?>
                        <div class="col-md-6">
                            <div class="card mb-4">
                                <div class="card-body text-center">
                                    <h5 class="card-title"><?php echo $article["title"]; ?></h5>
                                    <p class="card-text flex-grow-1 text-justify"><?php echo $article["content"]; ?></p>

                                    <div class="d-flex justify-content-between">
                                        <form action="scripts/approve_article.php" method="post">
                                            <input type="hidden" name="article_id" value="<?php echo $article["id"]; ?>">
                                            <button type="submit" class="btn btn-primary">Approve</button>
                                        </form>

                                        <form action="scripts/decline_article.php" method="post">
                                            <input type="hidden" name="article_id" value="<?php echo $article["id"]; ?>">
                                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#amendmentModal" onclick="setArticleId(<?php echo $article['id']; ?>)">
                                                Decline
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
            <div id="accordion" class="row mt-4">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header" id="headingAmendments">
                            <h5 class="mb-0">
                                <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseAmendments" aria-expanded="false" aria-controls="collapseAmendments">
                                    <i class="fas fa-chevron-down"></i>
                                    Waiting for changes...
                                </button>
                            </h5>
                        </div>
                        <div id="collapseAmendments" class="collapse" aria-labelledby="headingAmendments" data-parent="#accordion">
                            <div class="row mt-4">
                                <?php foreach ($declined_articles as $declined_article) : ?>
                                    <?php $amendment = $amendments -> get_amendment_by_article_id($declined_article["id"]);
                                    if ($amendment) : ?>
                                        <div class="col-md-6 p-3">
                                            <div class="card mb-4">
                                                <div class="card-body text-center">
                                                    <h5 class="card-title"><?php echo $declined_article["title"]; ?></h5>
                                                    <!--                                                    <p class="card-text flex-grow-1 text-justify">--><?php //echo $declined_article["content"]; ?><!--</p>-->
                                                    <div class="d-flex justify-content-center">
                                                        <form action="" method="post">
                                                            <input type="hidden" name="article_id" value="<?php echo $declined_article["id"]; ?>">
                                                            <button type="submit" class="btn btn-primary">Show amendments</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php elseif ($user["role_id"] == 2): // Writer Role ?>
            <div class="row justify-content-center mt-4">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Submit Article</h5>
                        </div>
                        <div class="card-body">
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
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary btn-block">Submit Article</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 p-3">
                    <h5 class="text-muted">My Articles</h5>
                </div>
                <div class="col-md-12">
                    <div id="articleCarousel" class="carousel slide" data-ride="carousel">
                        <div class="carousel-inner text-center">
                            <?php foreach ($writer_articles as $index => $each_article): ?>
                                <div class="carousel-item <?php echo $index === 0 ? "active" : ""; ?>">
                                    <div class="card-deck">
                                        <div class="card">
                                            <div class="card-body">
                                                <h5 class="card-title"><?php echo $each_article["title"]; ?></h5>
                                                <p class="card-text flex-grow-1 text-justify">
                                                    <?php echo get_substring($each_article["content"]); ?>
                                                </p>
                                                <p class="font-weight-bold">
                                                    <?php
                                                    $amendment = $amendments -> get_amendment_by_article_id($each_article["id"]);
                                                    $status = $each_article["is_approved"] == 1 ? "Article approved" :
                                                        ($amendment ? "Changes required" : "Waiting for approval");

                                                    $statusClass = $each_article["is_approved"] == 1 ? "text-success" : ($amendment ? "text-warning" : "text-secondary");
                                                    echo "<span class='{$statusClass}'>{$status}</span>";
                                                    ?>
                                                </p>
                                            </div>
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

    <!-- Modal for writing amendments -->
    <div class="modal fade" id="amendmentModal" tabindex="-1" role="dialog" aria-labelledby="amendmentModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="amendmentModalLabel">Write Amendments</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="amendmentForm" action="scripts/decline_article.php" method="post">
                        <div class="form-group row">
                            <label for="amendmentText" class="col-sm-3 col-form-label">Amendments:</label>
                            <div class="col-sm-9">
                                <textarea class="form-control" id="amendmentText" name="text" rows="4" required></textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-12 text-center">
                                <input type="hidden" id="article_id" name="article_id" value="">
                                <button type="submit" class="btn btn-primary btn-block" onclick="getArticleId(this)">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
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
