<?php
    include "../classes/Database.php";
    include "../classes/Amendment.php";
    include "../classes/Article.php";
    session_start();

    if (!isset($_SESSION["user"])) {
        header("Location: ../login.php");
        exit();
    }
    $user = $_SESSION["user"];

    // Check if the user has the writer role
    if ($user["role_id"] !== 2) {
        $_SESSION["no_rights_error"] = "Only writers are allowed to submit articles.";
        header("Location: ../dashboard.php?error=" . urlencode($_SESSION["no_rights_error"]));
        exit();
    }

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $title = $_POST["title"];
        $content = $_POST["content"];
        $category_id = $_POST["category_id"];
        $article_id = $_POST["article_id"];
        $amendment_id = $_POST["amendment_id"];

        $database = new Database();
        $article = new Article($database);
        $amendment = new Amendment($database);

        $result = $article -> update_article($article_id, $title, $content, $user["id"], $category_id, 0);
        $result2 = $amendment -> delete_amendment($amendment_id);

        if ($result && $result2) {
            header("Location: ../newspaper/dashboard.php");
        } else {
            $_SESSION["submit_article_error"] = "Article submission failed. Please try again.";
            header("Location: ../newspaper/dashboard.php?error=" . urlencode($_SESSION["submit_article_error"]));
        }
        exit();
    }
