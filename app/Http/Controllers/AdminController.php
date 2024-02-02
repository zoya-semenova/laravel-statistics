<?php

namespace App\Http\Controllers;

use App\DTO\PostForm;
use App\Http\Controllers\Controller;
use App\Http\Filters\PostFilter;
use App\Http\Requests\Admin\PostFormRequest;
use App\Models\Ip;
use App\Models\Post;
use App\Models\Statistic;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class AdminController extends Controller
{

    /**
     * @throws \Exception
     */
    public function admin(PostFilter $filter, Request $request)
    {
        $start = microtime(true);

        $posts = Statistic::with('ip')->filter($filter)->orderBy("date", "DESC")->paginate(10);
        $sum = Statistic::with('ip')->filter($filter)->sum('time');

        $timer = microtime(true) - $start;

        return view('admin', [
            "posts" => $posts,
            "sum" => $sum,
            "request" => $request,
            "timer" => $timer
        ]);
    }
}
