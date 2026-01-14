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
        $this->repository = new NoteDaoDb();
    }

    public function getAllNotes($userId)
    {

        $notes = $this->repository->getAllNotes($userId);

        return $notes;
    }


    public function getNote($noteId, $userId)
    {
        $note = $this->repository->getNote($noteId);

        authorize($note->getUserId() == $userId);

        return $this->repository->getNote($noteId);
    }

    public function deleteNote($noteId, $userId)
    {

        $note = $this->repository->getNote($noteId);

        authorize($note->getUserId() === $userId);

        $this->repository->deleteNote($noteId);

    }

    public function createNote($body, $userId)
    {

        if (!Validator::string($body, 1, 1000)) {
            jsonResponse("body",'A body of no more than 1000 characters,  is required');
        }

        $this->repository->createNote($body, $userId);

    }

    public function updateNote($body, $noteId, $userId)
    {


        $note = $this->repository->getNote($noteId);

        authorize($note['user_id'] === $userId);


        if (!Validator::string($body, 1, 1000)) {
            jsonResponse('body','A body of no more than 1000 characters,  is required');
        }


        $this->repository->updateNote($noteId, $body);

    }


}