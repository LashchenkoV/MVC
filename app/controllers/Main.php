<?php

namespace app\controllers;

use app\models\Note;
use core\base\Controller;
use core\base\View;
use core\system\database\Database;
use core\system\database\DatabaseQuery;

class Main extends Controller
{

    public function action_index()
    {
        $tableNotes = new View("tableNotes");
        $tableNotes->notes = Note::all();
        $tableNotes->setTemplate();
        echo $tableNotes->render();
    }


}