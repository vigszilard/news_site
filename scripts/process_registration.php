<?php
    include "../classes/Database.php";
    include "../classes/Auth.php";
    include "../classes/Journalist.php";

    $database = new Database();
    $journalist = new Journalist($database);
    $auth = new Auth($journalist);

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $email = $_POST["email"];
        $password = $_POST["password"];
        $firstname = $_POST["firstname"];
        $lastname = $_POST["lastname"];
        $role_id = $_POST["role_id"];

        $result = $auth -> register($email, $password, $firstname, $lastname, $role_id);

        echo $result;

        if ($result) {
            header("Location: ../dashboard.php");
            exit();
        } else {
            echo "Registration failed. Please try again.";
        }
    }
