<?php

namespace Http\controllers;

use core\Middleware\Auth;
use Http\dao\dao\NoteDaoDb;
use Http\dao\factory\NoteDaoFactory;

class NotesRestController
{
    private NoteDaoDb $repository;
    public function __construct()
    {
        $this->repository = NoteDaoFactory::build();
    }

    public function index($apiRequest = false){
        $userId = Auth::getUserIdFromJwt();

        $notes = $this->repository->getAllNotes($userId);


        header('Content-Type: application/json');
        echo json_encode(["notes" =>$notes]);
        die();
    }

    public function show($apiRequest = false){
        $currentUserId = Auth::getUserIdFromJwt();

        $note = $this->repository->getNote($_GET['id'],$apiRequest);


        authorize($note->getUserId() == $currentUserId,$apiRequest);

        header('Content-Type: application/json');
        echo json_encode(["note" =>$note]);
        die();

    }





}