<?php

namespace Http\controllers;

use core\Middleware\Auth;
use core\Validator;
use Http\dao\dao\NoteDaoDb;
use Http\dao\factory\NoteDaoFactory;
use Http\services\NotesService;
use Http\services\UsersService;

class NotesRestController
{
    private NotesService $noteService;
    private UsersService $userService;

    public function __construct()
    {
        $this->noteService = new NotesService();
        $this->userService = new UsersService();
    }

    public function index()
    {
        $currentUserId = $this->userService->authorizeUser();

        $notes = $this->noteService->getAllNotes($currentUserId);

        jsonResponse("notes", $notes);
    }

    public function show()
    {
        $currentUserId = $this->userService->authorizeUser();
        $noteId = $_GET['id'];

        $note = $this->noteService->getNote($noteId, $currentUserId);

        jsonResponse("note", $note);
    }

    public function delete()
    {
        $currentUserId = $this->userService->authorizeUser();
        $requestBody = json_decode(file_get_contents('php://input'));


        $this->noteService->deleteNote($requestBody->noteId, $currentUserId);

        redirect("/api/notes");
    }

    public function store()
    {
        $currentUserId = $this->userService->authorizeUser();
        $requestBody = json_decode(file_get_contents('php://input'));


        $errors = $this->noteService->createNote($requestBody->body, $currentUserId);

        if (!empty($errors)) {
            jsonResponse("error", $errors);
        }
        redirect("/api/notes");
    }

    public function update()
    {
        $currentUserId = $this->userService->authorizeUser();

        $requestBody = json_decode(file_get_contents('php://input'));


        $errors = $this->noteService->updateNote($requestBody->body, $requestBody->noteId, $currentUserId);

        if (!empty($errors)) {
            jsonResponse("error", $errors);
        }

        redirect("/api/notes");

    }


}