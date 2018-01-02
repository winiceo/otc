<?php



namespace Genv\PlusID\Admin\Controllers;

class HomeController
{
    public function index()
    {
        // return trans('plus-id::messages.success');
        return view('plus-id::admin');
    }
}
