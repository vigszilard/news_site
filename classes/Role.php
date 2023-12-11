<?php

class Role {
    private Database $db;

    public function __construct($db) {
        $this -> db = $db;
    }

    public function get_all_roles(): bool|array {
        $query = "SELECT * FROM roles";
        $result = $this -> db -> query($query);

        return $result -> fetchAll(PDO::FETCH_ASSOC);
    }

    public function get_role_by_id($role_id) {
        $query = "SELECT * FROM roles WHERE id = :id";
        $statement = $this -> db -> prepare($query);
        $statement -> bindParam(':id', $role_id);
        $statement -> execute();

        return $statement -> fetch(PDO::FETCH_ASSOC);
    }
}
