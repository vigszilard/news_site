<?php
    include "../classes/Database.php";
    include "../classes/Auth.php";
    include "../classes/Journalist.php";
    session_start();

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $email = $_POST["email"];
        $password = $_POST["password"];
        $firstname = $_POST["firstname"];
        $lastname = $_POST["lastname"];
        $role_id = $_POST["role_id"];

        $database = new Database();
        $journalist = new Journalist($database);
        $auth = new Auth($journalist);

        $result = $auth -> register($email, $password, $firstname, $lastname, $role_id);

        if ($result) {
            if($_SESSION["article_id"]) {
                header("Location: ../article.php?id={$_SESSION['article_id']}");
                unset($_SESSION["article_id"]);
            } else {
                header("Location: ../dashboard.php");
            }
        } else {
            $_SESSION["register_error"] = "Register failed. Please try again.";
            header("Location: ../register.php?error=" . urlencode($_SESSION["register_error"]));
        }
        exit();
    }
