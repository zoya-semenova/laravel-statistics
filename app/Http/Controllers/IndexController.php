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
    function cidr_match($ip, $range)
    {
        list ($subnet, $bits) = explode('/', $range);
        if ($bits === null) {
            $bits = 32;
        }
        $ip = ip2long($ip);
        $subnet = ip2long($subnet);
        $mask = -1 << (32 - $bits);
        $subnet &= $mask; # nb: in case the supplied subnet wasn't correctly aligned
        return ($ip & $mask) == $subnet;
    }
    /**
     * @throws \Exception
     */
    public function index(PostFilter $filter, Request $request)
    {
        $start = microtime(true);
        //$posts = Ip::query()->paginate(100000);
        //$posts = Ip::query()->limit(100000)->get();
            //->get();
        /*
        $posts = DB::table('ips AS a')
            ->select('a.id', 'a.ip')
            ->whereRaw("ip <<= inet '148.20.47.0/24'")
            ->get();
        */
        /*
        $posts = DB::table('statistics AS s')
            ->select('a.id', 'a.ip')
            ->join('ips AS a', 'a.id', '=', 's.ip_id')
            ->where("s.date", '2024-06-25')
            ->get();
*/
        $posts = Statistic::with('ip')->filter($filter)->orderBy("date", "DESC")->paginate(10);
        $sum = Statistic::with('ip')->filter($filter)->sum('time');
        //$posts = Statistic::filter($filter)->get();
        //$posts = Ip::query()->limit(3)->get();

        //echo "<pre>";print_r($posts);exit;
        /*
        $posts = DB::table('ips AS a')
            ->select('a.id',
                'a.ip')
            ->get();
        */
        /*
        foreach ($posts as $IP) {
//            if ($this->cidr_match($IP, '10.2.0.0/16') == true) {
//                print "you're in the 10.2 subnet\n";
//            }
        }
        foreach ($posts as $post) {
            //echo "<pre>";print_r($post->ip)."\n";
        }
        */
        //echo count($posts)."\n";
        $timer = microtime(true) - $start;
        //echo "<pre>";print_r($timer);exit;

        return view('welcome', [
            "posts" => $posts,
            "sum" => $sum,
            "request" => $request,
            "timer" => $timer
        ]);
    }

    public function log(Request $request) {
        $ip = Ip::firstOrNew(['ip' => $request->ip()]);
        $ip->save();
        $ip->statistics()->updateOrCreate(['ip_id' => $ip->id, 'date' => Carbon::now()],
            ['time' => DB::raw('statistics.time + '.request('timeSpent'))]);
    }
}