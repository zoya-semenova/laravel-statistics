<?php

namespace App\Http\Controllers;

use App\Http\Filters\PostFilter;
use App\Models\Ip;
use App\Models\Statistic;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\Encryption\Encrypter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class IndexController extends Controller
{
    /**
     * @throws \Exception
     */
    public function index()
    {
        return view('welcome', []);
    }

    public function log(Request $request) {
        $ip = Ip::firstOrNew(['ip' => $request->ip()]);
        $ip->save();
        $ip->statistics()->updateOrCreate(['ip_id' => $ip->id, 'date' => Carbon::now()],
            ['time' => DB::raw('time + '.request('timeSpent'))]);
    }
}