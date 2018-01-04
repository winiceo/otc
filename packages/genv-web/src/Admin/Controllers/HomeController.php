<?php

namespace Genv\Web\Admin\Controllers;

class HomeController
{
    public function index()
    {
        return trans('web::messages.success');
    }
}
