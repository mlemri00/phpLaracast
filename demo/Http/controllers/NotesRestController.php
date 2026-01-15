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
    private NotesService $service;
    private UsersService $userService;
    public function __construct()
    {
        $this->service = new NotesService();
        $this->userService = new UsersService();
    }

    public function index()
    {
        $currentUserId = $this->userService->authorizeUser();

        $notes = $this->service->getAllNotes($currentUserId);

        jsonResponse("notes",$notes);
    }

    public function show()
    {
        $currentUserId = $this->userService->authorizeUser();
        $noteId = $_GET['id'];

        $note = $this->service->getNote($noteId, $currentUserId);

        jsonResponse("note",$note);
    }

    public function delete()
    {
        $currentUserId = $this->userService->authorizeUser();
        $requestBody = json_decode(file_get_contents('php://input'));


        $this->service->deleteNote($requestBody->noteId, $currentUserId);

        redirect("/api/notes");
    }

    public function store()
    {
        $currentUserId = $this->userService->authorizeUser();
        $requestBody = json_decode(file_get_contents('php://input'));


        $this->service->createNote($requestBody->body, $currentUserId);

        redirect("/api/notes");
    }

    public function edit()
    {
        $currentUserId = $this->userService->authorizeUser();

        $requestBody = json_decode(file_get_contents('php://input'));



        $this->service->updateNote($requestBody->body, $requestBody->noteId, $currentUserId);

        redirect("/api/notes");

    }


}