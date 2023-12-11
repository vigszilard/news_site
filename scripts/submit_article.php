<?php
    include "../classes/Database.php";
    include "../classes/Article.php";

    session_start();
    if (!isset($_SESSION["user"])) {
        header("Location: ../login.php");
        exit();
    }
    $user = $_SESSION["user"];

    // Check if the user has the writer role
    if ($user["role_id"] !== 2) {
        // Redirect to dashboard if the user doesn't have the writer role
        header("Location: ../dashboard.php");
        exit();
    }

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $title = $_POST["title"];
        $content = $_POST["content"];
        $category_id = $_POST["category_id"];

        $database = new Database();
        $article = new Article($database);

        $result = $article-> add_article($title, $content, $user["id"], $category_id);

        if ($result) {
            header("Location: ../dashboard.php");
            exit();
        } else {
            echo "Article submission failed. Please try again.";
        }
    }
