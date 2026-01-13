<?php

namespace Http\services;

use core\Middleware\Auth;
use Http\dao\dao\NoteDaoDb;

class NotesService
{
    private NoteDaoDb $repository;

    public function __construct()
    {
        $this->repository= new NoteDaoDb();
    }

    public function getAllNotes(){
    $userId = Auth::getUserIdFromJwt();
    $notes = $this->repository->getAllNotes($userId);

    return $notes;
}


public function getNote($noteId){
    $currentUserId = Auth::getUserIdFromJwt();
    $note = $this->repository->getNote($noteId);

    authorize($note->getUserId() == $currentUserId);

}










}