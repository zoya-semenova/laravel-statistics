<?php

namespace App\Http\Controllers;

use App\DTO\PostForm;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PostFormRequest;
use App\Models\Post;
use App\Models\Statistic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class AdminController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Statistic::orderBy("created_at", "DESC")->paginate(3);

        return view("admin.posts.index", [
            "posts" => $posts,
        ]);
    }


}
