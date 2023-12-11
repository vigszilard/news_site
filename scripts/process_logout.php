<?php
    include "../classes/Database.php";
    include "../classes/Auth.php";
    include "../classes/Journalist.php";
    session_start();

    $database = new Database();
    $journalist = new Journalist($database);
    $auth = new Auth($journalist);

    $result = $auth -> logout();

    if ($result) {
        header("Location: ../index.php");
        exit();
    } else {
        echo "Logout failed. Please try again.";
    }
