<?php




$router->get('/','index.php');
$router->get( '/about','about.php');
$router->get('/notes',"NotesController","index")->only("auth")   ;


$router->get('/note',"NotesController",'show')->only("auth");


$router->get('/notes/create','NotesController','create')->only("auth");
$router->delete('/note','NotesController', 'delete')->only("auth");

$router->get('/note/edit','NotesController','edit')->only("auth");
$router->patch('/note','NotesController','update')->only("auth");
$router->post('/note','NotesController','store')->only("auth");


$router->get('/contact','contact.php');

$router->get('/register','registration/create.php')->only('guest');
$router->post('/register','registration/store.php');

$router->get('/login','sessions/create.php')->only('guest');
$router->post('/sessions','sessions/store.php')->only('guest');
$router->delete('/sessions','sessions/destroy.php')->only('auth');


$router->post('/api/register','UsersRestController','register');
$router->post('/api/login','UsersRestController','authenticate');
$router->get("/api/token","UsersRestController",'getAllTokens');
$router->delete("/api/token","UsersRestController",'deleteToken');
$router->delete("/api/logout","UsersRestController","deleteAllTokens");

$router->get('/api/notes', 'NotesRestController', 'index');
$router->post('/api/notes', 'NotesRestController', 'store');
$router->get('/api/notes', 'NotesRestController', 'show');
$router->patch('/api/notes', 'NotesRestController', 'update');
$router->delete('/api/notes', 'NotesRestController', 'delete');


