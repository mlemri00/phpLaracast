<?php

require ('Database.php');
$config = require('config.php');
$dba = new Database($config);

$heading = "Note";

$note = $dba->query('select * from notes where id = :id',['id'=>$_GET['id']])->fetch() ;
require "views/note.view.php";