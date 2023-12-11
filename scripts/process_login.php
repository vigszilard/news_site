<?php
    include "../classes/Database.php";
    include "../classes/Auth.php";
    include "../classes/Journalist.php";
    session_start();

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $email = $_POST["email"];
        $password = $_POST["password"];

        $database = new Database();
        $journalist = new Journalist($database);
        $auth = new Auth($journalist);

        $result = $auth -> login($email, $password);

        if ($result) {
            header("Location: ../dashboard.php");
            exit();
        } else {
            echo "Login failed. Please check your credentials and try again.";
        }
    }
