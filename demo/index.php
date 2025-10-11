<?php

// require ("router.php");
require ("functions.php");

//Preparar connexió
$dsn = 'mysql:host=127.0.0.1;port=3309;user=root;password=123456789;dbname=myapp;charset=utf8mb4';
// PHP data object
$pdo = new PDO($dsn);

$statement = $pdo->prepare("select * from posts");
$statement->execute();

$posts = $statement->fetchAll(PDO::FETCH_ASSOC);


foreach ($posts as $post){
    echo "<li>". $post['title']."</li>";
}