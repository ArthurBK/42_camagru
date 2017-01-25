#!/usr/bin/php
<?php
try {
    $DB_DSN = "mysql:host=localhost;";
    $DB_USER = "root";
    $DB_PASSWORD = "root";


    $pdo = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);//Ligne 4
    $pdo->exec("CREATE DATABASE IF NOT EXISTS camagru_abonneca");
    $pdo->exec("use camagru_abonneca");
    $pdo->exec("
    CREATE TABLE IF NOT EXISTS users
    (
    id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    username VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    CONSTRAINT uc_UserID UNIQUE (username,email)
    );
    ");
    $pdo->exec("
    CREATE TABLE IF NOT EXISTS comments
    (
    id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    id_user INT NOT NULL,
    FOREIGN KEY (id) REFERENCES Users(id),
    content TEXT NOT NULL
    );
    ");
    $pdo->exec("
    CREATE TABLE IF NOT EXISTS likes
    (
    id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    id_user INT NOT NULL,
    FOREIGN KEY (id) REFERENCES Users(id),
    liked BOOLEAN NOT NULL DEFAULT FALSE
    );
    ");
    $pdo->exec("
    CREATE TABLE IF NOT EXISTS images
    (
    id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    id_like INT NOT NULL,
    id_comment INT NOT NULL,
    name VARCHAR(255) NOT NULL,
    FOREIGN KEY (id_comment) REFERENCES Comments(id),
    FOREIGN KEY (id_like) REFERENCES Likes(id)
    );
    ");
    echo "Database 'db_abonneca' created successfully.<br>";
} catch (PDOException $e) {
    $msg = 'ERREUR PDO dans ' . $e->getFile() . ' L.' . $e->getLine() . ' : ' . $e->getMessage();
    die($msg);
}

?>
