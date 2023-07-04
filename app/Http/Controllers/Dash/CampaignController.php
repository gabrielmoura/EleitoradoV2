<?php

namespace App\Http\Controllers\Dash;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use Illuminate\Http\Request;

class CampaignController extends Controller
{
    public function index()
    {
        return view('dash.campaign.index');
    }

    public function create()
    {
        return view('dash.campaign.create');
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Campaign $campaign)
    {
        //
    }

    public function edit(Campaign $campaign)
    {
        return view('dash.campaign.edit', compact('campaign'));
    }

    public function update(Request $request, Campaign $campaign)
    {
        //
    }

    public function destroy(Campaign $campaign)
    {
        //
    }
}
