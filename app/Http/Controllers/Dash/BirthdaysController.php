<?php

namespace App\Http\Controllers\Dash;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BirthdaysController extends Controller
{
    public function index()
    {
        return view('dash.birthdays.index');
    }
}
