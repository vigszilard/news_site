<?php

class Auth {
    private Journalist $journalist;

    public function __construct($journalist) {
        $this -> journalist = $journalist;
    }

    public function login($email, $password): bool {
        $user_data = $this -> journalist -> get_journalist_by_email($email);

        //Todo remove || when all users are created with hashed passwords
        if ($user_data && (password_verify($password, $user_data["password"])) || $password == $user_data["password"]) {
            $_SESSION["user"] = $user_data;
            return true;
        }
        return false;
    }

    public function logout(): bool {
        session_destroy();
        return true;
    }

    public function register($email, $password, $firstname, $lastname, $role_id): bool {
        if ($this -> journalist -> is_email_taken($email)) {
            return false;
        }

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $user_id = $this -> journalist -> add_journalist($email, $hashedPassword, $firstname, $lastname, $role_id);

        var_dump($user_id); // Add this line for debugging
        if ($user_id) {
            $_SESSION["user"] = [
                "id" => $user_id,
                "email" => $email,
                "role_id" => $role_id
            ];

            return $user_id;
        }
        return false;
    }

    public function authorize($required_role): bool {
        if ($this -> is_logged_in() && $this -> get_user_role() === $required_role) {
            return true;
        }
        return false;
    }

    public function is_logged_in(): bool {
        return isset($_SESSION["user"]);
    }

    public function get_user_role() {
        return $_SESSION["user"]["role_id"] ?? null;
    }
}
