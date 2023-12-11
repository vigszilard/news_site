<?php

class Journalist {
    private Database $db;

    public function __construct($db) {
        $this -> db = $db;
    }

    public function get_all_journalists(): bool|array {
        $query = "SELECT * FROM journalists";
        $result = $this -> db -> query($query);

        return $result -> fetchAll(PDO::FETCH_ASSOC);
    }

    public function get_journalist_by_id($journalist_id) {
        $query = "SELECT * FROM journalists WHERE id = :id";
        $statement = $this -> db -> prepare($query);
        $statement -> bindParam(':id', $journalist_id);
        $statement -> execute();

        return $statement -> fetch(PDO::FETCH_ASSOC);
    }

    public function get_journalist_by_email($email) {
        $query = "SELECT * FROM journalists WHERE email = :email";
        $statement = $this -> db -> prepare($query);
        $statement -> bindParam(':email', $email);
        $statement -> execute();

        return $statement -> fetch(PDO::FETCH_ASSOC);
    }

    public function add_journalist($email, $password, $firstname, $lastname, $role_id) {
        $query = "INSERT INTO journalists (email, password, firstname, lastname, role_id) 
                  VALUES (:email, :password, :firstname, :lastname, :role_id)";
        $statement = $this -> db -> prepare($query);
        $statement -> bindParam(':email', $email);
        $statement -> bindParam(':password', $password);
        $statement -> bindParam(':firstname', $firstname);
        $statement -> bindParam(':lastname', $lastname);
        $statement -> bindParam(':role_id', $role_id);

        if ($statement -> execute()) {
            return $this -> get_journalist_by_email($email);
        }
        return false;
    }

    public function is_email_taken($email): bool {
        $query = "SELECT COUNT(*) FROM journalists WHERE email = :email";
        $statement = $this -> db -> prepare($query);
        $statement -> bindParam(':email', $email);
        $statement -> execute();
        $count = $statement -> fetchColumn();

        return $count > 0;
    }

}
