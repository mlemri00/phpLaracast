<?php

namespace Http\controllers\notes;

use App;
use core\Database;
use core\Validator;

class NotesController
{

    public function __construct()
    {

    }


    public function index(){
        $db=App::resolve(Database::class);

    $notes =$db->query("select * from notes where user_id = :user_id",[
        'user_id'=>$_SESSION['user']['id']
    ])->get() ;

    view("notes/index.view.php",
        ["heading"=>"Notes"
            ,"notes"=>$notes]);
}

public function show(){
    $db=App::resolve(Database::class);
    $currentUserId = $_SESSION['user']['id'];




    $note = $db->query('select * from notes where id = :id', [
        'id' => $_GET['id']
    ])->findOrFail();


    authorize($note['user_id'] == $currentUserId);


    view("notes/show.view.php",
        ["heading"=>"Note"
            ,"note"=>$note]);

}
public function edit(){
    $db=App::resolve(Database::class);
    $currentUserId = $_SESSION['user']['id'];




    $note = $db->query('select * from notes where id = :id', [
        'id' => $_GET['id']
    ])->findOrFail();


    authorize($note['user_id'] == $currentUserId);




    view("notes/edit.view.php",[
        'heading'=>'Edit Note',
        'errors'=>[],
        'note'=>$note
    ]);
}

public function delete(){
    $currentUserId = $_SESSION['user']['id'];
    $db=App::resolve(Database::class);

    $note = $db->query('select * from notes where id = :id', [
        'id' => $_POST['id']
    ])->findOrFail();

    authorize($note['user_id']===$currentUserId);

    $db->query('delete from notes where id = :id',[
        'id'=>$_POST['id']
    ]);
    header('location: /notes');
    exit();

}


public function create(){
    view("notes/create.view.php",
        ["heading"=>"Create note"
            ,"errors"=>[]]);
}

public function store(){
    $errors =[];
    $db=App::resolve(Database::class);

    if (!Validator::string($_POST['body'],1,1000)){
        $errors['body']='A body of no more than 1000 characters,  is required';
    }

    if (! empty($errors)){
        return view("notes/create.view.php",[
            'heading'=>'Create Note',
            'errors'=>$errors
        ]);
    }

    $db->query(
        'INSERT INTO notes (body, user_id)
                VALUES (:body,:user_id)',
        [
            'body' => $_POST['body'],
            'user_id' => $_SESSION['user']['id']
        ]);
    header('location: /notes');
    die();



}
public function update(){
    $db = App::resolve(Database::class);


    $currentUserId = $_SESSION['user']['id'];

    $note = $db -> query('select * from notes where id = :id',[
        'id'=>$_POST['id']
    ])->findOrFail();


    authorize($note['user_id']===$currentUserId);

    $errors = [];

    if (!Validator::string($_POST['body'],1,1000)){
        $errors['body']='A body of no more than 1000 characters,  is required';
    }


    if (count($errors)){
        return view('notes/edit.view.php',[
            'heading'=>'Edit Note',
            'errors'=>$errors,
            'note'=>$note
        ]);
    }

    $db -> query('update notes set body = :body where id = :id',[

        'body' => $_POST['body']
        , 'id'=>$_POST['id']
    ]);

    header('location: /notes');
    die();
}



}