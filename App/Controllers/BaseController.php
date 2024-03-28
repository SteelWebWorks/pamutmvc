<?php

namespace App\Controllers;

use App\Database\Database;
use App\Http\Request;
use App\Http\Response;
use App\View;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;

class BaseController
{
    protected View $view;
    protected Request $request;
    protected Response $response;
    protected EntityManager $entityManager;
    public function __construct(Request $request, Response $response)
    {
        $this->view = new View();
        $this->request = $request;
        $this->response = $response;
        $this->entityManager = \entityManager();
    }

}
