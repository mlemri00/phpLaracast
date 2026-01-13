<?php

namespace Http\services;

use core\Middleware\Auth;
use core\Validator;
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

public function deleteNote($noteId){
    $currentUserId = Auth::getUserIdFromJwt();

    $note = $this->repository->getNote($noteId);

    authorize($note->getUserId() === $currentUserId);

    $this->repository->deleteNote($noteId);

}

public function createNote($body){
    $errors = [];

    $userId = Auth::getUserIdFromJwt();


    if (!Validator::string($body, 1, 1000)) {
        $errors['body'] = 'A body of no more than 1000 characters,  is required';
    }

    if (!empty($errors)) {
       return $errors;
    }

    $this->repository->createNote($body, $userId);

}

public function updateNote($body,$noteId){

    $currentUserId = Auth::getUserIdFromJwt();

    $note = $this->repository->getNote($noteId);

    authorize($note['user_id'] === $currentUserId);

    $errors = [];

    if (!Validator::string($body, 1, 1000)) {
        $errors['body'] = 'A body of no more than 1000 characters,  is required';
    }


    if (count($errors)) {
        return $errors;
    }

    $this->repository->updateNote($noteId, $_POST['body']);

}











}