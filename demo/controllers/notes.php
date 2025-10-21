<?php

require ('Database.php');
$config = require('config.php');
$dba = new Database($config);

$heading = "My Notes";

$notes = $dba->query('select * from notes where user_id = 1')->fetchAll() ;
require "views/notes.view.php";