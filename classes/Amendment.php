<?php

class Amendment {
    private Database $db;

    public function __construct($db) {
        $this -> db = $db;
    }

    public function get_all_amendments(): bool|array
    {
        $query = "SELECT * FROM amendments";
        $result = $this -> db -> query($query);

        return $result -> fetchAll(PDO::FETCH_ASSOC);
    }

    public function get_amendment_by_article_id($article_id) {
        $query = "SELECT * FROM amendments WHERE article_id = :article_id";
        $statement = $this -> db -> prepare($query);
        $statement -> bindParam(':article_id', $article_id);
        $statement -> execute();

        return $statement -> fetch(PDO::FETCH_ASSOC);
    }

    public function add_amendment($text, $article_id): bool {
        $query = "INSERT INTO amendments (text, article_id) VALUES (:text, :article_id)";
        $statement = $this -> db -> prepare($query);
        $statement -> bindParam(':text', $text);
        $statement -> bindParam(':article_id', $article_id);

        return $statement -> execute();
    }

    public function delete_amendment($amendment_id): bool {
        $query = "DELETE FROM amendments WHERE id = :id";
        $statement = $this -> db -> prepare($query);
        $statement -> bindParam(':id', $amendment_id);

        return $statement -> execute();
    }

}