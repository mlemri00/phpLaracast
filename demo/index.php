<?php

// require ("router.php");
require ("functions.php");
require ("Database.php");

$config=require ('config.php');

$db=new Database($config);


$posts=$db->query("select * from posts")->fetch() ;



dd($posts['title']);