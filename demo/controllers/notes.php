<?php

$config = require('config.php');
$dba = new Database($config);

$heading = "My Notes";

$notes = $dba->query('select * from notes ')->get() ;

require "views/notes.view.php";