<?php

namespace Http\controllers\notes;

use App;
use core\Database;

class NotesController
{



public function getAllNotes(){

    $db = App::resolve(Database::class);

    $notes = $db->query("select * from notes where user_id = :user_id",[
        'user_id'=>$_SESSION['user']['id']
    ])->get() ;

    view("notes/index.view.php",
        ["heading"=>"Notes"
            ,"notes"=>$notes]);
}

public function getNote(){
    $db = App::resolve(Database::class);
    $currentUserId = $_SESSION['user']['id'];




    $note = $db->query('select * from notes where id = :id', [
        'id' => $_GET['id']
    ])->findOrFail();


    authorize($note['user_id'] == $currentUserId);


    view("notes/show.view.php",
        ["heading"=>"Note"
            ,"note"=>$note]);

}


}