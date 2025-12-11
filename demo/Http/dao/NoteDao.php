<?php

namespace Http\dao;

use App;
use core\Database;
use Http\dao\interfaces\INoteDao;
use Http\models\Note;

class NoteDao implements INoteDao
{


    public function getAllNotes($userId)
    {

        $db=App::resolve(Database::class);
        $notesDao =$db->query("select * from notes where user_id = :user_id",[
            'user_id'=>$userId
        ])->get() ;
        $notes = [];
        foreach ($notesDao as $noteDao){
           $notes []= new Note(
                $noteDao['id'],
                $noteDao['body'],
                $noteDao['user_id']);
        }

        return $notes;


    }

    public function getNote($noteId,$apiRequest=false)
    {
        $db=App::resolve(Database::class);


        $noteDao = $db->query('select * from notes where id = :id', [
            'id' => $noteId
        ])->findOrFail($apiRequest);

        return new Note($noteDao['id'],$noteDao['body'],$noteDao['user_id']);
    }

    public function createNote($body,$userId){
        $db=App::resolve(Database::class);
        $db->query(
            'INSERT INTO notes (body, user_id)
                VALUES (:body,:user_id)',
            [
                'body' => $body,
                'user_id' => $userId
            ]);

    }

    public function deleteNote($noteId){
        $db=App::resolve(Database::class);

        $db->query('delete from notes where id = :id',[
            'id'=>$noteId
        ]);
    }

    public function updateNote($noteId,$body)
    {
        $db = App::resolve(Database::class);
        $db -> query('update notes set body = :body where id = :id',[

            'body' => $body
            , 'id'=>$noteId
        ]);

    }
}