<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\System\ResourceController;
use Illuminate\Http\Request;

class indexController extends ResourceController
{
    public function __construct()
    {
    }
    //
    public function index(Request $request, $id = '')
    {
        $data['breadcrumbs'] = $this->breadcrumbForIndex();
        return $this->renderView('index', $data);
    }
    public function moduleName()
    {
        return 'home';
    }

    /**
     * @returns {string}
     */
    public function viewFolder()
    {
        return 'system.home';
    }
}
