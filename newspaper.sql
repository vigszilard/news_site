CREATE DATABASE newspaper;

USE newspaper;

CREATE TABLE roles(
    id INT(6) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(25) NOT NULL
);

INSERT INTO roles(`name`) VALUES
('Reader'),
('Writer'),
('Editor');

CREATE TABLE journalists(
    id INT(6) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    email VARCHAR(50) NOT NULL,
    password VARCHAR(200) NOT NULL,
    firstname VARCHAR(50) NOT NULL,
    lastname VARCHAR(50) NOT NULL,
    role_id INT(6) NOT NULL,
    FOREIGN KEY (role_id) REFERENCES roles(id)
);

CREATE TABLE categories (
    id INT(6) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(50) NOT NULL
);

INSERT INTO categories(`name`) VALUES
('Artistic'),
('Technical'),
('Science'),
('Fashion');

CREATE TABLE articles (
    id INT(6) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(250) NOT NULL,
    content TEXT NOT NULL,
    author_id INT(6) NOT NULL,
    category_id INT(6) NOT NULL,
    is_approved BOOLEAN DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (author_id) REFERENCES journalists(id),
    FOREIGN KEY (category_id) REFERENCES categories(id)
);

CREATE TABLE amendments (
    id INT(6) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    text VARCHAR(250) NOT NULL,
    article_id INT(6) NOT NULL,
    FOREIGN KEY (article_id) REFERENCES articles(id)
);
