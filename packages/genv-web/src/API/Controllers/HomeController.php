<?php

namespace Genv\Web\API\Controllers;

class HomeController
{
    public function index()
    {
        return trans('web::messages.success');
    }
}
