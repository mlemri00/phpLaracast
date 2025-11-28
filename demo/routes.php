<?php


use Http\controllers\notes\NotesController;

$noteController = new NotesController();

$router->get('/','index.php');
$router->get( '/about','about.php');
//$router->get('/notes','notes/index.php')->only("auth");
$router->get('/notes',"notes@index")->only("auth")   ;


$router->get('/note',"notes@show")->only("auth");


$router->get('/notes/create','notes@create');
$router->delete('/note','notes@destroy');

$router->get('/note/edit','notes@edit');
$router->patch('/note','notes@update');
$router->post('/note','notes@store');


$router->get('/contact','contact.php');

$router->get('/register','registration/create.php')->only('guest');
$router->post('/register','registration/store.php');

$router->get('/login','sessions/create.php')->only('guest');
$router->post('/sessions','sessions/store.php')->only('guest');
$router->delete('/sessions','sessions/destroy.php')->only('auth');

////TEST TEST TEST TEST

