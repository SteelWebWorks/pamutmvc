<?php
/**
 * BaseController
 * Provides the basic functionality for the controllers
 */

declare(strict_types=1);

namespace App\Controllers;

use App\Database\Database;
use App\Http\Request;
use App\Http\Response;
use App\View;

class BaseController
{
    protected View $view;
    protected Request $request;
    protected Response $response;
    protected Database $database;
    public function __construct(Request $request, Response $response)
    {
        $this->view = new View();
        $this->request = $request;
        $this->response = $response;
        $this->database = new Database();
    }

}
