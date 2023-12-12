<?php
    include "../classes/Database.php";
    include "../classes/Article.php";
    include "../classes/Amendment.php";
    session_start();

    if (!isset($_SESSION["user"])) {
        header("Location: ../login.php");
        exit();
    }
    $user = $_SESSION["user"];

    if ($user["role_id"] !== 3) { //Editor
        $_SESSION["no_rights_error"] = "Only editors are allowed to approve / decline articles.";
        header("Location: ../dashboard.php?error=" . urlencode($_SESSION["no_rights_error"]));
        exit();
    }

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $text = $_POST["text"];
        $article_id = $_POST["article_id"];

        $database = new Database();
        $article = new Article($database);
        $amendment = new Amendment($database);

        $result = $amendment -> add_amendment($text, $article_id);

        if ($result) {
            header("Location: ../dashboard.php");
        } else {
            $_SESSION["decline_article_error"] = "Failed to decline the article. Please try again.";
            header("Location: ../dashboard.php?error=" . urlencode($_SESSION["decline_article_error"]));
        }
        exit();
    }
