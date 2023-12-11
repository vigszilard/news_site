<?php
    include "../classes/Database.php";
    include "../classes/Article.php";
    session_start();

    if (!isset($_SESSION["user"])) {
        header("Location: ../login.php");
        exit();
    }
    $user = $_SESSION["user"];

    // Check if the user has the editor role
    if ($user["role_id"] !== 3) {
        $_SESSION["no_rights_error"] = "Only editors are allowed to approve / decline articles.";
        header("Location: ../dashboard.php?error=" . urlencode($_SESSION["no_rights_error"]));
        exit();
    }

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $article_id = $_POST["article_id"];

        $database = new Database();
        $article = new Article($database);
        $old_article = $article -> get_article_by_id($article_id);

        $result = $article -> update_article($article_id, $old_article["title"], $old_article["content"],
            $old_article["author_id"], $old_article["category_id"], 1);

        if ($result) {
            header("Location: ../dashboard.php");
        } else {
            $_SESSION["approve_article_error"] = "Failed to approve the article. Please try again.";
            header("Location: ../dashboard.php?error=" . urlencode($_SESSION["approve_article_error"]));
        }
        exit();
    }


