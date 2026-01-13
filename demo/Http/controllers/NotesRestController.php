<?php

namespace Http\controllers;

use core\Middleware\Auth;
use core\Validator;
use Http\dao\dao\NoteDaoDb;
use Http\dao\factory\NoteDaoFactory;
use Http\services\NotesService;

class NotesRestController
{
    private NoteDaoDb $repository;
    private NotesService $service;
    public function __construct()
    {
        $this->repository = NoteDaoFactory::build();
        $this->service =  new NotesService();
    }

    public function index()
    {
        $notes = $this->service->getAllNotes();

        header('Content-Type: application/json');
        echo json_encode(["notes" => $notes]);
        die();
    }

    public function show()
    {
        $noteId = $_GET['id'];
        $note = $this->service->getNote($noteId);

        header('Content-Type: application/json');
        echo json_encode(["note" => $note]);
        die();

    }

    public function delete($apiRequest = false)
    {
        $currentUserId = Auth::getUserIdFromJwt();

        $noteID = $_POST['id'] ?? $_GET['id'];

        $note = $this->repository->getNote($noteID, $apiRequest);

        authorize($note->getUserId() === $currentUserId, $apiRequest);

        $this->repository->deleteNote($noteID);

        header('location: /api/notes');
        die();


    }

    public function store($apiRequest = false)
    {
        $errors = [];

        $body = $_POST['body'];

        $userId = Auth::getUserIdFromJwt();


        if (!Validator::string($body, 1, 1000)) {
            $errors['body'] = 'A body of no more than 1000 characters,  is required';
        }

        if (!empty($errors)) {
            header('Content-Type: application/json');
            echo json_encode(["message" => $errors]);
            die();
        }

        $this->repository->createNote($body, $userId);

        header('location: /api/notes');
        die();
    }

    public function update($apiRequest = false)
    {
        $currentUserId = Auth::getUserIdFromJwt();
        $noteId = $_POST['id'] ?? $_GET['id'];

        $note = $this->repository->getNote($noteId);

        authorize($note['user_id'] === $currentUserId, $apiRequest);

        $errors = [];

        if (!Validator::string($_POST['body'] ?? $_GET['body'], 1, 1000)) {
            $errors['body'] = 'A body of no more than 1000 characters,  is required';
        }


        if (count($errors)) {
            header('Content-Type: application/json');
            echo json_encode(["message" => $errors]);
            die();

        }

        $this->repository->updateNote($noteId, $_POST['body']);

        header('location: /api/notes');
        die();

    }


}