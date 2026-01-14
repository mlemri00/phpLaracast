<?php




$router->get('/','index.php');
$router->get( '/about','about.php');
$router->get('/notes',"NotesController","index")->only("auth")   ;


$router->get('/note',"NotesController",'show')->only("auth");


$router->get('/notes/create','NotesController','create');
$router->delete('/note','NotesController', 'delete');

$router->get('/note/edit','NotesController','edit');
$router->patch('/note','NotesController','update');
$router->post('/note','NotesController','store');


$router->get('/contact','contact.php');

$router->get('/register','registration/create.php')->only('guest');
$router->post('/register','registration/store.php');

$router->get('/login','sessions/create.php')->only('guest');
$router->post('/sessions','sessions/store.php')->only('guest');
$router->delete('/sessions','sessions/destroy.php')->only('auth');


$router->post('/api/register','UsersRestController','register');
$router->post('/api/login','UsersRestController','authenticate');
$router->delete("/api/token","UsersRestController",'');
$router->delete("/api/logout","UsersRestController");

$router->get('/api/notes', 'NotesRestController', 'index');
$router->post('/api/notes', 'NotesRestController', 'store');
$router->get('/api/note', 'NotesRestController', 'show');
$router->patch('/api/note/edit', 'NotesRestController', 'edit');
$router->delete('/api/note', 'NotesRestController', 'delete');


