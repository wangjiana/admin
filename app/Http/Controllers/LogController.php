<?php

namespace App\Http\Controllers;

use Rap2hpoutre\LaravelLogViewer\LogViewerController;

class LogController extends LogViewerController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }
}
