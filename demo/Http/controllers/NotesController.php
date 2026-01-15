<?php

namespace Http\controllers;

use App;
use core\Database;
use core\Middleware\Auth;
use core\Validator;
use Http\dao\dao\NoteDaoDb;
use Http\dao\factory\NoteDaoFactory;
use Http\services\NotesService;

class NotesController
{
    private NoteDaoDb $repository;
    private NotesService $service;

    public function __construct()
    {
        $this->service = new NotesService();
        $this->repository = NoteDaoFactory::build();
    }


    public function index()
    {
        $userId = $_SESSION['user']['id'];

        $notes = $this->service->getAllNotes($userId);

        view("notes/index.view.php",
            ["heading" => "Notes"
                , "notes" => $notes]);

    }


    public function show()
    {
        $currentUserId = $_SESSION['user']['id'];
        $noteId = $_GET['id'];

        $note = $this->service->getNote($noteId, $currentUserId);

        view("notes/show.view.php",
            ["heading" => "Note"
                , "note" => $note]);

    }

    public function edit()
    {

        $currentUserId = $_SESSION['user']['id'];

        $noteId = $_GET['id'];

        $note = $this->service->getNote($noteId, $currentUserId);

        view("notes/edit.view.php", [
            'heading' => 'Edit Note',
            'errors' => [],
            'note' => $note
        ]);
    }


    public function delete()
    {

        $currentUserId = $_SESSION['user']['id'];

        $noteId = $_POST['id'];

        $this->service->deleteNote($noteId, $currentUserId);

        header('location: /notes');
        exit();

    }


    public function create()
    {
        view("notes/create.view.php",
            ["heading" => "Create note"
                , "errors" => []]);
    }


    public function store()
    {
        $body = $_POST['body'];
        $userId = $_SESSION['user']['id'];

        $errors = $this->service->createNote($body, $userId);

        if (!empty($errors)) {
            return view("notes/create.view.php", [
                'heading' => 'Create Note',
                'errors' => $errors
            ]);


        }


        header('location: /notes');
        die();


    }

    public function update()
    {
        $currentUserId = $_SESSION['user']['id'];

        $noteId = $_POST['id'];

        $body = $_POST['body'];
        $errors = $this->service->updateNote($body, $noteId, $currentUserId);

        if (!empty($errors)) {
            $note = $this->service->getNote($noteId, $currentUserId);
            return view('notes/edit.view.php', [
                'heading' => 'Edit Note',
                'errors' => $errors,
                'note' => $note
            ]);

        }

        header('location: /notes');
        die();

    }


}