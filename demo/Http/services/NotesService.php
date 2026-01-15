<?php

namespace Http\services;

use core\Middleware\Auth;
use core\Validator;
use Http\dao\dao\NoteDaoDb;
use Http\dao\factory\NoteDaoFactory;

class NotesService
{
    private NoteDaoDb $repository;

    public function __construct()
    {
        $this->repository = NoteDaoFactory::build();
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
            return 'A body of no more than 1000 characters,  is required';
        }

        $this->repository->createNote($body, $userId);

    }

    public function updateNote($body, $noteId, $userId)
    {

        if (!Validator::string($body, 1, 1000)) {
            return 'A body of no more than 1000 characters,  is required';
        }

        $note = $this->repository->getNote($noteId);

        if ($note->getId() == null) {
            return 'Note not found';
        }

        authorize($note->getUserId() === $userId);


        $this->repository->updateNote($noteId, $body);

    }


}