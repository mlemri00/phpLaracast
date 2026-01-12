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
        $userId = $_SESSION['user']['id'] ;

        if ($apiRequest){
            $userId = Auth::getUserIdFromJwt();
        }
        $notes = $this->repository->getAllNotes($userId);
        //REST index

        if ($apiRequest){
            header('Content-Type: application/json');
            echo json_encode(["notes" =>$notes]);
            die();

        }else {
            view("notes/index.view.php",
                ["heading" => "Notes"
                    , "notes" => $notes]);
        }
    }


}