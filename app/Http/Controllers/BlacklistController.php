<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetBlacklistRequest;
use App\Http\Requests\SaveBlacklistRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use App\Models\Blacklist;

class BlacklistController extends Controller
{
    use RefreshDatabase;
    public function save(SaveBlacklistRequest $request)
    {
        Blacklist::saveBlacklist($request->blacklist, $request->advertiser);
        return redirect()->route('main');
    }

    public function get(GetBlacklistRequest $request)
    {
        $blacklist = Blacklist::getBlacklist($request->advertiser);
        return view('example', compact('blacklist'));
    }
}
