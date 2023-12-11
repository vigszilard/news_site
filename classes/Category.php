<?php

class Category {
    private Database $db;

    public function __construct($db) {
        $this -> db = $db;
    }

    public function get_all_categories(): bool|array {
        $query = "SELECT * FROM categories";
        $result = $this -> db -> query($query);

        return $result -> fetchAll(PDO::FETCH_ASSOC);
    }

    public function get_category_by_id($category_id) {
        $query = "SELECT * FROM categories WHERE id = :id";
        $statement = $this -> db -> prepare($query);
        $statement -> bindParam(':id', $category_id);
        $statement -> execute();

        return $statement -> fetch(PDO::FETCH_ASSOC);
    }

    public function add_category($name): bool {
        $query = "INSERT INTO categories (name) VALUES (:name)";
        $statement = $this -> db -> prepare($query);
        $statement -> bindParam(':name', $name);

        return $statement -> execute();
    }
}
