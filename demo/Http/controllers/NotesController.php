<?php

namespace Http\controllers;

use App;
use core\Database;
use core\Middleware\Auth;
use core\Validator;
use Http\dao\dao\NoteDaoDb;
use Http\dao\factory\NoteDaoFactory;

class NotesController
{
    private NoteDaoDb $repository;

    public function __construct()
    {
        $this->repository = NoteDaoFactory::build();
    }


    public function index()
    {
        $userId = $_SESSION['user']['id'];

        $notes = $this->repository->getAllNotes($userId);

        view("notes/index.view.php",
            ["heading" => "Notes"
                , "notes" => $notes]);

    }


    public function show()
    {
        $currentUserId = $_SESSION['user']['id'];
        $note = $this->repository->getNote($_GET['id']);

        authorize($note->getUserId() == $currentUserId);

        view("notes/show.view.php",
            ["heading" => "Note"
                , "note" => $note]);

    }

    public function edit()
    {

        $currentUserId = $_SESSION['user']['id'];

        $note = $this->repository->getNote($_GET['id']);

        authorize($note->getUserId() == $currentUserId);

        view("notes/edit.view.php", [
            'heading' => 'Edit Note',
            'errors' => [],
            'note' => $note
        ]);
    }


    public function delete()
    {

        $currentUserId = $_SESSION['user']['id'];

        $noteID = $_POST['id'] ?? $_GET['id'];

        $note = $this->repository->getNote($noteID);

        authorize($note->getUserId() === $currentUserId);

        $this->repository->deleteNote($noteID);

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
        $errors = [];

        $body = $_POST['body'];
        $userId = $_SESSION['user']['id'];

        if (!Validator::string($body, 1, 1000)) {
            $errors['body'] = 'A body of no more than 1000 characters,  is required';
        }

        if (!empty($errors)) {

            return view("notes/create.view.php", [
                'heading' => 'Create Note',
                'errors' => $errors
            ]);


        }

        $this->repository->createNote($body, $userId);

        header('location: /notes');
        die();


    }

    public function update()
    {


        $currentUserId = $_SESSION['user']['id'];

        $noteId = $_POST['id'] ?? $_GET['id'];

        $note = $this->repository->getNote($noteId);


        authorize($note['user_id'] === $currentUserId);

        $errors = [];

        if (!Validator::string($_POST['body'] ?? $_GET['body'], 1, 1000)) {
            $errors['body'] = 'A body of no more than 1000 characters,  is required';
        }


        if (count($errors)) {

            return view('notes/edit.view.php', [
                'heading' => 'Edit Note',
                'errors' => $errors,
                'note' => $note
            ]);

        }

        $this->repository->updateNote($noteId, $_POST['body']);
        header('location: /notes');
        die();

    }


}