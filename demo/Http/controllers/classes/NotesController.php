<?php

namespace Http\controllers\classes;

use App;
use core\Database;
use core\Validator;
use Http\dao\NoteDao;

class NotesController
{
    private $noteDao;
    public function __construct()
    {
    $this->noteDao=new NoteDao();
    }


    public function index($apiRequest = false){
    $userId = $_SESSION['user']['id'];
    $notes = $this->noteDao->getAllNotes($userId);
    //REST index
    if ($apiRequest){
        header('Content-Type: application/json');
        echo json_encode(["notes" =>$notes]);
        die();

    }else {
        view("notes/index.view.php",
            ["heading" => "Notes"
                , "notes" => $notes]);
    }
}

    public function show($apiRequest = false){
        $currentUserId = $_SESSION['user']['id'];

        $note = $this->noteDao->getNote($_GET['id']);
        authorize($note->getUserId() == $currentUserId,404,$apiRequest);
        if ($apiRequest){
            header('Content-Type: application/json');
            echo json_encode(["note" =>$note]);
            die();
        }else {
            view("notes/show.view.php",
                ["heading" => "Note"
                    , "note" => $note]);
        }
}
public function edit(){

    $currentUserId = $_SESSION['user']['id'];

    $note = $this->noteDao->getNote($_GET['id']);

    authorize($note->getUserId() == $currentUserId);

    view("notes/edit.view.php",[
        'heading'=>'Edit Note',
        'errors'=>[],
        'note'=>$note
    ]);
}

public function delete(){

    $currentUserId = $_SESSION['user']['id'];

    $noteID =$_POST['id'];

    $note = $this->noteDao->getNote($noteID);
    authorize($note->getUserId()===$currentUserId);

    $this->noteDao->deleteNote($noteID);

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

    $body = $_POST['body'];
    $userId = $_SESSION['user']['id'];

    if (!Validator::string($body,1,1000)){
        $errors['body']='A body of no more than 1000 characters,  is required';
    }

    if (! empty($errors)){
        return view("notes/create.view.php",[
            'heading'=>'Create Note',
            'errors'=>$errors
        ]);
    }

    $this->noteDao->createNote($body,$userId);

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