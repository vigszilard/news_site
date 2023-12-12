<?php
    include "../classes/Database.php";
    include "../classes/Auth.php";
    include "../classes/Journalist.php";
    session_start();

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $email = $_POST["email"];
        $password = $_POST["password"];
        $article_id = $_POST["article_id"];

        $database = new Database();
        $journalist = new Journalist($database);
        $auth = new Auth($journalist);

        $result = $auth -> login($email, $password);

        if ($result) {
            $user = $journalist -> get_journalist_by_email($email);
            if($article_id) {
                header("Location: ../article.php?id={'$article_id'}");
            } else if($user["role_id"] == 1) {
                header("Location: ../index.php");
            } else {
                header("Location: ../dashboard.php");
            }
        } else {
            $_SESSION["login_error"] = "Login failed. Please check your credentials and try again.";
            header("Location: ../login.php?error=" . urlencode($_SESSION["login_error"]));
        }
        exit();
    }
