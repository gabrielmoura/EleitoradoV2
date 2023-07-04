<?php

namespace App\Http\Controllers\Dash;

use App\Http\Controllers\Controller;
use App\Models\DirectMail;
use Illuminate\Http\Request;

class DirectMailController extends Controller
{
    public function index()
    {
        return view('dash.direct-mail.index');
    }

    public function create()
    {
        return view('dash.direct-mail.create');
    }

    public function store(Request $request)
    {
        //
    }

    public function show(DirectMail $directMail)
    {
        //
    }

    public function edit(DirectMail $directMail)
    {
        return view('dash.direct-mail.edit', compact('directMail'));
    }

    public function update(Request $request, DirectMail $directMail)
    {
        //
    }

    public function destroy(DirectMail $directMail)
    {
        //
    }
}
