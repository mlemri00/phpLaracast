<?php

namespace core;

use PDO;

class Database{


    public $connection;
    public $statement;
    public function __construct($config){

        $dsn = 'mysql:'.http_build_query($config,'',';');

        // PHP data object
        $this->connection = new PDO($dsn,'root','123456789',[
            PDO::ATTR_DEFAULT_FETCH_MODE =>PDO::FETCH_ASSOC
        ]);

    }

    public function query($query,$params =[]){
        ;
       $this-> statement = $this->connection->prepare($query);

       $this-> statement->execute($params);

        return $this;

    }

    public function get(){
        return $this->statement->fetchAll();
    }


    public function find(){return $this->statement->fetch();
    }

    public function findOrFail($apiRequest=false){
        $result = $this->find();
        if (!$result){
            abort($apiRequest);
        }
       return $result;
    }



}
