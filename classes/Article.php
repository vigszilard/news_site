<?php

class Article {
    private Database $db;

    public function __construct($db) {
        $this -> db = $db;
    }

    public function get_all_articles(): bool|array
    {
        $query = "SELECT * FROM articles";
        $result = $this -> db -> query($query);

        return $result -> fetchAll(PDO::FETCH_ASSOC);
    }

    public function get_approved_articles(): bool|array {
        $query = "SELECT * FROM articles WHERE is_approved = 1";
        $result = $this -> db -> prepare($query);
        $result -> execute();

        return $result -> fetchAll(PDO::FETCH_ASSOC);
    }

    public function get_declined_articles(): bool|array {
        $query = "SELECT * FROM articles WHERE is_approved = 0";
        $result = $this -> db -> prepare($query);
        $result -> execute();

        return $result -> fetchAll(PDO::FETCH_ASSOC);
    }

    public function get_article_by_id($article_id) {
        $query = "SELECT * FROM articles WHERE id = :id";
        $statement = $this -> db -> prepare($query);
        $statement -> bindParam(':id', $article_id);
        $statement -> execute();

        return $statement -> fetch(PDO::FETCH_ASSOC);
    }

    public function get_article_by_author_id($author_id) {
        $query = "SELECT * FROM articles WHERE author_id = :author_id";
        $statement = $this -> db -> prepare($query);
        $statement -> bindParam(':author_id', $author_id);
        $statement -> execute();

        return $statement -> fetch(PDO::FETCH_ASSOC);
    }

    public function add_article($title, $content, $author_id, $category_id): bool {
        $query = "INSERT INTO articles (title, content, author_id, category_id) 
                  VALUES (:title, :content, :author_id, :category_id)";
        $statement = $this -> db -> prepare($query);
        $statement -> bindParam(':title', $title);
        $statement -> bindParam(':content', $content);
        $statement -> bindParam(':author_id', $author_id);
        $statement -> bindParam(':category_id', $category_id);

        return $statement -> execute();
    }

    public function update_article($articleId, $title, $content, $author_id, $category_id, $is_approved): bool {
        $query = "UPDATE articles 
                  SET title = :title, content = :content, author_id = :author_id, category_id = :category_id, is_approved = :is_approved
                  WHERE id = :id";
        $statement = $this -> db -> prepare($query);
        $statement -> bindParam(':title', $title);
        $statement -> bindParam(':content', $content);
        $statement -> bindParam(':author_id', $author_id);
        $statement -> bindParam(':category_id', $category_id);
        $statement -> bindParam(':is_approved', $is_approved);
        $statement -> bindParam(':id', $articleId);

        return $statement -> execute();
    }

    public function get_articles_by_category_id($category_id): bool|array {
        $query = "SELECT * FROM articles WHERE category_id = :category_id";
        $statement = $this -> db -> prepare($query);
        $statement -> bindParam(':category_id', $category_id);
        $statement -> execute();

        return $statement -> fetchAll(PDO::FETCH_ASSOC);
    }

    public function get_articles_by_author_id($author_id): bool|array {
        $query = "SELECT * FROM articles WHERE author_id = :author_id";
        $statement = $this -> db -> prepare($query);
        $statement -> bindParam(':author_id', $author_id);
        $statement -> execute();

        return $statement -> fetchAll(PDO::FETCH_ASSOC);
    }

    public function delete_article($article_id): bool {
        $query = "DELETE FROM articles WHERE id = :id";
        $statement = $this -> db -> prepare($query);
        $statement -> bindParam(':id', $article_id);

        return $statement -> execute();
    }
}
