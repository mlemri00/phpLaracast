<?php




$router->get('/','index.php');
$router->get( '/about','about.php');
$router->get('/notes',"NotesController","index")->only("auth")   ;


$router->get('/note',"notes@show")->only("auth");


$router->get('/notes/create','notes@create');
$router->delete('/note','notes@delete');

$router->get('/note/edit','notes@edit');
$router->patch('/note','notes@update');
$router->post('/note','notes@store');


$router->get('/contact','contact.php');

$router->get('/register','registration/create.php')->only('guest');
$router->post('/register','registration/store.php');

$router->get('/login','sessions/create.php')->only('guest');
$router->post('/sessions','sessions/store.php')->only('guest');
$router->delete('/sessions','sessions/destroy.php')->only('auth');


$router->post('/registerjson','jwtAuth@register');
$router->post('/authenticate','jwtAuth@authenticate');
$router->delete("/deletetoken","jwtAuth@deleteToken");
$router->delete("/logout","jwtAuth@deleteAllTokens");

$router->get('/api/v1/notes', 'NotesClient', 'getAll');
$router->post('/api/v1/notes', 'NotesClient', 'store');
$router->get('/api/v1/notes/{id}', 'NotesClient', 'getOne');
$router->patch('/api/v1/notes/{id}', 'NotesClient', 'edit');
$router->delete('/api/v1/notes/{id}', 'NotesClient', 'destroy');
$router->post('/api/v1/users/auth', 'UsersClient', 'getToken');
$router->delete('/api/v1/users/auth', 'UsersClient', 'deleteToken');

////TEST TEST TEST TEST

