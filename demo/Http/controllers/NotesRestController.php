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
        $currentUserId = Auth::getUserIdFromJwt();

        $notes = $this->service->getAllNotes($currentUserId);

        header('Content-Type: application/json');
        echo json_encode(["notes" => $notes]);
        die();
    }

    public function show()
    {
        $currentUserId = Auth::getUserIdFromJwt();
        $noteId = $_GET['id'];
        $note = $this->service->getNote($noteId, $currentUserId);

        header('Content-Type: application/json');
        echo json_encode(["note" => $note]);
        die();

    }

    public function delete()
    {
        $currentUserId = Auth::getUserIdFromJwt();
        $noteID = $_POST['id'] ?? $_GET['id'];

        $this->service->deleteNote($noteID, $currentUserId);

        header('location: /api/notes');
        die();

    }

    public function store()
    {
        $currentUserId = Auth::getUserIdFromJwt();
        $body = $_POST['body'];

        $errors = $this->service->createNote($body,$currentUserId);
        if(!empty($errors)){
            header('Content-Type: application/json');
            echo json_encode(["message" => $errors]);
            die();
        }

        header('location: /api/notes');
        die();
    }

    public function update()
    {
        $currentUserId = Auth::getUserIdFromJwt();
        $noteId = $_POST['id'] ?? $_GET['id'];

        $body =  $_POST['body'];

        $errors = $this->service->updateNote($body,$noteId,$currentUserId);

        if (empty($errors)) {
            header('Content-Type: application/json');
            echo json_encode(["message" => $errors]);
            die();
        }

        header('location: /api/notes');
        die();

    }


}