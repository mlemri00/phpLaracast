<?php

namespace Http\controllers;

use App;
use core\Database;

class NotesController
{


    public function getFunction($function){
        switch ($function){
            case 'getIndex':
                return $this->getIndex();
            break;
        }

    }
private function getIndex(){

    $db = App::resolve(Database::class);
    $currentUserId = $_SESSION['user']['id'];




    $note = $db->query('select * from notes where id = :id', [
        'id' => $_GET['id']
    ])->findOrFail();


    authorize($note['user_id'] == $currentUserId);


    return view("notes/show.view.php",
        ["heading"=>"Note"
            ,"note"=>$note]);

}


}