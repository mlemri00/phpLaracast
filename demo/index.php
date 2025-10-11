<?php

// require ("router.php");
require ("functions.php");


class Database{


    public $connection;

    public function __construct(){
        $dsn = 'mysql:host=127.0.0.1;port=3309;user=root;password=123456789;dbname=myapp;charset=utf8mb4';
        // PHP data object
        $this->connection = new PDO($dsn);

    }

    public function query($query){
        $statement = $this->connection->prepare($query);
        $statement->execute();

        return $statement;

    }


}

$db=new Database();


$posts=$db->query("select * from posts")->fetch(PDO::FETCH_ASSOC) ;



dd($posts['title']);