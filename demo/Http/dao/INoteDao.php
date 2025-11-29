<?php

namespace Http\dao;

interface INoteDao
{
public function getAllNotes($userID);
public function getNote($noteId);
public function createNote($body,$userId);
public function deleteNote($noteId);

public function updateNote($noteId,$body);

}