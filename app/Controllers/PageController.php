<?php

namespace App\Controllers;

use App\Core\View;

class PageController
{
    public function about():View
    {
        return View::render()->view('client.layouts.about');
    }

    public function contact():View
    {
        return View::render()->view('client.layouts.contact');
    }

    public function home():View
    {
        return View::render()->view('client.layouts.home');
    }

}
