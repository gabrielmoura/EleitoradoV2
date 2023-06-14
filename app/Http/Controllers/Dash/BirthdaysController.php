<?php

namespace App\Http\Controllers\Dash;

use App\Http\Controllers\Controller;

class BirthdaysController extends Controller
{
    public function index()
    {
        return view('dash.birthdays.index');
    }
}
